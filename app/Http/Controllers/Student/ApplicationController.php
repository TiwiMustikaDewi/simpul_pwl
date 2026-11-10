<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Internship;
use App\Models\InternshipGroup;
use App\Models\InternshipGroupMember;
use App\Models\Notification;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $user = Auth::user();
        $student = $user->student;

        if (! $student) {
            return redirect()->route('dashboard')->with('error', 'Profil mahasiswa belum lengkap.');
        }

        // Check if student already has active / pending internship
        $existing = Internship::where('student_id', $student->id)
            ->orWhereHas('group.members', fn ($q) => $q->where('student_id', $student->id))
            ->whereIn('status', ['pending', 'approved', 'in_progress'])
            ->first();

        if ($existing) {
            return redirect()->route('mahasiswa.dashboard')->with(
                'info',
                'Kamu sudah memiliki pengajuan KP aktif berstatus: '.strtoupper($existing->status).'.'
            );
        }

        $selectedCompanyId = $request->query('company_id');

        $companies = Company::with(['internships.group', 'internships.student.user'])
            ->orderBy('name')
            ->get();

        // Other students that can be invited to a group
        $availableStudents = Student::with('user')
            ->where('id', '!=', $student->id)
            ->whereDoesntHave('internships', function ($q) {
                $q->whereIn('status', ['pending', 'approved', 'in_progress']);
            })
            ->whereDoesntHave('memberGroups.internships', function ($q) {
                $q->whereIn('status', ['pending', 'approved', 'in_progress']);
            })
            ->get();

        return view('student.applications.create', [
            'student' => $student,
            'companies' => $companies,
            'selectedCompanyId' => $selectedCompanyId,
            'availableStudents' => $availableStudents,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $student = $user->student;

        if (! $student) {
            return back()->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'type' => ['required', 'in:individual,group'],
            'title' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'group_name' => ['nullable', 'required_if:type,group', 'string', 'max:255'],
            'member_ids' => ['nullable', 'array', 'max:2'],
            'member_ids.*' => ['exists:students,id'],
        ]);

        $company = Company::findOrFail($validated['company_id']);
        $quota = $company->quota_info;

        // Quota validation
        if ($validated['type'] === 'group') {
            if (! $quota['can_accept_group']) {
                $reason = $quota['has_group']
                    ? 'Perusahaan ini sudah diisi oleh kelompok lain.'
                    : "Perusahaan ini sudah diisi oleh {$quota['individual_count']} mahasiswa individu sehingga tidak menerima kelompok baru.";

                return back()
                    ->withInput()
                    ->withErrors(['company_id' => "Tidak dapat mendaftar kelompok: {$reason}"]);
            }
        } else {
            if (! $quota['can_accept_individual']) {
                $reason = $quota['has_group']
                    ? 'Perusahaan ini telah terisi oleh 1 kelompok KP penuh.'
                    : 'Kuota individu untuk perusahaan ini sudah penuh (maksimal 3 mahasiswa).';

                return back()
                    ->withInput()
                    ->withErrors(['company_id' => "Tidak dapat mendaftar individu: {$reason}"]);
            }
        }

        DB::transaction(function () use ($student, $validated, $company) {
            $groupId = null;

            if ($validated['type'] === 'group') {
                $group = InternshipGroup::create([
                    'name' => $validated['group_name'],
                    'leader_id' => $student->id,
                ]);

                // Add leader as member
                InternshipGroupMember::create([
                    'group_id' => $group->id,
                    'student_id' => $student->id,
                ]);

                // Add selected peers
                if (! empty($validated['member_ids'])) {
                    foreach ($validated['member_ids'] as $memberStudentId) {
                        InternshipGroupMember::create([
                            'group_id' => $group->id,
                            'student_id' => $memberStudentId,
                        ]);
                    }
                }

                $groupId = $group->id;
            }

            Internship::create([
                'student_id' => $student->id,
                'company_id' => $company->id,
                'supervisor_id' => null,
                'group_id' => $groupId,
                'type' => $validated['type'],
                'title' => $validated['title'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'status' => 'pending',
                'admin_note' => null,
            ]);

            // Create notification for student
            Notification::create([
                'user_id' => $student->user_id,
                'title' => 'Pengajuan Kesiapan KP Berhasil Dikirim',
                'message' => "Pengajuan KP kamu di {$company->name} berhasil dikirim dan sedang menunggu verifikasi berkas oleh Admin Jurusan.",
                'is_read' => false,
            ]);

            // Notify all admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $adm) {
                Notification::create([
                    'user_id' => $adm->id,
                    'title' => 'Pengajuan KP Baru Menunggu Verifikasi',
                    'message' => "Mahasiswa {$student->user->name} mengajukan KP di {$company->name}.",
                    'is_read' => false,
                ]);
            }
        });

        return redirect()->route('mahasiswa.dashboard')->with(
            'success',
            'Pengajuan kesiapan KP berhasil dikirimkan! Admin Jurusan akan memverifikasi berkas Anda.'
        );
    }
}
