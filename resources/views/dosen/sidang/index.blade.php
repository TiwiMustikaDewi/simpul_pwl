@extends('layouts.dosen')

@section('title', 'Sidang & Penilaian KP')

@section('content')
    <div class="page-top">
        <div>
            <div class="breadcrumb">SIMPUL / Dosen / Sidang &amp; Penilaian</div>
            <h1>Sidang Kuliah Praktik &amp; Penilaian</h1>
            <p>Lihat jadwal pelaksanaan sidang, tentukan nilai akhir, dan berikan evaluasi sidang mahasiswa bimbingan.</p>
        </div>
        <a href="{{ route('dosen.dashboard') }}" class="btn btn-outline">← Dashboard</a>
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

    <!-- RINGKASAN METRIK SIDANG -->
    <div class="stat-grid" style="margin-bottom: 20px;">
        <div class="stat-card blue">
            <div class="stat-number">{{ number_format($counts['all']) }}</div>
            <div class="stat-label">Total Sidang KP</div>
            <div class="stat-hint">Pengajuan &amp; terjadwal</div>
        </div>
        <div class="stat-card green">
            <div class="stat-number">{{ number_format($counts['scheduled']) }}</div>
            <div class="stat-label">Terjadwal</div>
            <div class="stat-hint">Siap diuji &amp; dievaluasi</div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-number">{{ number_format($counts['submitted']) }}</div>
            <div class="stat-label">Menunggu Jadwal</div>
            <div class="stat-hint">Menunggu penentuan admin</div>
        </div>
        <div class="stat-card green" style="background: #eafaf3; border-color: #bcebd7;">
            <div class="stat-number" style="color: var(--green);">{{ number_format($counts['completed']) }}</div>
            <div class="stat-label">Selesai Dinilai</div>
            <div class="stat-hint">Nilai akhir telah tersimpan</div>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="filter-bar">
        <div class="filter-group">
            <a href="{{ route('dosen.sidang.index', ['status' => 'all', 'q' => $search]) }}" class="filter-pill {{ $statusFilter === 'all' ? 'active' : '' }}">
                Semua <span class="filter-count">{{ $counts['all'] }}</span>
            </a>
            <a href="{{ route('dosen.sidang.index', ['status' => 'scheduled', 'q' => $search]) }}" class="filter-pill {{ $statusFilter === 'scheduled' ? 'active' : '' }}">
                Terjadwal <span class="filter-count">{{ $counts['scheduled'] }}</span>
            </a>
            <a href="{{ route('dosen.sidang.index', ['status' => 'submitted', 'q' => $search]) }}" class="filter-pill {{ $statusFilter === 'submitted' ? 'active' : '' }}">
                Menunggu Jadwal <span class="filter-count">{{ $counts['submitted'] }}</span>
            </a>
            <a href="{{ route('dosen.sidang.index', ['status' => 'completed', 'q' => $search]) }}" class="filter-pill {{ $statusFilter === 'completed' ? 'active' : '' }}">
                Selesai / Dinilai <span class="filter-count">{{ $counts['completed'] }}</span>
            </a>
        </div>

        <form method="GET" action="{{ route('dosen.sidang.index') }}" style="display: flex; gap: 8px;">
            <input type="hidden" name="status" value="{{ $statusFilter }}">
            <input
                type="text"
                name="q"
                value="{{ $search }}"
                placeholder="Cari mahasiswa, ruang, judul..."
                class="form-control"
                style="width: 240px;"
            >
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            @if ($search || $statusFilter !== 'all')
                <a href="{{ route('dosen.sidang.index') }}" class="btn btn-outline btn-sm">Reset</a>
            @endif
        </form>
    </div>

    <!-- PANDUAN STANDAR RUBRIK PENILAIAN -->
    <div class="rubric-box">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
            <span style="font-size: 16px;">📋</span>
            <strong style="color: var(--blue-dark); font-size: 12px;">Pedoman Penilaian Sidang Kuliah Praktik:</strong>
        </div>
        <p style="font-size: 11px; color: #536783; line-height: 1.7;">
            Rentang Predikat Nilai: <strong>A</strong> (&ge; 80) · <strong>A-</strong> (76–79) · <strong>B+</strong> (71–75) · <strong>B</strong> (66–70) · <strong>B-</strong> (61–65) · <strong>C</strong> (55–60).
            Penilaian mencakup penguasaan materi laporan, presentasi, sikap/etika, dan capaian target kerja praktik.
        </p>
    </div>

    <!-- DAFTAR SIDANG -->
    <section class="workflow-list">
        @forelse ($sidangList as $item)
            <article class="panel workflow-panel searchable-card">
                <div class="workflow-card-heading">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <div class="mini-avatar">
                            {{ strtoupper(mb_substr($item->student_name, 0, 1)) }}
                        </div>
                        <div>
                            <h2>{{ $item->student_name }} · <span style="color: var(--muted); font-size: 12px;">{{ $item->npm }}</span></h2>
                            <p style="color: var(--blue-dark); font-weight: 700; margin-top: 3px;">
                                "{{ $item->internship_title }}"
                            </p>
                            <small style="color: var(--muted); display: block; margin-top: 2px;">
                                {{ $item->major }} · Instansi: {{ $item->company_name }}
                                ({{ $item->internship_type === 'group' ? 'Kelompok' : 'Individu' }})
                            </small>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px;">
                        @if ($item->grade)
                            <div class="grade-ribbon-lg" style="min-width: 45px; height: 45px; font-size: 18px;" title="Nilai Sidang">
                                {{ $item->grade }}
                            </div>
                        @endif
                        <span class="status-pill {{ $item->status }}">
                            {{ ['scheduled' => 'Terjadwal', 'submitted' => 'Menunggu Jadwal', 'completed' => 'Selesai', 'rejected' => 'Ditolak'][$item->status] ?? $item->status }}
                        </span>
                    </div>
                </div>

                <div class="detail-grid" style="margin-top: 14px;">
                    <div class="detail-item">
                        <span class="label">Waktu Pelaksanaan</span>
                        <span class="val">
                            @if ($item->sidang_date)
                                📅 {{ \Carbon\Carbon::parse($item->sidang_date)->locale('id')->translatedFormat('l, d F Y - H:i') }} WIB
                            @else
                                <span style="color: var(--muted); font-style: italic;">Belum dijadwalkan oleh admin</span>
                            @endif
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="label">Ruang Sidang</span>
                        <span class="val">
                            🏛️ {{ $item->room ?? 'Belum ditentukan' }}
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="label">Status Evaluasi</span>
                        <span class="val">
                            @if ($item->grade)
                                <strong style="color: var(--green);">Sudah dinilai ({{ $item->grade }})</strong>
                            @else
                                <span style="color: #b25e00; font-weight: 700;">⚡ Menunggu penilaian</span>
                            @endif
                        </span>
                    </div>
                </div>

                @if ($item->notes)
                    <div class="review-note">
                        <strong>Catatan Evaluasi / Berita Acara Sidang:</strong> {{ $item->notes }}
                    </div>
                @endif

                <!-- Form Penilaian Sidang -->
                <form action="{{ route('dosen.sidang.grade', $item->id) }}" method="POST" class="workflow-form form-grid" style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed var(--border);">
                    @csrf
                    <div class="form-field-wide" style="font-weight: 700; color: var(--blue-dark); font-size: 12px;">
                        Input / Pembaruan Nilai Sidang Kuliah Praktik
                    </div>

                    <label class="form-field">
                        <span>Nilai Akhir Sidang (Huruf atau Angka)</span>
                        <input
                            type="text"
                            name="grade"
                            value="{{ old('grade', $item->grade) }}"
                            class="form-control"
                            placeholder="Contoh: A, A-, B+, 85"
                            required
                            maxlength="10"
                        >
                        <small style="color: var(--muted); font-size: 10px;">Nilai yang diberikan dosen penguji/pembimbing.</small>
                    </label>

                    <label class="form-field form-field-wide">
                        <span>Catatan Evaluasi / Berita Acara Sidang</span>
                        <textarea
                            name="notes"
                            rows="2"
                            class="form-control"
                            placeholder="Tuliskan catatan evaluasi penguasaan materi, tanya jawab, atau masukan sidang..."
                        >{{ old('notes', $item->notes) }}</textarea>
                    </label>

                    <div class="form-field-wide form-actions">
                        <button type="submit" class="btn btn-primary btn-sm">
                            {{ $item->status === 'completed' ? 'Perbarui Nilai Sidang' : 'Simpan Nilai & Selesaikan Sidang' }}
                        </button>
                    </div>
                </form>
            </article>
        @empty
            <div class="panel empty-state">
                <div style="font-size: 24px; margin-bottom: 6px;">🎓</div>
                <strong>Tidak ada data sidang KP</strong>
                Belum ada pengajuan atau jadwal sidang yang sesuai dengan filter.
            </div>
        @endforelse
    </section>
@endsection
