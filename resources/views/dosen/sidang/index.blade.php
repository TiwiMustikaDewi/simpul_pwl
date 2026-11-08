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

    <!-- DAFTAR SIDANG -->
    <section class="workflow-list">
        @forelse ($sidangList as $item)
            <article class="panel workflow-panel searchable-card">
                <div class="workflow-card-heading">
                    <div>
                        <h2>{{ $item->student_name }} · {{ $item->npm }}</h2>
                        <p style="color: var(--blue-dark); font-weight: 700; margin-top: 3px;">
                            "{{ $item->internship_title }}"
                        </p>
                        <small style="color: var(--muted);">
                            {{ $item->major }} · Instansi: {{ $item->company_name }}
                            ({{ $item->internship_type === 'group' ? 'Kelompok' : 'Individu' }})
                        </small>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px;">
                        @if ($item->grade)
                            <span class="status-pill completed" style="font-size: 11px;">
                                Nilai: {{ $item->grade }}
                            </span>
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
                                {{ \Carbon\Carbon::parse($item->sidang_date)->locale('id')->translatedFormat('l, d F Y - H:i') }} WIB
                            @else
                                Belum dijadwalkan oleh admin
                            @endif
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="label">Ruang Sidang</span>
                        <span class="val">{{ $item->room ?? 'Belum ditentukan' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="label">Status Evaluasi</span>
                        <span class="val">
                            @if ($item->grade)
                                Sudah dinilai ({{ $item->grade }})
                            @else
                                <span style="color: var(--yellow);">Menunggu penilaian</span>
                            @endif
                        </span>
                    </div>
                </div>

                @if ($item->notes)
                    <div class="review-note">
                        <strong>Catatan Evaluasi / Catatan Sidang:</strong> {{ $item->notes }}
                    </div>
                @endif

                <!-- Form Penilaian Sidang -->
                <form action="{{ route('dosen.sidang.grade', $item->id) }}" method="POST" class="workflow-form form-grid" style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed var(--border);">
                    @csrf
                    <div class="form-field-wide" style="font-weight: 700; color: var(--blue-dark); font-size: 12px;">
                        Input / Pembaruan Nilai Sidang Kuliah Praktik
                    </div>

                    <label class="form-field">
                        <span>Nilai Akhir Sidang</span>
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
                        <span>Catatan / Berita Acara Sidang</span>
                        <textarea
                            name="notes"
                            rows="2"
                            class="form-control"
                            placeholder="Tuliskan catatan evaluasi, revisi kecil jika ada, atau masukan sidang..."
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
                <strong>Tidak ada data sidang KP</strong>
                Belum ada pengajuan atau jadwal sidang yang sesuai dengan filter.
            </div>
        @endforelse
    </section>
@endsection
