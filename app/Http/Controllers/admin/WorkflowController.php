<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WorkflowController extends Controller
{
    public function people(): View
    {
        $people = DB::table('users')
            ->leftJoin('students', 'students.user_id', '=', 'users.id')
            ->leftJoin('supervisors', 'supervisors.user_id', '=', 'users.id')
            ->whereIn('users.role', ['student', 'supervisor'])
            ->orderBy('users.role')
            ->orderBy('users.name')
            ->get([
                'users.name',
                'users.email',
                'users.role',
                'students.npm',
                'students.major',
                'supervisors.nip',
                'supervisors.department',
            ]);

        return view('admin.workflow', [
            'section' => 'people',
            'title' => 'Data Mahasiswa & Dosen',
            'description' => 'Lihat profil mahasiswa dan dosen pembimbing yang terdaftar.',
            'people' => $people,
        ]);
    }

    public function companies(): View
    {
        $companies = DB::table('companies')
            ->leftJoin('internships', 'internships.company_id', '=', 'companies.id')
            ->select(
                'companies.id',
                'companies.name',
                'companies.address',
                'companies.city',
                'companies.contact_person',
                'companies.phone',
                DB::raw('COUNT(internships.id) as internship_count')
            )
            ->groupBy(
                'companies.id',
                'companies.name',
                'companies.address',
                'companies.city',
                'companies.contact_person',
                'companies.phone'
            )
            ->orderBy('companies.name')
            ->get();

        return view('admin.workflow', [
            'section' => 'companies',
            'title' => 'Data Perusahaan',
            'description' => 'Kelola instansi tempat KP dan informasi kontaknya.',
            'companies' => $companies,
        ]);
    }

    public function storeCompany(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:5000'],
            'city' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        DB::table('companies')->insert([
            ...$validated,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return to_route('admin.companies.index')
            ->with('success', 'Data perusahaan berhasil ditambahkan.');
    }

    public function updateCompany(Request $request, int $company): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:5000'],
            'city' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        $updated = DB::table('companies')
            ->where('id', $company)
            ->update([
                ...$validated,
                'updated_at' => now(),
            ]);

        abort_if($updated === 0 && ! DB::table('companies')->where('id', $company)->exists(), 404);

        return to_route('admin.companies.index')
            ->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    public function applications(): View
    {
        $applications = DB::table('internships')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('companies', 'companies.id', '=', 'internships.company_id')
            ->leftJoin('supervisors', 'supervisors.id', '=', 'internships.supervisor_id')
            ->leftJoin('users as supervisor_users', 'supervisor_users.id', '=', 'supervisors.user_id')
            ->orderByRaw("CASE internships.status WHEN 'pending' THEN 0 ELSE 1 END")
            ->orderByDesc('internships.created_at')
            ->get([
                'internships.id',
                'internships.type',
                'internships.title',
                'internships.start_date',
                'internships.end_date',
                'internships.status',
                'internships.admin_note',
                'internships.created_at',
                'users.name as student_name',
                'students.npm',
                'companies.name as company_name',
                'supervisor_users.name as supervisor_name',
            ]);

        return view('admin.workflow', [
            'section' => 'applications',
            'title' => 'Verifikasi Pengajuan',
            'description' => 'Tinjau kesiapan KP, setujui pengajuan, atau kembalikan dengan catatan.',
            'applications' => $applications,
        ]);
    }

    public function reviewApplication(Request $request, int $internship): RedirectResponse
    {
        $validated = $request->validate([
            'decision' => ['required', 'in:approved,rejected'],
            'admin_note' => ['nullable', 'required_if:decision,rejected', 'string', 'max:5000'],
        ], [
            'admin_note.required_if' => 'Catatan wajib diisi saat pengajuan ditolak.',
        ]);

        $updated = DB::table('internships')
            ->where('id', $internship)
            ->where('status', 'pending')
            ->update([
                'status' => $validated['decision'],
                'admin_note' => $validated['admin_note'] ?? null,
                'updated_at' => now(),
            ]);

        if ($updated === 0) {
            abort_unless(DB::table('internships')->where('id', $internship)->exists(), 404);

            return back()->with('error', 'Pengajuan ini sudah diproses dan tidak lagi menunggu verifikasi.');
        }

        return to_route('admin.applications.index')
            ->with('success', 'Keputusan verifikasi berhasil disimpan.');
    }

    public function groups(): View
    {
        $groupSupervisors = DB::table('internships')
            ->join('supervisors', 'supervisors.id', '=', 'internships.supervisor_id')
            ->join('users as supervisor_users', 'supervisor_users.id', '=', 'supervisors.user_id')
            ->whereNotNull('internships.group_id')
            ->select('internships.group_id', DB::raw('MAX(supervisor_users.name) as supervisor_name'))
            ->groupBy('internships.group_id');

        $groups = DB::table('internship_groups')
            ->join('students as leaders', 'leaders.id', '=', 'internship_groups.leader_id')
            ->join('users as leader_users', 'leader_users.id', '=', 'leaders.user_id')
            ->leftJoinSub($groupSupervisors, 'group_supervisors', 'group_supervisors.group_id', '=', 'internship_groups.id')
            ->orderBy('internship_groups.name')
            ->get([
                'internship_groups.id',
                'internship_groups.name',
                'leader_users.name as leader_name',
                'group_supervisors.supervisor_name',
            ]);

        $membersByGroup = DB::table('internship_group_members')
            ->join('students', 'students.id', '=', 'internship_group_members.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->orderBy('users.name')
            ->get([
                'internship_group_members.group_id',
                'users.name',
                'students.npm',
            ])
            ->groupBy('group_id');

        $students = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->whereNotExists(function ($query): void {
                $query->selectRaw('1')
                    ->from('internship_group_members')
                    ->whereColumn('internship_group_members.student_id', 'students.id');
            })
            ->orderBy('users.name')
            ->get(['students.id', 'students.npm', 'users.name']);

        $supervisors = DB::table('supervisors')
            ->join('users', 'users.id', '=', 'supervisors.user_id')
            ->orderBy('users.name')
            ->get(['supervisors.id', 'supervisors.nip', 'users.name']);

        $assignableInternships = DB::table('internships')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->leftJoin('internship_groups', 'internship_groups.id', '=', 'internships.group_id')
            ->whereIn('internships.status', ['approved', 'in_progress'])
            ->whereNull('internships.supervisor_id')
            ->where(function ($query): void {
                $query->whereNull('internships.group_id')
                    ->orWhereColumn('students.id', 'internship_groups.leader_id');
            })
            ->orderBy('users.name')
            ->get([
                'internships.id',
                'internships.title',
                'internships.status',
                'internship_groups.name as group_name',
                'users.name as student_name',
                'students.npm',
            ]);

        return view('admin.workflow', [
            'section' => 'groups',
            'title' => 'Kelompok & Pembimbing',
            'description' => 'Bentuk kelompok KP dan tetapkan dosen pembimbing untuk KP yang disetujui.',
            'groups' => $groups,
            'membersByGroup' => $membersByGroup,
            'students' => $students,
            'supervisors' => $supervisors,
            'assignableInternships' => $assignableInternships,
        ]);
    }

    public function storeGroup(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'leader_id' => [
                'required',
                'integer',
                'exists:students,id',
                Rule::unique('internship_group_members', 'student_id'),
            ],
            'member_ids' => ['required', 'array', 'min:1'],
            'member_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:students,id',
                Rule::unique('internship_group_members', 'student_id'),
            ],
        ], [
            'leader_id.unique' => 'Ketua sudah terdaftar di kelompok lain.',
            'member_ids.*.unique' => 'Anggota sudah terdaftar di kelompok lain.',
        ]);

        $memberIds = array_values(array_unique([
            ...$validated['member_ids'],
            $validated['leader_id'],
        ]));

        DB::transaction(function () use ($validated, $memberIds): void {
            $now = now();
            $groupId = DB::table('internship_groups')->insertGetId([
                'name' => $validated['name'],
                'leader_id' => $validated['leader_id'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('internship_group_members')->insert(array_map(
                fn (int $studentId): array => [
                    'group_id' => $groupId,
                    'student_id' => $studentId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                $memberIds
            ));

            DB::table('internships')
                ->whereIn('student_id', $memberIds)
                ->whereIn('status', ['pending', 'approved', 'in_progress'])
                ->whereNull('group_id')
                ->update([
                    'group_id' => $groupId,
                    'type' => 'group',
                    'updated_at' => $now,
                ]);
        });

        return to_route('admin.groups.index')
            ->with('success', 'Kelompok KP berhasil dibuat dan anggota telah disimpan.');
    }

    public function assignSupervisor(Request $request, int $internship): RedirectResponse
    {
        $validated = $request->validate([
            'supervisor_id' => ['required', 'integer', 'exists:supervisors,id'],
        ]);

        $internshipRecord = DB::table('internships')
            ->where('id', $internship)
            ->first(['id', 'group_id', 'status']);

        abort_if($internshipRecord === null, 404);

        if (! in_array($internshipRecord->status, ['approved', 'in_progress'], true)) {

            return back()->with('error', 'Pembimbing hanya dapat ditetapkan untuk KP yang disetujui atau sedang berjalan.');
        }

        $internships = DB::table('internships')
            ->whereIn('status', ['approved', 'in_progress']);

        if ($internshipRecord->group_id === null) {
            $internships->where('id', $internshipRecord->id);
        } else {
            $internships->where('group_id', $internshipRecord->group_id);
        }

        $internships->update([
            'supervisor_id' => $validated['supervisor_id'],
            'updated_at' => now(),
        ]);

        return to_route('admin.groups.index')
            ->with('success', 'Dosen pembimbing berhasil ditetapkan.');
    }

    public function monitoring(): View
    {
        $logCounts = DB::table('internship_logs')
            ->select('internship_id', DB::raw('COUNT(*) as total'))
            ->groupBy('internship_id');
        $reportCounts = DB::table('internship_reports')
            ->select('internship_id', DB::raw('COUNT(*) as total'))
            ->groupBy('internship_id');

        $internships = DB::table('internships')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('companies', 'companies.id', '=', 'internships.company_id')
            ->leftJoin('supervisors', 'supervisors.id', '=', 'internships.supervisor_id')
            ->leftJoin('users as supervisor_users', 'supervisor_users.id', '=', 'supervisors.user_id')
            ->leftJoinSub($logCounts, 'log_counts', 'log_counts.internship_id', '=', 'internships.id')
            ->leftJoinSub($reportCounts, 'report_counts', 'report_counts.internship_id', '=', 'internships.id')
            ->orderByDesc('internships.updated_at')
            ->get([
                'internships.id',
                'internships.title',
                'internships.start_date',
                'internships.end_date',
                'internships.status',
                'users.name as student_name',
                'students.npm',
                'companies.name as company_name',
                'supervisor_users.name as supervisor_name',
                DB::raw('COALESCE(log_counts.total, 0) as log_count'),
                DB::raw('COALESCE(report_counts.total, 0) as report_count'),
            ]);

        return view('admin.workflow', [
            'section' => 'monitoring',
            'title' => 'Monitoring KP',
            'description' => 'Pantau status KP, aktivitas logbook, laporan, dan pembimbing mahasiswa.',
            'internships' => $internships,
        ]);
    }

    public function sidang(): View
    {
        $sidang = DB::table('sidang_kps')
            ->join('internships', 'internships.id', '=', 'sidang_kps.internship_id')
            ->join('students', 'students.id', '=', 'internships.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->orderByRaw("CASE sidang_kps.status WHEN 'submitted' THEN 0 ELSE 1 END")
            ->orderBy('sidang_kps.sidang_date')
            ->get([
                'sidang_kps.id',
                'sidang_kps.sidang_date',
                'sidang_kps.room',
                'sidang_kps.status',
                'sidang_kps.grade',
                'sidang_kps.notes',
                'internships.title',
                'users.name as student_name',
                'students.npm',
            ]);

        return view('admin.workflow', [
            'section' => 'sidang',
            'title' => 'Sidang KP',
            'description' => 'Kelola pengajuan sidang dan tentukan jadwal serta ruang pelaksanaannya.',
            'sidang' => $sidang,
        ]);
    }

    public function scheduleSidang(Request $request, int $sidang): RedirectResponse
    {
        $validated = $request->validate([
            'sidang_date' => ['required', 'date', 'after:now'],
            'room' => ['required', 'string', 'max:255'],
        ]);

        $updated = DB::table('sidang_kps')
            ->where('id', $sidang)
            ->where('status', 'submitted')
            ->update([
                'sidang_date' => Carbon::parse($validated['sidang_date'])->format('Y-m-d H:i:s'),
                'room' => $validated['room'],
                'status' => 'scheduled',
                'updated_at' => now(),
            ]);

        if ($updated === 0) {
            abort_unless(DB::table('sidang_kps')->where('id', $sidang)->exists(), 404);

            return back()->with('error', 'Pengajuan sidang ini sudah diproses.');
        }

        return to_route('admin.sidang.index')
            ->with('success', 'Jadwal sidang berhasil disimpan.');
    }

    public function experiences(): View
    {
        $experiences = DB::table('internship_experiences')
            ->join('students', 'students.id', '=', 'internship_experiences.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('companies', 'companies.id', '=', 'internship_experiences.company_id')
            ->orderBy('internship_experiences.is_validated')
            ->orderByDesc('internship_experiences.created_at')
            ->get([
                'internship_experiences.id',
                'internship_experiences.position',
                'internship_experiences.selection_process',
                'internship_experiences.skills_used',
                'internship_experiences.experience_review',
                'internship_experiences.is_validated',
                'users.name as student_name',
                'students.npm',
                'companies.name as company_name',
            ]);

        return view('admin.workflow', [
            'section' => 'experiences',
            'title' => 'Validasi Pengalaman',
            'description' => 'Periksa pengalaman mahasiswa sebelum ditampilkan sebagai referensi tempat KP.',
            'experiences' => $experiences,
        ]);
    }

    public function validateExperience(int $experience): RedirectResponse
    {
        $updated = DB::table('internship_experiences')
            ->where('id', $experience)
            ->where('is_validated', false)
            ->update([
                'is_validated' => true,
                'updated_at' => now(),
            ]);

        if ($updated === 0) {
            abort_unless(DB::table('internship_experiences')->where('id', $experience)->exists(), 404);

            return back()->with('error', 'Pengalaman ini sudah divalidasi sebelumnya.');
        }

        return to_route('admin.experiences.index')
            ->with('success', 'Pengalaman mahasiswa berhasil divalidasi.');
    }
}
