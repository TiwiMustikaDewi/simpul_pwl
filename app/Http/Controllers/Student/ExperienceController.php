<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Internship;
use App\Models\InternshipExperience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    /**
     * Tampilkan katalog direktori ulasan pengalaman alumni KP.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $student = $user->student;

        // Cek apakah mahasiswa yang sedang login sudah menyelesaikan KP
        $completedInternship = null;
        $myExperience = null;
        if ($student) {
            $completedInternship = Internship::with(['company', 'experience'])
                ->where(function ($q) use ($student) {
                    $q->where('student_id', $student->id)
                        ->orWhereHas('group.members', fn ($sub) => $sub->where('student_id', $student->id));
                })
                ->where('status', 'completed')
                ->latest()
                ->first();

            if ($completedInternship) {
                $myExperience = $completedInternship->experience;
            }
        }

        $search = $request->query('search');
        $companyId = $request->query('company_id');

        $query = InternshipExperience::with(['student.user', 'company'])
            ->where('is_validated', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('position', 'like', "%{$search}%")
                    ->orWhere('skills_used', 'like', "%{$search}%")
                    ->orWhere('experience_review', 'like', "%{$search}%")
                    ->orWhere('selection_process', 'like', "%{$search}%")
                    ->orWhereHas('company', fn ($cq) => $cq->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('student.user', fn ($uq) => $uq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        $experiences = $query->latest()->paginate(9)->withQueryString();

        // Daftar perusahaan yang memiliki ulasan tervalidasi untuk filter
        $companies = Company::whereHas('validatedExperiences')->orderBy('name')->get();

        return view('student.experiences.index', [
            'experiences' => $experiences,
            'completedInternship' => $completedInternship,
            'myExperience' => $myExperience,
            'companies' => $companies,
            'search' => $search,
            'selectedCompanyId' => $companyId,
        ]);
    }

    /**
     * Tampilkan form pengisian ulasan pengalaman alumni.
     */
    public function create(): View
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

        // Jika mahasiswa belum menyelesaikan KP, tampilkan halaman edukatif tanpa melempar ke dashboard
        if (! $completedInternship) {
            return view('student.experiences.not_eligible', [
                'student' => $student,
            ]);
        }

        return view('student.experiences.create', [
            'internship' => $completedInternship,
            'experience' => $completedInternship->experience,
        ]);
    }

    /**
     * Simpan atau perbarui ulasan pengalaman alumni.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $student = $user->student;

        if (! $student) {
            return back()->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        $completedInternship = Internship::where(function ($q) use ($student) {
            $q->where('student_id', $student->id)
                ->orWhereHas('group.members', fn ($sub) => $sub->where('student_id', $student->id));
        })
            ->where('status', 'completed')
            ->latest()
            ->first();

        if (! $completedInternship) {
            return redirect()->route('mahasiswa.experiences.index')->with(
                'error',
                'Anda belum dapat mengisi ulasan karena pelaksanaan Kuliah Praktik belum berstatus Selesai (Completed).'
            );
        }

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
                'is_validated' => true,
            ]
        );

        return redirect()->route('mahasiswa.experiences.index')->with(
            'success',
            'Terima kasih! Ulasan pengalaman KP Anda berhasil disimpan dan diterbitkan sebagai referensi bagi rekan mahasiswa lainnya.'
        );
    }
}
