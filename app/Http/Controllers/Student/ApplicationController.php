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
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    /**
     * Tampilkan form pengajuan kesiapan KP.
     */
    public function create(Request $request): View|RedirectResponse
    {
        $user = Auth::user();
        $student = $user->student;

        if (! $student) {
            return redirect()->route('dashboard')->with('error', 'Profil mahasiswa belum lengkap.');
        }

        // Cek apakah mahasiswa sedang memiliki pengajuan aktif / berjalan
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

        $selectedCompanyName = $request->query('company_name');
        $selectedCompanyId = $request->query('company_id');

        $prefillCompany = null;
        if ($selectedCompanyId) {
            $prefillCompany = Company::find($selectedCompanyId);
        }

        // Daftar perusahaan yang sudah pernah diajukan untuk datalist / rekomendasi
        $existingCompanies = Company::orderBy('name')->get();

        // Rekan mahasiswa lain yang belum terdaftar KP untuk diundang kelompok
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
            'existingCompanies' => $existingCompanies,
            'prefillCompany' => $prefillCompany,
            'selectedCompanyName' => $selectedCompanyName ?? $prefillCompany?->name,
            'availableStudents' => $availableStudents,
        ]);
    }

    /**
     * Simpan pengajuan kesiapan KP mahasiswa.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $student = $user->student;

        if (! $student) {
            return back()->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_city' => ['required', 'string', 'max:255'],
            'company_address' => ['nullable', 'string', 'max:500'],
            'company_contact' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:individual,group'],
            'title' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'group_name' => ['nullable', 'string', 'max:255'],
            'leader_name' => ['nullable', 'required_if:type,group', 'string', 'max:255'],
            'leader_npm' => ['nullable', 'required_if:type,group', 'string', 'max:50'],
            'leader_major' => ['nullable', 'required_if:type,group', 'string', 'max:100'],
            'members' => ['nullable', 'array', 'max:2'],
            'members.*.name' => ['nullable', 'string', 'max:255'],
            'members.*.npm' => ['nullable', 'string', 'max:50'],
            'members.*.major' => ['nullable', 'string', 'max:100'],
            'member_ids' => ['nullable', 'array', 'max:2'],
            'member_ids.*' => ['exists:students,id'],
        ]);

        $companyName = trim($validated['company_name']);

        // Cari atau buat instansi baru secara otomatis
        $company = Company::whereRaw('LOWER(name) = ?', [strtolower($companyName)])->first();

        if (! $company) {
            $company = Company::create([
                'name' => $companyName,
                'city' => trim($validated['company_city']),
                'address' => trim($validated['company_address'] ?? 'Alamat sesuai pengajuan mahasiswa'),
                'contact_person' => trim($validated['company_contact'] ?? 'Divisi HR / Pembimbing Lapangan'),
                'phone' => '-',
            ]);
        }

        $quota = $company->quota_info;

        // Validasi kuota jika instansi sudah terisi fix oleh mahasiswa yang diterima
        if ($validated['type'] === 'group') {
            if (! $quota['can_accept_group']) {
                $reason = $quota['has_group']
                    ? 'Instansi ini sudah terisi penuh oleh 1 kelompok lain yang telah diterima.'
                    : "Instansi ini sudah terisi oleh {$quota['individual_count']} mahasiswa individu yang telah diterima, sehingga tidak menerima kelompok baru.";

                return back()
                    ->withInput()
                    ->withErrors(['company_name' => "Tidak dapat mendaftar kelompok: {$reason}"]);
            }
        } else {
            if (! $quota['can_accept_individual']) {
                $reason = $quota['has_group']
                    ? 'Instansi ini telah terisi penuh oleh 1 kelompok KP yang telah diterima.'
                    : 'Tempat KP di instansi ini sudah terisi penuh (maksimal 3 mahasiswa diterima).';

                return back()
                    ->withInput()
                    ->withErrors(['company_name' => "Tidak dapat mendaftar individu: {$reason}"]);
            }
        }

        DB::transaction(function () use ($student, $user, $validated, $company) {
            $groupId = null;

            if ($validated['type'] === 'group') {
                $leaderName = trim($validated['leader_name'] ?? $user->name);
                $leaderNpm = trim($validated['leader_npm'] ?? $student->npm);
                $leaderMajor = trim($validated['leader_major'] ?? ($student->major ?? 'S1 Ilmu Komputer'));

                // Helper untuk cari atau buat akun & data mahasiswa berdasarkan NPM
                $findOrCreateStudent = function (string $npm, string $name, string $major) {
                    $cleanNpm = trim($npm);
                    $cleanName = trim($name);
                    $cleanMajor = trim($major);

                    $existing = Student::where('npm', $cleanNpm)->first();
                    if ($existing) {
                        if ($cleanName && $existing->user) {
                            $existing->user->update(['name' => $cleanName]);
                        }
                        if ($cleanMajor) {
                            $existing->update(['major' => $cleanMajor]);
                        }

                        return $existing;
                    }

                    $cleanEmail = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $cleanNpm)).'@student.unila.ac.id';
                    if (User::where('email', $cleanEmail)->exists()) {
                        $cleanEmail = 'mhs_'.strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $cleanNpm)).'_'.uniqid().'@simpul.test';
                    }

                    $newUser = User::create([
                        'name' => $cleanName ?: 'Mahasiswa',
                        'email' => $cleanEmail,
                        'password' => Hash::make('password123'),
                        'role' => 'student',
                    ]);

                    return Student::create([
                        'user_id' => $newUser->id,
                        'npm' => $cleanNpm,
                        'major' => $cleanMajor ?: 'S1 Ilmu Komputer',
                        'phone' => null,
                    ]);
                };

                // Dapatkan data mahasiswa ketua kelompok
                $leaderStudent = $findOrCreateStudent($leaderNpm, $leaderName, $leaderMajor);

                $groupName = ! empty($validated['group_name']) ? trim($validated['group_name']) : ('Kelompok '.$leaderName);

                $group = InternshipGroup::create([
                    'name' => $groupName,
                    'leader_id' => $leaderStudent->id,
                ]);

                $attachedStudentIds = [];

                // Tambahkan ketua sebagai anggota kelompok
                InternshipGroupMember::create([
                    'group_id' => $group->id,
                    'student_id' => $leaderStudent->id,
                ]);
                $attachedStudentIds[] = $leaderStudent->id;

                // Jika mahasiswa yang sedang login bukan ketua, pastikan tetap terdaftar di kelompok
                if (! in_array($student->id, $attachedStudentIds)) {
                    InternshipGroupMember::create([
                        'group_id' => $group->id,
                        'student_id' => $student->id,
                    ]);
                    $attachedStudentIds[] = $student->id;
                }

                // Tambahkan rekan anggota yang diisi pada formulir (Nama, NPM, Prodi)
                if (! empty($validated['members'])) {
                    foreach ($validated['members'] as $memberData) {
                        $mName = trim($memberData['name'] ?? '');
                        $mNpm = trim($memberData['npm'] ?? '');
                        $mMajor = trim($memberData['major'] ?? '');

                        if ($mNpm !== '' || $mName !== '') {
                            $memberStudent = $findOrCreateStudent(
                                $mNpm ?: ('NPM-'.uniqid()),
                                $mName ?: 'Rekan Kelompok',
                                $mMajor ?: 'S1 Ilmu Komputer'
                            );

                            if (! in_array($memberStudent->id, $attachedStudentIds)) {
                                InternshipGroupMember::create([
                                    'group_id' => $group->id,
                                    'student_id' => $memberStudent->id,
                                ]);
                                $attachedStudentIds[] = $memberStudent->id;
                            }
                        }
                    }
                }

                // Kompatibilitas jika ada input member_ids
                if (! empty($validated['member_ids'])) {
                    foreach ($validated['member_ids'] as $memberStudentId) {
                        if (! in_array($memberStudentId, $attachedStudentIds)) {
                            InternshipGroupMember::create([
                                'group_id' => $group->id,
                                'student_id' => $memberStudentId,
                            ]);
                            $attachedStudentIds[] = $memberStudentId;
                        }
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
                'title' => ! empty($validated['title']) ? $validated['title'] : ('Kuliah Praktik di '.$company->name),
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'status' => 'pending',
                'admin_note' => null,
            ]);

            // Buat notifikasi untuk mahasiswa
            Notification::create([
                'user_id' => $student->user_id,
                'title' => 'Pengajuan Kesiapan KP Berhasil Dikirim',
                'message' => "Pengajuan KP Anda di {$company->name} berhasil dikirim ke jurusan. Silakan pantau pengumuman dari instansi dan perbarui status Anda jika telah diterima.",
                'is_read' => false,
            ]);

            // Beritahu admin jurusan
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $adm) {
                Notification::create([
                    'user_id' => $adm->id,
                    'title' => 'Pengajuan Surat Pengantar KP Baru',
                    'message' => "Mahasiswa {$student->user->name} mengajukan permohonan KP di {$company->name}.",
                    'is_read' => false,
                ]);
            }
        });

        return redirect()->route('mahasiswa.dashboard')->with(
            'success',
            "Pengajuan kesiapan KP di {$company->name} berhasil dikirimkan! Informasi instansi otomatis tercatat di fitur Eksplorasi Perusahaan."
        );
    }

    /**
     * Konfirmasi bahwa mahasiswa telah resmi diterima oleh instansi tempat KP.
     */
    public function confirmAcceptance(Request $request, Internship $internship): RedirectResponse
    {
        $user = Auth::user();
        $student = $user->student;

        if (! $student || ($internship->student_id !== $student->id && ! $internship->group?->members()->where('student_id', $student->id)->exists())) {
            abort(403, 'Akses tidak sah.');
        }

        if ($internship->status !== 'pending') {
            return back()->with('error', 'Status pengajuan sudah tidak dalam masa tunggu konfirmasi.');
        }

        $company = $internship->company;
        $quota = $company->fresh()->quota_info;

        // Cek apakah kuota sudah penuh sebelum konfirmasi ini
        if ($internship->type === 'group' && ! $quota['can_accept_group']) {
            $internship->update([
                'status' => 'rejected',
                'admin_note' => "Tempat KP di {$company->name} sudah diisi oleh mahasiswa lain yang lebih dulu diterima.",
            ]);

            return redirect()->route('mahasiswa.dashboard')->with(
                'error',
                "Mohon maaf, kuota tempat KP di {$company->name} telah terisi penuh oleh mahasiswa lain. Silakan ajukan ke instansi tujuan lain."
            );
        }

        if ($internship->type === 'individual' && ! $quota['can_accept_individual']) {
            $internship->update([
                'status' => 'rejected',
                'admin_note' => "Tempat KP di {$company->name} sudah diisi oleh mahasiswa lain yang lebih dulu diterima.",
            ]);

            return redirect()->route('mahasiswa.dashboard')->with(
                'error',
                "Mohon maaf, kuota individu (maksimal 3) di {$company->name} telah terisi penuh oleh mahasiswa yang lebih dulu diterima."
            );
        }

        DB::transaction(function () use ($internship, $company, $user) {
            // Ubah status mahasiswa menjadi approved / diterima
            $internship->update([
                'status' => 'approved',
                'admin_note' => 'Mahasiswa telah mengonfirmasi bahwa mereka resmi DITERIMA oleh pihak instansi.',
            ]);

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Konfirmasi Diterima di Instansi Berhasil',
                'message' => "Selamat! Status pengajuan KP Anda di {$company->name} telah berhasil diperbarui menjadi DITERIMA. Kuota Anda resmi terkunci.",
                'is_read' => false,
            ]);

            // Cek apakah kuota instansi sekarang menjadi PENUH
            $freshQuota = $company->fresh()->quota_info;
            if ($freshQuota['is_full']) {
                // Otomatis ubah status pendaftar lain di instansi ini yang masih pending menjadi rejected
                $otherPendingInternships = Internship::where('company_id', $company->id)
                    ->where('id', '!=', $internship->id)
                    ->where('status', 'pending')
                    ->get();

                foreach ($otherPendingInternships as $other) {
                    $other->update([
                        'status' => 'rejected',
                        'admin_note' => "Tempat KP di {$company->name} sudah diisi oleh mahasiswa yang lebih dulu mengonfirmasi penerimaan (kuota terpenuhi). Silakan ajukan ke instansi lain.",
                    ]);

                    Notification::create([
                        'user_id' => $other->student->user_id,
                        'title' => 'Tempat KP Sudah Terisi Penuh',
                        'message' => "Pemberitahuan: Kuota tempat KP di {$company->name} telah terisi penuh oleh mahasiswa yang lebih dulu diterima. Anda dapat segera mengajukan pendaftaran baru ke instansi lain.",
                        'is_read' => false,
                    ]);
                }
            }
        });

        return redirect()->route('mahasiswa.dashboard')->with(
            'success',
            "Selamat! Status pengajuan Anda di {$company->name} resmi diperbarui menjadi DITERIMA. Kuota tempat KP telah berhasil diamankan untuk Anda."
        );
    }

    /**
     * Mahasiswa membatalkan pengajuan atau mengonfirmasi tidak diterima instansi.
     */
    public function cancel(Request $request, Internship $internship): RedirectResponse
    {
        $user = Auth::user();
        $student = $user->student;

        if (! $student || ($internship->student_id !== $student->id && ! $internship->group?->members()->where('student_id', $student->id)->exists())) {
            abort(403, 'Akses tidak sah.');
        }

        if ($internship->status !== 'pending') {
            return back()->with('error', 'Hanya pengajuan berstatus menunggu yang dapat dibatalkan.');
        }

        $company = $internship->company;

        $internship->update([
            'status' => 'rejected',
            'admin_note' => 'Pengajuan dibatalkan oleh mahasiswa / Konfirmasi tidak lolos seleksi instansi.',
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Pengajuan KP Dibatalkan',
            'message' => "Pengajuan di {$company->name} telah dibatalkan. Anda sekarang dapat mendaftar kembali ke instansi lain.",
            'is_read' => false,
        ]);

        return redirect()->route('mahasiswa.dashboard')->with(
            'info',
            "Pengajuan di {$company->name} telah dibatalkan. Anda dapat mengajukan pendaftaran baru ke instansi tujuan lain."
        );
    }
}
