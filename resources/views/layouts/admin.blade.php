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
    </style>
    @stack('styles')
</head>
<body>

@php
    $unreadNotifCount = auth()->user()->notifications()->where('is_read', false)->count();
    $menu = [
        ['Dashboard',              'lucide:house', 'admin.dashboard', 'admin.dashboard'],
        ['Data Mahasiswa & Dosen', 'icon-park-outline:doc-search-two', 'admin.pengguna.index', 'admin.pengguna.*'],
        ['Data Perusahaan',        'uix-sharp:company-group', 'admin.companies.index', 'admin.companies.*'],
        ['Verifikasi Pengajuan',   'carbon:receipt-verification', 'admin.applications.index', 'admin.applications.*'],
        ['Kelompok & Pembimbing',  'uix-sharp:users-three', 'admin.groups.index', 'admin.groups.*'],
        ['Monitoring KP',          'tabler:heart-rate-monitor', 'admin.monitoring.index', 'admin.monitoring.*'],
        ['Sidang KP',              'lucide:calendar-clock', 'admin.sidang.index', 'admin.sidang.*'],
        ['Validasi Pengalaman',    'tabler:list-check', 'admin.experiences.index', 'admin.experiences.*'],
    ];
@endphp

<div class="app">

    <!-- HEADER -->
    <header class="topbar">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            <div class="brand-icon">S</div>
            <div>
                <div class="brand-name">SIMPUL</div>
                <div class="brand-subtitle">Portal Admin · Universitas Lampung</div>
            </div>
        </a>

        <div class="header-actions">
            <a
                href="{{ route('admin.notifications.index') }}"
                class="header-icon admin-notification-btn{{ request()->routeIs('admin.notifications.*') ? ' is-active' : '' }}"
                title="Pusat Notifikasi"
                aria-label="Pusat Notifikasi"
            >
                <iconify-icon icon="lucide:bell" width="20" height="20" aria-hidden="true"></iconify-icon>
                @if ($unreadNotifCount > 0)
                    <span class="admin-notification-count">
                        {{ $unreadNotifCount > 9 ? '9+' : $unreadNotifCount }}
                    </span>
                @endif
            </a>

            <div class="header-profile">
                <div class="header-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="header-profile-text">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span>Admin Jurusan</span>
                </div>
            </div>
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
                    <span class="nav-icon">
                        @if (str_contains($icon, ':'))
                            <iconify-icon icon="{{ $icon }}" width="18" height="18" aria-hidden="true"></iconify-icon>
                        @else
                            {{ $icon }}
                        @endif
                    </span>
                    {{ $label }}
                </a>
            @endforeach

            <div class="sidebar-footer">
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="sidebar-logout-form"
                    id="logoutTriggerForm"
                >
                    @csrf
                    <button type="submit" class="sidebar-logout-btn">
                        <iconify-icon icon="lucide:log-out" width="20" height="20" aria-hidden="true"></iconify-icon>
                        Logout
                    </button>
                </form>

                <div class="sidebar-profile" id="profil">
                    <div class="avatar" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: #fff; font-weight: 700; font-size: 14px; display: grid; place-items: center; border-radius: 50%;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <strong>{{ auth()->user()->name }}</strong>
                        <span>Admin Jurusan</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="content">
            @yield('content')
        </main>
    </div>
</div>

<div
    class="admin-logout-modal"
    id="adminLogoutModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="adminLogoutModalTitle"
    aria-hidden="true"
>
    <div class="admin-logout-dialog">
        <div class="admin-logout-icon">
            <iconify-icon icon="lucide:log-out" width="32" height="32" aria-hidden="true"></iconify-icon>
        </div>
        <h2 class="admin-logout-title" id="adminLogoutModalTitle">Konfirmasi Keluar Akun</h2>
        <p class="admin-logout-description">
            Apakah Anda yakin ingin keluar dari sistem SIMPUL? Anda harus login kembali untuk mengakses portal admin.
        </p>
        <div class="admin-logout-actions">
            <button type="button" class="admin-logout-button admin-logout-cancel" id="cancelAdminLogout">
                Batal
            </button>
            <form action="{{ route('logout') }}" method="POST" class="admin-logout-confirm-form">
                @csrf
                <button type="submit" class="admin-logout-button admin-logout-confirm">
                    Ya, Keluar Akun
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoutTriggerForm = document.getElementById('logoutTriggerForm');
        const logoutModal = document.getElementById('adminLogoutModal');
        const cancelLogoutButton = document.getElementById('cancelAdminLogout');
        let lastFocusedElement = null;

        if (!logoutTriggerForm || !logoutModal || !cancelLogoutButton) {
            return;
        }

        function openLogoutModal() {
            lastFocusedElement = document.activeElement;
            logoutModal.classList.add('is-active');
            logoutModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            cancelLogoutButton.focus();
        }

        function closeLogoutModal() {
            logoutModal.classList.remove('is-active');
            logoutModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';

            if (lastFocusedElement instanceof HTMLElement) {
                lastFocusedElement.focus();
            }
        }

        logoutTriggerForm.addEventListener('submit', function (event) {
            event.preventDefault();
            openLogoutModal();
        });

        cancelLogoutButton.addEventListener('click', closeLogoutModal);

        logoutModal.addEventListener('click', function (event) {
            if (event.target === logoutModal) {
                closeLogoutModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && logoutModal.classList.contains('is-active')) {
                closeLogoutModal();
            }
        });
    });
</script>

@stack('scripts')
</body>
</html>