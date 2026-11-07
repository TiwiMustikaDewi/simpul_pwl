<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BimbinganController extends Controller
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

    public function index(Request $request): View
    {
        $supervisor = $this->getSupervisor();

        $statusFilter = $request->query('status', 'all');
        $search = $request->query('q');

        // Subquery log counts
        $logStats = DB::table('internship_logs')
            ->select(
                'internship_id',
                DB::raw('COUNT(*) as total_logs'),
                DB::raw("COUNT(CASE WHEN status = 'approved' THEN 1 END) as approved_logs"),
                DB::raw("COUNT(CASE WHEN status = 'submitted' THEN 1 END) as pending_logs")
            )
            ->groupBy('internship_id');

        // Subquery report stats
        $reportStats = DB::table('internship_reports')
            ->select(
                'internship_id',
                DB::raw('COUNT(*) as total_reports'),
                DB::raw('MAX(status) as latest_report_status')
            )
            ->groupBy('internship_id');

        $query = DB::table('internships')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('companies', 'companies.id', '=', 'internships.company_id')
            ->leftJoin('internship_groups', 'internship_groups.id', '=', 'internships.group_id')
            ->leftJoin('sidang_kps', 'sidang_kps.internship_id', '=', 'internships.id')
            ->leftJoinSub($logStats, 'log_stats', 'log_stats.internship_id', '=', 'internships.id')
            ->leftJoinSub($reportStats, 'report_stats', 'report_stats.internship_id', '=', 'internships.id')
            ->where('internships.supervisor_id', $supervisor->id)
            ->select([
                'internships.id',
                'internships.type',
                'internships.title',
                'internships.start_date',
                'internships.end_date',
                'internships.status',
                'internships.group_id',
                'users.name as student_name',
                'users.email as student_email',
                'students.npm',
                'students.major',
                'companies.name as company_name',
                'companies.city as company_city',
                'internship_groups.name as group_name',
                'sidang_kps.status as sidang_status',
                'sidang_kps.grade as sidang_grade',
                'sidang_kps.sidang_date',
                DB::raw('COALESCE(log_stats.total_logs, 0) as total_logs'),
                DB::raw('COALESCE(log_stats.approved_logs, 0) as approved_logs'),
                DB::raw('COALESCE(log_stats.pending_logs, 0) as pending_logs'),
                DB::raw('COALESCE(report_stats.total_reports, 0) as total_reports'),
                'report_stats.latest_report_status',
            ]);

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('internships.status', $statusFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('students.npm', 'like', "%{$search}%")
                    ->orWhere('companies.name', 'like', "%{$search}%")
                    ->orWhere('internships.title', 'like', "%{$search}%");
            });
        }

        $internships = $query->orderByDesc('internships.updated_at')->get();

        // Status counts for filter pills
        $counts = [
            'all' => DB::table('internships')->where('supervisor_id', $supervisor->id)->count(),
            'in_progress' => DB::table('internships')->where('supervisor_id', $supervisor->id)->where('status', 'in_progress')->count(),
            'approved' => DB::table('internships')->where('supervisor_id', $supervisor->id)->where('status', 'approved')->count(),
            'completed' => DB::table('internships')->where('supervisor_id', $supervisor->id)->where('status', 'completed')->count(),
        ];

        return view('dosen.bimbingan.index', compact('internships', 'statusFilter', 'search', 'counts'));
    }

    public function show(int $internshipId): View
    {
        $supervisor = $this->getSupervisor();

        $internship = DB::table('internships')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('companies', 'companies.id', '=', 'internships.company_id')
            ->leftJoin('internship_groups', 'internship_groups.id', '=', 'internships.group_id')
            ->where('internships.id', $internshipId)
            ->where('internships.supervisor_id', $supervisor->id)
            ->select([
                'internships.*',
                'users.name as student_name',
                'users.email as student_email',
                'students.npm',
                'students.major',
                'students.phone as student_phone',
                'companies.name as company_name',
                'companies.address as company_address',
                'companies.city as company_city',
                'companies.contact_person as company_contact',
                'companies.phone as company_phone',
                'internship_groups.name as group_name',
            ])
            ->first();

        abort_if(! $internship, 404, 'Data bimbingan KP tidak ditemukan atau bukan bimbingan Anda.');

        // Group members if this is a group
        $groupMembers = [];
        if ($internship->group_id) {
            $groupMembers = DB::table('internship_group_members')
                ->join('students', 'students.id', '=', 'internship_group_members.student_id')
                ->join('users', 'users.id', '=', 'students.user_id')
                ->where('internship_group_members.group_id', $internship->group_id)
                ->get([
                    'users.name',
                    'students.npm',
                    'students.major',
                ]);
        }

        // Logs
        $logs = DB::table('internship_logs')
            ->where('internship_id', $internshipId)
            ->orderByDesc('date')
            ->get();

        // Reports
        $reports = DB::table('internship_reports')
            ->where('internship_id', $internshipId)
            ->orderByDesc('created_at')
            ->get();

        // Sidang
        $sidang = DB::table('sidang_kps')
            ->where('internship_id', $internshipId)
            ->first();

        return view('dosen.bimbingan.show', compact('internship', 'groupMembers', 'logs', 'reports', 'sidang'));
    }
}
