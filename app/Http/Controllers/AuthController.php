<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:student,admin,supervisor'],
        ]);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password tidak sesuai.',
                ])
                ->withInput($request->only('email', 'role'));
        }

        $user = Auth::user();

        // Memastikan role yang dipilih sesuai dengan akun.
        if ($user->role !== $validated['role']) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'role' => 'Pilihan role tidak sesuai dengan akun ini.',
                ])
                ->withInput($request->only('email', 'role'));
        }

        // Memastikan role akun dikenali.
        if (!in_array($user->role, ['student', 'admin', 'supervisor'], true)) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'email' => 'Role akun tidak dikenali. Hubungi admin.',
                ])
                ->withInput($request->only('email', 'role'));
        }

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Login berhasil. Selamat datang di SIMPUL!');
    }

    /**
     * Menampilkan halaman registrasi.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi mahasiswa.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'npm' => [
                'required',
                'string',
                'max:20',
                'unique:students,npm',
            ],

            'faculty' => [
                'required',
                'string',
                'max:255',
            ],

            'major' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8),
            ],

            'role' => [
                'required',
                'in:student,admin,supervisor',
            ],
        ]);

        // Registrasi mandiri hanya diperbolehkan untuk mahasiswa.
        if ($validated['role'] !== 'student') {
            return back()
                ->withErrors([
                    'role' => 'Akun Admin Jurusan dan Dosen Pembimbing harus dibuat oleh pihak berwenang.',
                ])
                ->withInput(
                    $request->except('password', 'password_confirmation')
                );
        }

        try {
            // Membuat akun dan profil mahasiswa dalam satu transaksi.
            $user = DB::transaction(function () use ($validated) {

                // Membuat akun pengguna.
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'student',
                ]);

                // Membuat profil mahasiswa.
                Student::create([
                    'user_id' => $user->id,
                    'npm' => $validated['npm'],
                    'faculty' => $validated['faculty'],
                    'major' => $validated['major'],
                    'phone' => $validated['phone'] ?? null,
                ]);

                return $user;
            });

            // Login otomatis setelah registrasi berhasil.
            Auth::login($user);

            $request->session()->regenerate();

            return redirect()
                ->route('dashboard')
                ->with(
                    'success',
                    'Registrasi mahasiswa berhasil. Selamat datang di SIMPUL!'
                );

        } catch (\Illuminate\Database\QueryException $e) {

            return back()
                ->withErrors([
                    'npm' => 'Registrasi gagal. NPM atau email mungkin sudah terdaftar.',
                ])
                ->withInput(
                    $request->except('password', 'password_confirmation')
                );
        }
    }

    /**
     * Mengarahkan pengguna ke dashboard sesuai role.
     */
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'supervisor' => redirect()->route('dosen.dashboard'),
            'student' => redirect()->route('mahasiswa.dashboard'),
<<<<<<< HEAD
            default => abort(
                403,
                'Role akun tidak memiliki akses.'
            ),
=======
            default => abort(403, 'Role akun tidak memiliki akses.'),
>>>>>>> af4810d (Update registrasi)
        };
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Kamu berhasil logout.');
    }

    /**
     * Menampilkan halaman lupa password.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Mengirimkan link reset password.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'status',
                'Permintaan reset password berhasil diproses. Periksa log email aplikasi untuk melihat tautan reset pada lingkungan pengembangan.'
            );
        }

        return back()->withErrors([
            'email' => __($status),
        ]);
    }

    /**
     * Menampilkan halaman reset password.
     */
    public function showResetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /**
     * Memproses perubahan password.
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8),
            ],
        ]);

        $status = Password::reset(
            $validated,
            function (User $user, string $password) {

                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Password berhasil diubah. Silakan login dengan password baru.'
                );
        }

        return back()
            ->withErrors([
                'email' => __($status),
            ])
            ->withInput($request->only('email'));
    }
}
