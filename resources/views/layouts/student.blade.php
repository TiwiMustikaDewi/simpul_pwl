<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Mahasiswa') | SIMPUL UNILA</title>

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

        .badge-quota {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
        }
        .badge-quota.success {
            background: #dcfce7;
            color: #15803d;
        }
        .badge-quota.warning {
            background: #fef3c7;
            color: #b45309;
        }
        .badge-quota.danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .alert-box {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 22px;
            font-size: 13.5px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
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

        .nav-link.active {
            background: #eaf1fd;
            color: var(--brand-primary);
            font-weight: 600;
            border-right: 3px solid var(--brand-primary);
        }

        .step-progress-bar {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            margin: 20px 0;
        }
        .step-item {
            background: #ffffff;
            border: 1px solid var(--border);
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            font-size: 11.5px;
            transition: all .2s ease;
        }
        .step-item.active {
            border-color: var(--brand-primary);
            background: #f0f7ff;
            color: var(--brand-dark);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(64, 121, 234, 0.12);
        }
        .step-item.done {
            background: #f0fdf4;
            border-color: #86efac;
            color: #166534;
        }

        .btn-brand {
            background: var(--brand-primary);
            color: #ffffff !important;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s;
            cursor: pointer;
        }
        .btn-brand:hover {
            background: var(--brand-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
        }
        .btn-brand:disabled, .btn-brand.disabled {
            background: #cbd5e1 !important;
            color: #64748b !important;
            cursor: not-allowed !important;
            transform: none !important;
            box-shadow: none !important;
        }

        .avatar-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4079ea, #1d4ed8);
            color: #ffffff;
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 14px;
        }
    </style>
    @stack('styles')
</head>
<body>

@php
    $studentUser = auth()->user();
    $studentProfile = $studentUser->student;

    $studentMenu = [
        ['Dashboard',                 '⌂', 'mahasiswa.dashboard',          'mahasiswa.dashboard'],
        ['Eksplorasi Perusahaan',     '▦', 'mahasiswa.companies.index',     'mahasiswa.companies.*'],
        ['Pengajuan Kesiapan KP',     '▤', 'mahasiswa.applications.create', 'mahasiswa.applications.*'],
        ['Logbook Kegiatan Harian',   '▥', 'mahasiswa.logbook.index',       'mahasiswa.logbook.*'],
        ['Laporan Akhir KP',          '▣', 'mahasiswa.reports.index',       'mahasiswa.reports.*'],
        ['Pendaftaran Sidang KP',     '▧', 'mahasiswa.sidang.index',        'mahasiswa.sidang.*'],
        ['Ulasan Pengalaman Alumni',  '☆', 'mahasiswa.experiences.create',  'mahasiswa.experiences.*'],
    ];
@endphp

<div class="app">

    <!-- TOPBAR -->
    <header class="topbar">
        <a href="{{ route('mahasiswa.dashboard') }}" class="brand">
            <div class="brand-icon">S</div>
            <div>
                <div class="brand-name">SIMPUL</div>
                <div class="brand-subtitle">Portal Mahasiswa • Universitas Lampung</div>
            </div>
        </a>

        <div class="header-actions">
            <div style="display: flex; align-items: center; gap: 10px; margin-right: 12px;">
                <div class="avatar-circle">
                    {{ strtoupper(substr($studentUser->name, 0, 1)) }}
                </div>
                <div style="text-align: left; line-height: 1.3;">
                    <div style="font-weight: 600; font-size: 13px; color: var(--text);">{{ $studentUser->name }}</div>
                    <div style="font-size: 11px; color: var(--muted);">NPM: {{ $studentProfile?->npm ?? 'Belum diisi' }}</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-outline" style="border-radius: 20px; font-size: 12px; padding: 6px 14px;">Logout</button>
            </form>
        </div>
    </header>

    <div class="layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="nav-label">ALUR KULIAH PRAKTIK</div>

            @foreach ($studentMenu as [$label, $icon, $routeName, $pattern])
                <a
                    href="{{ route($routeName) }}"
                    class="nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}"
                >
                    <span class="nav-icon">{{ $icon }}</span>
                    <span>{{ $label }}</span>
                </a>
            @endforeach

            <div class="sidebar-note" style="margin-top: 30px; background: #eff6ff; border-color: #bfdbfe;">
                <div class="note-icon">📌</div>
                <h3 style="color: #1e40af;">Aturan Kuota Instansi</h3>
                <p style="font-size: 11.5px; color: #3b82f6; line-height: 1.5; margin-top: 4px;">
                    Setiap instansi dibatasi maksimal <strong>1 Kelompok</strong> ATAU <strong>3 Mahasiswa Individu</strong> pada periode berjalan.
                </p>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
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
</div>

@stack('scripts')
</body>
</html>
