<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\InternshipLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LogbookController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $student = $user->student;

        $internship = null;
        if ($student) {
            $internship = Internship::with(['company', 'supervisor.user', 'logs' => fn ($q) => $q->orderByDesc('date')])
                ->where(function ($q) use ($student) {
                    $q->where('student_id', $student->id)
                        ->orWhereHas('group.members', fn ($sub) => $sub->where('student_id', $student->id));
                })
                ->whereIn('status', ['in_progress', 'completed'])
                ->first();
        }

        return view('student.logbook.index', [
            'internship' => $internship,
            'logs' => $internship?->logs ?? collect(),
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
            'date' => ['required', 'date'],
            'activity' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        InternshipLog::create([
            'internship_id' => $internship->id,
            'date' => $validated['date'],
            'activity' => $validated['activity'],
            'description' => $validated['description'],
            'status' => 'submitted',
            'supervisor_note' => null,
        ]);

        return back()->with('success', 'Catatan logbook berhasil disimpan dan diteruskan ke Dosen Pembimbing.');
    }

    public function update(Request $request, InternshipLog $log): RedirectResponse
    {
        $user = Auth::user();
        $student = $user->student;

        // Ensure ownership
        $internship = $log->internship;
        $isOwner = $internship->student_id === $student->id ||
            $internship->group?->members()->where('student_id', $student->id)->exists();

        if (! $isOwner) {
            abort(403);
        }

        $validated = $request->validate([
            'activity' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $log->update([
            'activity' => $validated['activity'],
            'description' => $validated['description'],
            'status' => 'submitted', // Re-submitted for review
        ]);

        return back()->with('success', 'Perbaikan catatan logbook berhasil disimpan.');
    }
}
