@extends('layouts.student')

@section('title', 'Eksplorasi Perusahaan & Kuota KP')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 700; color: var(--text);">Eksplorasi Perusahaan & Ketersediaan Kuota</h2>
        <p style="font-size: 13px; color: var(--muted); margin-top: 4px;">
            Cari instansi referensi tempat Kuliah Praktik, pantau kuota penerimaan secara <em>real-time</em>, dan pelajari rekam jejak pengalaman alumni.
        </p>
    </div>

    <a href="{{ route('mahasiswa.applications.create') }}" class="btn-brand">
        <span>✍</span> Ajukan Kesiapan KP
    </a>
</div>

<!-- FILTER & SEARCH BAR -->
<div class="panel" style="margin-bottom: 24px; padding: 16px 20px;">
    <form action="{{ route('mahasiswa.companies.index') }}" method="GET" style="display: flex; gap: 14px; flex-wrap: wrap; align-items: center;">
        <div style="flex: 1; min-width: 260px;">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari berdasarkan nama perusahaan, kota, atau alamat..."
                style="width: 100%; padding: 10px 16px; border: 1px solid var(--border); border-radius: 25px; font-size: 13px; background: #f8fbff;"
            >
        </div>

        <div style="display: flex; gap: 8px;">
            <a
                href="{{ route('mahasiswa.companies.index', ['search' => $search, 'status' => 'all']) }}"
                class="btn {{ $filterStatus === 'all' ? 'btn-brand' : 'btn-outline' }}"
                style="border-radius: 20px; font-size: 12px; padding: 7px 14px;"
            >
                Semua
            </a>
            <a
                href="{{ route('mahasiswa.companies.index', ['search' => $search, 'status' => 'available']) }}"
                class="btn {{ $filterStatus === 'available' ? 'btn-brand' : 'btn-outline' }}"
                style="border-radius: 20px; font-size: 12px; padding: 7px 14px;"
            >
                Kuota Tersedia
            </a>
            <a
                href="{{ route('mahasiswa.companies.index', ['search' => $search, 'status' => 'full']) }}"
                class="btn {{ $filterStatus === 'full' ? 'btn-brand' : 'btn-outline' }}"
                style="border-radius: 20px; font-size: 12px; padding: 7px 14px;"
            >
                Kuota Terpenuhi
            </a>
        </div>
    </form>
</div>

<!-- COMPANIES GRID -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 20px;">
    @forelse ($companies as $company)
        @php
            $q = $company->quota_info;
            $expCount = $company->validatedExperiences->count();
        @endphp

        <div class="panel" style="display: flex; flex-direction: column; justify-content: space-between; border-top: 4px solid {{ $q['is_full'] ? '#f43f5e' : ($q['individual_count'] > 0 ? '#f59e0b' : '#3b82f6') }};">
            <div>
                <!-- CARD HEADER & BADGE -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; margin-bottom: 12px;">
                    <div>
                        <div style="font-size: 11px; font-weight: 600; color: var(--muted); text-transform: uppercase;">
                            📍 {{ $company->city }}
                        </div>
                        <h3 style="font-size: 16px; font-weight: 700; color: var(--text); margin-top: 2px; line-height: 1.3;">
                            <a href="{{ route('mahasiswa.companies.show', $company->id) }}" style="color: inherit;">
                                {{ $company->name }}
                            </a>
                        </h3>
                    </div>

                    <span class="badge-quota {{ $q['badge_variant'] }}" style="flex-shrink: 0;">
                        {{ $q['status_label'] }}
                    </span>
                </div>

                <p style="font-size: 12px; color: var(--muted); line-height: 1.5; margin-bottom: 14px;">
                    {{ Str::limit($company->address, 95) }}
                </p>

                <!-- QUOTA PROGRESS & DETAIL STATUS -->
                <div style="background: #f8fbff; border: 1px solid var(--border); border-radius: 10px; padding: 12px; margin-bottom: 14px;">
                    <div style="display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 6px;">
                        <span style="font-weight: 600; color: var(--text);">Kapasitas Periode Berjalan</span>
                        <span style="font-weight: 700; color: {{ $q['is_full'] ? '#b91c1c' : '#1d4ed8' }};">
                            {{ $q['has_group'] ? '1 Kelompok Terisi' : ($q['individual_count'] . ' / 3 Individu Terisi') }}
                        </span>
                    </div>

                    <!-- PROGRESS BAR -->
                    <div style="height: 6px; background: #e2e8f0; border-radius: 4px; overflow: hidden; margin-bottom: 10px;">
                        <div style="height: 100%; width: {{ $q['capacity_percent'] }}%; background: {{ $q['is_full'] ? '#ef4444' : ($q['individual_count'] > 0 ? '#f59e0b' : '#3b82f6') }}; transition: width .3s;"></div>
                    </div>

                    <!-- KETERANGAN MAHASISWA YANG FIX DITERIMA / TERDAFTAR -->
                    @if (!empty($q['occupants']))
                        <div style="font-size: 11.5px; color: var(--text); line-height: 1.4;">
                            <span style="color: var(--muted);">Fix Terisi Oleh:</span>
                            @if ($q['has_group'])
                                <div style="font-weight: 600; color: #1e3a8a; margin-top: 2px;">
                                    👥 {{ $q['occupants'][0] }}
                                </div>
                            @else
                                <div style="margin-top: 3px; display: flex; flex-direction: column; gap: 2px;">
                                    @foreach ($q['occupants'] as $idx => $occName)
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #3b82f6;"></span>
                                            <strong>{{ $occName }}</strong> (Mahasiswa {{ $idx + 1 }})
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div style="font-size: 11px; color: #059669; font-weight: 500;">
                            ✓ Belum ada mahasiswa yang terdaftar di instansi ini.
                        </div>
                    @endif

                    @if ($q['pending_count'] > 0)
                        <div style="margin-top: 8px; font-size: 10.5px; color: #b45309; background: #fffbeb; padding: 4px 8px; border-radius: 4px;">
                            ⏳ <em>Terdapat {{ $q['pending_count'] }} pengajuan sedang menunggu verifikasi admin.</em>
                        </div>
                    @endif
                </div>

                <!-- ALUMNI EXPERIENCE COUNTER -->
                <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; margin-bottom: 16px;">
                    <span>⭐</span>
                    @if ($expCount > 0)
                        <span style="color: #047857; font-weight: 600;">{{ $expCount }} Rekam Jejak Pengalaman Alumni</span>
                    @else
                        <span style="color: var(--muted);">Belum ada ulasan alumni</span>
                    @endif
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div style="display: flex; gap: 10px; align-items: center; padding-top: 14px; border-top: 1px solid var(--border);">
                <a
                    href="{{ route('mahasiswa.companies.show', $company->id) }}"
                    class="btn btn-outline"
                    style="flex: 1; text-align: center; border-radius: 20px; font-size: 12px; padding: 8px 12px;"
                >
                    Lihat Review & Profil
                </a>

                @if ($q['is_full'])
                    <button
                        type="button"
                        class="btn-brand disabled"
                        disabled
                        title="Kuota instansi ini telah terpenuhi untuk periode berjalan."
                        style="flex: 1; text-align: center; font-size: 12px; padding: 8px 12px;"
                    >
                        Kuota Penuh
                    </button>
                @else
                    <a
                        href="{{ route('mahasiswa.applications.create', ['company_id' => $company->id]) }}"
                        class="btn-brand"
                        style="flex: 1; text-align: center; font-size: 12px; padding: 8px 12px;"
                    >
                        Daftar ke Sini →
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="panel" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
            <div style="font-size: 32px; margin-bottom: 10px;">🔍</div>
            <h3 style="font-size: 16px; font-weight: 700;">Tidak Ditemukan Perusahaan</h3>
            <p style="font-size: 13px; color: var(--muted); margin-top: 4px;">
                Coba sesuaikan kata kunci pencarian atau filter status ketersediaan kuota.
            </p>
            <a href="{{ route('mahasiswa.companies.index') }}" class="btn btn-outline" style="margin-top: 14px; border-radius: 20px;">
                Reset Pencarian
            </a>
        </div>
    @endforelse
</div>
@endsection
