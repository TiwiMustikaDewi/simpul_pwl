@extends('layouts.student')

@section('title', 'Pendaftaran & Jadwal Sidang KP')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="font-size: 22px; font-weight: 700; color: var(--text);">Pendaftaran & Status Sidang Kuliah Praktik</h2>
    <p style="font-size: 13px; color: var(--muted); margin-top: 4px;">
        Ajukan permohonan pelaksanaan sidang kelulusan KP dan pantau penetapan jadwal, ruangan, serta perolehan nilai akhir.
    </p>
</div>

@if (! $internship)
    <div class="panel" style="text-align: center; padding: 40px;">
        <div style="font-size: 32px; margin-bottom: 10px;">🎓</div>
        <h3 style="font-size: 16px; font-weight: 700;">Belum Ada Pelaksanaan KP Aktif</h3>
        <p style="font-size: 13px; color: var(--muted); margin-top: 4px;">
            Pendaftaran sidang dibuka setelah pelaksanaan KP dan laporan akhir disetujui oleh Dosen Pembimbing.
        </p>
    </div>
@else
    <div style="max-width: 740px; margin: 0 auto;">
        @if (! $sidang)
            <!-- BELUM DAFTAR SIDANG -->
            <div class="panel" style="text-align: center; padding: 36px 20px;">
                <div style="font-size: 36px; margin-bottom: 12px;">📑</div>
                <h3 style="font-size: 18px; font-weight: 700; color: var(--text);">Siap Mengajukan Sidang Kuliah Praktik?</h3>
                <p style="font-size: 13px; color: var(--muted); max-width: 480px; margin: 6px auto 20px; line-height: 1.5;">
                    Pastikan Anda telah mengisi seluruh logbook harian dan draf laporan akhir telah ditinjau serta mendapatkan persetujuan dari Dosen Pembimbing.
                </p>

                <form action="{{ route('mahasiswa.sidang.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-brand" style="padding: 12px 28px; font-size: 14px;">
                        Daftar Sidang Kuliah Praktik Sekarang →
                    </button>
                </form>
            </div>
        @else
            <!-- STATUS SIDANG SUDAH TERDAFTAR -->
            @php
                $statusMap = [
                    'submitted' => ['bg' => '#fef3c7', 'text' => '#b45309', 'label' => 'Menunggu Penjadwalan Admin'],
                    'scheduled' => ['bg' => '#dbeafe', 'text' => '#1e40af', 'label' => 'Jadwal Telah Ditetapkan'],
                    'completed' => ['bg' => '#dcfce7', 'text' => '#15803d', 'label' => 'Sidang Telah Selesai (Lulus)'],
                    'rejected' => ['bg' => '#fee2e2', 'text' => '#b91c1c', 'label' => 'Pengajuan Sidang Ditolak'],
                ];
                $st = $statusMap[$sidang->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569', 'label' => strtoupper($sidang->status)];
            @endphp

            <div class="panel" style="border-top: 4px solid {{ $sidang->status === 'completed' ? '#10b981' : ($sidang->status === 'scheduled' ? '#3b82f6' : '#f59e0b') }};">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <div>
                        <div style="font-size: 11px; font-weight: 600; color: var(--muted);">STATUS PENDAFTARAN SIDANG KP:</div>
                        <h3 style="font-size: 18px; font-weight: 700; color: var(--text); margin-top: 2px;">
                            {{ $internship->title }}
                        </h3>
                    </div>

                    <span style="background: {{ $st['bg'] }}; color: {{ $st['text'] }}; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                        {{ $st['label'] }}
                    </span>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; background: #f8fbff; border: 1px solid var(--border); border-radius: 10px; padding: 18px; margin-bottom: 20px;">
                    <div>
                        <span style="font-size: 11.5px; color: var(--muted);">Waktu / Tanggal Sidang:</span>
                        <div style="font-size: 14px; font-weight: 700; color: var(--text); margin-top: 2px;">
                            {{ $sidang->sidang_date ? $sidang->sidang_date->format('d M Y, H:i') . ' WIB' : 'Belum dijadwalkan oleh Admin' }}
                        </div>
                    </div>
                    <div>
                        <span style="font-size: 11.5px; color: var(--muted);">Ruang / Lokasi Sidang:</span>
                        <div style="font-size: 14px; font-weight: 700; color: var(--text); margin-top: 2px;">
                            {{ $sidang->room ?? 'Menunggu penetapan ruangan' }}
                        </div>
                    </div>
                    <div>
                        <span style="font-size: 11.5px; color: var(--muted);">Dosen Pembimbing:</span>
                        <div style="font-size: 13px; font-weight: 600; color: var(--brand-dark); margin-top: 2px;">
                            {{ $internship->supervisor?->user?->name ?? '-' }}
                        </div>
                    </div>
                    <div>
                        <span style="font-size: 11.5px; color: var(--muted);">Nilai Akhir Kelulusan:</span>
                        <div style="font-size: 16px; font-weight: 800; color: {{ $sidang->grade ? '#15803d' : 'var(--muted)' }}; margin-top: 2px;">
                            {{ $sidang->grade ?? 'Belum terbit' }}
                        </div>
                    </div>
                </div>

                @if ($sidang->notes)
                    <div style="padding: 14px; background: #ffffff; border: 1px solid var(--border); border-radius: 8px; font-size: 12.5px;">
                        <strong>Catatan Dewan Penguji:</strong>
                        <p style="color: #475569; margin-top: 4px; line-height: 1.5;">
                            {{ $sidang->notes }}
                        </p>
                    </div>
                @endif

                @if ($sidang->status === 'completed')
                    <div style="margin-top: 20px; text-align: center; padding-top: 16px; border-top: 1px solid var(--border);">
                        <a href="{{ route('mahasiswa.experiences.create') }}" class="btn-brand" style="background: #15803d;">
                            ⭐ Bagikan Ulasan Pengalaman Alumni Sekarang →
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
@endif
@endsection
