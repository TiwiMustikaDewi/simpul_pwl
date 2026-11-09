@extends('layouts.dosen')

@section('title', 'Dashboard Dosen Pembimbing')

@section('content')

    @php
        $statusLabel = [
            'in_progress' => 'Sedang berjalan',
            'approved'    => 'Disetujui',
            'completed'   => 'Selesai',
            'pending'     => 'Menunggu',
            'rejected'    => 'Ditolak',
        ];
        $totalKp = max(array_sum($statusCounts), 1);
    @endphp

    <div class="page-top">
        <div>
            <div class="breadcrumb">SIMPUL / Dashboard Dosen</div>
            <h1>Dashboard Dosen Pembimbing</h1>
            <p>Monitoring bimbingan mahasiswa, verifikasi logbook harian, review laporan, dan evaluasi sidang KP.</p>
        </div>

        <div class="period-badge">▣ Periode KP {{ $period }}</div>
    </div>

    @if (session('success'))
        <div class="notice notice-success" role="status">{{ session('success') }}</div>
    @endif

    <div class="dashboard-grid">

        <!-- KOLOM UTAMA -->
        <div class="main-column">

            <!-- WELCOME BANNER -->
            <section class="welcome-banner">
                <div class="eyebrow">DOSEN PEMBIMBING · UNIVERSITAS LAMPUNG</div>

                <h2>
                    Selamat datang,<br>
                    <span>{{ auth()->user()->name }}!</span>
                </h2>

                <p class="welcome-text">
                    NIP: <strong>{{ $supervisor->nip }}</strong> · Departemen: <strong>{{ $supervisor->department }}</strong><br>
                    Pantau aktivitas mahasiswa bimbingan, berikan catatan atau persetujuan logbook kegiatan, serta lakukan review laporan dan penilaian sidang.
                </p>

                <div class="form-actions">
                    <a href="{{ route('dosen.logs.index', ['status' => 'submitted']) }}" class="btn btn-primary">
                        Tinjau Logbook
                        @if ($stats['pending_logs'] > 0)
                            <span class="count-chip">{{ $stats['pending_logs'] }}</span>
                        @endif
                        <span>→</span>
                    </a>
                    <a href="{{ route('dosen.students.index') }}" class="btn btn-outline">
                        Semua Mahasiswa Bimbingan
                    </a>
                </div>
            </section>

            <!-- STATISTIK -->
            <section>
                <div class="section-heading">
                    <div>
                        <h2>Ringkasan Bimbingan</h2>
                        <p>Aktivitas dan tanggung jawab bimbingan Kuliah Praktik Anda.</p>
                    </div>
                </div>

                <div class="stat-grid">
                    <a href="{{ route('dosen.students.index') }}" class="stat-card blue searchable-card">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <polyline points="17 11 19 13 23 9"></polyline>
                            </svg>
                        </div>
                        <div class="stat-number">{{ number_format($stats['active_students']) }}</div>
                        <div class="stat-label">Mahasiswa Aktif</div>
                        <div class="stat-hint">Dari {{ $stats['total_students'] }} total bimbingan</div>
                    </a>

                    <a href="{{ route('dosen.logs.index', ['status' => 'submitted']) }}" class="stat-card yellow searchable-card">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div class="stat-number">{{ number_format($stats['pending_logs']) }}</div>
                        <div class="stat-label">Logbook Menunggu</div>
                        <div class="stat-hint">Perlu verifikasi dosen</div>
                    </a>

                    <a href="{{ route('dosen.reports.index', ['status' => 'submitted']) }}" class="stat-card red searchable-card">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                        </div>
                        <div class="stat-number">{{ number_format($stats['pending_reports']) }}</div>
                        <div class="stat-label">Laporan Akhir</div>
                        <div class="stat-hint">Menunggu umpan balik</div>
                    </a>

                    <a href="{{ route('dosen.sidang.index') }}" class="stat-card green searchable-card">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <div class="stat-number">{{ number_format($stats['scheduled_sidang']) }}</div>
                        <div class="stat-label">Sidang Terjadwal</div>
                        <div class="stat-hint">Siap dinilai &amp; dievaluasi</div>
                    </a>
                </div>
            </section>

            <!-- LOGBOOK PERLU TINDAKAN -->
            <section id="perlu-tindakan">
                <div class="section-heading">
                    <div>
                        <h2>Logbook Perlu Ditinjau</h2>
                        <p>Catatan kegiatan mahasiswa yang baru diajukan dan membutuhkan respon Anda.</p>
                    </div>
                    <a href="{{ route('dosen.logs.index', ['status' => 'submitted']) }}" class="text-link">Lihat Semua ({{ $stats['pending_logs'] }}) →</a>
                </div>

                <div class="panel">
                    @forelse ($pendingLogs as $log)
                        <div class="list-row searchable-card">
                            <div class="mini-avatar">
                                {{ strtoupper(mb_substr($log->student_name, 0, 1)) }}
                            </div>

                            <div class="row-body">
                                <div class="row-title">{{ $log->student_name }} ({{ $log->npm }})</div>
                                <div class="row-meta">
                                    {{ \Carbon\Carbon::parse($log->date)->locale('id')->translatedFormat('d M Y') }}
                                    · <strong>{{ $log->activity }}</strong>
                                </div>
                            </div>

                            <a href="{{ route('dosen.logs.index', ['student_id' => $log->internship_id]) }}" class="btn btn-primary btn-sm">Periksa →</a>
                        </div>
                    @empty
                        <div class="empty-state">
                            <strong>Tidak ada logbook menunggu</strong>
                            Semua logbook kegiatan mahasiswa bimbingan telah ditinjau dengan baik.
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- MENU LAYANAN PEMBIMBING -->
            <section>
                <div class="section-heading">
                    <div>
                        <h2>Menu Layanan Pembimbing</h2>
                        <p>Akses cepat ke seluruh fitur pengelolaan bimbingan Kuliah Praktik.</p>
                    </div>
                </div>

                <div class="service-grid">
                    <a href="{{ route('dosen.students.index') }}" class="service-card blue searchable-card">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <h3>Mahasiswa Bimbingan</h3>
                        <p>Lihat daftar mahasiswa, profil instansi tempat KP, dan rincian progres bimbingan.</p>
                        <span class="service-arrow">→</span>
                    </a>

                    <a href="{{ route('dosen.logs.index') }}" class="service-card yellow searchable-card">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                <path d="M9 14l2 2 4-4"></path>
                            </svg>
                        </div>
                        <h3>Pemeriksaan Logbook</h3>
                        <p>Pantau logbook harian, berikan persetujuan, atau minta revisi disertai catatan dosen.</p>
                        <span class="service-arrow">→</span>
                    </a>

                    <a href="{{ route('dosen.reports.index') }}" class="service-card red searchable-card">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <line x1="10" y1="9" x2="8" y2="9"></line>
                            </svg>
                        </div>
                        <h3>Laporan Akhir KP</h3>
                        <p>Periksa draf laporan akhir, beri feedback revisi, dan berikan persetujuan laporan.</p>
                        <span class="service-arrow">→</span>
                    </a>

                    <a href="{{ route('dosen.sidang.index') }}" class="service-card green searchable-card">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                            </svg>
                        </div>
                        <h3>Sidang &amp; Penilaian</h3>
                        <p>Lihat jadwal &amp; ruang sidang, berikan nilai akhir serta catatan evaluasi sidang KP.</p>
                        <span class="service-arrow">→</span>
                    </a>
                </div>
            </section>

        </div>

        <!-- KOLOM KANAN -->
        <aside class="right-column">

            <!-- DISTRIBUSI STATUS -->
            <section class="panel">
                <div class="panel-title">
                    <h2>Status Mahasiswa</h2>
                    <span class="small-badge">{{ $stats['total_students'] }} Mahasiswa</span>
                </div>

                @if (array_sum($statusCounts) === 0)
                    <div class="empty-state">
                        <strong>Belum ada mahasiswa bimbingan</strong>
                        Admin jurusan akan menetapkan Anda sebagai pembimbing pada kelompok atau mahasiswa KP.
                    </div>
                @else
                    <div class="bar-list">
                        @foreach ($statusLabel as $key => $label)
                            @php $count = $statusCounts[$key] ?? 0; @endphp
                            <div>
                                <div class="bar-top">
                                    <span>{{ $label }}</span>
                                    <span>{{ $count }}</span>
                                </div>
                                <div class="bar-track">
                                    <div
                                        class="bar-fill {{ $key }}"
                                        style="width: {{ round($count / $totalKp * 100) }}%"
                                    ></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- LAPORAN MENUNGGU TINJAUAN -->
            <section class="panel">
                <div class="panel-title">
                    <h2>Laporan Menunggu</h2>
                    <a href="{{ route('dosen.reports.index') }}" class="text-link">Kelola →</a>
                </div>

                @forelse ($pendingReports as $report)
                    <div class="list-row searchable-card">
                        <div class="mini-avatar">
                            {{ strtoupper(mb_substr($report->student_name, 0, 1)) }}
                        </div>

                        <div class="row-body">
                            <div class="row-title">{{ $report->student_name }}</div>
                            <div class="row-meta">{{ $report->title }}</div>
                        </div>

                        <a href="{{ route('dosen.reports.index') }}" class="btn btn-outline btn-sm">Review</a>
                    </div>
                @empty
                    <div class="empty-state">
                        <strong>Tidak ada laporan pending</strong>
                        Laporan akhir yang diunggah mahasiswa bimbingan akan muncul di sini.
                    </div>
                @endforelse
            </section>

            <!-- JADWAL SIDANG MENDATANG -->
            <section class="panel">
                <div class="panel-title">
                    <h2>Jadwal Sidang KP</h2>
                    <a href="{{ route('dosen.sidang.index') }}" class="text-link">Lihat →</a>
                </div>

                @forelse ($upcomingSidang as $sidang)
                    <div class="list-row searchable-card">
                        <div class="mini-avatar">
                            {{ strtoupper(mb_substr($sidang->student_name, 0, 1)) }}
                        </div>

                        <div class="row-body">
                            <div class="row-title">{{ $sidang->student_name }} ({{ $sidang->npm }})</div>
                            <div class="row-meta">
                                @if ($sidang->sidang_date)
                                    {{ \Carbon\Carbon::parse($sidang->sidang_date)->locale('id')->translatedFormat('d M Y, H:i') }}
                                    · {{ $sidang->room ?? 'Ruang TBA' }}
                                @else
                                    Jadwal belum ditentukan admin
                                @endif
                            </div>
                        </div>

                        <span class="status-pill {{ $sidang->status }}">
                            {{ ['scheduled' => 'Terjadwal', 'submitted' => 'Diajukan', 'completed' => 'Selesai'][$sidang->status] ?? $sidang->status }}
                        </span>
                    </div>
                @empty
                    <div class="empty-state">
                        <strong>Belum ada jadwal sidang</strong>
                        Sidang mahasiswa bimbingan yang dijadwalkan admin akan tampil di sini.
                    </div>
                @endforelse
            </section>

        </aside>

    </div>

@endsection
