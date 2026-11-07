<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected function getSupervisor(): object
    {
        $userId = Auth::id();
        $supervisor = DB::table('supervisors')->where('user_id', $userId)->first();

        if (! $supervisor) {
            $id = DB::table('supervisors')->insertGetId([
                'user_id' => $userId,
                'nip' => '19800101'.str_pad((string) $userId, 6, '0', STR_PAD_LEFT),
                'department' => 'Ilmu Komputer',
                'phone' => '08123456789',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $supervisor = DB::table('supervisors')->where('id', $id)->first();
        }

        return $supervisor;
    }

    public function index(): View
    {
        $supervisor = $this->getSupervisor();
        $period = now()->year;

        $myInternshipIds = DB::table('internships')
            ->where('supervisor_id', $supervisor->id)
            ->pluck('id');

        $stats = [
            'total_students' => $myInternshipIds->count(),
            'active_students' => DB::table('internships')
                ->where('supervisor_id', $supervisor->id)
                ->whereIn('status', ['approved', 'in_progress'])
                ->count(),
            'pending_logs' => DB::table('internship_logs')
                ->whereIn('internship_id', $myInternshipIds)
                ->where('status', 'submitted')
                ->count(),
            'pending_reports' => DB::table('internship_reports')
                ->whereIn('internship_id', $myInternshipIds)
                ->where('status', 'submitted')
                ->count(),
            'scheduled_sidang' => DB::table('sidang_kps')
                ->whereIn('internship_id', $myInternshipIds)
                ->where('status', 'scheduled')
                ->count(),
            'completed' => DB::table('internships')
                ->where('supervisor_id', $supervisor->id)
                ->where('status', 'completed')
                ->count(),
        ];

        // Sebaran status KP mahasiswa bimbingan
        $statusCounts = DB::table('internships')
            ->where('supervisor_id', $supervisor->id)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->map(fn ($total) => (int) $total)
            ->all();

        // 5 Mahasiswa bimbingan terbaru
        $recentStudents = DB::table('internships')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('companies', 'companies.id', '=', 'internships.company_id')
            ->where('internships.supervisor_id', $supervisor->id)
            ->orderByDesc('internships.updated_at')
            ->limit(5)
            ->get([
                'internships.id',
                'internships.title',
                'internships.type',
                'internships.status',
                'internships.start_date',
                'internships.end_date',
                'users.name as student_name',
                'students.npm',
                'companies.name as company_name',
            ]);

        // 5 Logbook yang menunggu pemeriksaan
        $pendingLogs = DB::table('internship_logs')
            ->join('internships', 'internships.id', '=', 'internship_logs.internship_id')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->where('internships.supervisor_id', $supervisor->id)
            ->where('internship_logs.status', 'submitted')
            ->orderByDesc('internship_logs.date')
            ->limit(5)
            ->get([
                'internship_logs.id',
                'internship_logs.internship_id',
                'internship_logs.date',
                'internship_logs.activity',
                'internship_logs.status',
                'users.name as student_name',
                'students.npm',
            ]);

        // 5 Laporan akhir yang menunggu review
        $pendingReports = DB::table('internship_reports')
            ->join('internships', 'internships.id', '=', 'internship_reports.internship_id')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->where('internships.supervisor_id', $supervisor->id)
            ->where('internship_reports.status', 'submitted')
            ->orderByDesc('internship_reports.created_at')
            ->limit(5)
            ->get([
                'internship_reports.id',
                'internship_reports.internship_id',
                'internship_reports.title',
                'internship_reports.created_at',
                'users.name as student_name',
                'students.npm',
            ]);

        // 5 Sidang KP mendatang
        $upcomingSidang = DB::table('sidang_kps')
            ->join('internships', 'internships.id', '=', 'sidang_kps.internship_id')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->where('internships.supervisor_id', $supervisor->id)
            ->whereIn('sidang_kps.status', ['submitted', 'scheduled'])
            ->orderByRaw('sidang_kps.sidang_date IS NULL')
            ->orderBy('sidang_kps.sidang_date')
            ->limit(5)
            ->get([
                'sidang_kps.id',
                'sidang_kps.sidang_date',
                'sidang_kps.room',
                'sidang_kps.status',
                'internships.title',
                'users.name as student_name',
                'students.npm',
            ]);

        return view('dosen.dashboard', compact(
            'supervisor',
            'period',
            'stats',
            'statusCounts',
            'recentStudents',
            'pendingLogs',
            'pendingReports',
            'upcomingSidang'
        ));
    }
}
