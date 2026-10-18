<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends Controller
{
    // =========================
    // LOGIN
    // =========================

    public function showLogin()
    {
        return view('auth.login');
    }

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

        if (! Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password tidak sesuai.',
                ])
                ->withInput($request->only('email', 'role'));
        }

        $user = Auth::user();

        if ($user->role !== $validated['role']) {
            Auth::logout();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'role' => 'Pilihan role tidak sesuai dengan akun ini.',
                ])
                ->withInput($request->only('email', 'role'));
        }

        if (! in_array(
            $user->role,
            ['student', 'admin', 'supervisor'],
            true
        )) {
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

        return redirect()->route('dashboard')
            ->with('success', 'Login berhasil. Selamat datang di SIMPUL!');
    }

    // =========================
    // REGISTER
    // =========================

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
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

        if ($validated['role'] !== 'student') {
            return back()
                ->withErrors([
                    'role' => 'Akun Admin Jurusan dan Dosen Pembimbing harus dibuat oleh pihak berwenang.',
                ])
                ->withInput(
                    $request->except(
                        'password',
                        'password_confirmation'
                    )
                );
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with(
                'success',
                'Registrasi mahasiswa berhasil. Selamat datang di SIMPUL!'
            );
    }

    public function dashboard()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        return match ($user->role) {
            'admin' => view('dashboard-admin'),
            'supervisor' => view('dashboard-supervisor'),
            'student' => view('dashboard'),
            default => abort(
                403,
                'Role akun tidak memiliki akses.'
            ),
        };
    }

    // =========================
    // LOGOUT
    // =========================

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Kamu berhasil logout.');
    }

    // =========================
    // LUPA PASSWORD
    // =========================

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

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

    // =========================
    // TAMPILAN RESET PASSWORD
    // =========================

    public function showResetPassword(
        Request $request,
        string $token
    ) {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    // =========================
    // PROSES RESET PASSWORD
    // =========================

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
            return redirect()->route('login')
                ->with(
                    'success',
                    'Password berhasil diubah. Silakan login dengan password baru.'
                );
        }

        return back()
            ->withErrors([
                'email' => __($status),
            ])
            ->withInput(
                $request->only('email')
            );
    }
}
