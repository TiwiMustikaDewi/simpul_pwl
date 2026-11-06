<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\InternshipExperience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $user = Auth::user();
        $student = $user->student;

        $completedInternship = null;
        if ($student) {
            $completedInternship = Internship::with(['company', 'experience'])
                ->where(function ($q) use ($student) {
                    $q->where('student_id', $student->id)
                        ->orWhereHas('group.members', fn ($sub) => $sub->where('student_id', $student->id));
                })
                ->where('status', 'completed')
                ->latest()
                ->first();
        }

        if (! $completedInternship) {
            return redirect()->route('mahasiswa.dashboard')->with(
                'info',
                'Fitur ulasan pengalaman alumni dapat diisi setelah pelaksanaan Kuliah Praktik kamu berstatus COMPLETED (Selesai).'
            );
        }

        return view('student.experiences.create', [
            'internship' => $completedInternship,
            'experience' => $completedInternship->experience,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $student = $user->student;

        $completedInternship = Internship::where(function ($q) use ($student) {
            $q->where('student_id', $student->id)
                ->orWhereHas('group.members', fn ($sub) => $sub->where('student_id', $student->id));
        })
            ->where('status', 'completed')
            ->latest()
            ->firstOrFail();

        $validated = $request->validate([
            'position' => ['required', 'string', 'max:255'],
            'selection_process' => ['required', 'string'],
            'skills_used' => ['required', 'string'],
            'experience_review' => ['required', 'string'],
        ]);

        InternshipExperience::updateOrCreate(
            [
                'internship_id' => $completedInternship->id,
                'student_id' => $student->id,
            ],
            [
                'company_id' => $completedInternship->company_id,
                'position' => $validated['position'],
                'selection_process' => $validated['selection_process'],
                'skills_used' => $validated['skills_used'],
                'experience_review' => $validated['experience_review'],
                'is_validated' => false, // Will be validated by Admin Jurusan before being visible to public
            ]
        );

        return redirect()->route('mahasiswa.dashboard')->with(
            'success',
            'Ulasan pengalaman KP kamu berhasil dikirim! Admin Jurusan akan memvalidasi agar tampil sebagai referensi bagi mahasiswa angkatan berikutnya.'
        );
    }
}
