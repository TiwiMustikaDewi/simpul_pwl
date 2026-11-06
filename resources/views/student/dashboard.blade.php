@extends('layouts.student')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="font-size: 22px; font-weight: 700; color: var(--text);">Selamat Datang, {{ $user->name }}! 👋</h2>
    <p style="font-size: 13px; color: var(--muted); margin-top: 4px;">
        Pantau alur Kuliah Praktik kamu secara terstruktur mulai dari pencarian instansi, bimbingan logbook, hingga pendaftaran sidang.
    </p>
</div>

<!-- TAHAPAN ALUR KP (STEP PROGRESS TRACKER) -->
@php
    $currentStep = 1;
    if ($internship) {
        if ($internship->status === 'pending') {
            $currentStep = 1; // Menunggu verifikasi berkas
        } elseif ($internship->status === 'approved' || $internship->status === 'in_progress') {
            if ($internship->sidang && in_array($internship->sidang->status, ['submitted', 'scheduled', 'completed'])) {
                $currentStep = 4; // Sidang
            } elseif ($internship->reports()->where('status', 'approved')->exists()) {
                $currentStep = 4; // Laporan disetujui, siap sidang
            } else {
                $currentStep = ($internship->logs()->count() > 0) ? 3 : 2; // Pelaksanaan logbook
            }
        } elseif ($internship->status === 'completed') {
            $currentStep = 5; // Selesai
        }
    }
@endphp

<div class="panel" style="margin-bottom: 24px;">
    <div style="font-weight: 600; font-size: 14px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
        <span>Tahapan Pelaksanaan KP Kamu</span>
        <span style="font-size: 12px; color: var(--brand-primary);">Langkah {{ $currentStep }} dari 5</span>
    </div>

    <div class="step-progress-bar">
        <div class="step-item {{ $currentStep > 1 ? 'done' : ($currentStep == 1 ? 'active' : '') }}">
            <div style="font-weight: 700;">1. Pengajuan</div>
            <div style="font-size: 10px; color: var(--muted);">Pilih Instansi & Berkas</div>
        </div>
        <div class="step-item {{ $currentStep > 2 ? 'done' : ($currentStep == 2 ? 'active' : '') }}">
            <div style="font-weight: 700;">2. Penetapan</div>
            <div style="font-size: 10px; color: var(--muted);">Verifikasi & Pembimbing</div>
        </div>
        <div class="step-item {{ $currentStep > 3 ? 'done' : ($currentStep == 3 ? 'active' : '') }}">
            <div style="font-weight: 700;">3. Pelaksanaan</div>
            <div style="font-size: 10px; color: var(--muted);">Logbook & Bimbingan</div>
        </div>
        <div class="step-item {{ $currentStep > 4 ? 'done' : ($currentStep == 4 ? 'active' : '') }}">
            <div style="font-weight: 700;">4. Evaluasi</div>
            <div style="font-size: 10px; color: var(--muted);">Laporan & Sidang KP</div>
        </div>
        <div class="step-item {{ $currentStep == 5 ? 'done' : '' }}">
            <div style="font-weight: 700;">5. Selesai</div>
            <div style="font-size: 10px; color: var(--muted);">Kelulusan & Review Alumni</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 24px;">

    <!-- LEFT COLUMN: STATUS KP AKTIF -->
    <div>
        <div class="panel" style="margin-bottom: 24px;">
            <div class="panel-title" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <span style="font-weight: 700; font-size: 15px;">Status Kuliah Praktik Berjalan</span>
                @if ($internship)
                    @php
                        $statusColors = [
                            'pending' => ['bg' => '#fef3c7', 'text' => '#b45309', 'label' => 'Menunggu Verifikasi Admin'],
                            'approved' => ['bg' => '#e0e7ff', 'text' => '#3730a3', 'label' => 'Disetujui Admin'],
                            'rejected' => ['bg' => '#fee2e2', 'text' => '#b91c1c', 'label' => 'Pengajuan Ditolak'],
                            'in_progress' => ['bg' => '#dbeafe', 'text' => '#1e40af', 'label' => 'Sedang Dilaksanakan'],
                            'completed' => ['bg' => '#dcfce7', 'text' => '#15803d', 'label' => 'Selesai & Lulus Sidang'],
                        ];
                        $st = $statusColors[$internship->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569', 'label' => strtoupper($internship->status)];
                    @endphp
                    <span style="background: {{ $st['bg'] }}; color: {{ $st['text'] }}; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                        {{ $st['label'] }}
                    </span>
                @endif
            </div>

            @if ($internship)
                <div style="background: #f8fbff; border: 1px solid var(--border); border-radius: 12px; padding: 18px; margin-bottom: 16px;">
                    <div style="font-size: 16px; font-weight: 700; color: var(--brand-dark); margin-bottom: 6px;">
                        {{ $internship->title }}
                    </div>
                    <div style="font-size: 13px; color: var(--text); display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                        <span>🏢</span>
                        <strong>{{ $internship->company->name }}</strong>
                        <span style="color: var(--muted);">({{ $internship->company->city }})</span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; font-size: 12px; padding-top: 12px; border-top: 1px dashed var(--border);">
                        <div>
                            <span style="color: var(--muted);">Tipe Pengajuan:</span>
                            <div style="font-weight: 600;">
                                {{ $internship->type === 'group' ? 'Kelompok (' . ($internship->group?->name ?? 'Tim') . ')' : 'Individu' }}
                            </div>
                        </div>
                        <div>
                            <span style="color: var(--muted);">Periode KP:</span>
                            <div style="font-weight: 600;">
                                {{ $internship->start_date->format('d M Y') }} s/d {{ $internship->end_date->format('d M Y') }}
                            </div>
                        </div>
                        <div>
                            <span style="color: var(--muted);">Dosen Pembimbing:</span>
                            <div style="font-weight: 600; color: var(--brand-primary);">
                                {{ $internship->supervisor?->user?->name ?? 'Belum ditetapkan oleh Admin' }}
                            </div>
                        </div>
                        <div>
                            <span style="color: var(--muted);">Kontak Instansi:</span>
                            <div style="font-weight: 600;">
                                {{ $internship->company->contact_person ?? '-' }} ({{ $internship->company->phone ?? '-' }})
                            </div>
                        </div>
                    </div>

                    @if ($internship->admin_note)
                        <div style="margin-top: 14px; padding: 10px 14px; background: #ffffff; border-left: 3px solid var(--brand-primary); border-radius: 6px; font-size: 12px;">
                            <strong>Catatan Admin Jurusan:</strong> {{ $internship->admin_note }}
                        </div>
                    @endif
                </div>

                <!-- QUICK ACTIONS -->
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    @if (in_array($internship->status, ['in_progress', 'completed']))
                        <a href="{{ route('mahasiswa.logbook.index') }}" class="btn-brand">
                            <span>📝</span> Isi Logbook Harian
                        </a>
                        <a href="{{ route('mahasiswa.reports.index') }}" class="btn btn-outline" style="border-radius: 30px; font-size: 13px;">
                            <span>📁</span> Unggah Laporan Akhir
                        </a>
                        <a href="{{ route('mahasiswa.sidang.index') }}" class="btn btn-outline" style="border-radius: 30px; font-size: 13px;">
                            <span>🎓</span> Status Sidang KP
                        </a>
                    @elseif ($internship->status === 'completed')
                        <a href="{{ route('mahasiswa.experiences.create') }}" class="btn-brand" style="background: #15803d;">
                            <span>⭐</span> Tulis Ulasan Pengalaman Alumni
                        </a>
                    @endif
                </div>
            @else
                <div style="text-align: center; padding: 36px 20px; background: #f8fbff; border: 1px dashed var(--border); border-radius: 12px;">
                    <div style="font-size: 32px; margin-bottom: 8px;">🚀</div>
                    <div style="font-weight: 700; font-size: 15px; margin-bottom: 6px;">Kamu Belum Mengajukan Kuliah Praktik</div>
                    <p style="font-size: 12.5px; color: var(--muted); max-width: 440px; margin: 0 auto 18px;">
                        Cari instansi yang sesuai dengan minatmu di katalog perusahaan atau langsung ajukan kesiapan KP bersama kelompokmu.
                    </p>
                    <div style="display: flex; justify-content: center; gap: 12px;">
                        <a href="{{ route('mahasiswa.companies.index') }}" class="btn btn-outline" style="border-radius: 30px; font-size: 13px;">
                            🔍 Eksplorasi Perusahaan
                        </a>
                        <a href="{{ route('mahasiswa.applications.create') }}" class="btn-brand">
                            ✍ Ajukan Kesiapan KP
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- RECENT LOGS PREVIEW -->
        @if ($internship && $internship->logs->isNotEmpty())
            <div class="panel">
                <div class="panel-title" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                    <span style="font-weight: 700; font-size: 15px;">Logbook Terbaru Kamu</span>
                    <a href="{{ route('mahasiswa.logbook.index') }}" style="font-size: 12px; color: var(--brand-primary); font-weight: 600;">Lihat Semua →</a>
                </div>

                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach ($internship->logs as $log)
                        <div style="padding: 12px 14px; background: #ffffff; border: 1px solid var(--border); border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-size: 11px; color: var(--muted);">{{ $log->date->format('d M Y') }}</div>
                                <div style="font-weight: 600; font-size: 13px; color: var(--text);">{{ $log->activity }}</div>
                            </div>
                            <span class="badge-quota {{ $log->status === 'approved' ? 'success' : ($log->status === 'revision' ? 'danger' : 'warning') }}">
                                {{ strtoupper($log->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- RIGHT COLUMN: NOTIFIKASI & INFO KUOTA INSTANSI -->
    <div>
        <!-- NOTIFIKASI SISTEM -->
        <div class="panel" style="margin-bottom: 24px;">
            <div class="panel-title" style="font-weight: 700; font-size: 15px; margin-bottom: 14px;">
                🔔 Notifikasi Perkembangan
            </div>

            @if ($notifications->isNotEmpty())
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach ($notifications as $notif)
                        <div style="padding: 10px 12px; background: #f8fbff; border-radius: 8px; font-size: 12px; border-left: 3px solid var(--brand-primary);">
                            <div style="font-weight: 600; color: var(--text);">{{ $notif->title }}</div>
                            <div style="color: var(--muted); margin-top: 2px;">{{ $notif->message }}</div>
                            <div style="font-size: 10px; color: #94a3b8; margin-top: 4px;">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; color: var(--muted); font-size: 12.5px; padding: 20px 0;">
                    Belum ada notifikasi baru.
                </div>
            @endif
        </div>

        <!-- PREVIEW KUOTA INSTANSI -->
        <div class="panel">
            <div class="panel-title" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <span style="font-weight: 700; font-size: 15px;">Status Kuota Instansi</span>
                <a href="{{ route('mahasiswa.companies.index') }}" style="font-size: 12px; color: var(--brand-primary); font-weight: 600;">Katalog Lengkap →</a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach ($companies as $comp)
                    @php $q = $comp->quota_info; @endphp
                    <div style="padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: #ffffff;">
                        <div style="font-weight: 600; font-size: 13px; color: var(--text); margin-bottom: 3px;">
                            {{ $comp->name }}
                        </div>
                        <div style="font-size: 11px; color: var(--muted); margin-bottom: 8px;">
                            📍 {{ $comp->city }}
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="badge-quota {{ $q['badge_variant'] }}">
                                {{ $q['status_label'] }}
                            </span>
                            <a href="{{ route('mahasiswa.companies.show', $comp->id) }}" style="font-size: 11.5px; color: var(--brand-primary); font-weight: 600;">
                                Detail & Review →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
