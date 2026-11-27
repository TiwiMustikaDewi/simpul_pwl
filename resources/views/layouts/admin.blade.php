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
        <div class="topbar-brand">
            <button
                type="button"
                class="admin-sidebar-toggle"
                id="adminSidebarToggle"
                aria-label="Buka Menu Navigasi"
                aria-controls="adminSidebar"
                aria-expanded="false"
            >
                <iconify-icon icon="lucide:menu" width="22" height="22" aria-hidden="true"></iconify-icon>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="brand">
                <div class="brand-icon">S</div>
                <div>
                    <div class="brand-name">SIMPUL</div>
                    <div class="brand-subtitle">Portal Admin · Universitas Lampung</div>
                </div>
            </a>
        </div>

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
        <div class="admin-sidebar-backdrop" id="adminSidebarBackdrop"></div>
        <aside class="sidebar" id="adminSidebar" aria-label="Navigasi admin">
            <div class="sidebar-mobile-header">
                <div class="sidebar-mobile-brand">
                    <div class="brand-icon">S</div>
                    <div>
                        <div class="brand-name">SIMPUL</div>
                        <div class="brand-subtitle">Portal Admin</div>
                    </div>
                </div>
                <button type="button" class="sidebar-close-btn" id="adminSidebarClose" aria-label="Tutup Menu Navigasi">
                    <iconify-icon icon="lucide:x" width="20" height="20" aria-hidden="true"></iconify-icon>
                </button>
            </div>
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
        const adminSidebar = document.getElementById('adminSidebar');
        const adminSidebarToggle = document.getElementById('adminSidebarToggle');
        const adminSidebarClose = document.getElementById('adminSidebarClose');
        const adminSidebarBackdrop = document.getElementById('adminSidebarBackdrop');

        function closeAdminSidebar() {
            if (!adminSidebar || !adminSidebarToggle) {
                return;
            }

            adminSidebar.classList.remove('is-open');
            adminSidebarBackdrop.classList.remove('is-active');
            document.body.classList.remove('admin-sidebar-open');
            adminSidebarToggle.setAttribute('aria-expanded', 'false');
            adminSidebarToggle.setAttribute('aria-label', 'Buka Menu Navigasi');
            adminSidebarToggle.focus();
        }

        if (adminSidebar && adminSidebarToggle && adminSidebarClose && adminSidebarBackdrop) {
            adminSidebarToggle.addEventListener('click', function () {
                const isOpen = adminSidebar.classList.toggle('is-open');

                adminSidebarBackdrop.classList.toggle('is-active', isOpen);
                document.body.classList.toggle('admin-sidebar-open', isOpen);
                adminSidebarToggle.setAttribute('aria-expanded', String(isOpen));
                adminSidebarToggle.setAttribute('aria-label', isOpen ? 'Tutup Menu Navigasi' : 'Buka Menu Navigasi');
            });

            adminSidebarClose.addEventListener('click', closeAdminSidebar);
            adminSidebarBackdrop.addEventListener('click', closeAdminSidebar);

            adminSidebar.querySelectorAll('.nav-link').forEach(function (link) {
                link.addEventListener('click', closeAdminSidebar);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && adminSidebar.classList.contains('is-open')) {
                    closeAdminSidebar();
                }
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth > 900 && adminSidebar.classList.contains('is-open')) {
                    closeAdminSidebar();
                }
            });
        }

        const serviceTrack = document.getElementById('adminServiceTrack');
        const scrollServicesButton = document.getElementById('scrollAdminServices');
        const scrollServicesBackButton = document.getElementById('scrollAdminServicesBack');

        if (serviceTrack && scrollServicesButton && scrollServicesBackButton) {
            function getServiceScrollDistance() {
                const firstCard = serviceTrack.querySelector('.service-card');
                const gap = parseFloat(getComputedStyle(serviceTrack).gap) || 0;

                return firstCard
                    ? firstCard.getBoundingClientRect().width + gap
                    : serviceTrack.clientWidth;
            }

            function updateServiceScrollButtons() {
                const hasScrolled = serviceTrack.scrollLeft > 1;
                const backButtonWasHidden = scrollServicesBackButton.hidden;
                const firstCard = serviceTrack.querySelector('.service-card');
                const visibleCardCount = firstCard
                    ? serviceTrack.clientWidth / firstCard.getBoundingClientRect().width
                    : 0;

                scrollServicesBackButton.hidden = !hasScrolled;

                if (hasScrolled && backButtonWasHidden && visibleCardCount >= 2.7) {
                    serviceTrack.scrollTo({
                        left: serviceTrack.scrollWidth - serviceTrack.clientWidth,
                        behavior: 'smooth',
                    });
                }

                const maxScrollLeft = serviceTrack.scrollWidth - serviceTrack.clientWidth;

                scrollServicesButton.disabled = maxScrollLeft <= 1 || serviceTrack.scrollLeft >= maxScrollLeft - 1;
                scrollServicesBackButton.disabled = !hasScrolled;
            }

            scrollServicesButton.addEventListener('click', function () {
                serviceTrack.scrollBy({ left: getServiceScrollDistance(), behavior: 'smooth' });
            });

            scrollServicesBackButton.addEventListener('click', function () {
                serviceTrack.scrollBy({ left: -getServiceScrollDistance(), behavior: 'smooth' });
            });

            serviceTrack.addEventListener('scroll', updateServiceScrollButtons, { passive: true });
            window.addEventListener('resize', updateServiceScrollButtons);
            updateServiceScrollButtons();
        }

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