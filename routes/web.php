<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\WorkflowController as AdminWorkflowController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dosen\BimbinganController as DosenBimbinganController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\LogbookController as DosenLogbookController;
use App\Http\Controllers\Dosen\ProfileController as DosenProfileController;
use App\Http\Controllers\Dosen\ReportController as DosenReportController;
use App\Http\Controllers\Dosen\SidangController as DosenSidangController;
use App\Http\Controllers\Student\ApplicationController as StudentApplicationController;
use App\Http\Controllers\Student\CompanyController as StudentCompanyController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ExperienceController as StudentExperienceController;
use App\Http\Controllers\Student\LogbookController as StudentLogbookController;
use App\Http\Controllers\Student\ReportController as StudentReportController;
use App\Http\Controllers\Student\SidangController as StudentSidangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
        ->name('password.request');

    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])
        ->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/pengguna', [AdminWorkflowController::class, 'people'])
            ->name('pengguna.index');

        Route::get('/perusahaan', [AdminWorkflowController::class, 'companies'])
            ->name('companies.index');
        Route::post('/perusahaan', [AdminWorkflowController::class, 'storeCompany'])
            ->name('companies.store');
        Route::put('/perusahaan/{company}', [AdminWorkflowController::class, 'updateCompany'])
            ->whereNumber('company')
            ->name('companies.update');

        Route::get('/pengajuan', [AdminWorkflowController::class, 'applications'])
            ->name('applications.index');
        Route::post('/pengajuan/{internship}/verifikasi', [AdminWorkflowController::class, 'reviewApplication'])
            ->whereNumber('internship')
            ->name('applications.review');

        Route::get('/kelompok', [AdminWorkflowController::class, 'groups'])
            ->name('groups.index');
        Route::post('/kelompok', [AdminWorkflowController::class, 'storeGroup'])
            ->name('groups.store');
        Route::post('/kelompok/{internship}/pembimbing', [AdminWorkflowController::class, 'assignSupervisor'])
            ->whereNumber('internship')
            ->name('groups.assign-supervisor');

        Route::get('/monitoring', [AdminWorkflowController::class, 'monitoring'])
            ->name('monitoring.index');

        Route::get('/sidang', [AdminWorkflowController::class, 'sidang'])
            ->name('sidang.index');
        Route::put('/sidang/{sidang}/jadwal', [AdminWorkflowController::class, 'scheduleSidang'])
            ->whereNumber('sidang')
            ->name('sidang.schedule');

        Route::get('/pengalaman', [AdminWorkflowController::class, 'experiences'])
            ->name('experiences.index');
        Route::patch('/pengalaman/{experience}/validasi', [AdminWorkflowController::class, 'validateExperience'])
            ->whereNumber('experience')
            ->name('experiences.validate');
    });

Route::middleware(['auth', 'role:student'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

        // Eksplorasi Perusahaan & Rekam Jejak Alumni
        Route::get('/perusahaan', [StudentCompanyController::class, 'index'])->name('companies.index');
        Route::get('/perusahaan/{company}', [StudentCompanyController::class, 'show'])
            ->whereNumber('company')
            ->name('companies.show');

        // Pengajuan Kesiapan KP
        Route::get('/pengajuan', [StudentApplicationController::class, 'create'])->name('applications.create');
        Route::post('/pengajuan', [StudentApplicationController::class, 'store'])->name('applications.store');

        // Logbook Harian
        Route::get('/logbook', [StudentLogbookController::class, 'index'])->name('logbook.index');
        Route::post('/logbook', [StudentLogbookController::class, 'store'])->name('logbook.store');
        Route::put('/logbook/{log}', [StudentLogbookController::class, 'update'])
            ->whereNumber('log')
            ->name('logbook.update');

        // Laporan Akhir KP
        Route::get('/laporan', [StudentReportController::class, 'index'])->name('reports.index');
        Route::post('/laporan', [StudentReportController::class, 'store'])->name('reports.store');

        // Pendaftaran Sidang KP
        Route::get('/sidang', [StudentSidangController::class, 'index'])->name('sidang.index');
        Route::post('/sidang', [StudentSidangController::class, 'store'])->name('sidang.store');

        // Berbagi Pengalaman Alumni
        Route::get('/pengalaman', [StudentExperienceController::class, 'create'])->name('experiences.create');
        Route::post('/pengalaman', [StudentExperienceController::class, 'store'])->name('experiences.store');
    });

Route::middleware(['auth', 'role:supervisor'])
    ->prefix('dosen')
    ->name('dosen.')
    ->group(function () {
        Route::get('/dashboard', [DosenDashboardController::class, 'index'])
            ->name('dashboard');

        // Mahasiswa Bimbingan
        Route::get('/bimbingan', [DosenBimbinganController::class, 'index'])
            ->name('students.index');
        Route::get('/bimbingan/{internship}', [DosenBimbinganController::class, 'show'])
            ->whereNumber('internship')
            ->name('students.show');

        // Logbook
        Route::get('/logbook', [DosenLogbookController::class, 'index'])
            ->name('logs.index');
        Route::post('/logbook/{log}/review', [DosenLogbookController::class, 'review'])
            ->whereNumber('log')
            ->name('logs.review');

        // Laporan Akhir
        Route::get('/laporan', [DosenReportController::class, 'index'])
            ->name('reports.index');
        Route::post('/laporan/{report}/review', [DosenReportController::class, 'review'])
            ->whereNumber('report')
            ->name('reports.review');
        Route::get('/laporan/{report}/download', [DosenReportController::class, 'download'])
            ->whereNumber('report')
            ->name('reports.download');

        // Sidang & Penilaian
        Route::get('/sidang', [DosenSidangController::class, 'index'])
            ->name('sidang.index');
        Route::post('/sidang/{sidang}/nilai', [DosenSidangController::class, 'grade'])
            ->whereNumber('sidang')
            ->name('sidang.grade');

        // Profil Dosen
        Route::get('/profil', [DosenProfileController::class, 'index'])
            ->name('profile.index');
        Route::put('/profil', [DosenProfileController::class, 'update'])
            ->name('profile.update');
    });
