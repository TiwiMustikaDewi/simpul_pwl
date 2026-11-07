<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = now();

        // 1. Admin
        User::updateOrCreate(
            ['email' => 'admin@simpul.test'],
            [
                'name' => 'Dinar Aisa Artika',
                'password' => 'password123',
                'role' => 'admin',
            ]
        );

        // 2. Dosen Pembimbing
        $dosenUser = User::updateOrCreate(
            ['email' => 'dosen@simpul.test'],
            [
                'name' => 'Dr. Ing. Ahmad Zarkasi, S.Kom., M.T.',
                'password' => 'password123',
                'role' => 'supervisor',
            ]
        );

        DB::table('supervisors')->updateOrInsert(
            ['user_id' => $dosenUser->id],
            [
                'nip' => '198203152008121002',
                'department' => 'S1 Ilmu Komputer',
                'phone' => '081298765432',
                'updated_at' => $now,
            ]
        );
        $supervisor = DB::table('supervisors')->where('user_id', $dosenUser->id)->first();

        // 3. Perusahaan
        $telkom = DB::table('companies')->where('name', 'like', '%Telkom%')->first();
        $telkomId = $telkom ? $telkom->id : DB::table('companies')->insertGetId([
            'name' => 'PT Telkom Indonesia (Persero) Tbk Witel Lampung',
            'address' => 'Jl. Pangeran Diponegoro No. 89, Teluk Betung',
            'city' => 'Bandar Lampung',
            'contact_person' => 'Rian Hidayat (HR Talent & Internship)',
            'phone' => '0721-482200',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $diskominfo = DB::table('companies')->where('name', 'like', '%Kominfotik%')->first();
        $diskominfoId = $diskominfo ? $diskominfo->id : DB::table('companies')->insertGetId([
            'name' => 'Dinas Kominfotik Provinsi Lampung',
            'address' => 'Jl. WR. Monginsidi No. 69, Teluk Betung Utara',
            'city' => 'Bandar Lampung',
            'contact_person' => 'Bambang Irawan, S.Kom. (Kasi Aplikasi Informatika)',
            'phone' => '0721-481177',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 4. Mahasiswa
        $tiwiUser = User::updateOrCreate(
            ['email' => 'tiwi@simpul.test'],
            [
                'name' => 'Tiwi Mustika Dewi',
                'password' => 'password123',
                'role' => 'student',
            ]
        );
        DB::table('students')->updateOrInsert(
            ['npm' => '2417051034'],
            [
                'user_id' => $tiwiUser->id,
                'major' => 'S1 Ilmu Komputer',
                'phone' => '081377889901',
                'updated_at' => $now,
            ]
        );
        $tiwiStudent = DB::table('students')->where('npm', '2417051034')->first();

        $yuliaUser = User::updateOrCreate(
            ['email' => 'yulia@simpul.test'],
            [
                'name' => 'Yulia Nuritnasari',
                'password' => 'password123',
                'role' => 'student',
            ]
        );
        DB::table('students')->updateOrInsert(
            ['npm' => '2457051008'],
            [
                'user_id' => $yuliaUser->id,
                'major' => 'S1 Ilmu Komputer',
                'phone' => '081377889902',
                'updated_at' => $now,
            ]
        );
        $yuliaStudent = DB::table('students')->where('npm', '2457051008')->first();

        $zahraUser = User::updateOrCreate(
            ['email' => 'zahra@simpul.test'],
            [
                'name' => 'Zahra Ayesha Nurdina',
                'password' => 'password123',
                'role' => 'student',
            ]
        );
        DB::table('students')->updateOrInsert(
            ['npm' => '2417051027'],
            [
                'user_id' => $zahraUser->id,
                'major' => 'S1 Ilmu Komputer',
                'phone' => '081377889903',
                'updated_at' => $now,
            ]
        );
        $zahraStudent = DB::table('students')->where('npm', '2417051027')->first();

        // 5. Kelompok KP (Tiwi & Yulia)
        $group = DB::table('internship_groups')->where('name', 'Tim Diskominfo Squad')->first();
        $groupId = $group ? $group->id : DB::table('internship_groups')->insertGetId([
            'name' => 'Tim Diskominfo Squad',
            'leader_id' => $tiwiStudent->id,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('internship_group_members')->updateOrInsert(
            ['group_id' => $groupId, 'student_id' => $tiwiStudent->id],
            ['updated_at' => $now]
        );
        DB::table('internship_group_members')->updateOrInsert(
            ['group_id' => $groupId, 'student_id' => $yuliaStudent->id],
            ['updated_at' => $now]
        );

        // 6. Internships
        $tiwiInternship = DB::table('internships')->where('student_id', $tiwiStudent->id)->first();
        $tiwiInternshipId = $tiwiInternship ? $tiwiInternship->id : DB::table('internships')->insertGetId([
            'student_id' => $tiwiStudent->id,
            'company_id' => $diskominfoId,
            'supervisor_id' => $supervisor->id,
            'group_id' => $groupId,
            'type' => 'group',
            'title' => 'Pengembangan Sistem Dashboard Pelayanan Publik Diskominfo Provinsi Lampung',
            'start_date' => now()->subMonths(2)->format('Y-m-d'),
            'end_date' => now()->addMonth()->format('Y-m-d'),
            'status' => 'in_progress',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $yuliaInternship = DB::table('internships')->where('student_id', $yuliaStudent->id)->first();
        $yuliaInternshipId = $yuliaInternship ? $yuliaInternship->id : DB::table('internships')->insertGetId([
            'student_id' => $yuliaStudent->id,
            'company_id' => $diskominfoId,
            'supervisor_id' => $supervisor->id,
            'group_id' => $groupId,
            'type' => 'group',
            'title' => 'Implementasi Modul Pengelolaan Konten Portal Web Provinsi Lampung',
            'start_date' => now()->subMonths(2)->format('Y-m-d'),
            'end_date' => now()->addMonth()->format('Y-m-d'),
            'status' => 'in_progress',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $zahraInternship = DB::table('internships')->where('student_id', $zahraStudent->id)->first();
        $zahraInternshipId = $zahraInternship ? $zahraInternship->id : DB::table('internships')->insertGetId([
            'student_id' => $zahraStudent->id,
            'company_id' => $telkomId,
            'supervisor_id' => $supervisor->id,
            'group_id' => null,
            'type' => 'individual',
            'title' => 'Otomasi Monitoring Kualitas Jaringan Akses Fiber Optik Berbasis Python & REST API',
            'start_date' => now()->subMonths(3)->format('Y-m-d'),
            'end_date' => now()->subDays(5)->format('Y-m-d'),
            'status' => 'approved',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 7. Logbook entries
        if (DB::table('internship_logs')->where('internship_id', $tiwiInternshipId)->count() === 0) {
            DB::table('internship_logs')->insert([
                [
                    'internship_id' => $tiwiInternshipId,
                    'date' => now()->subDays(1)->format('Y-m-d'),
                    'activity' => 'Perancangan Antarmuka Modul Analitik Kunjungan Layanan',
                    'description' => 'Membuat wireframe dan prototipe high-fidelity untuk halaman analitik pengunjung layanan portal Diskominfo menggunakan Figma. Melakukan validasi awal dengan pembimbing lapangan.',
                    'status' => 'submitted',
                    'supervisor_note' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'internship_id' => $tiwiInternshipId,
                    'date' => now()->subDays(3)->format('Y-m-d'),
                    'activity' => 'Integrasi API RESTful Backend Layanan Pengaduan',
                    'description' => 'Menghubungkan frontend React dengan endpoint API backend pengaduan masyarakat. Menangani autentikasi token JWT dan validasi respon form pengaduan.',
                    'status' => 'approved',
                    'supervisor_note' => 'Kerja bagus, pastikan penanganan error HTTP 401 dan 422 sudah diuji di sisi client.',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'internship_id' => $tiwiInternshipId,
                    'date' => now()->subDays(7)->format('Y-m-d'),
                    'activity' => 'Analisis Kebutuhan Sistem & Wawancara Pengguna Bidang Aptika',
                    'description' => 'Melakukan wawancara dengan staf bidang aplikasi informatika terkait alur distribusi tiket permohonan layanan publik.',
                    'status' => 'revision',
                    'supervisor_note' => 'Tambahkan lampiran matriks kebutuhan fungsional (FR) dan non-fungsional (NFR) sesuai standar penulisan KP.',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        if (DB::table('internship_logs')->where('internship_id', $yuliaInternshipId)->count() === 0) {
            DB::table('internship_logs')->insert([
                [
                    'internship_id' => $yuliaInternshipId,
                    'date' => now()->subDays(2)->format('Y-m-d'),
                    'activity' => 'Pengujian Modul Publikasi Berita dan Siaran Pers',
                    'description' => 'Melakukan pengujian black-box testing terhadap modul editor berita siaran pers dan mekanisme preview sebelum artikel dipublikasikan ke portal publik.',
                    'status' => 'submitted',
                    'supervisor_note' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        if (DB::table('internship_logs')->where('internship_id', $zahraInternshipId)->count() === 0) {
            DB::table('internship_logs')->insert([
                [
                    'internship_id' => $zahraInternshipId,
                    'date' => now()->subDays(6)->format('Y-m-d'),
                    'activity' => 'Pengambilan Data Telemetri OLT dan Analisis Redaman Fiber Optik',
                    'description' => 'Mengekstraksi data log loss optical power dari 15 perangkat OLT di sentral telepon Telkom Tanjung Karang menggunakan skrip Python otomatis.',
                    'status' => 'submitted',
                    'supervisor_note' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        // 8. Internship Reports
        if (DB::table('internship_reports')->where('internship_id', $zahraInternshipId)->count() === 0) {
            DB::table('internship_reports')->insert([
                'internship_id' => $zahraInternshipId,
                'title' => 'Laporan Akhir KP: Otomasi Monitoring Kualitas Jaringan Fiber Optik Telkom Lampung',
                'file_path' => 'reports/laporan_kp_zahra_2417051027.pdf',
                'status' => 'submitted',
                'feedback' => null,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ]);
        }

        if (DB::table('internship_reports')->where('internship_id', $tiwiInternshipId)->count() === 0) {
            DB::table('internship_reports')->insert([
                'internship_id' => $tiwiInternshipId,
                'title' => 'Draf Laporan Akhir KP: Dashboard Pelayanan Publik Diskominfo Lampung',
                'file_path' => 'reports/draf_laporan_tiwi_2417051034.pdf',
                'status' => 'submitted',
                'feedback' => null,
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ]);
        }

        // 9. Sidang KP
        if (DB::table('sidang_kps')->where('internship_id', $zahraInternshipId)->count() === 0) {
            DB::table('sidang_kps')->insert([
                'internship_id' => $zahraInternshipId,
                'sidang_date' => now()->addDays(3)->setHour(9)->setMinute(30)->setSecond(0)->format('Y-m-d H:i:s'),
                'room' => 'Ruang Sidang 1 Gedung Dekanat FMIPA Unila',
                'status' => 'scheduled',
                'grade' => null,
                'notes' => 'Siapkan slide presentasi maksimal 15 menit dan bawa lembar berita acara sidang.',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (DB::table('sidang_kps')->where('internship_id', $tiwiInternshipId)->count() === 0) {
            DB::table('sidang_kps')->insert([
                'internship_id' => $tiwiInternshipId,
                'sidang_date' => null,
                'room' => null,
                'status' => 'submitted',
                'grade' => null,
                'notes' => 'Menunggu verifikasi berkas laporan dan penjadwalan oleh admin jurusan.',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
