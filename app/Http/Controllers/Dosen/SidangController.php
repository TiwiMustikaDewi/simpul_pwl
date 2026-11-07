<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SidangController extends Controller
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

        $query = DB::table('sidang_kps')
            ->join('internships', 'internships.id', '=', 'sidang_kps.internship_id')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('companies', 'companies.id', '=', 'internships.company_id')
            ->where('internships.supervisor_id', $supervisor->id)
            ->select([
                'sidang_kps.*',
                'internships.title as internship_title',
                'internships.type as internship_type',
                'users.name as student_name',
                'students.npm',
                'students.major',
                'companies.name as company_name',
            ]);

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('sidang_kps.status', $statusFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('students.npm', 'like', "%{$search}%")
                    ->orWhere('internships.title', 'like', "%{$search}%")
                    ->orWhere('sidang_kps.room', 'like', "%{$search}%");
            });
        }

        $sidangList = $query->orderByRaw("CASE sidang_kps.status WHEN 'scheduled' THEN 0 WHEN 'submitted' THEN 1 ELSE 2 END")
            ->orderBy('sidang_kps.sidang_date')
            ->get();

        $baseQuery = DB::table('sidang_kps')
            ->join('internships', 'internships.id', '=', 'sidang_kps.internship_id')
            ->where('internships.supervisor_id', $supervisor->id);

        $counts = [
            'all' => (clone $baseQuery)->count(),
            'scheduled' => (clone $baseQuery)->where('sidang_kps.status', 'scheduled')->count(),
            'submitted' => (clone $baseQuery)->where('sidang_kps.status', 'submitted')->count(),
            'completed' => (clone $baseQuery)->where('sidang_kps.status', 'completed')->count(),
        ];

        return view('dosen.sidang.index', compact('sidangList', 'statusFilter', 'search', 'counts'));
    }

    public function grade(Request $request, int $sidangId): RedirectResponse
    {
        $supervisor = $this->getSupervisor();

        $validated = $request->validate([
            'grade' => ['required', 'string', 'max:10'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $sidang = DB::table('sidang_kps')
            ->join('internships', 'internships.id', '=', 'sidang_kps.internship_id')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->where('sidang_kps.id', $sidangId)
            ->where('internships.supervisor_id', $supervisor->id)
            ->select('sidang_kps.*', 'internships.id as internship_id', 'students.user_id as student_user_id')
            ->first();

        abort_if(! $sidang, 404, 'Data sidang KP tidak ditemukan atau bukan bimbingan Anda.');

        DB::transaction(function () use ($sidangId, $sidang, $validated): void {
            DB::table('sidang_kps')
                ->where('id', $sidangId)
                ->update([
                    'grade' => strtoupper(trim($validated['grade'])),
                    'notes' => $validated['notes'] ?? null,
                    'status' => 'completed',
                    'updated_at' => now(),
                ]);

            DB::table('internships')
                ->where('id', $sidang->internship_id)
                ->update([
                    'status' => 'completed',
                    'updated_at' => now(),
                ]);

            $notesMsg = ! empty($validated['notes']) ? "\nCatatan: ".$validated['notes'] : '';

            DB::table('notifications')->insert([
                'user_id' => $sidang->student_user_id,
                'title' => 'Nilai Sidang KP Diberikan',
                'message' => 'Sidang Kuliah Praktik Anda telah dinilai oleh Dosen Pembimbing. Nilai Akhir: '.strtoupper(trim($validated['grade'])).".{$notesMsg}",
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return back()->with('success', 'Nilai dan evaluasi sidang KP berhasil disimpan. Status KP kini dinyatakan Selesai.');
    }
}
