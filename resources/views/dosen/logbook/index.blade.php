@extends('layouts.dosen')

@section('title', 'Pemeriksaan Logbook')

@section('content')
    <div class="page-top">
        <div>
            <div class="breadcrumb">SIMPUL / Dosen / Pemeriksaan Logbook</div>
            <h1>Pemeriksaan Logbook Kegiatan</h1>
            <p>Verifikasi kegiatan harian mahasiswa Kuliah Praktik, berikan persetujuan atau instruksi revisi.</p>
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
            <a href="{{ route('dosen.logs.index', ['status' => 'all', 'student_id' => $studentFilter, 'q' => $search]) }}" class="filter-pill {{ $statusFilter === 'all' ? 'active' : '' }}">
                Semua <span class="filter-count">{{ $counts['all'] }}</span>
            </a>
            <a href="{{ route('dosen.logs.index', ['status' => 'submitted', 'student_id' => $studentFilter, 'q' => $search]) }}" class="filter-pill {{ $statusFilter === 'submitted' ? 'active' : '' }}">
                Menunggu Review <span class="filter-count">{{ $counts['submitted'] }}</span>
            </a>
            <a href="{{ route('dosen.logs.index', ['status' => 'approved', 'student_id' => $studentFilter, 'q' => $search]) }}" class="filter-pill {{ $statusFilter === 'approved' ? 'active' : '' }}">
                Disetujui <span class="filter-count">{{ $counts['approved'] }}</span>
            </a>
            <a href="{{ route('dosen.logs.index', ['status' => 'revision', 'student_id' => $studentFilter, 'q' => $search]) }}" class="filter-pill {{ $statusFilter === 'revision' ? 'active' : '' }}">
                Perlu Revisi <span class="filter-count">{{ $counts['revision'] }}</span>
            </a>
        </div>

        <form method="GET" action="{{ route('dosen.logs.index') }}" style="display: flex; flex-wrap: wrap; gap: 8px;">
            <input type="hidden" name="status" value="{{ $statusFilter }}">

            <select name="student_id" class="form-control" style="width: 200px;">
                <option value="">-- Semua Mahasiswa --</option>
                @foreach ($myStudents as $st)
                    <option value="{{ $st->internship_id }}" {{ (string) $studentFilter === (string) $st->internship_id ? 'selected' : '' }}>
                        {{ $st->name }} ({{ $st->npm }})
                    </option>
                @endforeach
            </select>

            <input
                type="text"
                name="q"
                value="{{ $search }}"
                placeholder="Cari aktivitas/kegiatan..."
                class="form-control"
                style="width: 200px;"
            >
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            @if ($search || $studentFilter || $statusFilter !== 'all')
                <a href="{{ route('dosen.logs.index') }}" class="btn btn-outline btn-sm">Reset</a>
            @endif
        </form>
    </div>

    <!-- DAFTAR LOGBOOK -->
    <section class="workflow-list">
        @forelse ($logs as $log)
            <article class="panel workflow-panel searchable-card">
                <div class="workflow-card-heading">
                    <div>
                        <span class="timeline-date">
                            {{ \Carbon\Carbon::parse($log->date)->locale('id')->translatedFormat('l, d F Y') }}
                        </span>
                        <h2 style="margin-top: 4px;">{{ $log->student_name }} · {{ $log->npm }}</h2>
                        <p><strong>Aktivitas:</strong> {{ $log->activity }}</p>
                        <small style="color: var(--muted);">Tempat KP: {{ $log->company_name }} · "{{ $log->internship_title }}"</small>
                    </div>
                    <span class="status-pill {{ $log->status }}">
                        {{ ['submitted' => 'Menunggu review', 'approved' => 'Disetujui', 'revision' => 'Perlu revisi'][$log->status] ?? $log->status }}
                    </span>
                </div>

                <div style="margin-top: 14px; padding: 14px; background: #fbfdff; border: 1px solid var(--border); border-radius: 10px; font-size: 11px; line-height: 1.8; color: var(--text);">
                    <strong style="color: var(--blue-dark); display: block; margin-bottom: 4px;">Uraian Kegiatan:</strong>
                    <div style="white-space: pre-line;">{{ $log->description }}</div>
                </div>

                @if ($log->supervisor_note)
                    <div class="review-note">
                        <strong>Catatan Dosen:</strong> {{ $log->supervisor_note }}
                    </div>
                @endif

                <form action="{{ route('dosen.logs.review', $log->id) }}" method="POST" class="workflow-form form-grid" style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed var(--border);">
                    @csrf
                    <label class="form-field">
                        <span>Status Keputusan</span>
                        <select name="status" class="form-control" required>
                            <option value="approved" {{ $log->status === 'approved' ? 'selected' : '' }}>✓ Setujui Kegiatan</option>
                            <option value="revision" {{ $log->status === 'revision' ? 'selected' : '' }}>⚠ Minta Revisi Kegiatan</option>
                        </select>
                    </label>

                    <label class="form-field form-field-wide">
                        <span>Catatan / Umpan Balik Dosen Pembimbing</span>
                        <textarea name="supervisor_note" rows="2" class="form-control" placeholder="Tuliskan catatan arahan, masukan atau koreksi...">{{ old('supervisor_note', $log->supervisor_note) }}</textarea>
                    </label>

                    <div class="form-field-wide form-actions">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Keputusan Logbook</button>
                    </div>
                </form>
            </article>
        @empty
            <div class="panel empty-state">
                <strong>Tidak ada logbook kegiatan</strong>
                Tidak ada data logbook yang sesuai dengan kriteria filter saat ini.
            </div>
        @endforelse
    </section>
@endsection
