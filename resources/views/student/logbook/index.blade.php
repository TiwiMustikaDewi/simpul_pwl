@extends('layouts.student')

@section('title', 'Logbook Kegiatan Harian KP')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="font-size: 22px; font-weight: 700; color: var(--text);">Logbook Kegiatan Harian Kuliah Praktik</h2>
    <p style="font-size: 13px; color: var(--muted); margin-top: 4px;">
        Catat seluruh aktivitas pekerjaan harian selama pelaksanaan KP untuk ditinjau dan divalidasi oleh Dosen Pembimbing.
    </p>
</div>

@if (! $internship)
    <div class="panel" style="text-align: center; padding: 40px;">
        <div style="font-size: 32px; margin-bottom: 10px;">📋</div>
        <h3 style="font-size: 16px; font-weight: 700;">Belum Ada Pelaksanaan KP Aktif</h3>
        <p style="font-size: 13px; color: var(--muted); max-width: 480px; margin: 4px auto 16px;">
            Fitur logbook harian dapat diakses setelah pengajuan kesiapan KP kamu disetujui oleh Admin Jurusan dan Dosen Pembimbing telah ditetapkan.
        </p>
        <a href="{{ route('mahasiswa.applications.create') }}" class="btn-brand">
            Ajukan Kesiapan KP Sekarang →
        </a>
    </div>
@else
    <!-- HEADER RINGKASAN KP AKTIF -->
    <div class="panel" style="margin-bottom: 24px; background: #f8fbff; border-left: 4px solid var(--brand-primary);">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <div>
                <div style="font-size: 11px; font-weight: 600; color: var(--muted);">INSTANSI TEMPAT KP:</div>
                <div style="font-size: 16px; font-weight: 700; color: var(--brand-dark);">{{ $internship->company->name }}</div>
                <div style="font-size: 12.5px; color: var(--text); margin-top: 2px;">
                    Dosen Pembimbing: <strong>{{ $internship->supervisor?->user?->name ?? 'Menunggu penetapan' }}</strong>
                </div>
            </div>

            <div style="text-align: right;">
                <div style="font-size: 11px; color: var(--muted);">TOTAL LOGBOOK:</div>
                <div style="font-size: 20px; font-weight: 800; color: var(--brand-primary);">{{ $logs->count() }} Kegiatan</div>
            </div>
        </div>
    </div>

    <!-- FORM INPUT LOGBOOK HARIAN -->
    <div class="panel" style="margin-bottom: 24px;">
        <h3 style="font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 14px;">
            ✍ Tambah Catatan Kegiatan Harian
        </h3>

        <form action="{{ route('mahasiswa.logbook.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 220px 1fr; gap: 16px; margin-bottom: 14px;">
                <div>
                    <label for="date" style="font-weight: 600; font-size: 12.5px; display: block; margin-bottom: 5px;">
                        Tanggal Kegiatan <span style="color: red;">*</span>
                    </label>
                    <input
                        type="date"
                        name="date"
                        id="date"
                        value="{{ old('date', date('Y-m-d')) }}"
                        required
                        style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px;"
                    >
                </div>

                <div>
                    <label for="activity" style="font-weight: 600; font-size: 12.5px; display: block; margin-bottom: 5px;">
                        Ringkasan Kegiatan / Judul Aktivitas <span style="color: red;">*</span>
                    </label>
                    <input
                        type="text"
                        name="activity"
                        id="activity"
                        value="{{ old('activity') }}"
                        required
                        placeholder="Contoh: Analisis kebutuhan fungsional dan perancangan database PostgreSQL"
                        style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px;"
                    >
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label for="description" style="font-weight: 600; font-size: 12.5px; display: block; margin-bottom: 5px;">
                    Uraian Detail Pekerjaan yang Dilakukan <span style="color: red;">*</span>
                </label>
                <textarea
                    name="description"
                    id="description"
                    rows="3"
                    required
                    placeholder="Jelaskan secara terperinci apa yang dikerjakan, kendala yang dihadapi, serta hasil yang dicapai hari ini..."
                    style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px;"
                >{{ old('description') }}</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-brand">
                    Simpan & Kirim ke Pembimbing →
                </button>
            </div>
        </form>
    </div>

    <!-- DAFTAR LOGBOOK -->
    <div class="panel">
        <h3 style="font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 14px;">
            📑 Riwayat Logbook Kegiatan
        </h3>

        @if ($logs->isNotEmpty())
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: #f8fbff; border-bottom: 2px solid var(--border); text-align: left;">
                            <th style="padding: 12px 14px;">Tanggal</th>
                            <th style="padding: 12px 14px;">Aktivitas</th>
                            <th style="padding: 12px 14px;">Uraian Pekerjaan</th>
                            <th style="padding: 12px 14px;">Status Validasi</th>
                            <th style="padding: 12px 14px;">Catatan Dosen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 12px 14px; white-space: nowrap; font-weight: 600; color: #475569;">
                                    {{ $log->date->format('d M Y') }}
                                </td>
                                <td style="padding: 12px 14px; font-weight: 600; color: var(--text);">
                                    {{ $log->activity }}
                                </td>
                                <td style="padding: 12px 14px; color: #334155; line-height: 1.4;">
                                    {{ $log->description }}
                                </td>
                                <td style="padding: 12px 14px; white-space: nowrap;">
                                    <span class="badge-quota {{ $log->status === 'approved' ? 'success' : ($log->status === 'revision' ? 'danger' : 'warning') }}">
                                        {{ strtoupper($log->status) }}
                                    </span>
                                </td>
                                <td style="padding: 12px 14px; font-size: 12px; color: {{ $log->supervisor_note ? '#b45309' : '#94a3b8' }};">
                                    {{ $log->supervisor_note ?? 'Belum ada catatan' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; color: var(--muted); padding: 30px;">
                Belum ada catatan kegiatan harian yang disimpan. Isi formulir di atas untuk memulai logbook pertamamu!
            </div>
        @endif
    </div>
@endif
@endsection
