<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\SidangKp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SidangController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $student = $user->student;

        $internship = null;
        $sidang = null;
        if ($student) {
            $internship = Internship::with(['company', 'supervisor.user', 'reports', 'sidang'])
                ->where(function ($q) use ($student) {
                    $q->where('student_id', $student->id)
                        ->orWhereHas('group.members', fn ($sub) => $sub->where('student_id', $student->id));
                })
                ->whereIn('status', ['in_progress', 'completed'])
                ->first();

            $sidang = $internship?->sidang;
        }

        return view('student.sidang.index', [
            'internship' => $internship,
            'sidang' => $sidang,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $student = $user->student;

        $internship = Internship::where(function ($q) use ($student) {
            $q->where('student_id', $student->id)
                ->orWhereHas('group.members', fn ($sub) => $sub->where('student_id', $student->id));
        })
            ->whereIn('status', ['in_progress', 'completed'])
            ->firstOrFail();

        if ($internship->sidang) {
            return back()->with('info', 'Pengajuan sidang sudah terdaftar.');
        }

        SidangKp::create([
            'internship_id' => $internship->id,
            'sidang_date' => null,
            'room' => null,
            'status' => 'submitted',
            'grade' => null,
            'notes' => null,
        ]);

        return back()->with('success', 'Pendaftaran sidang KP berhasil diajukan! Admin Jurusan akan menjadwalkan waktu dan ruangan sidang.');
    }
}
