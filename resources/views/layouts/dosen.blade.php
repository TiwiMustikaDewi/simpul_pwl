<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Dosen') | SIMPUL</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/simpul-admin.css') }}">
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <style>
        iconify-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            vertical-align: -0.15em;
        }

        body, button, input, select, textarea {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        }

      

        /* Transisi halus & elevasi kartu */
        .panel {
            transition: box-shadow .2s ease, border-color .2s ease;
        }
        .panel:hover {
            box-shadow: 0 8px 24px #173b670d;
        }

        /* Navigasi Sidebar Dosen yang Lebih Menawan */
        .sidebar .nav-link {
            position: relative;
            font-weight: 600;
        }
        .sidebar .nav-link.active {
            background: linear-gradient(90deg, #e4f0ff 0%, #eaf4ff 100%);
            color: var(--blue);
            font-weight: 700;
            border-left: 3px solid var(--blue);
            padding-left: 10px;
        }
        .sidebar .nav-link:hover:not(.active) {
            background: #f4f8fe;
            color: var(--blue-dark);
            transform: translateX(2px);
        }

        /* Pill status yang lebih kontras & modern */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 11px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .2px;
        }
        .status-pill::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }
        .status-pill.submitted::before { background: var(--blue); }
        .status-pill.in_progress::before { background: var(--blue); }
        .status-pill.scheduled::before { background: var(--green); }
        .status-pill.approved::before, .status-pill.completed::before { background: var(--green); }
        .status-pill.pending::before, .status-pill.revision::before { background: var(--yellow); }
        .status-pill.rejected::before { background: var(--red); }

        /* Komponen Quick Jump / Sub-navigasi Cepat */
        .quick-nav-pills {
            display: flex;
            align-items: center;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 6px;
            margin-bottom: 18px;
        }
        .quick-nav-pills a {
            padding: 8px 14px;
            border-radius: 20px;
            background: #fff;
            border: 1px solid var(--border);
            font-size: 11px;
            font-weight: 700;
            color: #536783;
            transition: .2s;
            white-space: nowrap;
        }
        .quick-nav-pills a:hover {
            background: var(--blue-light);
            color: var(--blue);
            border-color: #bcd9fb;
        }

        /* Mini progress bar dalam tabel/kartu */
        .mini-progress-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 110px;
        }
        .mini-progress-bar {
            flex: 1;
            height: 6px;
            background: #e6f0fa;
            border-radius: 10px;
            overflow: hidden;
        }
        .mini-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--blue), #45a4ff);
            border-radius: inherit;
        }

        /* Kartu Unduhan Berkas / File Attachment */
        .doc-file-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 12px 16px;
            border-radius: 12px;
            background: #f7fbff;
            border: 1px solid #d8e8fc;
            margin: 10px 0;
            transition: .2s;
        }
        .doc-file-card:hover {
            background: #edf5ff;
            border-color: #bad8fb;
        }
        .doc-file-meta {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .doc-file-icon {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            background: #ffebe9;
            color: #dc3545;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 800;
        }

        /* Rubrik & Catatan Nilai Sidang */
        .rubric-box {
            padding: 14px 16px;
            border-radius: 12px;
            background: linear-gradient(135deg, #f9fcff 0%, #edf5ff 100%);
            border: 1px solid #d2e4fc;
            margin-bottom: 16px;
        }
        .grade-ribbon-lg {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 65px;
            height: 65px;
            padding: 0 16px;
            border-radius: 16px;
            background: linear-gradient(135deg, #e2f8ef, #c8f2de);
            color: #127952;
            font-size: 28px;
            font-weight: 800;
            border: 1px solid #b7ecd3;
            box-shadow: 0 4px 12px rgba(24, 168, 117, 0.12);
        }

        /* Card timeline yang lebih elegan */
        .timeline-card {
            position: relative;
            border-left: 3px solid #cbdff7;
            padding-left: 18px;
            transition: .2s;
        }
        .timeline-card:hover {
            border-left-color: var(--blue);
            box-shadow: 0 6px 18px #173b6708;
        }

        /* Header Dosen Profil */
        .dosen-header-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 10px;
            border-radius: 12px;
            background: #f8fbff;
            border: 1px solid var(--border);
        }
        .dosen-header-profile:hover {
            background: var(--blue-light);
        }
        .dosen-notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 17px;
            height: 17px;
            padding: 0 4px;
            border: 2px solid #fff;
            border-radius: 20px;
            background: #ef4444;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            line-height: 13px;
            text-align: center;
        }
    </style>
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
    $unreadNotificationCount = auth()->user()->notifications()->where('is_read', false)->count();

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
            <a href="{{ route('dosen.notifications.index') }}" class="header-icon{{ request()->routeIs('dosen.notifications.*') ? ' is-active' : '' }}" title="Pusat notifikasi" style="position: relative;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path>
                    <path d="M10 21h4"></path>
                </svg>
                @if ($unreadNotificationCount > 0)
                    <span class="dosen-notification-badge">{{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}</span>
                @endif
            </a>
            <a href="{{ route('dosen.profile.index') }}" class="header-icon" title="Profil dosen pembimbing">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </a>

            <a href="{{ route('dosen.profile.index') }}" class="dosen-header-profile" title="Buka profil dosen">
                <div class="avatar" style="width: 28px; height: 28px; font-size: 11px;">{{ $initials }}</div>
                <div style="display: flex; flex-direction: column;">
                    <span class="account-name" style="max-width: 130px;">{{ auth()->user()->name }}</span>
                    <span style="font-size: 9px; color: var(--muted); font-weight: 700; text-transform: uppercase;">Dosen Pembimbing</span>
                </div>
            </a>

            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari akun Dosen?');">
                @csrf
                <button type="submit" class="btn btn-outline" title="Keluar dari akun">Logout</button>
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
                <a href="{{ route('dosen.logs.index') }}" class="btn btn-primary btn-full">Periksa Logbook</a>
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
            const searchables = document.querySelectorAll('.searchable-card, .workflow-table tbody tr, .workflow-card, .timeline-card');

            searchables.forEach(function (item) {
                const match = item.textContent.toLowerCase().includes(keyword);
                item.style.display = match ? '' : 'none';
            });
        });
    }
</script>
</body>
</html>