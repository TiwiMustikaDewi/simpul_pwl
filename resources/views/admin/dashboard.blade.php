@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    @php
        $statusLabel = [
            'pending'     => 'Menunggu verifikasi',
            'approved'    => 'Disetujui',
            'in_progress' => 'Sedang berjalan',
            'completed'   => 'Selesai',
            'rejected'    => 'Ditolak',
        ];
        $totalKp = max(array_sum($statusCounts), 1);
    @endphp

    <div class="page-top">
        <div>
            <div class="breadcrumb">SIMPUL / Dashboard Admin</div>
            <h1>Dashboard Admin Jurusan</h1>
            <p>Ringkasan pengelolaan dan pemantauan Kuliah Praktik mahasiswa.</p>
        </div>

        <div class="period-badge">▣ Periode KP {{ $period }}</div>
    </div>

    <div class="dashboard-grid">

        <!-- KOLOM UTAMA -->
        <div class="main-column">

            <!-- WELCOME -->
            <section class="welcome-banner">
                <div class="eyebrow">ADMIN JURUSAN · UNIVERSITAS LAMPUNG</div>

                <h2>
                    Selamat datang,<br>
                    <span>{{ auth()->user()->name }}!</span>
                </h2>

                <p class="welcome-text">
                    Kelola data mahasiswa, verifikasi pengajuan dan dokumen,
                    tetapkan dosen pembimbing, serta pantau pelaksanaan
                    Kuliah Praktik melalui SIMPUL.
                </p>

                <a href="#perlu-tindakan" class="btn btn-primary">
                    Tinjau Pengajuan
                    @if ($stats['pending'] > 0)
                        <span class="count-chip">{{ $stats['pending'] }}</span>
                    @endif
                    <span>→</span>
                </a>
            </section>

            <!-- RINGKASAN -->
            <section>
                <div class="section-heading">
                    <div>
                        <h2>Ringkasan Data</h2>
                        <p>Gambaran singkat data yang kamu kelola.</p>
                    </div>
                </div>

                <div class="stat-grid">
                    <div class="stat-card blue searchable-card">
                        <div class="service-icon">🎓</div>
                        <div class="stat-number">{{ number_format($stats['students']) }}</div>
                        <div class="stat-label">Mahasiswa</div>
                        <div class="stat-hint">Terdaftar di sistem</div>
                    </div>

                    <div class="stat-card red searchable-card">
                        <div class="service-icon">👩‍🏫</div>
                        <div class="stat-number">{{ number_format($stats['supervisors']) }}</div>
                        <div class="stat-label">Dosen Pembimbing</div>
                        <div class="stat-hint">{{ $stats['unassigned'] }} KP belum punya pembimbing</div>
                    </div>

                    <div class="stat-card green searchable-card">
                        <div class="service-icon">🏢</div>
                        <div class="stat-number">{{ number_format($stats['companies']) }}</div>
                        <div class="stat-label">Perusahaan / Instansi</div>
                        <div class="stat-hint">Tempat KP tersedia</div>
                    </div>

                    <div class="stat-card yellow searchable-card">
                        <div class="service-icon">📋</div>
                        <div class="stat-number">{{ number_format($stats['pending']) }}</div>
                        <div class="stat-label">Menunggu Verifikasi</div>
                        <div class="stat-hint">Pengajuan perlu ditinjau</div>
                    </div>
                </div>
            </section>

            <!-- PERLU TINDAKAN -->
            <section id="perlu-tindakan">
                <div class="section-heading">
                    <div>
                        <h2>Perlu Tindakan</h2>
                        <p>Pengajuan KP terbaru yang menunggu verifikasi.</p>
                    </div>

                    <a href="{{ route('admin.applications.index') }}" class="text-link">Lihat Semua →</a>
                </div>

                <div class="panel">
                    @forelse ($pending as $item)
                        <div class="list-row searchable-card">
                            <div class="mini-avatar">
                                {{ strtoupper(mb_substr($item->student_name, 0, 1)) }}
                            </div>

                            <div class="row-body">
                                <div class="row-title">{{ $item->student_name }}</div>
                                <div class="row-meta">
                                    {{ $item->company_name }}
                                    · {{ $item->type === 'group' ? 'Kelompok' : 'Individu' }}
                                    · {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->diffForHumans() }}
                                </div>
                            </div>

                            <a href="{{ route('admin.applications.index') }}" class="btn btn-primary btn-sm">Tinjau →</a>
                        </div>
                    @empty
                        <div class="empty-state">
                            <strong>Belum ada pengajuan</strong>
                            Pengajuan mahasiswa yang perlu diverifikasi akan muncul di sini.
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- KELOLA LAYANAN -->
            <section>
                <div class="section-heading">
                    <div>
                        <h2>Kelola Layanan</h2>
                        <p>Pilih layanan yang ingin kamu kelola.</p>
                    </div>
                </div>

                <div class="service-grid">
                    <a href="{{ route('admin.applications.index') }}" class="service-card blue searchable-card">
                        <div class="service-icon">📋</div>
                        <h3>Verifikasi Pengajuan</h3>
                        <p>Periksa dokumen, beri catatan perbaikan, dan setujui pengajuan KP.</p>
                        <span class="service-arrow">→</span>
                    </a>

                    <a href="{{ route('admin.companies.index') }}" class="service-card red searchable-card">
                        <div class="service-icon">🏢</div>
                        <h3>Data Perusahaan</h3>
                        <p>Kelola data perusahaan atau instansi tempat KP beserta kuota periode.</p>
                        <span class="service-arrow">→</span>
                    </a>

                    <a href="{{ route('admin.groups.index') }}" class="service-card green searchable-card">
                        <div class="service-icon">👥</div>
                        <h3>Kelompok &amp; Pembimbing</h3>
                        <p>Atur kelompok KP dan tetapkan dosen pembimbing.</p>
                        <span class="service-arrow">→</span>
                    </a>

                    <a href="{{ route('admin.sidang.index') }}" class="service-card yellow searchable-card">
                        <div class="service-icon">🗓️</div>
                        <h3>Sidang KP</h3>
                        <p>Kelola pengajuan sidang dan atur jadwal pelaksanaan.</p>
                        <span class="service-arrow">→</span>
                    </a>
                </div>
            </section>
        </div>

        <!-- KOLOM KANAN -->
        <aside class="right-column">

            <section class="panel">
                <div class="panel-title">
                    <h2>Status KP</h2>
                    <span class="small-badge">Periode {{ $period }}</span>
                </div>

                @if (array_sum($statusCounts) === 0)
                    <div class="empty-state">
                        <strong>Belum ada data KP</strong>
                        Distribusi status tampil setelah mahasiswa mengajukan KP.
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

            <section class="panel">
                <div class="panel-title">
                    <h2>Sidang KP</h2>
                    <a href="{{ route('admin.sidang.index') }}" class="text-link">Kelola →</a>
                </div>

                @forelse ($sidang as $item)
                    <div class="list-row searchable-card">
                        <div class="mini-avatar">
                            {{ strtoupper(mb_substr($item->student_name, 0, 1)) }}
                        </div>

                        <div class="row-body">
                            <div class="row-title">{{ $item->student_name }}</div>
                            <div class="row-meta">
                                @if ($item->sidang_date)
                                    {{ \Carbon\Carbon::parse($item->sidang_date)->locale('id')->translatedFormat('d M Y, H:i') }}
                                @else
                                    Jadwal belum ditetapkan
                                @endif
                            </div>
                        </div>

                        <span class="status-pill {{ $item->status }}">
                            {{ $item->status === 'scheduled' ? 'Terjadwal' : 'Diajukan' }}
                        </span>
                    </div>
                @empty
                    <div class="empty-state">
                        <strong>Belum ada sidang</strong>
                        Pengajuan sidang mahasiswa akan tampil di sini.
                    </div>
                @endforelse
            </section>

            <section class="panel">
                <div class="panel-title">
                    <h2>Validasi Pengalaman</h2>
                    <a href="{{ route('admin.experiences.index') }}" class="text-link">Kelola →</a>
                </div>

                @forelse ($experiences as $item)
                    <div class="list-row searchable-card">
                        <div class="mini-avatar">
                            {{ strtoupper(mb_substr($item->student_name, 0, 1)) }}
                        </div>

                        <div class="row-body">
                            <div class="row-title">{{ $item->student_name }}</div>
                            <div class="row-meta">{{ $item->position }} · {{ $item->company_name }}</div>
                        </div>

                        <a href="{{ route('admin.experiences.index') }}" class="btn btn-outline btn-sm">Validasi</a>
                    </div>
                @empty
                    <div class="empty-state">
                        <strong>Tidak ada antrean</strong>
                        Pengalaman KP yang dikirim mahasiswa akan muncul di sini sebelum dijadikan referensi.
                    </div>
                @endforelse
            </section>

        </aside>
    </div>

@endsection

@push('scripts')
<script>
    // Pencarian sederhana: menyaring kartu dan baris di dashboard.
    const searchInput = document.getElementById('dashboardSearch');
    const searchables = document.querySelectorAll('.searchable-card');

    searchInput.addEventListener('input', function () {
        const keyword = this.value.trim().toLowerCase();

        searchables.forEach(function (item) {
            const match = item.textContent.toLowerCase().includes(keyword);
            item.style.display = match ? '' : 'none';
        });
    });
</script>
@endpush