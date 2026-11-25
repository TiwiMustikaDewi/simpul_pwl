<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\SidangKp;
use Carbon\Carbon;
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

        $validated = $request->validate([
            'proposed_date' => ['required', 'date', 'after:now'],
            'presentation_file' => ['nullable', 'file', 'mimes:pdf,ppt,pptx,zip', 'max:20480'],
            'student_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $filePath = null;
        if ($request->hasFile('presentation_file')) {
            $filePath = $request->file('presentation_file')->store('presentation_slides', 'public');
        }

        SidangKp::create([
            'internship_id' => $internship->id,
            'proposed_date' => ! empty($validated['proposed_date']) ? Carbon::parse($validated['proposed_date']) : null,
            'presentation_file' => $filePath,
            'student_notes' => $validated['student_notes'] ?? null,
            'sidang_date' => null,
            'room' => null,
            'status' => 'submitted',
            'grade' => null,
            'notes' => null,
        ]);

        return back()->with('success', 'Pendaftaran sidang KP berhasil diajukan! Usulan jadwal Anda telah dikirimkan ke Admin Jurusan untuk diverifikasi dan ditetapkan.');
    }
}
