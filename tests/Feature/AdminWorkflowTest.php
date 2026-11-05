<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminWorkflowTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_sidebar_destinations_render_their_workflow_pages(): void
    {
        $this->actingAs($this->createUser('admin'));

        $pages = [
            'admin.dashboard' => 'Dashboard Admin Jurusan',
            'admin.pengguna.index' => 'Data Mahasiswa & Dosen',
            'admin.companies.index' => 'Tambah perusahaan',
            'admin.applications.index' => 'Verifikasi Pengajuan',
            'admin.groups.index' => 'Bentuk kelompok KP',
            'admin.monitoring.index' => 'Monitoring KP',
            'admin.sidang.index' => 'Sidang KP',
            'admin.experiences.index' => 'Validasi Pengalaman',
        ];

        foreach ($pages as $route => $content) {
            $this->get(route($route))->assertOk()->assertSee($content);
        }
    }

    public function test_student_cannot_open_admin_workflow_pages(): void
    {
        $this->actingAs($this->createUser('student'))
            ->get(route('admin.applications.index'))
            ->assertForbidden();
    }

    public function test_admin_can_create_and_update_a_company(): void
    {
        $admin = $this->createUser('admin');
        $this->actingAs($admin);

        $this->post(route('admin.companies.store'), [
            'name' => 'PT Contoh',
            'address' => 'Jl. Merdeka No. 1',
            'city' => 'Bandar Lampung',
            'contact_person' => 'Ayu',
            'phone' => '08123456789',
        ])->assertRedirect(route('admin.companies.index'));

        $companyId = DB::table('companies')->where('name', 'PT Contoh')->value('id');
        $this->assertNotNull($companyId);

        $this->put(route('admin.companies.update', $companyId), [
            'name' => 'PT Contoh Baru',
            'address' => 'Jl. Diponegoro No. 2',
            'city' => 'Metro',
            'contact_person' => 'Dina',
            'phone' => '08111111111',
        ])->assertRedirect(route('admin.companies.index'));

        $this->assertDatabaseHas('companies', [
            'id' => $companyId,
            'name' => 'PT Contoh Baru',
            'city' => 'Metro',
        ]);

        $this->get(route('admin.companies.index'))
            ->assertOk()
            ->assertSee('PT Contoh Baru');
    }

    public function test_admin_can_reject_a_pending_application_with_a_reason(): void
    {
        $this->actingAs($this->createUser('admin'));
        $student = $this->createStudent('2417051001');
        $companyId = $this->createCompany();
        $internshipId = $this->createInternship($student, $companyId);

        $this->post(route('admin.applications.review', $internshipId), [
            'decision' => 'rejected',
            'admin_note' => 'Mohon lengkapi surat pengantar.',
        ])->assertRedirect(route('admin.applications.index'));

        $this->assertDatabaseHas('internships', [
            'id' => $internshipId,
            'status' => 'rejected',
            'admin_note' => 'Mohon lengkapi surat pengantar.',
        ]);

        $this->get(route('admin.applications.index'))
            ->assertOk()
            ->assertSee('Mohon lengkapi surat pengantar.');
    }

    public function test_admin_note_is_required_when_rejecting_an_application(): void
    {
        $this->actingAs($this->createUser('admin'));
        $student = $this->createStudent('2417051002');
        $companyId = $this->createCompany();
        $internshipId = $this->createInternship($student, $companyId);

        $this->from(route('admin.applications.index'))
            ->post(route('admin.applications.review', $internshipId), [
                'decision' => 'rejected',
            ])
            ->assertRedirect(route('admin.applications.index'))
            ->assertSessionHasErrors([
                'admin_note' => 'Catatan wajib diisi saat pengajuan ditolak.',
            ]);

        $this->assertDatabaseHas('internships', [
            'id' => $internshipId,
            'status' => 'pending',
            'admin_note' => null,
        ]);
    }

    public function test_admin_can_create_a_group_and_assign_a_supervisor(): void
    {
        $this->actingAs($this->createUser('admin'));
        $student = $this->createStudent('2417051003');
        $groupMember = $this->createStudent('2417051006');
        $companyId = $this->createCompany();
        $internshipId = $this->createInternship($student, $companyId, 'approved');
        $groupMemberInternshipId = $this->createInternship($groupMember, $companyId, 'approved');
        $supervisor = $this->createUser('supervisor');
        $supervisorId = DB::table('supervisors')->insertGetId([
            'user_id' => $supervisor->id,
            'nip' => '1980010100000001',
            'department' => 'Informatika',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->post(route('admin.groups.store'), [
            'name' => 'Kelompok A',
            'leader_id' => $student,
            'member_ids' => [$student, $groupMember],
        ])->assertRedirect(route('admin.groups.index'));

        $groupId = DB::table('internship_groups')->where('name', 'Kelompok A')->value('id');
        $this->assertNotNull($groupId);
        $this->assertDatabaseHas('internship_group_members', [
            'group_id' => $groupId,
            'student_id' => $student,
        ]);
        $this->assertDatabaseHas('internship_group_members', [
            'group_id' => $groupId,
            'student_id' => $groupMember,
        ]);
        $this->assertDatabaseHas('internships', [
            'id' => $internshipId,
            'group_id' => $groupId,
            'type' => 'group',
        ]);

        $this->post(route('admin.groups.assign-supervisor', $internshipId), [
            'supervisor_id' => $supervisorId,
        ])->assertRedirect(route('admin.groups.index'));

        $this->assertDatabaseHas('internships', [
            'id' => $internshipId,
            'supervisor_id' => $supervisorId,
        ]);
        $this->assertDatabaseHas('internships', [
            'id' => $groupMemberInternshipId,
            'supervisor_id' => $supervisorId,
        ]);

        $this->get(route('admin.groups.index'))
            ->assertOk()
            ->assertSee('Kelompok A')
            ->assertSee($supervisor->name);
        $this->get(route('admin.monitoring.index'))
            ->assertOk()
            ->assertSee('Praktik Pengembangan Sistem');
    }

    public function test_admin_can_schedule_a_submitted_sidang(): void
    {
        $this->travelTo('2026-11-05 09:00:00');
        $this->actingAs($this->createUser('admin'));
        $student = $this->createStudent('2417051004');
        $companyId = $this->createCompany();
        $internshipId = $this->createInternship($student, $companyId, 'approved');
        $sidangId = DB::table('sidang_kps')->insertGetId([
            'internship_id' => $internshipId,
            'status' => 'submitted',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->put(route('admin.sidang.schedule', $sidangId), [
            'sidang_date' => '2026-11-07T10:30',
            'room' => 'Ruang Seminar 1',
        ])->assertRedirect(route('admin.sidang.index'));

        $this->assertDatabaseHas('sidang_kps', [
            'id' => $sidangId,
            'sidang_date' => '2026-11-07 10:30:00',
            'room' => 'Ruang Seminar 1',
            'status' => 'scheduled',
        ]);

        $this->get(route('admin.sidang.index'))
            ->assertOk()
            ->assertSee('Ruang Seminar 1');
    }

    public function test_admin_can_validate_a_student_experience(): void
    {
        $this->actingAs($this->createUser('admin'));
        $student = $this->createStudent('2417051005');
        $companyId = $this->createCompany();
        $internshipId = $this->createInternship($student, $companyId, 'completed');
        $experienceId = DB::table('internship_experiences')->insertGetId([
            'internship_id' => $internshipId,
            'student_id' => $student,
            'company_id' => $companyId,
            'position' => 'Web Developer',
            'selection_process' => 'Tes teknis',
            'skills_used' => 'Laravel',
            'experience_review' => 'Pengalaman yang baik.',
            'is_validated' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->patch(route('admin.experiences.validate', $experienceId))
            ->assertRedirect(route('admin.experiences.index'));

        $this->assertDatabaseHas('internship_experiences', [
            'id' => $experienceId,
            'is_validated' => true,
        ]);

        $this->get(route('admin.experiences.index'))
            ->assertOk()
            ->assertSee('Web Developer')
            ->assertSee('Tervalidasi');
    }

    private function createStudent(string $npm): int
    {
        $user = $this->createUser('student');

        return DB::table('students')->insertGetId([
            'user_id' => $user->id,
            'npm' => $npm,
            'major' => 'Informatika',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createCompany(): int
    {
        return DB::table('companies')->insertGetId([
            'name' => 'PT SIMPUL',
            'address' => 'Jl. Pendidikan',
            'city' => 'Bandar Lampung',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createUser(string $role): User
    {
        return User::query()->create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'role' => $role,
        ]);
    }

    private function createInternship(int $studentId, int $companyId, string $status = 'pending'): int
    {
        return DB::table('internships')->insertGetId([
            'student_id' => $studentId,
            'company_id' => $companyId,
            'type' => 'individual',
            'title' => 'Praktik Pengembangan Sistem',
            'start_date' => '2026-11-10',
            'end_date' => '2027-01-10',
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
