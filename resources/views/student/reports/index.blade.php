@extends('layouts.student')

@section('title', 'Laporan Akhir Kuliah Praktik')

@push('styles')
<style>
    .reports-layout {
        display: grid;
        grid-template-columns: 1.2fr 1.8fr;
        gap: 24px;
    }

    @media (max-width: 1024px) {
        .reports-layout {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }
</style>
@endpush

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="font-size: clamp(19px, 4.5vw, 22px); font-weight: 700; color: var(--text);">Laporan Akhir Kuliah Praktik</h2>
    <p style="font-size: 13px; color: var(--muted); margin-top: 4px;">
        Unggah berkas draf naskah laporan akhir KP dalam format PDF/Word untuk ditinjau dan disetujui oleh Dosen Pembimbing sebelum pengajuan sidang.
    </p>
</div>

@if (! $internship)
    <div class="panel" style="text-align: center; padding: 40px 20px;">
        <div style="margin-bottom: 14px;">
            <iconify-icon icon="lucide:folder-closed" width="42" height="42" style="color: #94a3b8;"></iconify-icon>
        </div>
        <h3 style="font-size: 16px; font-weight: 700;">Belum Ada Pelaksanaan KP Aktif</h3>
        <p style="font-size: 13px; color: var(--muted); margin-top: 4px;">
            Unggah laporan akhir dapat dilakukan setelah pengajuan kesiapan KP kamu disetujui.
        </p>
    </div>
@else
    <div class="reports-layout">

        <!-- FORM UNGGAH LAPORAN -->
        <div class="panel">
            <h3 style="font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                <iconify-icon icon="lucide:upload-cloud" width="18" height="18" style="color: var(--brand-primary);"></iconify-icon>
                <span>Unggah Naskah Laporan KP</span>
            </h3>

            <form action="{{ route('mahasiswa.reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom: 14px;">
                    <label for="title" style="font-weight: 600; font-size: 12.5px; display: block; margin-bottom: 5px;">
                        Judul Laporan / Keterangan Revisi <span style="color: red;">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title') }}"
                        required
                        placeholder="Contoh: Draf Laporan Akhir KP - Revisi Bab 1 s/d 4"
                        style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px;"
                    >
                </div>

                <div style="margin-bottom: 16px;">
                    <label for="report_file" style="font-weight: 600; font-size: 12.5px; display: block; margin-bottom: 5px;">
                        Berkas Naskah (PDF, DOC, DOCX - Maks. 10MB) <span style="color: red;">*</span>
                    </label>
                    <input
                        type="file"
                        name="report_file"
                        id="report_file"
                        required
                        accept=".pdf,.doc,.docx"
                        style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px; background: #f8fbff;"
                    >
                </div>

                <button type="submit" class="btn-brand" style="width: 100%; justify-content: center;">
                    Unggah Naskah Laporan
                </button>
            </form>
        </div>

        <!-- RIWAYAT LAPORAN & CATATAN DOSEN -->
        <div class="panel">
            <h3 style="font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                <iconify-icon icon="lucide:file-text" width="18" height="18" style="color: var(--brand-primary);"></iconify-icon>
                <span>Riwayat Unggahan &amp; Catatan Pembimbing</span>
            </h3>

            @forelse ($reports as $report)
                <div style="padding: 14px; background: #ffffff; border: 1px solid var(--border); border-radius: 10px; margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; margin-bottom: 8px;">
                        <div>
                            <div style="font-size: 11px; color: var(--muted);">{{ $report->created_at->format('d M Y, H:i') }} WIB</div>
                            <div style="font-weight: 700; font-size: 14px; color: var(--brand-dark);">{{ $report->title }}</div>
                        </div>

                        <span class="badge-quota {{ $report->status === 'approved' ? 'success' : ($report->status === 'revision' ? 'danger' : 'warning') }}">
                            {{ strtoupper($report->status) }}
                        </span>
                    </div>

                    <div style="margin-top: 8px; padding-top: 8px; border-top: 1px dashed var(--border); font-size: 12px;">
                        <span style="color: var(--muted);">Umpan Balik Dosen Pembimbing:</span>
                        <div style="color: {{ $report->feedback ? '#b45309' : '#94a3b8' }}; margin-top: 2px;">
                            {{ $report->feedback ?? 'Belum ada catatan umpan balik dari Dosen Pembimbing.' }}
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: var(--muted); padding: 30px;">
                    Belum ada naskah laporan yang diunggah. Silakan unggah draf laporan pertamamu pada formulir di sebelah kiri.
                </div>
            @endforelse
        </div>

    </div>
@endif
@endsection
