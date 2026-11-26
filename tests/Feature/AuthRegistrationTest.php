<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_registration_page_renders_poppins_and_simpul_branding(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee("font-family: 'Poppins', -apple-system", false)
            ->assertSee('<div class="brand-icon">S</div>', false)
            ->assertDontSee('<<<<<<< HEAD');
    }

    public function test_student_registration_creates_user_and_profile(): void
    {
        $response = $this->post(route('register.process'), [
            'name' => 'Mahasiswa Registrasi',
            'npm' => '2417051234',
            'faculty' => 'Fakultas Teknik',
            'major' => 'S1 Teknik Informatika',
            'phone' => '081234567890',
            'email' => 'registrasi@simpul.test',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'student',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'name' => 'Mahasiswa Registrasi',
            'email' => 'registrasi@simpul.test',
            'role' => 'student',
        ]);

        $this->assertDatabaseHas('students', [
            'npm' => '2417051234',
            'faculty' => 'Fakultas Teknik',
            'major' => 'S1 Teknik Informatika',
        ]);
    }
}
