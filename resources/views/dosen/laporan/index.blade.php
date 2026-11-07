@extends('layouts.dosen')

@section('title', 'Laporan Akhir KP')

@section('content')
    <div class="page-top">
        <div>
            <div class="breadcrumb">SIMPUL / Dosen / Laporan Akhir KP</div>
            <h1>Laporan Akhir Kuliah Praktik</h1>
            <p>Periksa berkas laporan akhir mahasiswa, berikan evaluasi, catatan revisi, atau persetujuan laporan.</p>
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
            <strong>Terjadi kesalahan:</strong>
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
            <a href="{{ route('dosen.reports.index', ['status' => 'all', 'q' => $search]) }}" class="filter-pill {{ $statusFilter === 'all' ? 'active' : '' }}">
                Semua <span class="filter-count">{{ $counts['all'] }}</span>
            </a>
            <a href="{{ route('dosen.reports.index', ['status' => 'submitted', 'q' => $search]) }}" class="filter-pill {{ $statusFilter === 'submitted' ? 'active' : '' }}">
                Menunggu Review <span class="filter-count">{{ $counts['submitted'] }}</span>
            </a>
            <a href="{{ route('dosen.reports.index', ['status' => 'approved', 'q' => $search]) }}" class="filter-pill {{ $statusFilter === 'approved' ? 'active' : '' }}">
                Disetujui <span class="filter-count">{{ $counts['approved'] }}</span>
            </a>
            <a href="{{ route('dosen.reports.index', ['status' => 'revision', 'q' => $search]) }}" class="filter-pill {{ $statusFilter === 'revision' ? 'active' : '' }}">
                Perlu Revisi <span class="filter-count">{{ $counts['revision'] }}</span>
            </a>
        </div>

        <form method="GET" action="{{ route('dosen.reports.index') }}" style="display: flex; gap: 8px;">
            <input type="hidden" name="status" value="{{ $statusFilter }}">
            <input
                type="text"
                name="q"
                value="{{ $search }}"
                placeholder="Cari judul laporan / nama..."
                class="form-control"
                style="width: 240px;"
            >
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            @if ($search || $statusFilter !== 'all')
                <a href="{{ route('dosen.reports.index') }}" class="btn btn-outline btn-sm">Reset</a>
            @endif
        </form>
    </div>

    <!-- DAFTAR LAPORAN -->
    <section class="workflow-list">
        @forelse ($reports as $report)
            <article class="panel workflow-panel searchable-card">
                <div class="workflow-card-heading">
                    <div>
                        <h2>{{ $report->title }}</h2>
                        <p style="font-weight: 700; color: var(--blue-dark); margin-top: 4px;">
                            {{ $report->student_name }} · {{ $report->npm }}
                        </p>
                        <small style="color: var(--muted);">
                            Tempat KP: {{ $report->company_name }} · "{{ $report->internship_title }}"
                            · Diunggah: {{ \Carbon\Carbon::parse($report->created_at)->locale('id')->translatedFormat('d F Y, H:i') }}
                        </small>
                    </div>
                    <span class="status-pill {{ $report->status }}">
                        {{ ['submitted' => 'Menunggu review', 'approved' => 'Disetujui', 'revision' => 'Perlu revisi'][$report->status] ?? $report->status }}
                    </span>
                </div>

                <div style="margin: 14px 0 10px;">
                    <a href="{{ route('dosen.reports.download', $report->id) }}" class="btn btn-outline btn-sm">
                        Unduh Berkas Laporan
                    </a>
                </div>

                @if ($report->feedback)
                    <div class="review-note">
                        <strong>Catatan Evaluasi / Feedback:</strong> {{ $report->feedback }}
                    </div>
                @endif

                <form action="{{ route('dosen.reports.review', $report->id) }}" method="POST" class="workflow-form form-grid" style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed var(--border);">
                    @csrf
                    <label class="form-field">
                        <span>Status Persetujuan</span>
                        <select name="status" class="form-control" required>
                            <option value="approved" {{ $report->status === 'approved' ? 'selected' : '' }}>✓ Setujui Laporan</option>
                            <option value="revision" {{ $report->status === 'revision' ? 'selected' : '' }}>⚠ Minta Revisi Laporan</option>
                        </select>
                    </label>

                    <label class="form-field form-field-wide">
                        <span>Catatan Masukan / Uraian Revisi Laporan</span>
                        <textarea name="feedback" rows="3" class="form-control" placeholder="Tuliskan catatan evaluasi isi, format, atau revisi laporan...">{{ old('feedback', $report->feedback) }}</textarea>
                    </label>

                    <div class="form-field-wide form-actions">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Tinjauan Laporan</button>
                    </div>
                </form>
            </article>
        @empty
            <div class="panel empty-state">
                <strong>Tidak ada laporan akhir</strong>
                Belum ada laporan yang sesuai dengan filter atau mahasiswa bimbingan belum mengunggah laporan.
            </div>
        @endforelse
    </section>
@endsection
