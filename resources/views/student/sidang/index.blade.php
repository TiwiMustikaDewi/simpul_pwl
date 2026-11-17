@extends('layouts.student')

@section('title', 'Pendaftaran & Jadwal Sidang KP')

@push('styles')
<style>
    .sidang-main-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(320px, 1fr);
        gap: 28px;
        align-items: start;
    }

    .sidang-steps-3col {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 22px;
    }

    .sidang-grid-2col {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    @media (max-width: 1024px) {
        .sidang-main-layout {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .sidang-steps-3col {
            grid-template-columns: 1fr;
            gap: 10px;
        }
    }

    @media (max-width: 640px) {
        .sidang-grid-2col {
            grid-template-columns: 1fr;
            gap: 12px;
        }
    }
</style>
@endpush

@section('content')
<div style="margin-bottom: 28px;">
    <h1 style="font-size: clamp(20px, 4.5vw, 24px); font-weight: 800; color: #0f172a; letter-spacing: -0.5px; line-height: 1.3; margin: 0 0 6px 0;">
        Pendaftaran &amp; Status Sidang Kuliah Praktik
    </h1>
    <p style="font-size: 13.5px; color: #64748b; margin: 0; line-height: 1.6;">
        Ajukan permohonan pelaksanaan sidang kelulusan KP dan pantau penetapan jadwal, ruangan, serta perolehan nilai akhir.
    </p>
</div>

@if (! $internship)
    <div class="panel" style="text-align: center; padding: 48px 24px;">
        <div style="width: 48px; height: 48px; margin: 0 auto 14px; background: #f1f5f9; border-radius: 50%; display: grid; place-items: center;">
            <iconify-icon icon="lucide:graduation-cap" width="26" height="26" style="color: #94a3b8;"></iconify-icon>
        </div>
        <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">Belum Ada Pelaksanaan KP Aktif</h3>
        <p style="font-size: 13.5px; color: #64748b; max-width: 460px; margin: 0 auto 20px; line-height: 1.6;">
            Pendaftaran sidang dibuka setelah pengajuan kesiapan KP kamu disetujui oleh Admin Jurusan dan Dosen Pembimbing telah ditetapkan.
        </p>
        <a href="{{ route('mahasiswa.applications.create') }}" class="btn-brand">
            <iconify-icon icon="lucide:file-plus" width="16" height="16"></iconify-icon>
            <span>Ajukan Kesiapan KP Sekarang</span>
        </a>
    </div>
@else
    <!-- LAYOUT DUA KOLOM SEIMBANG (RESPONSIF MOBILE) -->
    <div class="sidang-main-layout">

        <!-- KOLOM KIRI (KOLOM UTAMA) -->
        <div>
            @if (! $sidang)
                <!-- TAHAP 1: BELUM MENDAFTAR (LANGKAH-LANGKAH PENDAFTARAN SIDANG) -->
                <div class="panel">
                    <div class="panel-title">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <iconify-icon icon="lucide:clipboard-check" width="18" height="18" style="color: var(--brand-primary);"></iconify-icon>
                            <span>Formulir Pengajuan Sidang KP</span>
                        </div>
                        <span class="badge-status warning">
                            <iconify-icon icon="lucide:clock" width="12" height="12"></iconify-icon>
                            <span>Siap Diajukan</span>
                        </span>
                    </div>

                    <!-- RINGKASAN KP YANG AKAN DIUJIKAN -->
                    <div style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%); border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px 22px; margin-bottom: 22px;">
                        <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #64748b; margin-bottom: 6px;">
                            Judul Kuliah Praktik Yang Diujikan
                        </div>
                        <div style="font-size: 16px; font-weight: 600; color: #1e3a8a; line-height: 1.45; margin-bottom: 12px;">
                            {{ $internship->title }}
                        </div>

                        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap; font-size: 12.5px; color: #475569;">
                            <div style="display: inline-flex; align-items: center; gap: 5px;">
                                <iconify-icon icon="lucide:building-2" width="15" height="15" style="color: #64748b;"></iconify-icon>
                                <span>{{ $internship->company->name }}</span>
                            </div>
                            <span style="color: #cbd5e1;">•</span>
                            <div style="display: inline-flex; align-items: center; gap: 5px;">
                                <iconify-icon icon="lucide:graduation-cap" width="15" height="15" style="color: #64748b;"></iconify-icon>
                                <span>Pembimbing: {{ $internship->supervisor?->user?->name ?? 'Belum ditentukan' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- CHECKLIST KELENGKAPAN SYARAT AKADEMIK -->
                    <div style="margin-bottom: 24px;">
                        <h4 style="font-size: 13.5px; font-weight: 600; color: #0f172a; margin: 0 0 12px 0;">
                            Pemeriksaan Kelayakan Berkas Sidang:
                        </h4>

                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <!-- ITEM 1: LOGBOOK -->
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <iconify-icon icon="lucide:check-circle" width="18" height="18" style="color: #16a34a;"></iconify-icon>
                                    <div>
                                        <div style="font-size: 13px; font-weight: 600; color: #166534;">Logbook Aktivitas Kerja Harian</div>
                                        <div style="font-size: 11.5px; color: #15803d; font-weight: 400;">Tercatat {{ $internship->logs->count() }} kegiatan di sistem SIMPUL</div>
                                    </div>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #15803d; background: #dcfce7; padding: 2px 8px; border-radius: 6px;">
                                    Memenuhi Syarat
                                </span>
                            </div>

                            <!-- ITEM 2: LAPORAN AKHIR -->
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <iconify-icon icon="lucide:check-circle" width="18" height="18" style="color: #16a34a;"></iconify-icon>
                                    <div>
                                        <div style="font-size: 13px; font-weight: 600; color: #166534;">Naskah Laporan Akhir KP</div>
                                        <div style="font-size: 11.5px; color: #15803d; font-weight: 400;">Berkas telah diunggah dan siap diverifikasi penguji</div>
                                    </div>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #15803d; background: #dcfce7; padding: 2px 8px; border-radius: 6px;">
                                    Tersedia
                                </span>
                            </div>

                            <!-- ITEM 3: PERSETUJUAN PEMBIMBING -->
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <iconify-icon icon="lucide:check-circle" width="18" height="18" style="color: #16a34a;"></iconify-icon>
                                    <div>
                                        <div style="font-size: 13px; font-weight: 600; color: #166534;">Validasi Pembimbing Jurusan</div>
                                        <div style="font-size: 11.5px; color: #15803d; font-weight: 400;">Mendapat rekomendasi maju sidang dari dosen pembimbing</div>
                                    </div>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #15803d; background: #dcfce7; padding: 2px 8px; border-radius: 6px;">
                                    Tervalidasi
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- FORM PENDAFTARAN & USULAN JADWAL -->
                    <form action="{{ route('mahasiswa.sidang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- USULAN TANGGAL & WAKTU PELAKSANAAN -->
                        <div style="margin-bottom: 20px;">
                            <label for="proposed_date" style="display: block; margin-bottom: 6px;">
                                <div style="font-size: 13px; font-weight: 600; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                                    <iconify-icon icon="lucide:calendar" width="15" height="15" style="color: var(--brand-primary);"></iconify-icon>
                                    <span>Usulan Rencana Tanggal &amp; Waktu Sidang <span style="color: #ef4444; font-weight: 700;">*</span></span>
                                </div>
                                <div style="font-size: 11.5px; color: #64748b; font-weight: 400; margin-top: 3px; line-height: 1.4;">
                                    Rekomendasi bersama Dosen Pembimbing sebelum diajukan ke sistem
                                </div>
                            </label>
                            <input
                                type="datetime-local"
                                name="proposed_date"
                                id="proposed_date"
                                value="{{ old('proposed_date') }}"
                                required
                                style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px; background: #ffffff; color: #0f172a;"
                            >
                            @error('proposed_date')
                                <div style="font-size: 11.5px; color: #ef4444; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                            <div style="font-size: 11px; color: #64748b; margin-top: 5px; line-height: 1.4;">
                                Jadwal resmi dan alokasi ruangan akan diverifikasi serta ditetapkan/disesuaikan oleh Admin Jurusan.
                            </div>
                        </div>

                        <!-- UNGGAH SLIDE PRESENTASI -->
                        <div style="margin-bottom: 20px;">
                            <label for="presentation_file" style="display: block; margin-bottom: 6px;">
                                <div style="font-size: 13px; font-weight: 600; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                                    <iconify-icon icon="lucide:presentation" width="15" height="15" style="color: var(--brand-primary);"></iconify-icon>
                                    <span>Unggah Draf Slide Presentasi Sidang</span>
                                    <span style="font-size: 11px; color: #94a3b8; font-weight: 400;">(Opsional)</span>
                                </div>
                                <div style="font-size: 11.5px; color: #64748b; font-weight: 400; margin-top: 3px; line-height: 1.4;">
                                    Format berkas: PDF, PPT, atau PPTX (maksimal 20MB)
                                </div>
                            </label>
                            <input
                                type="file"
                                name="presentation_file"
                                id="presentation_file"
                                accept=".pdf,.ppt,.pptx,.zip"
                                style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 12.5px; background: #f8fafc;"
                            >
                            <div style="font-size: 11px; color: #64748b; margin-top: 5px; line-height: 1.4;">
                                Berkas materi presentasi untuk dipelajari oleh Dewan Penguji sebelum pelaksanaan sidang.
                            </div>
                        </div>

                        <!-- CATATAN / KETERANGAN TAMBAHAN -->
                        <div style="margin-bottom: 20px;">
                            <label for="student_notes" style="display: block; margin-bottom: 6px;">
                                <div style="font-size: 13px; font-weight: 600; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                                    <iconify-icon icon="lucide:message-square" width="15" height="15" style="color: var(--brand-primary);"></iconify-icon>
                                    <span>Catatan Tambahan untuk Admin Jurusan</span>
                                    <span style="font-size: 11px; color: #94a3b8; font-weight: 400;">(Opsional)</span>
                                </div>
                                <div style="font-size: 11.5px; color: #64748b; font-weight: 400; margin-top: 3px; line-height: 1.4;">
                                    Sampaikan preferensi teknis sidang atau konfirmasi ketersediaan pembimbing
                                </div>
                            </label>
                            <textarea
                                name="student_notes"
                                id="student_notes"
                                rows="3"
                                placeholder="Contoh: Sudah konfirmasi kesiapan dosen pembimbing; siap sidang offline di kampus atau hybrid..."
                                style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px; line-height: 1.5; resize: vertical;"
                            >{{ old('student_notes') }}</textarea>
                        </div>

                        <!-- PERNYATAAN INTEGRITAS -->
                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 14px 16px; margin-bottom: 22px;">
                            <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-size: 12.5px; color: #1e40af; line-height: 1.5;">
                                <input type="checkbox" required style="margin-top: 3px; accent-color: var(--brand-primary);">
                                <span>
                                    Saya menyatakan bahwa seluruh kegiatan logbook dan naskah laporan akhir yang diajukan sudah lengkap serta siap diuji dalam Sidang Kuliah Praktik. <span style="color: #ef4444; font-weight: 700;">*</span>
                                </span>
                            </label>
                        </div>

                        <div style="display: flex; justify-content: flex-end;">
                            <button type="submit" class="btn-brand" style="padding: 12px 28px; font-size: 13.5px;">
                                <iconify-icon icon="lucide:send" width="16" height="16"></iconify-icon>
                                <span>Ajukan Pendaftaran Sidang Sekarang</span>
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <!-- TAHAP 2: SUDAH MENDAFTAR (STATUS PENJADWALAN & EVALUASI SIDANG) -->
                @php
                    $statusMap = [
                        'submitted' => [
                            'bg' => '#fef3c7',
                            'text' => '#b45309',
                            'border' => '#fde68a',
                            'icon' => 'lucide:clock',
                            'label' => 'Menunggu Penjadwalan Admin',
                            'step' => 1
                        ],
                        'scheduled' => [
                            'bg' => '#eff6ff',
                            'text' => '#1d4ed8',
                            'border' => '#bfdbfe',
                            'icon' => 'lucide:calendar-check',
                            'label' => 'Jadwal Telah Ditetapkan',
                            'step' => 2
                        ],
                        'completed' => [
                            'bg' => '#dcfce7',
                            'text' => '#15803d',
                            'border' => '#bbf7d0',
                            'icon' => 'lucide:award',
                            'label' => 'Sidang Telah Selesai (Lulus)',
                            'step' => 3
                        ],
                        'rejected' => [
                            'bg' => '#fee2e2',
                            'text' => '#b91c1c',
                            'border' => '#fecaca',
                            'icon' => 'lucide:alert-triangle',
                            'label' => 'Pengajuan Sidang Ditolak',
                            'step' => 1
                        ],
                    ];
                    $st = $statusMap[$sidang->status] ?? [
                        'bg' => '#f1f5f9',
                        'text' => '#475569',
                        'border' => '#e2e8f0',
                        'icon' => 'lucide:info',
                        'label' => strtoupper($sidang->status),
                        'step' => 1
                    ];
                @endphp

                <div class="panel">
                    <div class="panel-title">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <iconify-icon icon="lucide:graduation-cap" width="18" height="18" style="color: var(--brand-primary);"></iconify-icon>
                            <span>Status Pendaftaran Sidang KP</span>
                        </div>
                        <span style="background: {{ $st['bg'] }}; color: {{ $st['text'] }}; border: 1px solid {{ $st['border'] }}; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 500; display: inline-flex; align-items: center; gap: 5px;">
                            <iconify-icon icon="{{ $st['icon'] }}" width="13" height="13"></iconify-icon>
                            <span>{{ $st['label'] }}</span>
                        </span>
                    </div>

                    <!-- STEPPER KEMAJUAN SIDANG -->
                    <div class="sidang-steps-3col">
                        <!-- STEP 1 -->
                        <div style="padding: 12px 14px; border-radius: 10px; border: 1px solid {{ $st['step'] >= 1 ? '#86efac' : '#e2e8f0' }}; background: {{ $st['step'] >= 1 ? '#f0fdf4' : '#ffffff' }};">
                            <div style="font-size: 10.5px; font-weight: 600; text-transform: uppercase; color: {{ $st['step'] >= 1 ? '#15803d' : '#94a3b8' }}; margin-bottom: 2px;">
                                Langkah 1
                            </div>
                            <div style="font-size: 12.5px; font-weight: 600; color: {{ $st['step'] >= 1 ? '#166534' : '#475569' }};">
                                Pengajuan Terkirim
                            </div>
                        </div>

                        <!-- STEP 2 -->
                        <div style="padding: 12px 14px; border-radius: 10px; border: 1px solid {{ $st['step'] >= 2 ? '#86efac' : ($st['step'] == 1 ? '#bfdbfe' : '#e2e8f0') }}; background: {{ $st['step'] >= 2 ? '#f0fdf4' : ($st['step'] == 1 ? '#eff6ff' : '#ffffff') }};">
                            <div style="font-size: 10.5px; font-weight: 600; text-transform: uppercase; color: {{ $st['step'] >= 2 ? '#15803d' : ($st['step'] == 1 ? '#2563eb' : '#94a3b8') }}; margin-bottom: 2px;">
                                Langkah 2
                            </div>
                            <div style="font-size: 12.5px; font-weight: 600; color: {{ $st['step'] >= 2 ? '#166534' : ($st['step'] == 1 ? '#1e40af' : '#475569') }};">
                                Penetapan Jadwal
                            </div>
                        </div>

                        <!-- STEP 3 -->
                        <div style="padding: 12px 14px; border-radius: 10px; border: 1px solid {{ $st['step'] >= 3 ? '#86efac' : '#e2e8f0' }}; background: {{ $st['step'] >= 3 ? '#f0fdf4' : '#ffffff' }};">
                            <div style="font-size: 10.5px; font-weight: 600; text-transform: uppercase; color: {{ $st['step'] >= 3 ? '#15803d' : '#94a3b8' }}; margin-bottom: 2px;">
                                Langkah 3
                            </div>
                            <div style="font-size: 12.5px; font-weight: 600; color: {{ $st['step'] >= 3 ? '#166534' : '#475569' }};">
                                Pelaksanaan &amp; Nilai
                            </div>
                        </div>
                    </div>

                    <!-- RINCIAN JUDUL & MITRA -->
                    <div style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%); border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px 22px; margin-bottom: 20px;">
                        <div style="font-size: 16px; font-weight: 600; color: #1e3a8a; line-height: 1.45; margin-bottom: 8px;">
                            {{ $internship->title }}
                        </div>
                        <div style="font-size: 12.5px; color: #475569; display: flex; align-items: center; gap: 6px;">
                            <iconify-icon icon="lucide:building-2" width="14" height="14" style="color: #64748b;"></iconify-icon>
                            <span>{{ $internship->company->name }} ({{ $internship->company->city }})</span>
                        </div>
                    </div>

                    <!-- 4 METADATA CARDS (SEPERTI DASHBOARD) -->
                    <div class="sidang-grid-2col">
                        <!-- JADWAL -->
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #fef3c7; color: #d97706; display: grid; place-items: center; flex-shrink: 0;">
                                <iconify-icon icon="lucide:calendar" width="18" height="18"></iconify-icon>
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 3px;">
                                    Waktu &amp; Tanggal Sidang
                                </div>
                                <div style="font-weight: 600; font-size: 13px; color: #0f172a; line-height: 1.4;">
                                    @if ($sidang->sidang_date)
                                        {{ $sidang->sidang_date->format('d M Y, H:i') }} WIB
                                    @else
                                        <span>Menunggu Penetapan Admin</span>
                                        @if ($sidang->proposed_date)
                                            <div style="font-size: 11px; font-weight: 500; color: #b45309; margin-top: 3px;">
                                                Usulan: {{ $sidang->proposed_date->format('d M Y, H:i') }} WIB
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- RUANGAN -->
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: grid; place-items: center; flex-shrink: 0;">
                                <iconify-icon icon="lucide:map-pin" width="18" height="18"></iconify-icon>
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 3px;">
                                    Ruang / Lokasi Sidang
                                </div>
                                <div style="font-weight: 600; font-size: 13px; color: #0f172a; line-height: 1.4;">
                                    {{ $sidang->room ?? 'Menunggu penetapan ruangan' }}
                                </div>
                            </div>
                        </div>

                        <!-- PEMBIMBING -->
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #f3e8ff; color: #7c3aed; display: grid; place-items: center; flex-shrink: 0;">
                                <iconify-icon icon="lucide:graduation-cap" width="18" height="18"></iconify-icon>
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 3px;">
                                    Dosen Pembimbing
                                </div>
                                <div style="font-weight: 600; font-size: 13px; color: #2563eb; line-height: 1.4;">
                                    {{ $internship->supervisor?->user?->name ?? 'Belum ditetapkan' }}
                                </div>
                            </div>
                        </div>

                        <!-- NILAI -->
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #ecfdf5; color: #059669; display: grid; place-items: center; flex-shrink: 0;">
                                <iconify-icon icon="lucide:award" width="18" height="18"></iconify-icon>
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 3px;">
                                    Nilai Akhir Kelulusan
                                </div>
                                <div style="font-weight: 600; font-size: 13px; color: {{ $sidang->grade ? '#15803d' : '#64748b' }}; line-height: 1.4;">
                                    {{ $sidang->grade ?? 'Belum terbit' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BERKAS & CATATAN PENGAJUAN MAHASISWA -->
                    @if ($sidang->presentation_file || $sidang->student_notes)
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; margin-bottom: 18px;">
                            <div style="font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                                <iconify-icon icon="lucide:file-text" width="14" height="14" style="color: var(--brand-primary);"></iconify-icon>
                                <span>Rincian Pengajuan Anda:</span>
                            </div>
                            @if ($sidang->presentation_file)
                                <div style="font-size: 12px; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                                    <span style="color: #64748b;">Slide Materi Presentasi:</span>
                                    <a href="{{ asset('storage/' . $sidang->presentation_file) }}" target="_blank" style="color: #2563eb; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;">
                                        <iconify-icon icon="lucide:download" width="12" height="12"></iconify-icon>
                                        <span>Unduh Slide</span>
                                    </a>
                                </div>
                            @endif
                            @if ($sidang->student_notes)
                                <div style="font-size: 12px; color: #475569; line-height: 1.5;">
                                    <span style="color: #64748b;">Catatan Mahasiswa:</span> &ldquo;{{ $sidang->student_notes }}&rdquo;
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- CATATAN PENGUJI / ADMIN -->
                    @if ($sidang->notes)
                        <div style="padding: 14px 18px; background: #eff6ff; border: 1px solid #bfdbfe; border-left: 4px solid var(--brand-primary); border-radius: 10px; font-size: 13px; line-height: 1.55;">
                            <div style="font-weight: 600; color: #1d4ed8; margin-bottom: 3px;">Catatan Dewan Penguji &amp; Admin:</div>
                            <div style="color: #334155;">{{ $sidang->notes }}</div>
                        </div>
                    @endif

                    <!-- TOMBOL ULASAN JIKA SUDAH SELESAI -->
                    @if ($sidang->status === 'completed')
                        <div style="margin-top: 20px; text-align: center; padding-top: 18px; border-top: 1px solid #f1f5f9;">
                            <a href="{{ route('mahasiswa.experiences.create') }}" class="btn-brand" style="background: #15803d;">
                                <iconify-icon icon="lucide:star" width="16" height="16"></iconify-icon>
                                <span>Bagikan Ulasan Pengalaman Alumni</span>
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- KOLOM KANAN (SIDEBAR PANDUAN & ALUR KELULUSAN) -->
        <div>
            <!-- PANEL ALUR SIDANG KP -->
            <div class="panel">
                <div class="panel-title">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <iconify-icon icon="lucide:route" width="18" height="18" style="color: var(--brand-primary);"></iconify-icon>
                        <span>Alur Pelaksanaan Sidang</span>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <div style="display: flex; gap: 12px;">
                        <div style="width: 26px; height: 26px; border-radius: 50%; background: #eff6ff; color: #2563eb; font-size: 12px; font-weight: 600; display: grid; place-items: center; flex-shrink: 0;">
                            1
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 13px; color: #0f172a; margin-bottom: 2px;">Pengajuan Pendaftaran</div>
                            <div style="font-size: 12px; color: #64748b; line-height: 1.5;">
                                Mahasiswa mengajukan permohonan sidang setelah logbook dan draf laporan disetujui.
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <div style="width: 26px; height: 26px; border-radius: 50%; background: #fef3c7; color: #d97706; font-size: 12px; font-weight: 600; display: grid; place-items: center; flex-shrink: 0;">
                            2
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 13px; color: #0f172a; margin-bottom: 2px;">Verifikasi &amp; Penjadwalan</div>
                            <div style="font-size: 12px; color: #64748b; line-height: 1.5;">
                                Admin Jurusan menetapkan tanggal, jam, ruangan, serta dosen penguji sidang.
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <div style="width: 26px; height: 26px; border-radius: 50%; background: #f1f5f9; color: #475569; font-size: 12px; font-weight: 600; display: grid; place-items: center; flex-shrink: 0;">
                            3
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 13px; color: #0f172a; margin-bottom: 2px;">Pelaksanaan Ujian Sidang</div>
                            <div style="font-size: 12px; color: #64748b; line-height: 1.5;">
                                Presentasi hasil kerja praktik (15-20 menit) dan sesi tanya jawab dewan penguji.
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <div style="width: 26px; height: 26px; border-radius: 50%; background: #ecfdf5; color: #059669; font-size: 12px; font-weight: 600; display: grid; place-items: center; flex-shrink: 0;">
                            4
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 13px; color: #0f172a; margin-bottom: 2px;">Penerbitan Nilai Akhir</div>
                            <div style="font-size: 12px; color: #64748b; line-height: 1.5;">
                                Rekapitulasi nilai pembimbing lapangan, dosen pembimbing, dan dewan penguji.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL KETENTUAN HARI-H -->
            <div class="panel">
                <div class="panel-title">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <iconify-icon icon="lucide:info" width="18" height="18" style="color: var(--brand-primary);"></iconify-icon>
                        <span>Ketentuan Hari-H Sidang</span>
                    </div>
                </div>

                <ul style="margin: 0; padding-left: 18px; font-size: 12.5px; color: #475569; line-height: 1.7;">
                    <li>Mengenakan kemeja putih, bawahan hitam formal, dan <strong>jas almamater Unila</strong>.</li>
                    <li>Menyiapkan slide presentasi materi inti dan ringkasan kontribusi pekerjaan KP.</li>
                    <li>Hadir di lokasi sidang minimal <strong>15 menit</strong> sebelum jadwal dimulai.</li>
                    <li>Membawa naskah laporan cetak atau berkas digital cadangan jika diperlukan penguji.</li>
                </ul>
            </div>
        </div>

    </div>
@endif
@endsection
