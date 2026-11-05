<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $period = now()->year;

        $stats = [
            'students' => DB::table('students')->count(),
            'supervisors' => DB::table('supervisors')->count(),
            'companies' => DB::table('companies')->count(),
            'pending' => DB::table('internships')->where('status', 'pending')->count(),
            // KP disetujui / berjalan yang belum punya dosen pembimbing
            'unassigned' => DB::table('internships')
                ->whereIn('status', ['approved', 'in_progress'])
                ->whereNull('supervisor_id')
                ->count(),
        ];

        // Hasil: ['pending' => 3, 'approved' => 5, ...]
        $statusCounts = DB::table('internships')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->map(fn ($total) => (int) $total)
            ->all();

        // Pengajuan menunggu verifikasi (terbaru dulu)
        $pending = DB::table('internships')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('companies', 'companies.id', '=', 'internships.company_id')
            ->where('internships.status', 'pending')
            ->orderByDesc('internships.created_at')
            ->limit(5)
            ->get([
                'internships.id',
                'internships.type',
                'internships.created_at',
                'users.name as student_name',
                'companies.name as company_name',
            ]);

        // Sidang yang masih aktif (diajukan / terjadwal)
        $sidang = DB::table('sidang_kps')
            ->join('internships', 'internships.id', '=', 'sidang_kps.internship_id')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->whereIn('sidang_kps.status', ['submitted', 'scheduled'])
            ->orderByRaw('sidang_kps.sidang_date IS NULL')
            ->orderBy('sidang_kps.sidang_date')
            ->limit(5)
            ->get([
                'sidang_kps.id',
                'sidang_kps.sidang_date',
                'sidang_kps.room',
                'sidang_kps.status',
                'users.name as student_name',
            ]);

        // Pengalaman KP yang belum divalidasi
        $experiences = DB::table('internship_experiences')
            ->join('students', 'students.id', '=', 'internship_experiences.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('companies', 'companies.id', '=', 'internship_experiences.company_id')
            ->where('internship_experiences.is_validated', false)
            ->orderByDesc('internship_experiences.created_at')
            ->limit(5)
            ->get([
                'internship_experiences.id',
                'internship_experiences.position',
                'users.name as student_name',
                'companies.name as company_name',
            ]);

        return view('admin.dashboard', compact(
            'period',
            'stats',
            'statusCounts',
            'pending',
            'sidang',
            'experiences'
        ));
    }
}
