@extends('layouts.student')

@section('title', 'Eksplorasi Perusahaan & Kuota KP')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 700; color: var(--text-main); margin: 0; line-height: 1.3;">
            Eksplorasi Perusahaan & Ketersediaan Kuota
        </h2>
        <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px; margin-bottom: 0;">
            Cari instansi referensi tempat Kuliah Praktik, pantau status pendaftar dan penerimaan secara <em>real-time</em>, serta pelajari rekam jejak pengalaman alumni.
        </p>
    </div>

    <a href="{{ route('mahasiswa.applications.create') }}" class="btn-brand">
        <iconify-icon icon="lucide:file-plus" width="16" height="16"></iconify-icon>
        <span>Ajukan Kesiapan KP</span>
    </a>
</div>

<!-- FILTER & SEARCH BAR -->
<div class="panel" style="margin-bottom: 24px; padding: 18px 22px; border-radius: 16px;">
    <form action="{{ route('mahasiswa.companies.index') }}" method="GET" style="display: flex; gap: 14px; flex-wrap: wrap; align-items: center; justify-content: space-between;">
        <div style="position: relative; flex: 1; min-width: 280px;">
            <iconify-icon icon="lucide:search" width="16" height="16" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></iconify-icon>
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari berdasarkan nama instansi, kota, atau alamat..."
                style="width: 100%; padding: 10px 14px 10px 38px; border: 1px solid var(--border-color); border-radius: 25px; font-size: 13px; background: #f8fafc;"
            >
        </div>

        <div style="display: flex; gap: 8px; align-items: center;">
            <a
                href="{{ route('mahasiswa.companies.index', ['search' => $search, 'status' => 'all']) }}"
                class="{{ $filterStatus === 'all' ? 'btn-brand' : 'btn-outline-custom' }}"
                style="border-radius: 20px; font-size: 12px; padding: 7px 16px;"
            >
                Semua
            </a>
            <a
                href="{{ route('mahasiswa.companies.index', ['search' => $search, 'status' => 'available']) }}"
                class="{{ $filterStatus === 'available' ? 'btn-brand' : 'btn-outline-custom' }}"
                style="border-radius: 20px; font-size: 12px; padding: 7px 16px;"
            >
                Kuota Tersedia
            </a>
            <a
                href="{{ route('mahasiswa.companies.index', ['search' => $search, 'status' => 'full']) }}"
                class="{{ $filterStatus === 'full' ? 'btn-brand' : 'btn-outline-custom' }}"
                style="border-radius: 20px; font-size: 12px; padding: 7px 16px;"
            >
                Kuota Terpenuhi
            </a>
        </div>
    </form>
</div>

<!-- COMPANIES GRID -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 320px), 1fr)); gap: 20px; align-items: stretch;">
    @forelse ($companies as $company)
        @php
            $q = $company->quota_info;
            $expCount = $company->validatedExperiences->count();
        @endphp

        <div class="panel" style="display: flex; flex-direction: column; padding: 22px 24px; border-radius: 16px; border-top: 4px solid {{ $q['is_full'] ? '#f43f5e' : ($q['individual_count'] > 0 ? '#f59e0b' : '#3b82f6') }};">
            
            <!-- CARD TOP ROW: LOCATION & STATUS BADGE -->
            <div style="display: flex; justify-content: space-between; align-items: center; gap: 8px; margin-bottom: 10px;">
                <div style="font-size: 11.5px; color: #64748b; font-weight: 500; display: inline-flex; align-items: center; gap: 5px;">
                    <iconify-icon icon="lucide:map-pin" width="13" height="13" style="color: #64748b;"></iconify-icon>
                    <span>{{ $company->city }}</span>
                </div>

                @if ($q['is_full'])
                    <span style="font-size: 11px; font-weight: 500; color: #991b1b; background: #fef2f2; border: 1px solid #fecaca; padding: 3px 10px; border-radius: 12px; white-space: nowrap;">
                        Tempat Terisi Penuh
                    </span>
                @elseif ($q['individual_count'] > 0)
                    <span style="font-size: 11px; font-weight: 500; color: #92400e; background: #fffbeb; border: 1px solid #fde68a; padding: 3px 10px; border-radius: 12px; white-space: nowrap;">
                        Terisi {{ $q['individual_count'] }}/3
                    </span>
                @else
                    <span style="font-size: 11px; font-weight: 500; color: #166534; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 3px 10px; border-radius: 12px; white-space: nowrap;">
                        Kuota Tersedia
                    </span>
                @endif
            </div>

            <!-- COMPANY NAME & ADDRESS -->
            <h3 style="font-size: 15.5px; font-weight: 600; color: var(--text-main); margin: 0 0 6px 0; line-height: 1.4; min-height: 44px; display: flex; align-items: flex-start;">
                <a href="{{ route('mahasiswa.companies.show', $company->id) }}" style="color: inherit; text-decoration: none;">
                    {{ $company->name }}
                </a>
            </h3>

            <p style="font-size: 12px; color: #64748b; font-weight: 400; line-height: 1.5; margin: 0 0 16px 0; min-height: 36px;">
                {{ Str::limit($company->address, 85) }}
            </p>

            <!-- STATISTIK PENDAFTARAN & PENERIMAAN -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; margin-bottom: 16px;">
                <!-- Row Info -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; font-size: 12px;">
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <span style="color: #64748b; font-weight: 400;">Diterima:</span>
                        <span style="font-weight: 600; color: {{ $q['is_full'] ? '#b91c1c' : '#0f172a' }};">
                            {{ $q['has_group'] ? '1 Kelompok' : $q['individual_count'] . ' / 3 Orang' }}
                        </span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <span style="color: #64748b; font-weight: 400;">Pendaftar:</span>
                        <span style="font-weight: 600; color: #2563eb;">{{ $q['pending_count'] }} Mengajukan</span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div style="height: 5px; background: #e2e8f0; border-radius: 3px; overflow: hidden; margin-bottom: 10px;">
                    <div style="height: 100%; width: {{ $q['capacity_percent'] }}%; background: {{ $q['is_full'] ? '#ef4444' : ($q['individual_count'] > 0 ? '#f59e0b' : '#3b82f6') }};"></div>
                </div>

                <!-- Keterangan Mahasiswa / Status -->
                <div style="font-size: 11.5px; line-height: 1.45; min-height: 34px;">
                    @if (!empty($q['occupants']))
                        <div style="color: #334155;">
                            <span style="color: #64748b; font-weight: 400;">Fix Terisi:</span>
                            <span style="font-weight: 500; color: #1e293b;">{{ implode(', ', $q['occupants']) }}</span>
                        </div>
                    @else
                        <div style="color: #059669; font-weight: 400;">
                            Belum ada mahasiswa yang diterima (kuota masih terbuka penuh).
                        </div>
                    @endif
                </div>
            </div>

            <!-- ALUMNI EXPERIENCE COUNTER -->
            <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: #64748b; font-weight: 400; margin-bottom: 18px;">
                <iconify-icon icon="lucide:message-square-text" width="14" height="14" style="color: #94a3b8;"></iconify-icon>
                @if ($expCount > 0)
                    <span style="color: #0f172a; font-weight: 500;">{{ $expCount }} Ulasan Pengalaman Alumni</span>
                @else
                    <span>Belum ada ulasan alumni</span>
                @endif
            </div>

            <!-- ACTION BUTTONS -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: auto; padding-top: 14px; border-top: 1px solid #f1f5f9;">
                <a
                    href="{{ route('mahasiswa.companies.show', $company->id) }}"
                    class="btn-outline-custom"
                    style="justify-content: center; padding: 9px 12px; font-size: 12px; border-radius: 20px;"
                >
                    Detail & Ulasan
                </a>

                @if ($q['is_full'])
                    <button
                        type="button"
                        class="btn-brand disabled"
                        disabled
                        title="Kuota tempat KP di instansi ini sudah terisi penuh oleh mahasiswa yang diterima."
                        style="width: 100%; justify-content: center; display: inline-flex; align-items: center; padding: 9px 12px; font-size: 12px; font-weight: 500; border-radius: 20px; background: #f1f5f9; color: #94a3b8 !important; border: 1px solid #e2e8f0; cursor: not-allowed; box-shadow: none;"
                    >
                        Tempat Terisi
                    </button>
                @else
                    <a
                        href="{{ route('mahasiswa.applications.create', ['company_id' => $company->id, 'company_name' => $company->name]) }}"
                        class="btn-brand"
                        style="justify-content: center; padding: 9px 12px; font-size: 12px; border-radius: 20px;"
                    >
                        Daftar ke Sini
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="panel" style="grid-column: 1 / -1; text-align: center; padding: 48px 24px; border-radius: 16px;">
            <div style="margin-bottom: 12px;">
                <iconify-icon icon="lucide:search-x" width="38" height="38" style="color: #94a3b8;"></iconify-icon>
            </div>
            <h3 style="font-size: 16px; font-weight: 600; color: var(--text-main);">Tidak Ditemukan Perusahaan</h3>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">
                Coba sesuaikan kata kunci pencarian atau filter status ketersediaan kuota.
            </p>
            <a href="{{ route('mahasiswa.companies.index') }}" class="btn-outline-custom" style="margin-top: 14px; border-radius: 20px; display: inline-flex;">
                Reset Pencarian
            </a>
        </div>
    @endforelse
</div>
@endsection
