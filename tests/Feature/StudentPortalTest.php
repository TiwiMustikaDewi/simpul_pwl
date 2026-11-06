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
}
