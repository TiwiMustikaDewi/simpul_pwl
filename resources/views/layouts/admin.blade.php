<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') | SIMPUL</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/simpul-admin.css') }}">

    <style>
        body, button, input, select, textarea {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        }

        :root {
            --brand-primary: #4079ea;
            --brand-dark: #1d4ed8;
            --brand-light: #eff6ff;
        }

        .nav-link.active {
            background: #eaf1fd;
            color: var(--brand-primary);
            font-weight: 600;
            border-right: 3px solid var(--brand-primary);
        }
    </style>
    @stack('styles')
</head>
<body>

@php
    $menu = [
        ['Dashboard',              '⌂', 'admin.dashboard', 'admin.dashboard'],
        ['Data Mahasiswa & Dosen', '♧', 'admin.pengguna.index', 'admin.pengguna.*'],
        ['Data Perusahaan',        '▦', 'admin.companies.index', 'admin.companies.*'],
        ['Verifikasi Pengajuan',   '▤', 'admin.applications.index', 'admin.applications.*'],
        ['Kelompok & Pembimbing',  '▣', 'admin.groups.index', 'admin.groups.*'],
        ['Monitoring KP',          '▥', 'admin.monitoring.index', 'admin.monitoring.*'],
        ['Sidang KP',              '▧', 'admin.sidang.index', 'admin.sidang.*'],
        ['Validasi Pengalaman',    '☆', 'admin.experiences.index', 'admin.experiences.*'],
    ];
@endphp

<div class="app">

    <!-- HEADER -->
    <header class="topbar">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            <div class="brand-icon">S</div>
            <div>
                <div class="brand-name">SIMPUL</div>
                <div class="brand-subtitle">Sistem Informasi Manajemen Praktik</div>
            </div>
        </a>

        <label class="search-box">
            <span class="search-icon">⌕</span>
            <input
                type="search"
                id="dashboardSearch"
                placeholder="Cari mahasiswa, perusahaan, atau pengajuan..."
                aria-label="Cari di dashboard admin"
            >
        </label>

        <div class="header-actions">
            <a href="{{ route('admin.applications.index') }}" class="header-icon" title="Lihat pengajuan KP">♧</a>
            <a href="#profil" class="header-icon" title="Profil pengguna">◉</a>

            <span class="account-name">{{ auth()->user()->name }}</span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline">Logout</button>
            </form>
        </div>
    </header>

    <div class="layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="nav-label">MENU UTAMA</div>

            @foreach ($menu as [$label, $icon, $routeName, $pattern])
                <a
                    href="{{ route($routeName) }}"
                    class="nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}"
                >
                    <span class="nav-icon">{{ $icon }}</span>
                    {{ $label }}
                </a>
            @endforeach

            <div class="sidebar-note">
                <div class="note-icon">🛠️</div>
                <h3>Panduan Admin</h3>
                <p>
                    Alur verifikasi berkas, penetapan dosen pembimbing,
                    dan penjadwalan sidang Kuliah Praktik.
                </p>
                <a href="{{ route('admin.applications.index') }}" class="btn btn-primary btn-full">Lihat Pengajuan →</a>
            </div>

            <div class="sidebar-profile" id="profil">
                <div class="avatar">🧑🏻‍💼</div>
                <div class="profile-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span>Admin Jurusan</span>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="content">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>