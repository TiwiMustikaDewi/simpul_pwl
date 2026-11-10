<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Internship;
use App\Models\InternshipExperience;
use App\Models\InternshipGroup;
use App\Models\InternshipGroupMember;
use App\Models\InternshipLog;
use App\Models\InternshipReport;
use App\Models\SidangKp;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $defaultPassword = Hash::make('password123');

        // ==========================================
        // 1. Admin Jurusan
        // ==========================================
        User::updateOrCreate(
            ['email' => 'admin@simpul.test'],
            [
                'name' => 'Admin Jurusan (Dinar Aisa Artika)',
                'password' => $defaultPassword,
                'role' => 'admin',
            ]
        );

        // ==========================================
        // 2. Dosen Pembimbing (Supervisors)
        // ==========================================
        $dosenMainUser = User::updateOrCreate(
            ['email' => 'dosen@simpul.test'],
            [
                'name' => 'Dr. Ing. Ahmad Zarkasi, S.Kom., M.T.',
                'password' => $defaultPassword,
                'role' => 'supervisor',
            ]
        );
        $dosenMain = Supervisor::updateOrCreate(
            ['user_id' => $dosenMainUser->id],
            [
                'nip' => '198203152008121002',
                'department' => 'S1 Ilmu Komputer',
                'phone' => '081298765432',
            ]
        );

        $dosen1User = User::updateOrCreate(
            ['email' => 'dosen1@simpul.test'],
            [
                'name' => 'Dr. Favorisen R. Lumbanraja, M.Si.',
                'password' => $defaultPassword,
                'role' => 'supervisor',
            ]
        );
        $dosen1 = Supervisor::updateOrCreate(
            ['user_id' => $dosen1User->id],
            [
                'nip' => '197801012005011001',
                'department' => 'S1 Ilmu Komputer',
                'phone' => '081234567801',
            ]
        );

        $dosen2User = User::updateOrCreate(
            ['email' => 'dosen2@simpul.test'],
            [
                'name' => 'Didik Kurniawan, S.Si., M.T.',
                'password' => $defaultPassword,
                'role' => 'supervisor',
            ]
        );
        $dosen2 = Supervisor::updateOrCreate(
            ['user_id' => $dosen2User->id],
            [
                'nip' => '198002022006021002',
                'department' => 'S1 Ilmu Komputer',
                'phone' => '081234567802',
            ]
        );

        // ==========================================
        // 3. Perusahaan Mitra (Companies)
        // ==========================================
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
                'contact_person' => 'Bambang Irawan, S.Kom. (Kasi Aplikasi Informatika)',
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

        // ==========================================
        // 4. Mahasiswa (Students)
        // ==========================================
        $tiwiUser = User::updateOrCreate(
            ['email' => 'tiwi@simpul.test'],
            [
                'name' => 'Tiwi Mustika Dewi',
                'password' => $defaultPassword,
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
                'password' => $defaultPassword,
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
                'password' => $defaultPassword,
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
                'password' => $defaultPassword,
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
                'password' => $defaultPassword,
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

        // Mahasiswa Tambahan untuk demo kuota
        $mhsAUser = User::updateOrCreate(
            ['email' => 'mhs.a@simpul.test'],
            [
                'name' => 'Budi Santoso',
                'password' => $defaultPassword,
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
                'password' => $defaultPassword,
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
                'password' => $defaultPassword,
                'role' => 'student',
            ]
        );
        $mhsC = Student::updateOrCreate(
            ['user_id' => $mhsCUser->id],
            ['npm' => '2317051003', 'major' => 'S1 Ilmu Komputer', 'phone' => '08111111003']
        );

        // ==========================================
        // 5. Kelompok KP Diskominfo (Tiwi, Yulia, Dinar)
        // ==========================================
        $groupDiskominfo = InternshipGroup::updateOrCreate(
            ['name' => 'Tim Diskominfo Squad'],
            ['leader_id' => $tiwiStudent->id]
        );

        InternshipGroupMember::updateOrCreate(
            ['group_id' => $groupDiskominfo->id, 'student_id' => $tiwiStudent->id]
        );
        InternshipGroupMember::updateOrCreate(
            ['group_id' => $groupDiskominfo->id, 'student_id' => $yuliaStudent->id]
        );
        InternshipGroupMember::updateOrCreate(
            ['group_id' => $groupDiskominfo->id, 'student_id' => $dinarStudent->id]
        );

        // ==========================================
        // 6. Data Internship Aktif
        // ==========================================

        // Tiwi (Diskominfo)
        $tiwiInternship = Internship::updateOrCreate(
            [
                'student_id' => $tiwiStudent->id,
                'company_id' => $diskominfo->id,
            ],
            [
                'supervisor_id' => $dosenMain->id,
                'group_id' => $groupDiskominfo->id,
                'type' => 'group',
                'title' => 'Pengembangan Sistem Dashboard Pelayanan Publik Diskominfo Provinsi Lampung',
                'start_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                'end_date' => Carbon::now()->addMonth()->format('Y-m-d'),
                'status' => 'in_progress',
                'admin_note' => 'Disetujui untuk 1 kelompok kerja praktik pada Bidang Aplikasi Informatika.',
            ]
        );

        // Yulia (Diskominfo)
        $yuliaInternship = Internship::updateOrCreate(
            [
                'student_id' => $yuliaStudent->id,
                'company_id' => $diskominfo->id,
            ],
            [
                'supervisor_id' => $dosenMain->id,
                'group_id' => $groupDiskominfo->id,
                'type' => 'group',
                'title' => 'Implementasi Modul Pengelolaan Konten Portal Web Provinsi Lampung',
                'start_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                'end_date' => Carbon::now()->addMonth()->format('Y-m-d'),
                'status' => 'in_progress',
                'admin_note' => 'Disetujui untuk 1 kelompok kerja praktik.',
            ]
        );

        // Zahra (Telkom)
        $zahraInternship = Internship::updateOrCreate(
            [
                'student_id' => $zahraStudent->id,
                'company_id' => $telkom->id,
            ],
            [
                'supervisor_id' => $dosenMain->id,
                'group_id' => null,
                'type' => 'individual',
                'title' => 'Otomasi Monitoring Kualitas Jaringan Akses Fiber Optik Berbasis Python & REST API',
                'start_date' => Carbon::now()->subMonths(3)->format('Y-m-d'),
                'end_date' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'status' => 'approved',
                'admin_note' => 'Diterima magang divisi Network Telkom.',
            ]
        );

        // Budi Santoso (Telkom - 1/3 Kuota Individu)
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
                'start_date' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(50)->format('Y-m-d'),
                'status' => 'in_progress',
                'admin_note' => 'Berkas pengantar dan surat penerimaan PT Telkom valid.',
            ]
        );

        // BRI (3/3 Kuota Penuh)
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
                'start_date' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(45)->format('Y-m-d'),
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
                'start_date' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(45)->format('Y-m-d'),
                'status' => 'in_progress',
                'admin_note' => 'Diterima Unit IT Kanwil.',
            ]
        );

        // Alumni (Selesai KP & Review)
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
                'start_date' => Carbon::now()->subMonths(6)->format('Y-m-d'),
                'end_date' => Carbon::now()->subMonths(4)->format('Y-m-d'),
                'status' => 'completed',
                'admin_note' => 'KP telah selesai dan lulus sidang.',
            ]
        );

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

        // ==========================================
        // 7. Logbook Kegiatan
        // ==========================================
        // Logbook Tiwi
        InternshipLog::updateOrCreate(
            [
                'internship_id' => $tiwiInternship->id,
                'date' => Carbon::now()->subDays(1)->format('Y-m-d'),
            ],
            [
                'activity' => 'Perancangan Antarmuka Modul Analitik Kunjungan Layanan',
                'description' => 'Membuat wireframe dan prototipe high-fidelity untuk halaman analitik pengunjung layanan portal Diskominfo menggunakan Figma. Melakukan validasi awal dengan pembimbing lapangan.',
                'status' => 'submitted',
                'supervisor_note' => null,
            ]
        );

        InternshipLog::updateOrCreate(
            [
                'internship_id' => $tiwiInternship->id,
                'date' => Carbon::now()->subDays(3)->format('Y-m-d'),
            ],
            [
                'activity' => 'Integrasi API RESTful Backend Layanan Pengaduan',
                'description' => 'Menghubungkan frontend React dengan endpoint API backend pengaduan masyarakat. Menangani autentikasi token JWT dan validasi respon form pengaduan.',
                'status' => 'approved',
                'supervisor_note' => 'Kerja bagus, pastikan penanganan error HTTP 401 dan 422 sudah diuji di sisi client.',
            ]
        );

        InternshipLog::updateOrCreate(
            [
                'internship_id' => $tiwiInternship->id,
                'date' => Carbon::now()->subDays(7)->format('Y-m-d'),
            ],
            [
                'activity' => 'Analisis Kebutuhan Sistem & Wawancara Pengguna Bidang Aptika',
                'description' => 'Melakukan wawancara dengan staf bidang aplikasi informatika terkait alur distribusi tiket permohonan layanan publik.',
                'status' => 'revision',
                'supervisor_note' => 'Tambahkan lampiran matriks kebutuhan fungsional (FR) dan non-fungsional (NFR) sesuai standar penulisan KP.',
            ]
        );

        // Logbook Yulia
        InternshipLog::updateOrCreate(
            [
                'internship_id' => $yuliaInternship->id,
                'date' => Carbon::now()->subDays(2)->format('Y-m-d'),
            ],
            [
                'activity' => 'Pengujian Modul Publikasi Berita dan Siaran Pers',
                'description' => 'Melakukan pengujian black-box testing terhadap modul editor berita siaran pers dan mekanisme preview sebelum artikel dipublikasikan ke portal publik.',
                'status' => 'submitted',
                'supervisor_note' => null,
            ]
        );

        // Logbook Zahra
        InternshipLog::updateOrCreate(
            [
                'internship_id' => $zahraInternship->id,
                'date' => Carbon::now()->subDays(6)->format('Y-m-d'),
            ],
            [
                'activity' => 'Pengambilan Data Telemetri OLT dan Analisis Redaman Fiber Optik',
                'description' => 'Mengekstraksi data log loss optical power dari 15 perangkat OLT di sentral telepon Telkom Tanjung Karang menggunakan skrip Python otomatis.',
                'status' => 'submitted',
                'supervisor_note' => null,
            ]
        );

        // ==========================================
        // 8. Laporan Akhir KP
        // ==========================================
        InternshipReport::updateOrCreate(
            ['internship_id' => $zahraInternship->id],
            [
                'title' => 'Laporan Akhir KP: Otomasi Monitoring Kualitas Jaringan Fiber Optik Telkom Lampung',
                'file_path' => 'reports/laporan_kp_zahra_2417051027.pdf',
                'status' => 'submitted',
                'feedback' => null,
            ]
        );

        InternshipReport::updateOrCreate(
            ['internship_id' => $tiwiInternship->id],
            [
                'title' => 'Draf Laporan Akhir KP: Dashboard Pelayanan Publik Diskominfo Lampung',
                'file_path' => 'reports/draf_laporan_tiwi_2417051034.pdf',
                'status' => 'submitted',
                'feedback' => null,
            ]
        );

        // ==========================================
        // 9. Sidang KP
        // ==========================================
        SidangKp::updateOrCreate(
            ['internship_id' => $zahraInternship->id],
            [
                'sidang_date' => Carbon::now()->addDays(3)->setHour(9)->setMinute(30)->setSecond(0),
                'room' => 'Ruang Sidang 1 Gedung Dekanat FMIPA Unila',
                'status' => 'scheduled',
                'grade' => null,
                'notes' => 'Siapkan slide presentasi maksimal 15 menit dan bawa lembar berita acara sidang.',
            ]
        );

        SidangKp::updateOrCreate(
            ['internship_id' => $tiwiInternship->id],
            [
                'sidang_date' => null,
                'room' => null,
                'status' => 'submitted',
                'grade' => null,
                'notes' => 'Menunggu verifikasi berkas laporan dan penjadwalan oleh admin jurusan.',
            ]
        );
    }
}
