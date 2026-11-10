<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\InternshipReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $student = $user->student;

        $internship = null;
        if ($student) {
            $internship = Internship::with(['company', 'supervisor.user', 'reports' => fn ($q) => $q->latest()])
                ->where(function ($q) use ($student) {
                    $q->where('student_id', $student->id)
                        ->orWhereHas('group.members', fn ($sub) => $sub->where('student_id', $student->id));
                })
                ->whereIn('status', ['in_progress', 'completed'])
                ->first();
        }

        return view('student.reports.index', [
            'internship' => $internship,
            'reports' => $internship?->reports ?? collect(),
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

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'report_file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        $path = $request->file('report_file')->store('reports', 'public');

        InternshipReport::create([
            'internship_id' => $internship->id,
            'title' => $validated['title'],
            'file_path' => $path,
            'status' => 'submitted',
            'feedback' => null,
        ]);

        return back()->with('success', 'Naskah laporan akhir berhasil diunggah dan siap ditinjau oleh Dosen Pembimbing.');
    }
}
