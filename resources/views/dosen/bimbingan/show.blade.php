@extends('layouts.dosen')

@section('title', 'Detail Bimbingan: ' . $internship->student_name)

@section('content')
    <div class="page-top">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('dosen.dashboard') }}">SIMPUL</a> /
                <a href="{{ route('dosen.students.index') }}">Mahasiswa Bimbingan</a> /
                {{ $internship->student_name }}
            </div>
            <h1>Bimbingan KP: {{ $internship->student_name }}</h1>
            <p>{{ $internship->title }}</p>
        </div>
        <a href="{{ route('dosen.students.index') }}" class="btn btn-outline">← Kembali ke Daftar</a>
    </div>

    @if (session('success'))
        <div class="notice notice-success" role="status">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="notice notice-error" role="alert">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="notice notice-error" role="alert">
            <strong>Terjadi kesalahan validasi:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- DETAIL INFORMASI KP -->
    <section class="panel workflow-panel" style="margin-bottom: 22px;">
        <div class="panel-title">
            <h2>Informasi Pelaksanaan Kuliah Praktik</h2>
            <span class="status-pill {{ $internship->status }}">
                Status: {{ ['in_progress' => 'Sedang Berjalan', 'approved' => 'Disetujui', 'completed' => 'Selesai', 'pending' => 'Pending', 'rejected' => 'Ditolak'][$internship->status] ?? $internship->status }}
            </span>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <span class="label">Mahasiswa</span>
                <span class="val">{{ $internship->student_name }}</span>
                <small style="color: var(--muted); font-size: 11px;">NPM: {{ $internship->npm }} · {{ $internship->major }}</small>
                <small style="color: var(--muted); font-size: 11px; display: block;">Email: {{ $internship->student_email }}</small>
                <small style="color: var(--muted); font-size: 11px; display: block;">No HP: {{ $internship->student_phone ?? '-' }}</small>
            </div>

            <div class="detail-item">
                <span class="label">Instansi / Perusahaan</span>
                <span class="val">{{ $internship->company_name }}</span>
                <small style="color: var(--muted); font-size: 11px;">{{ $internship->company_address }}, {{ $internship->company_city }}</small>
                <small style="color: var(--muted); font-size: 11px; display: block;">Kontak: {{ $internship->company_contact ?? '-' }} ({{ $internship->company_phone ?? '-' }})</small>
            </div>

            <div class="detail-item">
                <span class="label">Periode Pelaksanaan</span>
                <span class="val">{{ \Carbon\Carbon::parse($internship->start_date)->locale('id')->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($internship->end_date)->locale('id')->translatedFormat('d M Y') }}</span>
                <small style="color: var(--muted); font-size: 11px;">Tipe: {{ $internship->type === 'group' ? 'Kelompok' : 'Individu' }}</small>
                @if ($internship->group_id)
                    <small style="color: var(--blue); font-size: 11px; display: block; font-weight: 700;">Grup: {{ $internship->group_name }}</small>
                @endif
            </div>
        </div>

        @if ($internship->type === 'group' && count($groupMembers) > 0)
            <div style="margin-top: 10px; padding: 12px; background: var(--blue-light); border-radius: 10px;">
                <strong style="color: var(--blue-dark); font-size: 11px;">Anggota Kelompok KP:</strong>
                <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 6px;">
                    @foreach ($groupMembers as $member)
                        <span class="filter-pill" style="background: #fff;">
                            {{ $member->name }} ({{ $member->npm }})
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    <!-- SECTION 1: LOGBOOK -->
    <section class="panel workflow-panel" style="margin-bottom: 22px;">
        <div class="panel-title">
            <h2>Logbook Harian Mahasiswa</h2>
            <div style="display: flex; align-items: center; gap: 8px;">
                <span class="small-badge">{{ $logs->count() }} Kegiatan</span>
                <a href="{{ route('dosen.logs.index', ['student_id' => $internship->id]) }}" class="text-link">Buka di menu Logbook →</a>
            </div>
        </div>

        @forelse ($logs as $log)
            <article class="timeline-card searchable-card">
                <div class="timeline-header">
                    <div>
                        <span class="timeline-date">
                            {{ \Carbon\Carbon::parse($log->date)->locale('id')->translatedFormat('l, d F Y') }}
                        </span>
                        <h3 style="font-size: 13px; color: var(--blue-dark); margin-top: 3px;">
                            {{ $log->activity }}
                        </h3>
                    </div>
                    <span class="status-pill {{ $log->status }}">
                        {{ ['submitted' => 'Menunggu review', 'approved' => 'Disetujui', 'revision' => 'Perlu revisi'][$log->status] ?? $log->status }}
                    </span>
                </div>

                <div class="timeline-body">
                    <p style="white-space: pre-line;">{{ $log->description }}</p>

                    @if ($log->supervisor_note)
                        <div class="review-note">
                            <strong>Catatan Dosen Pembimbing:</strong> {{ $log->supervisor_note }}
                        </div>
                    @endif
                </div>

                <!-- Form Review Logbook -->
                <details class="workflow-card" style="margin-top: 12px; border-top: 1px dashed var(--border); padding-top: 10px;">
                    <summary>
                        <span class="btn btn-outline btn-sm">Beri Catatan / Ubah Status Logbook ▾</span>
                    </summary>
                    <form action="{{ route('dosen.logs.review', $log->id) }}" method="POST" class="workflow-form form-grid" style="margin-top: 10px;">
                        @csrf
                        <label class="form-field">
                            <span>Status Keputusan</span>
                            <select name="status" class="form-control" required>
                                <option value="approved" {{ $log->status === 'approved' ? 'selected' : '' }}>✓ Setujui Kegiatan</option>
                                <option value="revision" {{ $log->status === 'revision' ? 'selected' : '' }}>⚠ Minta Revisi Kegiatan</option>
                            </select>
                        </label>

                        <label class="form-field form-field-wide">
                            <span>Catatan &amp; Umpan Balik Pembimbing</span>
                            <textarea name="supervisor_note" rows="2" class="form-control" placeholder="Tuliskan catatan, saran atau instruksi perbaikan untuk mahasiswa...">{{ old('supervisor_note', $log->supervisor_note) }}</textarea>
                        </label>

                        <div class="form-field-wide form-actions">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan Tinjauan Logbook</button>
                        </div>
                    </form>
                </details>
            </article>
        @empty
            <div class="empty-state">
                <strong>Belum ada logbook kegiatan</strong>
                Mahasiswa belum mengisi catatan logbook harian untuk Kuliah Praktik ini.
            </div>
        @endforelse
    </section>

    <!-- SECTION 2: LAPORAN AKHIR -->
    <section class="panel workflow-panel" style="margin-bottom: 22px;">
        <div class="panel-title">
            <h2>Laporan Akhir Kuliah Praktik</h2>
            <span class="small-badge">{{ $reports->count() }} Berkas</span>
        </div>

        @forelse ($reports as $report)
            <article class="timeline-card searchable-card">
                <div class="timeline-header">
                    <div>
                        <h3 style="font-size: 14px; color: var(--blue-dark);">{{ $report->title }}</h3>
                        <small style="color: var(--muted);">
                            Diunggah: {{ \Carbon\Carbon::parse($report->created_at)->locale('id')->translatedFormat('d F Y, H:i') }}
                        </small>
                    </div>
                    <span class="status-pill {{ $report->status }}">
                        {{ ['submitted' => 'Menunggu review', 'approved' => 'Disetujui', 'revision' => 'Perlu revisi'][$report->status] ?? $report->status }}
                    </span>
                </div>

                <div style="margin: 10px 0;">
                    <a href="{{ route('dosen.reports.download', $report->id) }}" class="btn btn-outline btn-sm">
                        Unduh Berkas Laporan
                    </a>
                </div>

                @if ($report->feedback)
                    <div class="review-note">
                        <strong>Umpan Balik Dosen Pembimbing:</strong> {{ $report->feedback }}
                    </div>
                @endif

                <!-- Form Review Laporan -->
                <form action="{{ route('dosen.reports.review', $report->id) }}" method="POST" class="workflow-form form-grid" style="margin-top: 14px; padding-top: 12px; border-top: 1px dashed var(--border);">
                    @csrf
                    <label class="form-field">
                        <span>Status Persetujuan Laporan</span>
                        <select name="status" class="form-control" required>
                            <option value="approved" {{ $report->status === 'approved' ? 'selected' : '' }}>✓ Setujui Laporan Akhir</option>
                            <option value="revision" {{ $report->status === 'revision' ? 'selected' : '' }}>⚠ Minta Revisi Laporan</option>
                        </select>
                    </label>

                    <label class="form-field form-field-wide">
                        <span>Catatan Evaluasi / Masukan Perbaikan</span>
                        <textarea name="feedback" rows="3" class="form-control" placeholder="Tuliskan catatan evaluasi laporan untuk mahasiswa...">{{ old('feedback', $report->feedback) }}</textarea>
                    </label>

                    <div class="form-field-wide form-actions">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Evaluasi Laporan</button>
                    </div>
                </form>
            </article>
        @empty
            <div class="empty-state">
                <strong>Belum ada laporan akhir diunggah</strong>
                Mahasiswa belum mengunggah berkas laporan akhir KP.
            </div>
        @endforelse
    </section>

    <!-- SECTION 3: SIDANG KP & PENILAIAN -->
    <section class="panel workflow-panel">
        <div class="panel-title">
            <h2>Sidang Kuliah Praktik &amp; Penilaian</h2>
            @if ($sidang)
                <span class="status-pill {{ $sidang->status }}">
                    Status: {{ ['scheduled' => 'Terjadwal', 'submitted' => 'Diajukan', 'completed' => 'Selesai', 'rejected' => 'Ditolak'][$sidang->status] ?? $sidang->status }}
                </span>
            @endif
        </div>

        @if ($sidang)
            <div class="detail-grid" style="margin-bottom: 14px;">
                <div class="detail-item">
                    <span class="label">Jadwal Sidang</span>
                    <span class="val">
                        @if ($sidang->sidang_date)
                            {{ \Carbon\Carbon::parse($sidang->sidang_date)->locale('id')->translatedFormat('l, d F Y - H:i') }} WIB
                        @else
                            Menunggu penjadwalan oleh admin
                        @endif
                    </span>
                </div>

                <div class="detail-item">
                    <span class="label">Ruang Sidang</span>
                    <span class="val">{{ $sidang->room ?? 'TBA (Belum ditentukan)' }}</span>
                </div>

                <div class="detail-item">
                    <span class="label">Nilai Akhir Sidang</span>
                    <span class="val" style="font-size: 16px; color: var(--green);">
                        {{ $sidang->grade ?? 'Belum Dinilai' }}
                    </span>
                </div>
            </div>

            @if ($sidang->notes)
                <div class="review-note" style="margin-bottom: 16px;">
                    <strong>Catatan Sidang:</strong> {{ $sidang->notes }}
                </div>
            @endif

            <!-- Form Penilaian Sidang -->
            <form action="{{ route('dosen.sidang.grade', $sidang->id) }}" method="POST" class="workflow-form form-grid" style="border-top: 1px dashed var(--border); padding-top: 16px;">
                @csrf
                <div class="form-field-wide" style="color: var(--blue-dark); font-weight: 700; font-size: 12px;">
                    Form Penilaian &amp; Evaluasi Sidang KP
                </div>

                <label class="form-field">
                    <span>Nilai Sidang (Huruf / Angka)</span>
                    <input
                        type="text"
                        name="grade"
                        value="{{ old('grade', $sidang->grade) }}"
                        class="form-control"
                        placeholder="Contoh: A, A-, B+, 88"
                        required
                        maxlength="10"
                    >
                    <small style="color: var(--muted); font-size: 10px;">Nilai yang diberikan dosen pembimbing.</small>
                </label>

                <label class="form-field form-field-wide">
                    <span>Catatan Evaluasi / Berita Acara Sidang</span>
                    <textarea
                        name="notes"
                        rows="3"
                        class="form-control"
                        placeholder="Tuliskan evaluasi penguasaan materi, tanya jawab, atau masukan sidang..."
                    >{{ old('notes', $sidang->notes) }}</textarea>
                </label>

                <div class="form-field-wide form-actions">
                    <button type="submit" class="btn btn-primary">
                        {{ $sidang->status === 'completed' ? 'Perbarui Nilai Sidang' : 'Simpan Nilai & Selesaikan Sidang KP' }}
                    </button>
                </div>
            </form>
        @else
            <div class="empty-state">
                <strong>Mahasiswa belum mengajukan sidang KP</strong>
                Pengajuan sidang akan diajukan mahasiswa setelah laporan selesai dan logbook mencukupi.
            </div>
        @endif
    </section>
@endsection
