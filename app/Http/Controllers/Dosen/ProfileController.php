<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
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
        $user = Auth::user();
        $supervisor = $this->getSupervisor();

        $stats = [
            'total_students' => DB::table('internships')->where('supervisor_id', $supervisor->id)->count(),
            'active_students' => DB::table('internships')->where('supervisor_id', $supervisor->id)->whereIn('status', ['approved', 'in_progress'])->count(),
            'completed_students' => DB::table('internships')->where('supervisor_id', $supervisor->id)->where('status', 'completed')->count(),
            'reviewed_logs' => DB::table('internship_logs')
                ->join('internships', 'internships.id', '=', 'internship_logs.internship_id')
                ->where('internships.supervisor_id', $supervisor->id)
                ->whereIn('internship_logs.status', ['approved', 'revision'])
                ->count(),
            'reviewed_reports' => DB::table('internship_reports')
                ->join('internships', 'internships.id', '=', 'internship_reports.internship_id')
                ->where('internships.supervisor_id', $supervisor->id)
                ->whereIn('internship_reports.status', ['approved', 'revision'])
                ->count(),
        ];

        return view('dosen.profile.index', compact('user', 'supervisor', 'stats'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $supervisor = $this->getSupervisor();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => [
                'required',
                'string',
                'max:50',
                Rule::unique('supervisors', 'nip')->ignore($supervisor->id),
            ],
            'department' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        DB::transaction(function () use ($user, $supervisor, $validated): void {
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'name' => $validated['name'],
                    'updated_at' => now(),
                ]);

            DB::table('supervisors')
                ->where('id', $supervisor->id)
                ->update([
                    'nip' => $validated['nip'],
                    'department' => $validated['department'],
                    'phone' => $validated['phone'] ?? null,
                    'updated_at' => now(),
                ]);
        });

        return back()->with('success', 'Data profil dosen berhasil diperbarui.');
    }
}
