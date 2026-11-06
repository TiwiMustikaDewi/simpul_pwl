<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Internship;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();
        $student = $user->student;

        // Active / latest internship for this student
        $internship = null;
        if ($student) {
            $internship = Internship::with([
                'company',
                'supervisor.user',
                'group.members.student.user',
                'logs' => fn ($q) => $q->orderByDesc('date')->limit(5),
                'reports' => fn ($q) => $q->latest()->limit(3),
                'sidang',
                'experience',
            ])
                ->where('student_id', $student->id)
                ->orWhereHas('group.members', function ($q) use ($student) {
                    $q->where('student_id', $student->id);
                })
                ->latest()
                ->first();
        }

        // Available companies count & preview
        $companies = Company::with(['internships.group', 'internships.student.user'])
            ->limit(4)
            ->get();

        // Recent notifications
        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('student.dashboard', [
            'user' => $user,
            'student' => $student,
            'internship' => $internship,
            'companies' => $companies,
            'notifications' => $notifications,
        ]);
    }
}
