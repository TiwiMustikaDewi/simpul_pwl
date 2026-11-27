<?php

namespace Tests\Feature;

use App\Models\Notification;
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
            'admin.dashboard' => 'Ringkasan Data',
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

    public function test_admin_dashboard_and_workflow_pages_render_without_breadcrumbs(): void
    {
        $this->actingAs($this->createUser('admin'));

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Ringkasan Data')
            ->assertDontSee('Dashboard Admin Jurusan')
            ->assertDontSee('class="breadcrumb"', false)
            ->assertDontSee('SIMPUL / Dashboard Admin');

        $this->get(route('admin.companies.index'))
            ->assertOk()
            ->assertSee('Data Perusahaan')
            ->assertDontSee('class="breadcrumb"', false)
            ->assertDontSee('SIMPUL / Admin / Data Perusahaan');
    }

    public function test_admin_workflow_pages_show_an_icon_only_back_button_above_the_title(): void
    {
        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.applications.index'))
            ->assertOk()
            ->assertSee('<div class="workflow-page-header">', false)
            ->assertSee('href="'.route('admin.dashboard').'"', false)
            ->assertSee('class="workflow-back-button"', false)
            ->assertSee('aria-label="Kembali ke Dashboard"', false)
            ->assertSee('<iconify-icon icon="lucide:chevron-left" width="24" height="24" aria-hidden="true"></iconify-icon>', false)
            ->assertDontSee('← Dashboard')
            ->assertSee('<h1>Verifikasi Pengajuan</h1>', false);
    }

    public function test_admin_header_matches_student_brand_and_profile_layout(): void
    {
        $admin = $this->createUser('admin');

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Portal Admin · Universitas Lampung')
            ->assertSee('id="adminSidebarToggle"', false)
            ->assertSee('aria-label="Buka Menu Navigasi"', false)
            ->assertSee('id="adminSidebar"', false)
            ->assertSee('id="adminSidebarBackdrop"', false)
            ->assertSee('href="'.route('admin.notifications.index').'"', false)
            ->assertSee('<iconify-icon icon="lucide:bell" width="20" height="20" aria-hidden="true"></iconify-icon>', false)
            ->assertSee('<div class="header-avatar">'.strtoupper(substr($admin->name, 0, 1)).'</div>', false)
            ->assertSee($admin->name)
            ->assertSee('Admin Jurusan')
            ->assertDontSee('dashboardSearch')
            ->assertDontSee('Cari mahasiswa, perusahaan, atau pengajuan');
    }

    public function test_admin_notification_center_shows_owned_notifications_and_unread_count(): void
    {
        $admin = $this->createUser('admin');
        $notification = Notification::create([
            'user_id' => $admin->id,
            'title' => 'Pengajuan KP Baru',
            'message' => 'Mahasiswa mengajukan permohonan KP.',
            'is_read' => false,
        ]);
        DB::table('notifications')
            ->where('id', $notification->id)
            ->update(['created_at' => '2026-11-26 05:24:00']);
        Notification::create([
            'user_id' => $this->createUser('admin')->id,
            'title' => 'Notifikasi Milik Admin Lain',
            'message' => 'Konten privat.',
            'is_read' => false,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.notifications.index'))
            ->assertOk()
            ->assertSee('Pusat Notifikasi &amp; Pemberitahuan', false)
            ->assertSee('Pengajuan KP Baru')
            ->assertSee('Mahasiswa mengajukan permohonan KP.')
            ->assertSee('26 Nov 2026, 12:24 WIB')
            ->assertSee('notification-tab-count is-unread', false)
            ->assertDontSee('Notifikasi Milik Admin Lain')
            ->assertSee('class="header-icon admin-notification-btn is-active"', false)
            ->assertSee('notification-read-all', false);
    }

    public function test_admin_can_filter_notifications_and_mark_all_as_read(): void
    {
        $admin = $this->createUser('admin');
        Notification::create([
            'user_id' => $admin->id,
            'title' => 'Notifikasi Belum Dibaca',
            'message' => 'Pengajuan baru.',
            'is_read' => false,
        ]);
        Notification::create([
            'user_id' => $admin->id,
            'title' => 'Notifikasi Sudah Dibaca',
            'message' => 'Pengajuan sebelumnya.',
            'is_read' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.notifications.index', ['filter' => 'unread']))
            ->assertOk()
            ->assertSee('Notifikasi Belum Dibaca')
            ->assertDontSee('Notifikasi Sudah Dibaca');

        $this->post(route('admin.notifications.read-all'))
            ->assertRedirect();

        $this->assertDatabaseHas('notifications', [
            'user_id' => $admin->id,
            'title' => 'Notifikasi Belum Dibaca',
            'is_read' => true,
        ]);
    }

    public function test_admin_can_mark_owned_notification_as_read_and_delete_it(): void
    {
        $admin = $this->createUser('admin');
        $notification = Notification::create([
            'user_id' => $admin->id,
            'title' => 'Pengajuan KP Baru',
            'message' => 'Mahasiswa mengajukan permohonan KP.',
            'is_read' => false,
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.notifications.read', $notification))
            ->assertRedirect();

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'is_read' => true,
        ]);

        $this->delete(route('admin.notifications.destroy', $notification))
            ->assertRedirect();

        $this->assertDatabaseMissing('notifications', ['id' => $notification->id]);
    }

    public function test_admin_cannot_access_another_users_notification(): void
    {
        $admin = $this->createUser('admin');
        $otherUser = $this->createUser('admin');
        $notification = Notification::create([
            'user_id' => $otherUser->id,
            'title' => 'Notifikasi Pribadi',
            'message' => 'Tidak boleh diakses admin lain.',
            'is_read' => false,
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.notifications.read', $notification))
            ->assertNotFound();

        $this->delete(route('admin.notifications.destroy', $notification))
            ->assertNotFound();

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'user_id' => $otherUser->id,
            'is_read' => false,
        ]);
    }

    public function test_student_cannot_access_admin_notification_center(): void
    {
        $this->actingAs($this->createUser('student'))
            ->get(route('admin.notifications.index'))
            ->assertForbidden();
    }

    public function test_admin_guide_is_removed_from_the_dashboard_content(): void
    {
        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertDontSee('<section class="panel admin-guide">', false)
            ->assertDontSee('Panduan Admin')
            ->assertSee('Status KP')
            ->assertSee('Sidang KP')
            ->assertDontSee('<div class="sidebar-note">', false);
    }

    public function test_admin_dashboard_does_not_render_pending_action_section(): void
    {
        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertDontSee('id="perlu-tindakan"', false)
            ->assertDontSee('Perlu Tindakan')
            ->assertDontSee('Belum ada pengajuan')
            ->assertSee('Menunggu Verifikasi');
    }

    public function test_admin_service_cards_render_in_a_horizontal_scroller_with_next_button(): void
    {
        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('<section class="service-section">', false)
            ->assertSee('id="adminServiceTrack"', false)
            ->assertSee('aria-label="Lihat layanan berikutnya"', false)
            ->assertSee('aria-label="Lihat layanan sebelumnya"', false)
            ->assertSee('class="service-scroll-button service-scroll-back-button"', false)
            ->assertSee('aria-controls="adminServiceTrack"', false)
            ->assertDontSee('<span class="service-arrow">', false)
            ->assertSee('Kelola Layanan');
    }

    public function test_admin_welcome_banner_does_not_render_the_review_button(): void
    {
        $admin = $this->createUser('admin');

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('<section class="welcome-banner">', false)
            ->assertSee('Selamat datang <span>'.$admin->name.'!</span>', false)
            ->assertDontSee('Tinjau Pengajuan');
    }

    public function test_admin_company_sections_use_the_company_group_icon(): void
    {
        $response = $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk();

        $this->assertSame(3, substr_count($response->getContent(), 'icon="uix-sharp:company-group"'));
    }

    public function test_admin_verification_sections_use_the_receipt_verification_icon(): void
    {
        $response = $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Verifikasi Pengajuan')
            ->assertSee('Menunggu Verifikasi');

        $this->assertSame(3, substr_count($response->getContent(), 'icon="carbon:receipt-verification"'));
    }

    public function test_admin_group_menu_and_service_use_the_users_three_icon(): void
    {
        $response = $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Kelompok & Pembimbing');

        $this->assertSame(2, substr_count($response->getContent(), 'icon="uix-sharp:users-three"'));
    }

    public function test_admin_sidang_menu_and_service_use_the_calendar_clock_icon(): void
    {
        $response = $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('<h3>Sidang KP</h3>', false)
            ->assertDontSee('<h2>Sidang KP</h2>', false);

        $this->assertSame(2, substr_count($response->getContent(), 'icon="lucide:calendar-clock"'));
    }

    public function test_admin_monitoring_menu_uses_the_heart_rate_monitor_icon(): void
    {
        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee(
                '<iconify-icon icon="tabler:heart-rate-monitor" width="18" height="18" aria-hidden="true"></iconify-icon>',
                false
            )
            ->assertSee('Monitoring KP');
    }

    public function test_admin_experience_validation_menu_uses_the_list_check_icon(): void
    {
        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee(
                '<iconify-icon icon="tabler:list-check" width="18" height="18" aria-hidden="true"></iconify-icon>',
                false
            )
            ->assertSee('Validasi Pengalaman');
    }

    public function test_admin_student_and_supervisor_menu_uses_the_document_search_icon(): void
    {
        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee(
                '<iconify-icon icon="icon-park-outline:doc-search-two" width="18" height="18" aria-hidden="true"></iconify-icon>',
                false
            )
            ->assertSee('Data Mahasiswa & Dosen');
    }

    public function test_admin_supervisor_summary_uses_the_classroom_icon(): void
    {
        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee(
                '<iconify-icon icon="uix-sharp:classroom" width="24" height="24" aria-hidden="true"></iconify-icon>',
                false
            )
            ->assertSee('Dosen Pembimbing');
    }

    public function test_admin_student_summary_uses_the_graduation_cap_icon(): void
    {
        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee(
                '<iconify-icon icon="lucide:graduation-cap" width="24" height="24" aria-hidden="true"></iconify-icon>',
                false
            )
            ->assertSee('Mahasiswa');
    }

    public function test_admin_logout_form_is_in_the_sidebar_instead_of_the_topbar(): void
    {
        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('<div class="sidebar-footer">', false)
            ->assertSee('action="'.route('logout').'"', false)
            ->assertSee('class="sidebar-logout-form"', false)
            ->assertSee('id="adminLogoutModal"', false)
            ->assertSee('Konfirmasi Keluar Akun')
            ->assertSee('Anda harus login kembali untuk mengakses portal admin.')
            ->assertDontSee('return confirm(', false)
            ->assertSee('<button type="submit" class="sidebar-logout-btn">', false)
            ->assertSee('class="header-icon admin-notification-btn"', false)
            ->assertDontSee('<button type="submit" class="btn btn-outline">Logout</button>', false);
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
        DB::table('internships')
            ->whereIn('id', [$internshipId, $groupMemberInternshipId])
            ->update(['supervisor_name' => 'Nama Pembimbing Sebelumnya']);

        $this->get(route('admin.groups.index'))
            ->assertOk()
            ->assertSee('name="supervisor_id"', false)
            ->assertSee('value="'.$supervisorId.'"', false);

        $this->post(route('admin.groups.assign-supervisor', $internshipId), [
            'supervisor_id' => $supervisorId,
        ])->assertRedirect(route('admin.groups.index'));

        $this->assertDatabaseHas('internships', [
            'id' => $internshipId,
            'supervisor_id' => $supervisorId,
            'supervisor_name' => null,
        ]);
        $this->assertDatabaseHas('internships', [
            'id' => $groupMemberInternshipId,
            'supervisor_id' => $supervisorId,
            'supervisor_name' => null,
        ]);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $supervisor->id,
            'title' => 'Penugasan Pembimbing KP',
            'is_read' => false,
        ]);
        $notificationMessage = DB::table('notifications')
            ->where('user_id', $supervisor->id)
            ->value('message');
        $this->assertStringContainsString('Kelompok A', $notificationMessage);
        $this->assertStringContainsString('Praktik Pengembangan Sistem', $notificationMessage);

        $this->get(route('admin.groups.index'))
            ->assertOk()
            ->assertSee('Kelompok A')
            ->assertSee($supervisor->name);
        $this->get(route('admin.applications.index'))
            ->assertOk()
            ->assertSee($supervisor->name);
        $this->get(route('admin.monitoring.index'))
            ->assertOk()
            ->assertSee('Praktik Pengembangan Sistem')
            ->assertSee($supervisor->name);
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
