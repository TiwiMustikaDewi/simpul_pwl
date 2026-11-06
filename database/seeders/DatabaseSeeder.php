<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Internship;
use App\Models\InternshipExperience;
use App\Models\InternshipGroup;
use App\Models\InternshipGroupMember;
use App\Models\InternshipLog;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::updateOrCreate(
            ['email' => 'admin@simpul.test'],
            [
                'name' => 'Admin Jurusan Ilmu Komputer',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Dosen Pembimbing (Supervisors)
        $dosen1User = User::updateOrCreate(
            ['email' => 'dosen1@simpul.test'],
            [
                'name' => 'Dr. Favorisen R. Lumbanraja, M.Si.',
                'password' => Hash::make('password'),
                'role' => 'supervisor',
            ]
        );
        $dosen1 = Supervisor::updateOrCreate(
            ['user_id' => $dosen1User->id],
            [
                'nip' => '197801012005011001',
                'department' => 'Ilmu Komputer',
                'phone' => '081234567801',
            ]
        );

        $dosen2User = User::updateOrCreate(
            ['email' => 'dosen2@simpul.test'],
            [
                'name' => 'Didik Kurniawan, S.Si., M.T.',
                'password' => Hash::make('password'),
                'role' => 'supervisor',
            ]
        );
        $dosen2 = Supervisor::updateOrCreate(
            ['user_id' => $dosen2User->id],
            [
                'nip' => '198002022006021002',
                'department' => 'Ilmu Komputer',
                'phone' => '081234567802',
            ]
        );

        // 3. Mahasiswa (Students)
        $tiwiUser = User::updateOrCreate(
            ['email' => 'tiwi@simpul.test'],
            [
                'name' => 'Tiwi Mustika Dewi',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );
        $tiwiStudent = Student::updateOrCreate(
            ['user_id' => $tiwiUser->id],
            [
                'npm' => '2417051034',
                'major' => 'S1 Ilmu Komputer',
                'phone' => '082188990011',
            ]
        );

        $yuliaUser = User::updateOrCreate(
            ['email' => 'yulia@simpul.test'],
            [
                'name' => 'Yulia Nuritnasari',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );
        $yuliaStudent = Student::updateOrCreate(
            ['user_id' => $yuliaUser->id],
            [
                'npm' => '2457051008',
                'major' => 'S1 Ilmu Komputer',
                'phone' => '082188990022',
            ]
        );

        $dinarUser = User::updateOrCreate(
            ['email' => 'dinar@simpul.test'],
            [
                'name' => 'Dinar Aisa Artika',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );
        $dinarStudent = Student::updateOrCreate(
            ['user_id' => $dinarUser->id],
            [
                'npm' => '2417051020',
                'major' => 'S1 Ilmu Komputer',
                'phone' => '082188990033',
            ]
        );

        $zahraUser = User::updateOrCreate(
            ['email' => 'zahra@simpul.test'],
            [
                'name' => 'Zahra Ayesha Nurdina',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );
        $zahraStudent = Student::updateOrCreate(
            ['user_id' => $zahraUser->id],
            [
                'npm' => '2417051027',
                'major' => 'S1 Ilmu Komputer',
                'phone' => '082188990044',
            ]
        );

        $alumniUser = User::updateOrCreate(
            ['email' => 'alumni@simpul.test'],
            [
                'name' => 'Rian Pratama (Alumni KP)',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );
        $alumniStudent = Student::updateOrCreate(
            ['user_id' => $alumniUser->id],
            [
                'npm' => '2017051099',
                'major' => 'S1 Ilmu Komputer',
                'phone' => '082188990099',
            ]
        );

        // Additional dummy students to demonstrate 3/3 individual quota
        $mhsAUser = User::updateOrCreate(
            ['email' => 'mhs.a@simpul.test'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );
        $mhsA = Student::updateOrCreate(
            ['user_id' => $mhsAUser->id],
            ['npm' => '2317051001', 'major' => 'S1 Ilmu Komputer', 'phone' => '08111111001']
        );

        $mhsBUser = User::updateOrCreate(
            ['email' => 'mhs.b@simpul.test'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );
        $mhsB = Student::updateOrCreate(
            ['user_id' => $mhsBUser->id],
            ['npm' => '2317051002', 'major' => 'S1 Ilmu Komputer', 'phone' => '08111111002']
        );

        $mhsCUser = User::updateOrCreate(
            ['email' => 'mhs.c@simpul.test'],
            [
                'name' => 'Fajar Ramadhan',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );
        $mhsC = Student::updateOrCreate(
            ['user_id' => $mhsCUser->id],
            ['npm' => '2317051003', 'major' => 'S1 Ilmu Komputer', 'phone' => '08111111003']
        );

        // 4. Perusahaan (Companies)
        $telkom = Company::updateOrCreate(
            ['name' => 'PT Telkom Indonesia (Witel Lampung)'],
            [
                'address' => 'Jl. Pangeran Samodra No. 1, Pahoman',
                'city' => 'Bandar Lampung',
                'contact_person' => 'Bpk. Hendra (HR Development)',
                'phone' => '0721-701000',
            ]
        );

        $diskominfo = Company::updateOrCreate(
            ['name' => 'Dinas Komunikasi, Informatika dan Statistik Provinsi Lampung'],
            [
                'address' => 'Jl. Wolter Monginsidi No. 69, Pengajaran',
                'city' => 'Bandar Lampung',
                'contact_person' => 'Ibu Rahmawati (Bidang TIK)',
                'phone' => '0721-481103',
            ]
        );

        $bri = Company::updateOrCreate(
            ['name' => 'PT Bank Rakyat Indonesia (Persero) Tbk - Kantor Wilayah Lampung'],
            [
                'address' => 'Jl. Raden Intan No. 51, Enggal',
                'city' => 'Bandar Lampung',
                'contact_person' => 'Bpk. Satria (Unit IT Support)',
                'phone' => '0721-252555',
            ]
        );

        $bukitAsam = Company::updateOrCreate(
            ['name' => 'PT Bukit Asam Tbk - Unit Pelabuhan Tarahan'],
            [
                'address' => 'Jl. Raya Lintas Sumatera Km. 15, Srengsem',
                'city' => 'Bandar Lampung',
                'contact_person' => 'Bpk. Wahyu (Dept. Sistem Informasi)',
                'phone' => '0721-31500',
            ]
        );

        $polda = Company::updateOrCreate(
            ['name' => 'Kepolisian Daerah Lampung (Bidang TIK Polda)'],
            [
                'address' => 'Jl. Terusan Ryacudu, Way Huwi',
                'city' => 'Lampung Selatan',
                'contact_person' => 'AKP Supriyadi',
                'phone' => '0721-801234',
            ]
        );

        // 5. Setup Kasus Kuota Nyata:

        // A. Perusahaan 1: Telkom -> TERISI 1/3 INDIVIDU (oleh Budi Santoso)
        Internship::updateOrCreate(
            [
                'student_id' => $mhsA->id,
                'company_id' => $telkom->id,
            ],
            [
                'supervisor_id' => $dosen1->id,
                'group_id' => null,
                'type' => 'individual',
                'title' => 'Pengembangan Modul Monitoring Jaringan FTTH Telkom Regional',
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(50),
                'status' => 'in_progress',
                'admin_note' => 'Berkas pengantar dan surat penerimaan PT Telkom valid.',
            ]
        );

        // B. Perusahaan 2: Diskominfo -> TERISI 1 KELOMPOK (oleh Kelompok SIM-DESA, Ketua: Yulia, Anggota: Dinar)
        $groupDiskominfo = InternshipGroup::updateOrCreate(
            ['name' => 'Kelompok Pengembang E-Gov'],
            ['leader_id' => $yuliaStudent->id]
        );
        InternshipGroupMember::updateOrCreate(
            ['group_id' => $groupDiskominfo->id, 'student_id' => $yuliaStudent->id]
        );
        InternshipGroupMember::updateOrCreate(
            ['group_id' => $groupDiskominfo->id, 'student_id' => $dinarStudent->id]
        );

        Internship::updateOrCreate(
            [
                'student_id' => $yuliaStudent->id,
                'company_id' => $diskominfo->id,
            ],
            [
                'supervisor_id' => $dosen2->id,
                'group_id' => $groupDiskominfo->id,
                'type' => 'group',
                'title' => 'Integrasi Sistem Layanan Aspirasi Publik Provinsi Lampung',
                'start_date' => Carbon::now()->subDays(20),
                'end_date' => Carbon::now()->addDays(40),
                'status' => 'in_progress',
                'admin_note' => 'Disetujui untuk 1 kelompok kerja praktik pada Bidang Aplikasi Informatika.',
            ]
        );

        // C. Perusahaan 3: BRI -> KUOTA PENUH 3/3 INDIVIDU (Siti Nurhaliza, Fajar Ramadhan, Zahra)
        Internship::updateOrCreate(
            [
                'student_id' => $mhsB->id,
                'company_id' => $bri->id,
            ],
            [
                'supervisor_id' => $dosen1->id,
                'group_id' => null,
                'type' => 'individual',
                'title' => 'Automasi Validasi Data Transaksi Agen BRILink',
                'start_date' => Carbon::now()->subDays(15),
                'end_date' => Carbon::now()->addDays(45),
                'status' => 'in_progress',
                'admin_note' => 'Diterima Unit IT Kanwil.',
            ]
        );
        Internship::updateOrCreate(
            [
                'student_id' => $mhsC->id,
                'company_id' => $bri->id,
            ],
            [
                'supervisor_id' => $dosen1->id,
                'group_id' => null,
                'type' => 'individual',
                'title' => 'Dashboard Pemantauan Kinerja Mesin ATM Kanwil Bandar Lampung',
                'start_date' => Carbon::now()->subDays(15),
                'end_date' => Carbon::now()->addDays(45),
                'status' => 'in_progress',
                'admin_note' => 'Diterima Unit IT Kanwil.',
            ]
        );
        Internship::updateOrCreate(
            [
                'student_id' => $zahraStudent->id,
                'company_id' => $bri->id,
            ],
            [
                'supervisor_id' => $dosen2->id,
                'group_id' => null,
                'type' => 'individual',
                'title' => 'Audit Keamanan Siber Aplikasi Internal Bank BRI',
                'start_date' => Carbon::now()->subDays(15),
                'end_date' => Carbon::now()->addDays(45),
                'status' => 'in_progress',
                'admin_note' => 'Diterima Unit IT Kanwil (Kuota ke-3).',
            ]
        );

        // D. Kasus Alumni yang sudah selesai KP & memberikan review (Rian Pratama di PT Telkom)
        $completedInternship = Internship::updateOrCreate(
            [
                'student_id' => $alumniStudent->id,
                'company_id' => $telkom->id,
            ],
            [
                'supervisor_id' => $dosen1->id,
                'group_id' => null,
                'type' => 'individual',
                'title' => 'Implementasi RESTful API Layanan Indihome Digital Touchpoint',
                'start_date' => Carbon::now()->subMonths(6),
                'end_date' => Carbon::now()->subMonths(4),
                'status' => 'completed',
                'admin_note' => 'KP telah selesai dan lulus sidang.',
            ]
        );

        // Ulasan Pengalaman Alumni yang Tervalidasi
        InternshipExperience::updateOrCreate(
            [
                'internship_id' => $completedInternship->id,
                'student_id' => $alumniStudent->id,
                'company_id' => $telkom->id,
            ],
            [
                'position' => 'Junior Backend Developer Intern',
                'selection_process' => 'Pengajuan surat pengantar jurusan, seleksi berkas CV & portofolio GitHub, dilanjutkan wawancara teknis singkat mengenai dasar database dan REST API.',
                'skills_used' => 'PHP, Laravel, PostgreSQL, Docker, Git, Postman',
                'experience_review' => 'Lingkungan kerja di Witel Lampung sangat suportif terhadap mahasiswa KP. Mentor lapangan mendampingi perancangan database dan code review mingguan. Sangat direkomendasikan bagi mahasiswa yang fokus di Software Engineering.',
                'is_validated' => true,
            ]
        );

        // Buat sample logbook untuk Yulia di Diskominfo
        InternshipLog::updateOrCreate(
            [
                'internship_id' => $groupDiskominfo->internships()->first()?->id ?? 2,
                'date' => Carbon::now()->subDays(3)->format('Y-m-d'),
            ],
            [
                'activity' => 'Briefing Arsitektur Sistem dengan Kepala Seksi Aplikasi',
                'description' => 'Mendengarkan penjelasan alur kerja sistem informasi layanan publik dan pemetaan tabel database PostgreSQL yang sedang digunakan.',
                'status' => 'approved',
                'supervisor_note' => 'Bagus, lanjutkan dengan menyusun diagram ERD awal.',
            ]
        );
        InternshipLog::updateOrCreate(
            [
                'internship_id' => $groupDiskominfo->internships()->first()?->id ?? 2,
                'date' => Carbon::now()->subDays(1)->format('Y-m-d'),
            ],
            [
                'activity' => 'Perancangan Mockup UI dan Integrasi API Diskominfo',
                'description' => 'Membuat wireframe antarmuka pengguna halaman aduan masyarakat menggunakan Tailwind CSS dan menyambungkan endpoint autentikasi.',
                'status' => 'submitted',
                'supervisor_note' => null,
            ]
        );
    }
}
