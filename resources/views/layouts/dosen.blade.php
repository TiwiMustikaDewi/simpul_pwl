<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Dosen') | SIMPUL</title>

    <link rel="stylesheet" href="{{ asset('css/simpul-admin.css') }}">
    @stack('styles')
</head>
<body>

@php
    $menu = [
        ['Dashboard',              'dashboard', 'dosen.dashboard', 'dosen.dashboard'],
        ['Mahasiswa Bimbingan',    'users',     'dosen.students.index', 'dosen.students.*'],
        ['Pemeriksaan Logbook',    'logbook',   'dosen.logs.index', 'dosen.logs.*'],
        ['Laporan Akhir KP',       'reports',   'dosen.reports.index', 'dosen.reports.*'],
        ['Sidang & Penilaian',     'sidang',    'dosen.sidang.index', 'dosen.sidang.*'],
        ['Profil Dosen',           'profile',   'dosen.profile.index', 'dosen.profile.*'],
    ];

    // Hitung inisial nama dosen untuk avatar profesional
    $cleanedName = preg_replace('/^(Dr\.|Prof\.|Ir\.|Drs\.|H\.|Hj\.|Ing\.)\s+/i', '', auth()->user()->name);
    $nameParts = array_values(array_filter(explode(' ', trim($cleanedName))));
    $initials = '';
    if (count($nameParts) >= 2) {
        $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
    } elseif (count($nameParts) === 1) {
        $initials = strtoupper(substr($nameParts[0], 0, 2));
    } else {
        $initials = 'DP';
    }
@endphp

<div class="app">

    <!-- HEADER -->
    <header class="topbar">
        <a href="{{ route('dosen.dashboard') }}" class="brand">
            <div class="brand-icon">S</div>
            <div>
                <div class="brand-name">SIMPUL</div>
                <div class="brand-subtitle">Sistem Informasi Manajemen Praktik</div>
            </div>
        </a>

        <label class="search-box">
            <span class="search-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </span>
            <input
                type="search"
                id="dashboardSearch"
                placeholder="Cari mahasiswa, logbook, atau jadwal sidang..."
                aria-label="Cari di dashboard dosen"
            >
        </label>

        <div class="header-actions">
            <a href="{{ route('dosen.logs.index') }}" class="header-icon" title="Periksa logbook mahasiswa">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 11l3 3L22 4"></path>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
            </a>
            <a href="{{ route('dosen.profile.index') }}" class="header-icon" title="Profil dosen">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </a>

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
            <div class="nav-label">MENU PEMBIMBING</div>

            @foreach ($menu as [$label, $iconKey, $routeName, $pattern])
                <a
                    href="{{ route($routeName) }}"
                    class="nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}"
                >
                    <span class="nav-icon">
                        @if ($iconKey === 'dashboard')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        @elseif ($iconKey === 'users')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        @elseif ($iconKey === 'logbook')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 11l3 3L22 4"></path>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                            </svg>
                        @elseif ($iconKey === 'reports')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        @elseif ($iconKey === 'sidang')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                            </svg>
                        @elseif ($iconKey === 'profile')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        @endif
                    </span>
                    {{ $label }}
                </a>
            @endforeach

            <div class="sidebar-note">
                <div class="note-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                </div>
                <h3>Bimbingan KP</h3>
                <p>
                    Pantau aktivitas harian logbook, evaluasi laporan akhir,
                    serta berikan penilaian pada sidang Kuliah Praktik mahasiswa.
                </p>
                <a href="{{ route('dosen.logs.index') }}" class="btn btn-primary btn-full">Periksa Logbook →</a>
            </div>

            <div class="sidebar-profile" id="profil">
                <div class="avatar">{{ $initials }}</div>
                <div class="profile-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span>Dosen Pembimbing</span>
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
<script>
    const searchInput = document.getElementById('dashboardSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.trim().toLowerCase();
            const searchables = document.querySelectorAll('.searchable-card, .workflow-table tbody tr, .workflow-card');

            searchables.forEach(function (item) {
                const match = item.textContent.toLowerCase().includes(keyword);
                item.style.display = match ? '' : 'none';
            });
        });
    }
</script>
</body>
</html>
