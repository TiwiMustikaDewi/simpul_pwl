<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DosenWorkflowTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function createDosenUser(): array
    {
        $user = User::create([
            'name' => 'Dr. Budi Santoso, M.Kom.',
            'email' => 'budi@simpul.test',
            'password' => 'password123',
            'role' => 'supervisor',
        ]);

        $supervisorId = DB::table('supervisors')->insertGetId([
            'user_id' => $user->id,
            'nip' => '197905102005011003',
            'department' => 'Ilmu Komputer',
            'phone' => '081234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return [$user, $supervisorId];
    }

    protected function createStudentWithInternship(int $supervisorId): array
    {
        $studentUser = User::create([
            'name' => 'Fajar Pratama',
            'email' => 'fajar@simpul.test',
            'password' => 'password123',
            'role' => 'student',
        ]);

        $studentId = DB::table('students')->insertGetId([
            'user_id' => $studentUser->id,
            'npm' => '2417051999',
            'major' => 'Ilmu Komputer',
            'phone' => '089988776655',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $companyId = DB::table('companies')->insertGetId([
            'name' => 'PT Solusi Digital',
            'address' => 'Jl. Kartini No. 10',
            'city' => 'Bandar Lampung',
            'contact_person' => 'Dewi',
            'phone' => '0721-123456',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $internshipId = DB::table('internships')->insertGetId([
            'student_id' => $studentId,
            'company_id' => $companyId,
            'supervisor_id' => $supervisorId,
            'group_id' => null,
            'type' => 'individual',
            'title' => 'Rancang Bangun Sistem Pemantauan IoT',
            'start_date' => now()->subMonths(1)->format('Y-m-d'),
            'end_date' => now()->addMonth()->format('Y-m-d'),
            'status' => 'in_progress',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return [$studentUser, $studentId, $internshipId];
    }

    public function test_supervisor_can_access_dosen_pages(): void
    {
        [$dosen, $supervisorId] = $this->createDosenUser();
        [$studentUser, $studentId, $internshipId] = $this->createStudentWithInternship($supervisorId);

        $this->actingAs($dosen);

        $pages = [
            'dosen.dashboard' => 'Dashboard Dosen Pembimbing',
            'dosen.students.index' => 'Mahasiswa Bimbingan KP',
            'dosen.logs.index' => 'Pemeriksaan Logbook Kegiatan',
            'dosen.reports.index' => 'Laporan Akhir Kuliah Praktik',
            'dosen.sidang.index' => 'Sidang Kuliah Praktik & Penilaian',
            'dosen.profile.index' => 'Profil Dosen Pembimbing',
        ];

        foreach ($pages as $route => $text) {
            $this->get(route($route))->assertOk()->assertSee($text);
        }

        // Detail show
        $this->get(route('dosen.students.show', $internshipId))
            ->assertOk()
            ->assertSee('Rancang Bangun Sistem Pemantauan IoT');
    }

    public function test_student_cannot_access_dosen_pages(): void
    {
        $studentUser = User::create([
            'name' => 'Siswa Test',
            'email' => 'siswa@simpul.test',
            'password' => 'password123',
            'role' => 'student',
        ]);

        $this->actingAs($studentUser)
            ->get(route('dosen.dashboard'))
            ->assertForbidden();
    }

    public function test_general_dashboard_redirects_supervisor_to_dosen_dashboard(): void
    {
        [$dosen] = $this->createDosenUser();

        $this->actingAs($dosen)
            ->get(route('dashboard'))
            ->assertRedirect(route('dosen.dashboard'));
    }

    public function test_supervisor_can_review_logbook_with_note(): void
    {
        [$dosen, $supervisorId] = $this->createDosenUser();
        [$studentUser, $studentId, $internshipId] = $this->createStudentWithInternship($supervisorId);

        $logId = DB::table('internship_logs')->insertGetId([
            'internship_id' => $internshipId,
            'date' => now()->format('Y-m-d'),
            'activity' => 'Konfigurasi Broker MQTT',
            'description' => 'Melakukan setting server broker Mosquitto untuk menerima sinyal telemetri sensor.',
            'status' => 'submitted',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($dosen);

        $this->post(route('dosen.logs.review', $logId), [
            'status' => 'approved',
            'supervisor_note' => 'Bagus, pastikan enkripsi TLS sudah aktif.',
        ])->assertRedirect();

        $this->assertDatabaseHas('internship_logs', [
            'id' => $logId,
            'status' => 'approved',
            'supervisor_note' => 'Bagus, pastikan enkripsi TLS sudah aktif.',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $studentUser->id,
            'title' => 'Logbook Disetujui',
        ]);
    }

    public function test_supervisor_can_review_report_with_feedback(): void
    {
        [$dosen, $supervisorId] = $this->createDosenUser();
        [$studentUser, $studentId, $internshipId] = $this->createStudentWithInternship($supervisorId);

        $reportId = DB::table('internship_reports')->insertGetId([
            'internship_id' => $internshipId,
            'title' => 'Laporan Akhir KP Fajar',
            'file_path' => 'reports/test_report.pdf',
            'status' => 'submitted',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($dosen);

        $this->post(route('dosen.reports.review', $reportId), [
            'status' => 'revision',
            'feedback' => 'Perbaiki penulisan daftar pustaka dengan format IEEE.',
        ])->assertRedirect();

        $this->assertDatabaseHas('internship_reports', [
            'id' => $reportId,
            'status' => 'revision',
            'feedback' => 'Perbaiki penulisan daftar pustaka dengan format IEEE.',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $studentUser->id,
            'title' => 'Laporan Akhir KP Perlu Revisi',
        ]);
    }

    public function test_supervisor_can_grade_sidang_kp(): void
    {
        [$dosen, $supervisorId] = $this->createDosenUser();
        [$studentUser, $studentId, $internshipId] = $this->createStudentWithInternship($supervisorId);

        $sidangId = DB::table('sidang_kps')->insertGetId([
            'internship_id' => $internshipId,
            'sidang_date' => now()->addDay()->format('Y-m-d H:i:s'),
            'room' => 'Ruang 3 FMIPA',
            'status' => 'scheduled',
            'grade' => null,
            'notes' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($dosen);

        $this->post(route('dosen.sidang.grade', $sidangId), [
            'grade' => 'A',
            'notes' => 'Penguasaan materi sangat memuaskan, prototipe berfungsi baik.',
        ])->assertRedirect();

        $this->assertDatabaseHas('sidang_kps', [
            'id' => $sidangId,
            'grade' => 'A',
            'status' => 'completed',
        ]);

        // Status internship harus diubah ke completed
        $this->assertDatabaseHas('internships', [
            'id' => $internshipId,
            'status' => 'completed',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $studentUser->id,
            'title' => 'Nilai Sidang KP Diberikan',
        ]);
    }

    public function test_supervisor_can_update_profile(): void
    {
        [$dosen, $supervisorId] = $this->createDosenUser();

        $this->actingAs($dosen);

        $this->put(route('dosen.profile.update'), [
            'name' => 'Prof. Dr. Budi Santoso, M.Kom.',
            'nip' => '197905102005011003',
            'department' => 'S1 Ilmu Komputer & Sistem Informasi',
            'phone' => '081299998888',
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $dosen->id,
            'name' => 'Prof. Dr. Budi Santoso, M.Kom.',
        ]);

        $this->assertDatabaseHas('supervisors', [
            'id' => $supervisorId,
            'department' => 'S1 Ilmu Komputer & Sistem Informasi',
            'phone' => '081299998888',
        ]);
    }
}
