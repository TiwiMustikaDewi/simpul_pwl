<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
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

        $query = DB::table('internship_reports')
            ->join('internships', 'internships.id', '=', 'internship_reports.internship_id')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('companies', 'companies.id', '=', 'internships.company_id')
            ->where('internships.supervisor_id', $supervisor->id)
            ->select([
                'internship_reports.*',
                'internships.title as internship_title',
                'users.name as student_name',
                'students.npm',
                'companies.name as company_name',
            ]);

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('internship_reports.status', $statusFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('students.npm', 'like', "%{$search}%")
                    ->orWhere('internship_reports.title', 'like', "%{$search}%");
            });
        }

        $reports = $query->orderByDesc('internship_reports.created_at')->get();

        $baseQuery = DB::table('internship_reports')
            ->join('internships', 'internships.id', '=', 'internship_reports.internship_id')
            ->where('internships.supervisor_id', $supervisor->id);

        $counts = [
            'all' => (clone $baseQuery)->count(),
            'submitted' => (clone $baseQuery)->where('internship_reports.status', 'submitted')->count(),
            'approved' => (clone $baseQuery)->where('internship_reports.status', 'approved')->count(),
            'revision' => (clone $baseQuery)->where('internship_reports.status', 'revision')->count(),
        ];

        return view('dosen.laporan.index', compact('reports', 'statusFilter', 'search', 'counts'));
    }

    public function review(Request $request, int $reportId): RedirectResponse
    {
        $supervisor = $this->getSupervisor();

        $validated = $request->validate([
            'status' => ['required', 'in:approved,revision'],
            'feedback' => ['nullable', 'string', 'max:5000'],
        ]);

        $report = DB::table('internship_reports')
            ->join('internships', 'internships.id', '=', 'internship_reports.internship_id')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->where('internship_reports.id', $reportId)
            ->where('internships.supervisor_id', $supervisor->id)
            ->select('internship_reports.*', 'students.user_id as student_user_id')
            ->first();

        abort_if(! $report, 404, 'Data laporan tidak ditemukan atau bukan bimbingan Anda.');

        DB::table('internship_reports')
            ->where('id', $reportId)
            ->update([
                'status' => $validated['status'],
                'feedback' => $validated['feedback'] ?? null,
                'updated_at' => now(),
            ]);

        $statusText = $validated['status'] === 'approved' ? 'Disetujui' : 'Perlu Revisi';
        $feedbackMsg = ! empty($validated['feedback']) ? "\nCatatan: ".$validated['feedback'] : '';

        DB::table('notifications')->insert([
            'user_id' => $report->student_user_id,
            'title' => "Laporan Akhir KP {$statusText}",
            'message' => "Laporan akhir '{$report->title}' telah diperiksa oleh dosen pembimbing. Status: {$statusText}.{$feedbackMsg}",
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', "Laporan akhir berhasil ditinjau (Status: {$statusText}).");
    }

    public function download(int $reportId): BinaryFileResponse|RedirectResponse
    {
        $supervisor = $this->getSupervisor();

        $report = DB::table('internship_reports')
            ->join('internships', 'internships.id', '=', 'internship_reports.internship_id')
            ->where('internship_reports.id', $reportId)
            ->where('internships.supervisor_id', $supervisor->id)
            ->select('internship_reports.*')
            ->first();

        abort_if(! $report, 404, 'Laporan tidak ditemukan.');

        if ($report->file_path && Storage::exists($report->file_path)) {
            return response()->download(Storage::path($report->file_path), $report->title.'.pdf');
        }

        if ($report->file_path && file_exists(public_path($report->file_path))) {
            return response()->download(public_path($report->file_path), $report->title.'.pdf');
        }

        return back()->with('error', "Berkas fisik laporan ('{$report->file_path}') belum diunggah atau tidak ditemukan di penyimpanan server.");
    }
}
