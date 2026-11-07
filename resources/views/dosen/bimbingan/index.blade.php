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
                style="width: 240px;"
            >
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            @if ($search)
                <a href="{{ route('dosen.students.index', ['status' => $statusFilter]) }}" class="btn btn-outline btn-sm">Reset</a>
            @endif
        </form>
    </div>

    <section class="panel workflow-panel">
        <div class="panel-title">
            <h2>Daftar Bimbingan</h2>
            <span class="small-badge">{{ $internships->count() }} Mahasiswa</span>
        </div>

        <div class="workflow-table-wrap">
            <table class="workflow-table">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Perusahaan &amp; Judul</th>
                        <th>Periode</th>
                        <th>Status KP</th>
                        <th>Logbook</th>
                        <th>Laporan</th>
                        <th>Sidang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($internships as $item)
                        <tr>
                            <td data-label="Mahasiswa">
                                <strong>{{ $item->student_name }}</strong>
                                <small>{{ $item->npm }} · {{ $item->major }}</small>
                                @if ($item->type === 'group')
                                    <small><span class="count-chip" style="font-size: 8px;">Kelompok: {{ $item->group_name ?? 'Tim' }}</span></small>
                                @else
                                    <small><span style="color: var(--muted); font-size: 9px;">Individu</span></small>
                                @endif
                            </td>
                            <td data-label="Perusahaan &amp; Judul">
                                <strong>{{ $item->company_name }}</strong>
                                <small>{{ $item->company_city }}</small>
                                <small style="color: var(--blue-dark); font-style: italic;">"{{ $item->title }}"</small>
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
                            <td data-label="Logbook">
                                <strong>{{ $item->approved_logs }}/{{ $item->total_logs }}</strong> disetujui
                                @if ($item->pending_logs > 0)
                                    <small style="color: #a76b00; font-weight: 700;">({{ $item->pending_logs }} menunggu)</small>
                                @endif
                            </td>
                            <td data-label="Laporan">
                                @if ($item->total_reports > 0)
                                    <span class="status-pill {{ $item->latest_report_status }}">
                                        {{ ['submitted' => 'Menunggu review', 'approved' => 'Disetujui', 'revision' => 'Revisi'][$item->latest_report_status] ?? $item->latest_report_status }}
                                    </span>
                                @else
                                    <small style="color: var(--muted);">Belum unggah</small>
                                @endif
                            </td>
                            <td data-label="Sidang">
                                @if ($item->sidang_status)
                                    <span class="status-pill {{ $item->sidang_status }}">
                                        {{ ['scheduled' => 'Terjadwal', 'submitted' => 'Diajukan', 'completed' => 'Selesai', 'rejected' => 'Ditolak'][$item->sidang_status] ?? $item->sidang_status }}
                                    </span>
                                    @if ($item->sidang_grade)
                                        <small><strong>Nilai: {{ $item->sidang_grade }}</strong></small>
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
                                Tidak ada mahasiswa bimbingan yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
