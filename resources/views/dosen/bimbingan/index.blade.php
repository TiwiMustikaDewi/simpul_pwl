@extends('layouts.dosen')

@section('title', 'Mahasiswa Bimbingan')

@section('content')
    <div class="page-top">
        <div>
            <div class="breadcrumb">SIMPUL / Dosen / Mahasiswa Bimbingan</div>
            <h1>Mahasiswa Bimbingan KP</h1>
            <p>Daftar seluruh mahasiswa Kuliah Praktik yang menjadi tanggung jawab bimbingan Anda.</p>
        </div>
        <a href="{{ route('dosen.dashboard') }}" class="btn btn-outline">← Dashboard</a>
    </div>

    @if (session('success'))
        <div class="notice notice-success" role="status">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="notice notice-error" role="alert">{{ session('error') }}</div>
    @endif

    <!-- RINGKASAN METRIK BIMBINGAN -->
    <div class="stat-grid" style="margin-bottom: 20px;">
        <div class="stat-card blue">
            <div class="stat-number">{{ number_format($counts['all']) }}</div>
            <div class="stat-label">Total Mahasiswa</div>
            <div class="stat-hint">Keseluruhan bimbingan Anda</div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-number">{{ number_format($counts['in_progress']) }}</div>
            <div class="stat-label">Sedang Berjalan</div>
            <div class="stat-hint">Aktivitas KP di lapangan</div>
        </div>
        <div class="stat-card green">
            <div class="stat-number">{{ number_format($counts['approved']) }}</div>
            <div class="stat-label">Disetujui</div>
            <div class="stat-hint">Siap/menuju pelaksanaan</div>
        </div>
        <div class="stat-card green" style="background: #eafaf3; border-color: #bcebd7;">
            <div class="stat-number" style="color: var(--green);">{{ number_format($counts['completed']) }}</div>
            <div class="stat-label">Selesai / Lulus</div>
            <div class="stat-hint">Telah selesai dievaluasi</div>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="filter-bar">
        <div class="filter-group">
            <a href="{{ route('dosen.students.index', ['status' => 'all']) }}" class="filter-pill {{ $statusFilter === 'all' ? 'active' : '' }}">
                Semua <span class="filter-count">{{ $counts['all'] }}</span>
            </a>
            <a href="{{ route('dosen.students.index', ['status' => 'in_progress']) }}" class="filter-pill {{ $statusFilter === 'in_progress' ? 'active' : '' }}">
                Sedang Berjalan <span class="filter-count">{{ $counts['in_progress'] }}</span>
            </a>
            <a href="{{ route('dosen.students.index', ['status' => 'approved']) }}" class="filter-pill {{ $statusFilter === 'approved' ? 'active' : '' }}">
                Disetujui <span class="filter-count">{{ $counts['approved'] }}</span>
            </a>
            <a href="{{ route('dosen.students.index', ['status' => 'completed']) }}" class="filter-pill {{ $statusFilter === 'completed' ? 'active' : '' }}">
                Selesai <span class="filter-count">{{ $counts['completed'] }}</span>
            </a>
        </div>

        <form method="GET" action="{{ route('dosen.students.index') }}" style="display: flex; gap: 8px;">
            <input type="hidden" name="status" value="{{ $statusFilter }}">
            <input
                type="text"
                name="q"
                value="{{ $search }}"
                placeholder="Cari nama, NPM, perusahaan..."
                class="form-control"
                style="width: 250px;"
            >
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            @if ($search)
                <a href="{{ route('dosen.students.index', ['status' => $statusFilter]) }}" class="btn btn-outline btn-sm">Reset</a>
            @endif
        </form>
    </div>

    <!-- TABEL MAHASISWA BIMBINGAN -->
    <section class="panel workflow-panel">
        <div class="panel-title">
            <h2>Daftar Bimbingan Kuliah Praktik</h2>
            <span class="small-badge">{{ $internships->count() }} Mahasiswa Ditemukan</span>
        </div>

        <div class="workflow-table-wrap">
            <table class="workflow-table">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Perusahaan &amp; Judul</th>
                        <th>Periode</th>
                        <th>Status KP</th>
                        <th>Progres Logbook</th>
                        <th>Laporan Akhir</th>
                        <th>Sidang KP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($internships as $item)
                        @php
                            $logPct = $item->total_logs > 0 ? round(($item->approved_logs / $item->total_logs) * 100) : 0;
                            $studentInitials = strtoupper(mb_substr($item->student_name, 0, 1));
                        @endphp
                        <tr class="searchable-card">
                            <td data-label="Mahasiswa">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div class="mini-avatar">
                                        {{ $studentInitials }}
                                    </div>
                                    <div>
                                        <strong style="color: var(--blue-dark); font-size: 12px;">{{ $item->student_name }}</strong>
                                        <small>{{ $item->npm }} · {{ $item->major }}</small>
                                        @if ($item->type === 'group')
                                            <small><span class="count-chip" style="font-size: 9px; background: #e0efff; color: var(--blue-dark); padding: 2px 7px;">Kelompok: {{ $item->group_name ?? 'Tim' }}</span></small>
                                        @else
                                            <small><span style="color: var(--muted); font-size: 9px;">Individu</span></small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td data-label="Perusahaan &amp; Judul">
                                <strong>{{ $item->company_name }}</strong>
                                <small>{{ $item->company_city }}</small>
                                <small style="color: var(--blue-dark); font-style: italic; margin-top: 2px;">"{{ $item->title }}"</small>
                            </td>
                            <td data-label="Periode">
                                {{ \Carbon\Carbon::parse($item->start_date)->locale('id')->translatedFormat('d M Y') }}<br>
                                <small>s/d {{ \Carbon\Carbon::parse($item->end_date)->locale('id')->translatedFormat('d M Y') }}</small>
                            </td>
                            <td data-label="Status KP">
                                <span class="status-pill {{ $item->status }}">
                                    {{ ['in_progress' => 'Sedang berjalan', 'approved' => 'Disetujui', 'completed' => 'Selesai', 'pending' => 'Pending', 'rejected' => 'Ditolak'][$item->status] ?? $item->status }}
                                </span>
                            </td>
                            <td data-label="Progres Logbook">
                                <div class="mini-progress-wrap">
                                    <div class="mini-progress-bar" title="{{ $logPct }}% disetujui">
                                        <div class="mini-progress-fill" style="width: {{ $logPct }}%;"></div>
                                    </div>
                                    <strong style="font-size: 11px;">{{ $item->approved_logs }}/{{ $item->total_logs }}</strong>
                                </div>
                                @if ($item->pending_logs > 0)
                                    <small style="color: #b25e00; font-weight: 700; display: block; margin-top: 3px;">
                                        ⚡ {{ $item->pending_logs }} menunggu review
                                    </small>
                                @endif
                            </td>
                            <td data-label="Laporan Akhir">
                                @if ($item->total_reports > 0)
                                    <span class="status-pill {{ $item->latest_report_status }}">
                                        {{ ['submitted' => 'Menunggu review', 'approved' => 'Disetujui', 'revision' => 'Revisi'][$item->latest_report_status] ?? $item->latest_report_status }}
                                    </span>
                                @else
                                    <small style="color: var(--muted); font-style: italic;">Belum unggah</small>
                                @endif
                            </td>
                            <td data-label="Sidang KP">
                                @if ($item->sidang_status)
                                    <span class="status-pill {{ $item->sidang_status }}">
                                        {{ ['scheduled' => 'Terjadwal', 'submitted' => 'Diajukan', 'completed' => 'Selesai', 'rejected' => 'Ditolak'][$item->sidang_status] ?? $item->sidang_status }}
                                    </span>
                                    @if ($item->sidang_grade)
                                        <small style="display: block; margin-top: 2px;">
                                            <strong style="color: var(--green);">Nilai: {{ $item->sidang_grade }}</strong>
                                        </small>
                                    @endif
                                @else
                                    <small style="color: var(--muted);">-</small>
                                @endif
                            </td>
                            <td data-label="Aksi">
                                <a href="{{ route('dosen.students.show', $item->id) }}" class="btn btn-outline btn-sm">
                                    Detail Bimbingan →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="table-empty">
                                <div style="padding: 20px 0;">
                                    <div style="font-size: 24px; margin-bottom: 6px;">📂</div>
                                    <strong>Tidak ada mahasiswa bimbingan yang sesuai</strong>
                                    <p style="margin-top: 4px; font-size: 11px; color: var(--muted);">Coba ubah filter status atau kata kunci pencarian Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
