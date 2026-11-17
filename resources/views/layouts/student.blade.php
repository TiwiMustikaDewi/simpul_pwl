<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Mahasiswa') | SIMPUL UNILA</title>

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

        *, *::before, *::after {
            box-sizing: border-box;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        }

        :root {
            --brand-primary: #2563eb;
            --brand-dark: #1d4ed8;
            --brand-light: #eff6ff;
            --text-main: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --bg-canvas: #f8fafc;
        }

        body {
            background: #f8fafc;
            color: var(--text-body);
            -webkit-font-smoothing: antialiased;
            margin: 0;
            padding: 0;
        }

        /* ---------- TOPBAR ---------- */
        .topbar {
            height: 74px;
            position: sticky;
            top: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 36px;
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .brand-name {
            font-size: 19px;
            font-weight: 800;
            color: #1e3a8a;
            letter-spacing: -0.4px;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 1px;
        }

        /* ---------- LAYOUT & CONTAINER ---------- */
        .layout {
            display: grid;
            grid-template-columns: 270px minmax(0, 1fr);
            min-height: calc(100vh - 74px);
        }

        .content, .main-content {
            width: 100%;
            min-width: 0;
            max-width: 1440px;
            padding: 32px 40px 60px;
            margin: 0 auto;
        }

        /* ---------- SIDEBAR ---------- */
        .sidebar {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 18px 28px;
            background: #ffffff;
            border-right: 1px solid var(--border-color);
            position: sticky;
            top: 74px;
            height: calc(100vh - 74px);
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .nav-label {
            margin: 0 10px 12px;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            margin-bottom: 5px;
            border-radius: 12px;
            color: #475569;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.4;
            transition: all .2s ease;
            border-left: 3px solid transparent;
            text-decoration: none;
        }

        .nav-link:hover {
            color: var(--brand-primary);
            background: #f8fafc;
        }

        .nav-link.active {
            background: #eff6ff !important;
            color: var(--brand-dark) !important;
            font-weight: 600 !important;
            border-left: 3.5px solid var(--brand-primary) !important;
            box-shadow: 0 1px 3px rgba(37, 99, 235, 0.06);
        }

        .nav-icon-wrap {
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: currentColor;
        }

        .nav-icon-wrap svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
        }

        .sidebar-note {
            margin-top: 24px;
            padding: 16px;
            border-radius: 14px;
            background: #f0f7ff;
            border: 1px solid #bfdbfe;
        }

        .note-icon {
            width: 30px;
            height: 30px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: #dbeafe;
            margin-bottom: 8px;
            font-size: 15px;
        }

        /* ---------- PANELS & CARDS ---------- */
        .panel {
            min-width: 0;
            padding: 26px 28px;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03), 0 4px 12px rgba(15, 23, 42, 0.02);
            margin-bottom: 24px;
        }

        .panel:last-child {
            margin-bottom: 0;
        }

        .panel-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
        }

        /* ---------- BADGES ---------- */
        .badge-quota {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            line-height: 1.35;
        }

        .badge-quota.success {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .badge-quota.warning {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .badge-quota.danger {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 500;
            padding: 3px 9px;
            border-radius: 6px;
            line-height: 1.3;
        }

        .badge-status.success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .badge-status.warning {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .badge-status.danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .company-quota-card {
            padding: 16px 18px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.02);
            transition: all .2s ease;
        }

        .company-quota-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        }

        /* ---------- ALERTS ---------- */
        .alert-box {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 22px;
            font-size: 13.5px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            line-height: 1.5;
        }

        .alert-box.success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-box.error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-box.info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }

        /* ---------- BUTTONS ---------- */
        .btn-brand {
            background: var(--brand-primary);
            color: #ffffff !important;
            border: none;
            padding: 10px 22px;
            border-radius: 24px;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
        }

        .btn-brand:hover {
            background: var(--brand-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }

        .btn-outline-custom {
            background: #ffffff;
            color: #334155 !important;
            border: 1px solid #cbd5e1;
            padding: 10px 20px;
            border-radius: 24px;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-outline-custom:hover {
            border-color: #94a3b8;
            background: #f8fafc;
            color: #0f172a !important;
        }

        .avatar-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #ffffff;
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        }

        /* ---------- SIDEBAR TOGGLE & BACKDROP ---------- */
        .sidebar-toggle-btn {
            display: none;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            color: #334155;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
            padding: 0;
        }

        .sidebar-toggle-btn:hover,
        .sidebar-toggle-btn:focus-visible {
            background: #eff6ff;
            color: var(--brand-primary);
            border-color: #bfdbfe;
            outline: none;
        }

        .mobile-sidebar-header {
            display: none;
        }

        .sidebar-backdrop {
            display: none;
        }

        @media (max-width: 1024px) {
            .sidebar-toggle-btn {
                display: inline-flex;
            }

            .layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: flex !important;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                width: 285px !important;
                max-width: 85vw !important;
                height: 100vh !important;
                z-index: 1000 !important;
                background: #ffffff !important;
                box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.15), 0 10px 10px -5px rgba(15, 23, 42, 0.05) !important;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                overflow-y: auto;
                padding: 18px 16px 24px !important;
            }

            .sidebar.is-open {
                transform: translateX(0) !important;
            }

            .mobile-sidebar-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding-bottom: 14px;
                margin-bottom: 16px;
                border-bottom: 1px solid var(--border-color);
            }

            .sidebar-close-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 36px;
                border-radius: 10px;
                background: #f1f5f9;
                border: 1px solid var(--border-color);
                color: #475569;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .sidebar-close-btn:hover {
                background: #fee2e2;
                border-color: #fecaca;
                color: #dc2626;
            }

            .sidebar-backdrop {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.5);
                backdrop-filter: blur(2px);
                z-index: 999;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }

            .sidebar-backdrop.is-active {
                opacity: 1;
                pointer-events: auto;
            }

            body.sidebar-open {
                overflow: hidden;
            }

            .content, .main-content {
                padding: 24px 20px 48px;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                padding: 0 16px;
                height: 66px;
                gap: 10px;
            }

            .brand-name {
                font-size: 17px;
            }

            .brand-subtitle {
                display: none;
            }

            .brand-icon {
                width: 36px;
                height: 36px;
                font-size: 17px;
                border-radius: 10px;
            }

            .user-profile-text {
                display: none !important;
            }

            .content, .main-content {
                padding: 16px 14px 40px;
            }

            .panel {
                padding: 24px 16px !important;
                border-radius: 14px !important;
            }
        }

        /* ---------- LOGOUT CONFIRMATION MODAL ---------- */
        .logout-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .logout-modal-backdrop.is-active {
            display: flex;
            opacity: 1;
        }

        .logout-modal-card {
            background: #ffffff;
            border-radius: 20px;
            width: 100%;
            max-width: 420px;
            padding: 28px 24px;
            text-align: center;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.08);
            transform: scale(0.95);
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .logout-modal-backdrop.is-active .logout-modal-card {
            transform: scale(1);
        }

        .logout-modal-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #fee2e2;
            color: #dc2626;
            display: grid;
            place-items: center;
            margin: 0 auto 16px;
            border: 4px solid #fef2f2;
        }

        .logout-modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 8px;
        }

        .logout-modal-desc {
            font-size: 13.5px;
            color: #64748b;
            line-height: 1.55;
            margin: 0 0 24px;
        }

        .logout-modal-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logout-modal-btn {
            flex: 1;
            padding: 11px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid transparent;
        }

        .logout-modal-btn.btn-cancel {
            background: #f1f5f9;
            color: #475569;
            border-color: #e2e8f0;
        }

        .logout-modal-btn.btn-cancel:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .logout-modal-btn.btn-confirm {
            background: #dc2626;
            color: #ffffff;
            border-color: #dc2626;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.25);
            width: 100%;
        }

        .logout-modal-btn.btn-confirm:hover {
            background: #b91c1c;
            border-color: #b91c1c;
        }

        @media (max-width: 480px) {
            .logout-modal-actions {
                flex-direction: column-reverse;
            }
            .logout-modal-actions form {
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

@php
    $studentUser = auth()->user();
    $studentProfile = $studentUser->student;
    $unreadNotifCount = \App\Models\Notification::where('user_id', $studentUser->id)->where('is_read', false)->count();

    $studentMenu = [
        ['Dashboard',                 'dashboard', 'mahasiswa.dashboard',          'mahasiswa.dashboard'],
        ['Eksplorasi Perusahaan',     'company',   'mahasiswa.companies.index',     'mahasiswa.companies.*'],
        ['Pengajuan Kesiapan KP',     'document',  'mahasiswa.applications.create', 'mahasiswa.applications.*'],
        ['Logbook Kegiatan Harian',   'logbook',   'mahasiswa.logbook.index',       'mahasiswa.logbook.*'],
        ['Laporan Akhir KP',          'report',    'mahasiswa.reports.index',       'mahasiswa.reports.*'],
        ['Pendaftaran Sidang KP',     'sidang',    'mahasiswa.sidang.index',        'mahasiswa.sidang.*'],
        ['Ulasan Pengalaman Alumni',  'star',      'mahasiswa.experiences.index',   'mahasiswa.experiences.*'],
    ];
@endphp

<div class="app">

    <!-- TOPBAR -->
    <header class="topbar">
        <div style="display: flex; align-items: center; gap: 12px;">
            <!-- HAMBURGER BUTTON -->
            <button type="button" class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Buka Menu Navigasi" aria-expanded="false">
                <iconify-icon icon="lucide:menu" width="22" height="22"></iconify-icon>
            </button>

            <a href="{{ route('mahasiswa.dashboard') }}" class="brand">
                <div class="brand-icon">S</div>
                <div>
                    <div class="brand-name">SIMPUL</div>
                    <div class="brand-subtitle">Portal Mahasiswa • Universitas Lampung</div>
                </div>
            </a>
        </div>

        <div class="header-actions">
            <!-- NOTIFIKASI BELL BUTTON -->
            <a href="{{ route('mahasiswa.notifications.index') }}"
               class="headbar-notif-btn"
               title="Pusat Notifikasi"
               style="position: relative; width: 40px; height: 40px; border-radius: 12px; background: {{ request()->routeIs('mahasiswa.notifications.*') ? '#eff6ff' : '#f8fafc' }}; border: 1px solid {{ request()->routeIs('mahasiswa.notifications.*') ? '#93c5fd' : '#e2e8f0' }}; display: flex; align-items: center; justify-content: center; color: {{ request()->routeIs('mahasiswa.notifications.*') ? '#2563eb' : '#475569' }}; text-decoration: none; transition: all .2s; margin-right: 4px;">
                <iconify-icon icon="lucide:bell" width="20" height="20"></iconify-icon>
                @if ($unreadNotifCount > 0)
                    <span style="position: absolute; top: -3px; right: -3px; background: #ef4444; color: #ffffff; font-size: 10px; font-weight: 700; min-width: 18px; height: 18px; border-radius: 9px; display: flex; align-items: center; justify-content: center; padding: 0 4px; border: 2px solid #ffffff; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);">
                        {{ $unreadNotifCount > 9 ? '9+' : $unreadNotifCount }}
                    </span>
                @endif
            </a>

            <div style="display: flex; align-items: center; gap: 12px;">
                <div class="avatar-circle">
                    {{ strtoupper(substr($studentUser->name, 0, 1)) }}
                </div>
                <div style="text-align: left; line-height: 1.35;" class="user-profile-text">
                    <div style="font-weight: 600; font-size: 13.5px; color: var(--text-main);">{{ $studentUser->name }}</div>
                    <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 1px;">NPM: {{ $studentProfile?->npm ?? 'Belum diisi' }}</div>
                </div>
            </div>
        </div>
    </header>

    <div class="layout">

        <!-- BACKDROP OVERLAY FOR MOBILE SIDEBAR -->
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <!-- MOBILE SIDEBAR HEADER -->
            <div class="mobile-sidebar-header">
                <div class="brand" style="gap: 10px;">
                    <div class="brand-icon" style="width: 36px; height: 36px; font-size: 17px; border-radius: 10px;">S</div>
                    <div>
                        <div class="brand-name" style="font-size: 16px;">SIMPUL</div>
                        <div class="brand-subtitle" style="font-size: 10px;">Portal Mahasiswa</div>
                    </div>
                </div>
                <button type="button" class="sidebar-close-btn" id="sidebarClose" aria-label="Tutup Menu Navigasi">
                    <iconify-icon icon="lucide:x" width="20" height="20"></iconify-icon>
                </button>
            </div>

            <div>
                <div class="nav-label">ALUR KULIAH PRAKTIK</div>

                @foreach ($studentMenu as [$label, $iconKey, $routeName, $pattern])
                    <a
                        href="{{ route($routeName) }}"
                        class="nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}"
                    >
                        <span class="nav-icon-wrap">
                            @if ($iconKey === 'dashboard')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            @elseif ($iconKey === 'company')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            @elseif ($iconKey === 'document')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            @elseif ($iconKey === 'logbook')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                            @elseif ($iconKey === 'report')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><polyline points="9 15 11 17 15 13"/></svg>
                            @elseif ($iconKey === 'sidang')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                            @elseif ($iconKey === 'star')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            @endif
                        </span>
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </div>

            <!-- LOGOUT BUTTON IN NAVBAR POJOK KIRI BAWAH -->
            <div style="padding-top: 18px; border-top: 1px solid var(--border-color); margin-top: auto;">
                <button type="button" id="triggerLogoutBtn" style="width: 100%; display: flex; align-items: center; justify-content: flex-start; gap: 10px; padding: 11px 16px; background: #fff5f5; border: 1px solid #fed7d7; border-radius: 12px; color: #dc2626; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; font-family: inherit;" onmouseover="this.style.background='#fee2e2'; this.style.borderColor='#fca5a5';" onmouseout="this.style.background='#fff5f5'; this.style.borderColor='#fed7d7';">
                    <iconify-icon icon="lucide:log-out" width="17" height="17" style="color: #ef4444;"></iconify-icon>
                    <span>Logout</span>
                </button>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="content">
            @if (session('success'))
                <div class="alert-box success">
                    <span>✓</span>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-box error">
                    <span>✕</span>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if (session('info'))
                <div class="alert-box info">
                    <span>ℹ</span>
                    <div>{{ session('info') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-box error">
                    <span>✕</span>
                    <div>
                        <div style="font-weight: 600; margin-bottom: 4px;">Harap periksa kesalahan berikut:</div>
                        <ul style="margin-left: 18px;">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <!-- LOGOUT CONFIRMATION MODAL -->
    <div id="logoutModal" class="logout-modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="logoutModalTitle">
        <div class="logout-modal-card">
            <div class="logout-modal-icon">
                <iconify-icon icon="lucide:log-out" width="28" height="28"></iconify-icon>
            </div>
            <h3 id="logoutModalTitle" class="logout-modal-title">Konfirmasi Keluar Akun</h3>
            <p class="logout-modal-desc">
                Apakah Anda yakin ingin keluar dari sistem SIMPUL? Anda harus login kembali untuk mengakses portal mahasiswa.
            </p>
            <div class="logout-modal-actions">
                <button type="button" class="logout-modal-btn btn-cancel" id="cancelLogoutBtn">
                    Batal
                </button>
                <form action="{{ route('logout') }}" method="POST" id="confirmLogoutForm" style="margin: 0; flex: 1;">
                    @csrf
                    <button type="submit" class="logout-modal-btn btn-confirm">
                        Ya, Keluar Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function openSidebar() {
            if (!sidebar) return;
            sidebar.classList.add('is-open');
            if (sidebarBackdrop) sidebarBackdrop.classList.add('is-active');
            document.body.classList.add('sidebar-open');
            if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', 'true');
        }

        function closeSidebar() {
            if (!sidebar) return;
            sidebar.classList.remove('is-open');
            if (sidebarBackdrop) sidebarBackdrop.classList.remove('is-active');
            document.body.classList.remove('sidebar-open');
            if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', 'false');
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function (e) {
                e.stopPropagation();
                if (sidebar.classList.contains('is-open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        }

        if (sidebarClose) {
            sidebarClose.addEventListener('click', closeSidebar);
        }

        if (sidebarBackdrop) {
            sidebarBackdrop.addEventListener('click', closeSidebar);
        }

        // Close on ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && sidebar && sidebar.classList.contains('is-open')) {
                closeSidebar();
            }
        });

        // Close when window resized beyond 1024px
        window.addEventListener('resize', function () {
            if (window.innerWidth > 1024 && sidebar && sidebar.classList.contains('is-open')) {
                closeSidebar();
            }
        });

        // ---------- LOGOUT MODAL HANDLERS ----------
        const triggerLogoutBtn = document.getElementById('triggerLogoutBtn');
        const logoutModal = document.getElementById('logoutModal');
        const cancelLogoutBtn = document.getElementById('cancelLogoutBtn');

        function openLogoutModal() {
            if (!logoutModal) return;
            logoutModal.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        }

        function closeLogoutModal() {
            if (!logoutModal) return;
            logoutModal.classList.remove('is-active');
            if (!document.body.classList.contains('sidebar-open')) {
                document.body.style.overflow = '';
            }
        }

        if (triggerLogoutBtn) {
            triggerLogoutBtn.addEventListener('click', function (e) {
                e.preventDefault();
                openLogoutModal();
            });
        }

        if (cancelLogoutBtn) {
            cancelLogoutBtn.addEventListener('click', closeLogoutModal);
        }

        if (logoutModal) {
            logoutModal.addEventListener('click', function (e) {
                if (e.target === logoutModal) {
                    closeLogoutModal();
                }
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && logoutModal && logoutModal.classList.contains('is-active')) {
                closeLogoutModal();
            }
        });
    });
</script>

@stack('scripts')
</body>
</html>
