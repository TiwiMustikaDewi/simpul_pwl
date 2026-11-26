<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Internship;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class StudentPortalTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function createStudentUser(string $npm = '2417051034'): User
    {
        $user = User::query()->create([
            'name' => 'Mahasiswa Test',
            'email' => 'mhs_'.uniqid().'@simpul.test',
            'password' => 'secret123',
            'role' => 'student',
        ]);
        Student::create([
            'user_id' => $user->id,
            'npm' => $npm,
            'major' => 'S1 Ilmu Komputer',
            'phone' => '082188990000',
        ]);

        return $user;
    }

    public function test_student_can_access_dashboard_and_company_catalog(): void
    {
        $user = $this->createStudentUser();
        $this->actingAs($user);

        $company = Company::create([
            'name' => 'PT Solusi Digital Lampung',
            'address' => 'Jl. ZA Pagar Alam No. 10',
            'city' => 'Bandar Lampung',
            'contact_person' => 'Bpk. Budi',
            'phone' => '0721-123456',
        ]);

        $this->get(route('mahasiswa.dashboard'))
            ->assertOk()
            ->assertSee('Tahapan Pelaksanaan KP Kamu');

        $this->get(route('mahasiswa.companies.index'))
            ->assertOk()
            ->assertSee('PT Solusi Digital Lampung')
            ->assertSee('Kuota Tersedia');

        $this->get(route('mahasiswa.applications.create'))
            ->assertOk()
            ->assertSee('<datalist id="company-options">', false)
            ->assertSee('value="PT Solusi Digital Lampung"', false);
    }

    public function test_newly_added_admin_company_appears_in_student_dashboard_preview(): void
    {
        $student = $this->createStudentUser();

        for ($companyNumber = 1; $companyNumber <= 4; $companyNumber++) {
            Company::create([
                'name' => "Perusahaan Lama {$companyNumber}",
                'address' => 'Jl. Contoh',
                'city' => 'Bandar Lampung',
            ]);
        }

        $admin = User::query()->create([
            'name' => 'Admin Test',
            'email' => 'admin_'.uniqid().'@simpul.test',
            'password' => 'secret123',
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.companies.store'), [
                'name' => 'PT Perusahaan Terbaru',
                'address' => 'Jl. Terbaru',
                'city' => 'Metro',
            ])
            ->assertRedirect(route('admin.companies.index'));

        $this->actingAs($student)
            ->get(route('mahasiswa.dashboard'))
            ->assertOk()
            ->assertSee('PT Perusahaan Terbaru');
    }

    public function test_company_quota_shows_individual_count_and_blocks_excess(): void
    {
        $user1 = $this->createStudentUser('2417051001');
        $student1 = $user1->student;

        $company = Company::create([
            'name' => 'PT Telkom Witel Lampung',
            'address' => 'Jl. Samodra',
            'city' => 'Bandar Lampung',
        ]);

        // Student 1 applies individually and is approved
        Internship::create([
            'student_id' => $student1->id,
            'company_id' => $company->id,
            'type' => 'individual',
            'title' => 'Pengembangan Backend API',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(2),
            'status' => 'approved',
        ]);

        $this->actingAs($user1);

        // Check catalog displays 1/3 filled
        $this->get(route('mahasiswa.companies.index'))
            ->assertOk()
            ->assertSee('Terisi 1/3 Individu');
    }

    public function test_student_can_view_application_form_with_editable_group_inputs(): void
    {
        $user = $this->createStudentUser('2417051034');
        $this->actingAs($user);

        $response = $this->get(route('mahasiswa.applications.create'));

        $response->assertOk()
            ->assertSee('Formulir Anggota Kelompok KP')
            ->assertSee('name="leader_name"', false)
            ->assertSee('name="leader_npm"', false)
            ->assertSee('name="leader_major"', false)
            ->assertSee('name="members[0][name]"', false)
            ->assertSee('name="members[0][npm]"', false)
            ->assertSee('name="members[0][major]"', false);
    }

    public function test_student_can_submit_group_application_with_custom_leader_and_members(): void
    {
        $user = $this->createStudentUser('2417051034');
        $this->actingAs($user);
        $admin = User::query()->create([
            'name' => 'Admin Notifikasi',
            'email' => 'admin-notifikasi@simpul.test',
            'password' => 'secret123',
            'role' => 'admin',
        ]);

        $payload = [
            'type' => 'group',
            'company_name' => 'PT Teknologi Masa Depan',
            'company_city' => 'Bandar Lampung',
            'company_address' => 'Jl. ZA Pagar Alam No. 99',
            'company_contact' => 'HR Team',
            'title' => 'KP Tim Pengembang Aplikasi Web',
            'start_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
            'end_date' => Carbon::now()->addMonths(2)->format('Y-m-d'),
            'group_name' => 'Tim Garuda Unila',
            'leader_name' => 'Ahmad Ketua',
            'leader_npm' => '2417051099',
            'leader_major' => 'S1 Ilmu Komputer',
            'members' => [
                [
                    'name' => 'Budi Anggota Satu',
                    'npm' => '2417051088',
                    'major' => 'S1 Ilmu Komputer',
                ],
                [
                    'name' => 'Cici Anggota Dua',
                    'npm' => '2417051077',
                    'major' => 'D3 Manajemen Informatika',
                ],
            ],
        ];

        $response = $this->post(route('mahasiswa.applications.store'), $payload);

        $response->assertRedirect(route('mahasiswa.dashboard'));

        $this->assertDatabaseHas('notifications', [
            'user_id' => $admin->id,
            'title' => 'Pengajuan Surat Pengantar KP Baru',
            'is_read' => false,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.notifications.index'))
            ->assertOk()
            ->assertSee('Pengajuan Surat Pengantar KP Baru')
            ->assertSee('notification-read-all', false);

        $this->assertDatabaseHas('internship_groups', [
            'name' => 'Tim Garuda Unila',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Ahmad Ketua',
        ]);
        $this->assertDatabaseHas('students', [
            'npm' => '2417051099',
            'major' => 'S1 Ilmu Komputer',
        ]);

        $this->assertDatabaseHas('students', [
            'npm' => '2417051088',
            'major' => 'S1 Ilmu Komputer',
        ]);
        $this->assertDatabaseHas('students', [
            'npm' => '2417051077',
            'major' => 'D3 Manajemen Informatika',
        ]);
    }

    public function test_group_application_without_group_name_defaults_group_name(): void
    {
        $user = $this->createStudentUser('2417051034');
        $this->actingAs($user);

        $payload = [
            'type' => 'group',
            'company_name' => 'PT Solusi Cerdas',
            'company_city' => 'Bandar Lampung',
            'company_address' => 'Jl. Teuku Umar No. 1',
            'start_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
            'end_date' => Carbon::now()->addMonths(2)->format('Y-m-d'),
            'leader_name' => 'Faisal Pratama',
            'leader_npm' => '2417051080',
            'leader_major' => 'S1 Sistem Informasi',
            'members' => [
                [
                    'name' => 'Dinda Putri',
                    'npm' => '2417051081',
                    'major' => 'D3 Manajemen Informatika',
                ],
            ],
        ];

        $response = $this->post(route('mahasiswa.applications.store'), $payload);

        $response->assertRedirect(route('mahasiswa.dashboard'));

        $this->assertDatabaseHas('internship_groups', [
            'name' => 'Kelompok Faisal Pratama',
        ]);
    }
}
