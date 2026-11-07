<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LogbookController extends Controller
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
        $studentFilter = $request->query('student_id');
        $search = $request->query('q');

        // Subvised internships for student dropdown
        $myStudents = DB::table('internships')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->where('internships.supervisor_id', $supervisor->id)
            ->select('internships.id as internship_id', 'users.name', 'students.npm')
            ->orderBy('users.name')
            ->get();

        $query = DB::table('internship_logs')
            ->join('internships', 'internships.id', '=', 'internship_logs.internship_id')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('companies', 'companies.id', '=', 'internships.company_id')
            ->where('internships.supervisor_id', $supervisor->id)
            ->select([
                'internship_logs.*',
                'internships.title as internship_title',
                'users.name as student_name',
                'students.npm',
                'companies.name as company_name',
            ]);

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('internship_logs.status', $statusFilter);
        }

        if ($studentFilter) {
            $query->where('internship_logs.internship_id', (int) $studentFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('students.npm', 'like', "%{$search}%")
                    ->orWhere('internship_logs.activity', 'like', "%{$search}%")
                    ->orWhere('internship_logs.description', 'like', "%{$search}%");
            });
        }

        $logs = $query->orderByDesc('internship_logs.date')
            ->orderByDesc('internship_logs.id')
            ->get();

        // Summary counts for filter pills
        $baseQuery = DB::table('internship_logs')
            ->join('internships', 'internships.id', '=', 'internship_logs.internship_id')
            ->where('internships.supervisor_id', $supervisor->id);

        if ($studentFilter) {
            $baseQuery->where('internship_logs.internship_id', (int) $studentFilter);
        }

        $counts = [
            'all' => (clone $baseQuery)->count(),
            'submitted' => (clone $baseQuery)->where('internship_logs.status', 'submitted')->count(),
            'approved' => (clone $baseQuery)->where('internship_logs.status', 'approved')->count(),
            'revision' => (clone $baseQuery)->where('internship_logs.status', 'revision')->count(),
        ];

        return view('dosen.logbook.index', compact('logs', 'myStudents', 'statusFilter', 'studentFilter', 'search', 'counts'));
    }

    public function review(Request $request, int $logId): RedirectResponse
    {
        $supervisor = $this->getSupervisor();

        $validated = $request->validate([
            'status' => ['required', 'in:approved,revision'],
            'supervisor_note' => ['nullable', 'string', 'max:5000'],
        ]);

        $log = DB::table('internship_logs')
            ->join('internships', 'internships.id', '=', 'internship_logs.internship_id')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->where('internship_logs.id', $logId)
            ->where('internships.supervisor_id', $supervisor->id)
            ->select('internship_logs.*', 'students.user_id as student_user_id')
            ->first();

        abort_if(! $log, 404, 'Data logbook tidak ditemukan atau bukan bimbingan Anda.');

        DB::table('internship_logs')
            ->where('id', $logId)
            ->update([
                'status' => $validated['status'],
                'supervisor_note' => $validated['supervisor_note'] ?? null,
                'updated_at' => now(),
            ]);

        // Kirim notifikasi ke mahasiswa
        $statusText = $validated['status'] === 'approved' ? 'Disetujui' : 'Perlu Revisi';
        $noteMsg = ! empty($validated['supervisor_note']) ? "\nCatatan: ".$validated['supervisor_note'] : '';

        DB::table('notifications')->insert([
            'user_id' => $log->student_user_id,
            'title' => "Logbook {$statusText}",
            'message' => "Logbook kegiatan tanggal {$log->date} ({$log->activity}) telah ditinjau oleh dosen pembimbing. Status: {$statusText}.{$noteMsg}",
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', "Logbook berhasil ditinjau (Status: {$statusText}).");
    }
}
