@extends('layouts.student')

@section('title', 'Dashboard Mahasiswa')

@push('styles')
<style>
    /* ---------- DASHBOARD RESPONSIVE STYLES ---------- */
    .dashboard-header-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        line-height: 1.3;
        margin: 0;
    }

    .dashboard-steps-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 14px;
        margin-top: 10px;
    }

    .dashboard-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.52fr) minmax(320px, 1fr);
        gap: 28px;
        align-items: start;
    }

    .dashboard-meta-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 8px;
    }

    .onboarding-steps-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        text-align: left;
        margin-bottom: 28px;
    }

    .dashboard-action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .internship-status-card {
        background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px 26px;
        margin-bottom: 22px;
    }

    .onboarding-box {
        background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        border: 1.5px dashed #cbd5e1;
        border-radius: 16px;
        padding: 40px 30px;
        text-align: center;
    }

    /* Tablet breakpoint (<= 1024px) */
    @media (max-width: 1024px) {
        .dashboard-main-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .dashboard-steps-grid {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
        }

        .onboarding-steps-grid {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }
    }

    /* Mobile breakpoint (<= 640px) */
    @media (max-width: 640px) {
        .dashboard-header-title {
            font-size: 20px;
        }

        .dashboard-steps-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .dashboard-steps-grid > div:last-child:nth-child(odd) {
            grid-column: span 2;
        }

        .step-item {
            padding: 12px 10px !important;
        }

        .dashboard-meta-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .onboarding-steps-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .internship-status-card {
            padding: 18px 14px;
        }

        .onboarding-box {
            padding: 26px 14px;
        }

        .dashboard-action-buttons {
            flex-direction: column;
            width: 100%;
        }

        .dashboard-action-buttons a,
        .dashboard-action-buttons button {
            width: 100%;
            justify-content: center;
        }
    }

    /* Extra small mobile (<= 380px) */
    @media (max-width: 380px) {
        .dashboard-steps-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-steps-grid > div:last-child:nth-child(odd) {
            grid-column: auto;
        }
    }
</style>
@endpush

@section('content')
<div style="margin-bottom: 30px;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 6px; flex-wrap: wrap;">
        <h1 class="dashboard-header-title">
            Selamat Datang, {{ $user->name }}!
        </h1>
        <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 11px; background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; border-radius: 20px; font-size: 11.5px; font-weight: 600;">
            <iconify-icon icon="lucide:sparkles" width="14" height="14"></iconify-icon>
            Portal Aktif
        </span>
    </div>
    <p style="font-size: 13.5px; color: #64748b; margin: 0; line-height: 1.6;">
        Pantau alur Kuliah Praktik kamu secara terstruktur mulai dari pencarian instansi, bimbingan logbook, hingga pendaftaran sidang.
    </p>
</div>

<!-- TAHAPAN ALUR KP (STEP PROGRESS TRACKER) -->
@php
    $stepsData = [
        1 => ['title' => 'Pengajuan', 'desc' => 'Pilih Instansi & Berkas'],
        2 => ['title' => 'Penetapan', 'desc' => 'Verifikasi & Pembimbing'],
        3 => ['title' => 'Pelaksanaan', 'desc' => 'Logbook & Bimbingan'],
        4 => ['title' => 'Evaluasi', 'desc' => 'Laporan & Sidang KP'],
        5 => ['title' => 'Selesai', 'desc' => 'Kelulusan & Review Alumni'],
    ];
@endphp

<div class="panel">
    <div class="panel-title" style="display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <iconify-icon icon="lucide:list-checks" width="20" height="20" style="color: var(--brand-primary);"></iconify-icon>
            <span>Tahapan Pelaksanaan KP Kamu</span>
        </div>
        <span style="font-size: 12px; font-weight: 600; color: #2563eb; background: #eff6ff; padding: 5px 14px; border-radius: 20px; border: 1px solid #bfdbfe; white-space: nowrap;">
            Langkah {{ $currentStep }} dari 5
        </span>
    </div>

    <div class="dashboard-steps-grid">
        @foreach ($stepsData as $stepNum => $info)
            @php
                $isDone = $currentStep > $stepNum;
                $isActive = $currentStep === $stepNum;
            @endphp
            <div class="step-item" style="
                border-radius: 14px;
                padding: 16px 14px;
                transition: all .2s ease;
                display: flex;
                flex-direction: column;
                gap: 8px;
                @if ($isActive)
                    background: #eff6ff;
                    border: 1.5px solid #3b82f6;
                    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.08);
                @elseif ($isDone)
                    background: #f0fdf4;
                    border: 1px solid #86efac;
                @else
                    background: #ffffff;
                    border: 1px solid #e2e8f0;
                @endif
            ">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="
                        width: 26px;
                        height: 26px;
                        border-radius: 50%;
                        display: grid;
                        place-items: center;
                        font-size: 11.5px;
                        font-weight: 700;
                        @if ($isActive)
                            background: #2563eb;
                            color: #ffffff;
                            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35);
                        @elseif ($isDone)
                            background: #10b981;
                            color: #ffffff;
                        @else
                            background: #f1f5f9;
                            color: #64748b;
                        @endif
                    ">
                        @if ($isDone)
                            <iconify-icon icon="lucide:check" width="14" height="14" style="stroke-width: 3;"></iconify-icon>
                        @else
                            {{ $stepNum }}
                        @endif
                    </div>

                    @if ($isActive)
                        <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: #2563eb; background: #dbeafe; padding: 2px 7px; border-radius: 10px;">Aktif</span>
                    @elseif ($isDone)
                        <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: #166534; background: #dcfce7; padding: 2px 7px; border-radius: 10px;">Selesai</span>
                    @endif
                </div>

                <div>
                    <div style="font-weight: 700; font-size: 13px; color: {{ $isActive ? '#1d4ed8' : ($isDone ? '#166534' : '#0f172a') }}; line-height: 1.35; margin-bottom: 3px;">
                        {{ $stepNum }}. {{ $info['title'] }}
                    </div>
                    <div style="font-size: 11px; color: {{ $isActive ? '#3b82f6' : ($isDone ? '#15803d' : '#64748b') }}; line-height: 1.4;">
                        {{ $info['desc'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="dashboard-main-grid">

    <!-- LEFT COLUMN: STATUS KP / ONBOARDING MAHASISWA BARU -->
    <div>
        <div class="panel">
            <div class="panel-title" style="display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <iconify-icon icon="lucide:briefcase" width="20" height="20" style="color: var(--brand-primary);"></iconify-icon>
                    <span>Status Kuliah Praktik Mahasiswa</span>
                </div>
                @if ($internship)
                    @php
                        $statusColors = [
                            'pending' => ['bg' => '#eff6ff', 'text' => '#1d4ed8', 'border' => '#bfdbfe', 'label' => 'Mengajukan Magang (Menunggu Hasil Instansi)'],
                            'approved' => ['bg' => '#ecfdf5', 'text' => '#065f46', 'border' => '#a7f3d0', 'label' => 'Diterima oleh Instansi (Disetujui)'],
                            'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'border' => '#fecaca', 'label' => 'Tempat KP Sudah Diisi / Ditolak'],
                            'in_progress' => ['bg' => '#eff6ff', 'text' => '#1d4ed8', 'border' => '#bfdbfe', 'label' => 'Sedang Dilaksanakan'],
                            'completed' => ['bg' => '#dcfce7', 'text' => '#15803d', 'border' => '#bbf7d0', 'label' => 'Selesai & Lulus Sidang'],
                        ];
                        $st = $statusColors[$internship->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569', 'border' => '#e2e8f0', 'label' => strtoupper($internship->status)];
                    @endphp
                    <span style="background: {{ $st['bg'] }}; color: {{ $st['text'] }}; border: 1px solid {{ $st['border'] }}; padding: 5px 14px; border-radius: 20px; font-size: 11.5px; font-weight: 600;">
                        {{ $st['label'] }}
                    </span>
                @else
                    <span style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; padding: 5px 14px; border-radius: 20px; font-size: 11.5px; font-weight: 600;">
                        Belum Ada Pengajuan
                    </span>
                @endif
            </div>

            @if ($internship)
                <!-- TAMPILAN JIKA MAHASISWA MEMILIKI PENGAJUAN / KP BERJALAN -->
                <div class="internship-status-card">
                    <div style="font-size: 18px; font-weight: 700; color: #1e3a8a; line-height: 1.45; margin-bottom: 10px;">
                        {{ $internship->title }}
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 22px;">
                        <div style="font-size: 13.5px; font-weight: 600; color: #334155; display: inline-flex; align-items: center; gap: 7px;">
                            <iconify-icon icon="lucide:building-2" width="18" height="18" style="color: #475569;"></iconify-icon>
                            <span>{{ $internship->company->name }}</span>
                        </div>
                        <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 20px; font-size: 11.5px; color: #475569; font-weight: 500;">
                            <iconify-icon icon="lucide:map-pin" width="13" height="13" style="color: #64748b;"></iconify-icon>
                            {{ $internship->company->city }}
                        </span>
                    </div>

                    <!-- 4 METADATA CARDS -->
                    <div class="dashboard-meta-grid">
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: grid; place-items: center; flex-shrink: 0;">
                                <iconify-icon icon="lucide:users" width="18" height="18"></iconify-icon>
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #64748b; margin-bottom: 4px;">
                                    Tipe Pengajuan
                                </div>
                                <div style="font-weight: 600; font-size: 13px; color: #0f172a; line-height: 1.4;">
                                    {{ $internship->type === 'group' ? 'Kelompok (' . ($internship->group?->name ?? 'Tim') . ')' : 'Individu' }}
                                </div>
                            </div>
                        </div>

                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #fef3c7; color: #d97706; display: grid; place-items: center; flex-shrink: 0;">
                                <iconify-icon icon="lucide:calendar" width="18" height="18"></iconify-icon>
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #64748b; margin-bottom: 4px;">
                                    Periode Pelaksanaan
                                </div>
                                <div style="font-weight: 600; font-size: 13px; color: #0f172a; line-height: 1.4;">
                                    {{ $internship->start_date ? $internship->start_date->format('d M Y') : '-' }} s/d {{ $internship->end_date ? $internship->end_date->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>

                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #f3e8ff; color: #7c3aed; display: grid; place-items: center; flex-shrink: 0;">
                                <iconify-icon icon="lucide:graduation-cap" width="18" height="18"></iconify-icon>
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #64748b; margin-bottom: 4px;">
                                    Dosen Pembimbing
                                </div>
                                <div style="font-weight: 600; font-size: 13px; color: #2563eb; line-height: 1.4;">
                                    {{ $internship->supervisor?->user?->name ?? 'Belum ditetapkan oleh Admin' }}
                                </div>
                            </div>
                        </div>

                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #ecfdf5; color: #059669; display: grid; place-items: center; flex-shrink: 0;">
                                <iconify-icon icon="lucide:phone-call" width="18" height="18"></iconify-icon>
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #64748b; margin-bottom: 4px;">
                                    Kontak Instansi
                                </div>
                                <div style="font-weight: 600; font-size: 13px; color: #0f172a; line-height: 1.4;">
                                    {{ $internship->company->contact_person ?? '-' }} <span style="font-weight: 400; color: #64748b;">({{ $internship->company->phone ?? '-' }})</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($internship->status === 'pending')
                        <!-- BANNER KONFIRMASI PENERIMAAN DARI INSTANSI -->
                        <div style="margin-top: 18px; padding: 18px 20px; background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 12px;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                                <div style="flex: 1; min-width: 240px;">
                                    <div style="font-weight: 700; font-size: 13.5px; color: #92400e; display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                                        <iconify-icon icon="lucide:bell-ring" width="16" height="16" style="color: #b45309;"></iconify-icon>
                                        <span>Konfirmasi Pengumuman dari Instansi</span>
                                    </div>
                                    <p style="font-size: 12.5px; color: #78350f; line-height: 1.5; margin: 0;">
                                        Apakah Anda sudah menerima pengumuman seleksi dari <strong>{{ $internship->company->name }}</strong>? Perbarui status kelulusan Anda untuk mengunci kuota tempat KP secara resmi.
                                    </p>
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <form action="{{ route('mahasiswa.applications.confirm-acceptance', $internship->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Konfirmasi bahwa Anda resmi DITERIMA di instansi {{ $internship->company->name }}? Kuota penerimaan akan dikunci.');">
                                        @csrf
                                        <button type="submit" class="btn-brand" style="background: #16a34a; border-color: #16a34a; padding: 8px 16px; font-size: 12px; border-radius: 20px; box-shadow: 0 2px 6px rgba(22, 163, 74, 0.3);">
                                            <iconify-icon icon="lucide:check-circle" width="14" height="14"></iconify-icon>
                                            <span>Saya Diterima di Instansi</span>
                                        </button>
                                    </form>

                                    <form action="{{ route('mahasiswa.applications.cancel', $internship->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Konfirmasi batalkan pengajuan atau tidak lolos? Anda dapat segera mendaftar ke instansi lain.');">
                                        @csrf
                                        <button type="submit" class="btn-outline-custom" style="padding: 8px 14px; font-size: 12px; border-radius: 20px; color: #b91c1c; border-color: #fecaca;">
                                            <iconify-icon icon="lucide:x-circle" width="14" height="14"></iconify-icon>
                                            <span>Tidak Lolos / Batal</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @elseif ($internship->status === 'rejected')
                        <!-- BANNER TEMPAT KP SUDAH DIISI / REJECTED -->
                        <div style="margin-top: 18px; padding: 18px 20px; background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 12px;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                                <div style="flex: 1; min-width: 240px;">
                                    <div style="font-weight: 700; font-size: 13.5px; color: #991b1b; display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                                        <iconify-icon icon="lucide:alert-circle" width="16" height="16" style="color: #ef4444;"></iconify-icon>
                                        <span>Tempat KP Sudah Diisi / Pengajuan Dialihkan</span>
                                    </div>
                                    <p style="font-size: 12.5px; color: #7f1d1d; line-height: 1.5; margin: 0;">
                                        {{ $internship->admin_note ?? 'Tempat KP di instansi ini sudah terisi penuh oleh mahasiswa yang lebih dulu diterima. Silakan ajukan ke instansi tujuan lain.' }}
                                    </p>
                                </div>
                                <div>
                                    <a href="{{ route('mahasiswa.applications.create') }}" class="btn-brand" style="padding: 8px 16px; font-size: 12px; border-radius: 20px;">
                                        <iconify-icon icon="lucide:send" width="14" height="14"></iconify-icon>
                                        <span>Daftar ke Instansi Lain</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($internship->admin_note && $internship->status !== 'rejected')
                        <div style="margin-top: 16px; padding: 14px 18px; background: #eff6ff; border: 1px solid #bfdbfe; border-left: 4px solid #2563eb; border-radius: 10px; font-size: 13px; line-height: 1.55;">
                            <strong style="color: #1d4ed8;">Catatan:</strong> {{ $internship->admin_note }}
                        </div>
                    @endif
                </div>

                <!-- QUICK ACTIONS -->
                <div class="dashboard-action-buttons">
                    @if ($internship->status === 'pending')
                        <a href="{{ route('mahasiswa.applications.create') }}" class="btn-outline-custom">
                            <iconify-icon icon="lucide:file-edit" width="16" height="16"></iconify-icon>
                            <span>Ubah Berkas Pengajuan</span>
                        </a>
                        <a href="{{ route('mahasiswa.companies.index') }}" class="btn-outline-custom">
                            <iconify-icon icon="lucide:search" width="16" height="16"></iconify-icon>
                            <span>Eksplorasi Perusahaan Lain</span>
                        </a>
                    @elseif (in_array($internship->status, ['in_progress', 'completed']))
                        <a href="{{ route('mahasiswa.logbook.index') }}" class="btn-brand">
                            <iconify-icon icon="lucide:file-edit" width="16" height="16"></iconify-icon>
                            <span>Isi Logbook Harian</span>
                        </a>
                        <a href="{{ route('mahasiswa.reports.index') }}" class="btn-outline-custom">
                            <iconify-icon icon="lucide:upload-cloud" width="16" height="16"></iconify-icon>
                            <span>Unggah Laporan Akhir</span>
                        </a>
                        <a href="{{ route('mahasiswa.sidang.index') }}" class="btn-outline-custom">
                            <iconify-icon icon="lucide:award" width="16" height="16"></iconify-icon>
                            <span>Status Sidang KP</span>
                        </a>
                    @elseif ($internship->status === 'completed')
                        <a href="{{ route('mahasiswa.experiences.create') }}" class="btn-brand" style="background: #15803d;">
                            <iconify-icon icon="lucide:star" width="16" height="16"></iconify-icon>
                            <span>Tulis Ulasan Pengalaman Alumni</span>
                        </a>
                    @endif
                </div>
            @else
                <!-- TAMPILAN USER BARU (BELUM PERNAH DAFTAR SAMA SEKALI) -->
                <div class="onboarding-box">
                    <div style="width: 58px; height: 58px; margin: 0 auto 16px; background: #eff6ff; border-radius: 50%; display: grid; place-items: center; border: 1px solid #bfdbfe;">
                        <iconify-icon icon="lucide:sparkles" width="28" height="28" style="color: var(--brand-primary);"></iconify-icon>
                    </div>

                    <h3 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">
                        Selamat Datang di SIMPUL, {{ $user->name }}!
                    </h3>
                    <p style="font-size: 13.5px; color: #64748b; max-width: 520px; margin: 0 auto 26px; line-height: 1.6;">
                        Kamu belum memiliki riwayat pendaftaran Kuliah Praktik. Mulai langkah akademik kamu dengan mencari instansi tujuan atau langsung mengisi formulir pengajuan kesiapan KP.
                    </p>

                    <!-- 3 PANDUAN LANGKAH AWAL MAHASISWA BARU -->
                    <div class="onboarding-steps-grid">
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 16px;">
                            <div style="width: 30px; height: 30px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: grid; place-items: center; font-weight: 700; font-size: 13px; margin-bottom: 12px;">
                                1
                            </div>
                            <div style="font-size: 13.5px; font-weight: 600; color: #0f172a; margin-bottom: 4px;">Pilih Instansi Mitra</div>
                            <div style="font-size: 12px; color: #64748b; line-height: 1.45;">Cek kuota yang tersedia (maks. 1 kelompok / 3 mahasiswa) dan ulasan tempat KP.</div>
                        </div>

                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 16px;">
                            <div style="width: 30px; height: 30px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: grid; place-items: center; font-weight: 700; font-size: 13px; margin-bottom: 12px;">
                                2
                            </div>
                            <div style="font-size: 13.5px; font-weight: 600; color: #0f172a; margin-bottom: 4px;">Isi Formulir Kesiapan</div>
                            <div style="font-size: 12px; color: #64748b; line-height: 1.45;">Tentukan tipe individu/kelompok, tanggal mulai &amp; selesai, serta usulan topik.</div>
                        </div>

                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 16px;">
                            <div style="width: 30px; height: 30px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: grid; place-items: center; font-weight: 700; font-size: 13px; margin-bottom: 12px;">
                                3
                            </div>
                            <div style="font-size: 13.5px; font-weight: 600; color: #0f172a; margin-bottom: 4px;">Verifikasi &amp; Pembimbing</div>
                            <div style="font-size: 12px; color: #64748b; line-height: 1.45;">Admin Jurusan memeriksa berkas dan menetapkan Dosen Pembimbing resmi.</div>
                        </div>
                    </div>

                    <!-- TOMBOL AKSI UTAMA PENDAFTARAN -->
                    <div class="dashboard-action-buttons" style="justify-content: center;">
                        <a href="{{ route('mahasiswa.applications.create') }}" class="btn-brand" style="padding: 12px 24px; font-size: 13.5px;">
                            <iconify-icon icon="lucide:file-plus-2" width="18" height="18"></iconify-icon>
                            <span>Mulai Isi Formulir Pengajuan Kesiapan KP</span>
                        </a>
                        <a href="{{ route('mahasiswa.companies.index') }}" class="btn-outline-custom" style="padding: 12px 22px; font-size: 13.5px;">
                            <iconify-icon icon="lucide:building-2" width="16" height="16"></iconify-icon>
                            <span>Eksplorasi Mitra &amp; Kuota</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- RECENT LOGS PREVIEW (HANYA MUNCUL JIKA ADA LOGS) -->
        @if ($internship && $internship->logs->isNotEmpty())
            <div class="panel" style="margin-top: 24px;">
                <div class="panel-title" style="display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <iconify-icon icon="lucide:book-open" width="20" height="20" style="color: var(--brand-primary);"></iconify-icon>
                        <span>Logbook Terbaru Kamu</span>
                    </div>
                    <a href="{{ route('mahasiswa.logbook.index') }}" style="font-size: 12px; color: #2563eb; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;">
                        <span>Lihat Semua</span>
                        <iconify-icon icon="lucide:chevron-right" width="14" height="14"></iconify-icon>
                    </a>
                </div>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach ($internship->logs as $log)
                        <div style="padding: 16px 20px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">
                            <div style="min-width: 0; flex: 1;">
                                <div style="font-size: 11.5px; color: #64748b; margin-bottom: 4px; font-weight: 500;">{{ $log->date->format('d M Y') }}</div>
                                <div style="font-weight: 600; font-size: 13.5px; color: #0f172a; line-height: 1.4; word-break: break-word;">{{ $log->activity }}</div>
                            </div>
                            <span class="badge-quota {{ $log->status === 'approved' ? 'success' : ($log->status === 'revision' ? 'danger' : 'warning') }}" style="flex-shrink: 0;">
                                {{ strtoupper($log->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- RIGHT COLUMN: INFO KUOTA INSTANSI -->
    <div>
        <!-- PREVIEW KUOTA INSTANSI -->
        <div class="panel">
            <div class="panel-title" style="margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <iconify-icon icon="lucide:building-2" width="18" height="18" style="color: var(--brand-primary); flex-shrink: 0;"></iconify-icon>
                    <span style="font-size: 14px; font-weight: 700; color: #0f172a;">Status Kuota Instansi</span>
                </div>
                <a href="{{ route('mahasiswa.companies.index') }}" style="font-size: 12px; color: #2563eb; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 3px; flex-shrink: 0;">
                    <span>Katalog Lengkap</span>
                    <iconify-icon icon="lucide:chevron-right" width="14" height="14"></iconify-icon>
                </a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach ($companies as $comp)
                    @php $q = $comp->quota_info; @endphp
                    <div class="company-quota-card">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 8px;">
                            <div style="min-width: 0;">
                                <h4 style="font-size: 13.5px; font-weight: 600; color: #0f172a; line-height: 1.4; margin: 0 0 3px 0;">
                                    <a href="{{ route('mahasiswa.companies.show', $comp->id) }}" style="color: inherit; text-decoration: none;">
                                        {{ $comp->name }}
                                    </a>
                                </h4>
                                <div style="font-size: 11.5px; color: #64748b; font-weight: 400; display: flex; align-items: center; gap: 4px;">
                                    <iconify-icon icon="lucide:map-pin" width="12" height="12"></iconify-icon>
                                    <span>{{ $comp->city }}</span>
                                </div>
                            </div>

                            @if ($q['is_full'])
                                <span class="badge-status danger" style="flex-shrink: 0;">
                                    <iconify-icon icon="lucide:x-circle" width="11" height="11"></iconify-icon>
                                    <span>Penuh</span>
                                </span>
                            @elseif ($q['individual_count'] > 0)
                                <span class="badge-status warning" style="flex-shrink: 0;">
                                    <iconify-icon icon="lucide:pie-chart" width="11" height="11"></iconify-icon>
                                    <span>Terisi {{ $q['individual_count'] }}/3</span>
                                </span>
                            @else
                                <span class="badge-status success" style="flex-shrink: 0;">
                                    <iconify-icon icon="lucide:check-circle" width="11" height="11"></iconify-icon>
                                    <span>Tersedia</span>
                                </span>
                            @endif
                        </div>

                        <!-- CAPACITY BAR -->
                        <div style="margin: 10px 0 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 11px; margin-bottom: 5px;">
                                <span style="color: #64748b; font-weight: 400;">Kapasitas Periode Berjalan</span>
                                <span style="font-weight: 500; color: {{ $q['is_full'] ? '#b91c1c' : ($q['individual_count'] > 0 ? '#b45309' : '#059669') }};">
                                    {{ $q['has_group'] ? '1 Kelompok' : ($q['individual_count'] . '/3 Individu') }}
                                </span>
                            </div>
                            <div style="height: 4px; background: #f1f5f9; border-radius: 4px; overflow: hidden;">
                                <div style="height: 100%; width: {{ $q['capacity_percent'] }}%; background: {{ $q['is_full'] ? '#ef4444' : ($q['individual_count'] > 0 ? '#f59e0b' : '#10b981') }}; border-radius: 4px; transition: width .3s;"></div>
                            </div>
                        </div>

                        <!-- FOOTER ACTION -->
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px; border-top: 1px solid #f8fafc;">
                            <span style="font-size: 11px; color: #94a3b8; font-weight: 400;">
                                {{ $comp->validatedExperiences->count() }} ulasan alumni
                            </span>
                            <a href="{{ route('mahasiswa.companies.show', $comp->id) }}" style="font-size: 11.5px; color: #2563eb; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;">
                                <span>Lihat Detail</span>
                                <iconify-icon icon="lucide:chevron-right" width="13" height="13"></iconify-icon>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
