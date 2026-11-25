@extends('layouts.student')

@section('title', 'Ulasan Pengalaman Alumni KP')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 700; color: var(--text-main); margin: 0; line-height: 1.3;">
            Ulasan Pengalaman Alumni Kuliah Praktik
        </h2>
        <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px; margin-bottom: 0;">
            Eksplorasi pengalaman nyata, proses seleksi, dan keterampilan yang diasah oleh rekan mahasiswa dan alumni terdahulu di berbagai instansi mitra.
        </p>
    </div>

    @if ($completedInternship)
        <a href="{{ route('mahasiswa.experiences.create') }}" class="btn-brand">
            <iconify-icon icon="lucide:star" width="16" height="16"></iconify-icon>
            <span>{{ $myExperience ? 'Perbarui Ulasan Anda' : 'Tulis Pengalaman KP' }}</span>
        </a>
    @else
        <a href="{{ route('mahasiswa.experiences.create') }}" class="btn-outline-custom" title="Cek status pengisian ulasan Anda">
            <iconify-icon icon="lucide:pen-tool" width="15" height="15" style="color: #2563eb;"></iconify-icon>
            <span>Tulis Pengalaman Saya</span>
        </a>
    @endif
</div>

<!-- NOTICE STATUS MAHASISWA -->
@if ($completedInternship)
    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 14px; padding: 18px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: #d1fae5; color: #059669; display: grid; place-items: center; flex-shrink: 0;">
                <iconify-icon icon="lucide:award" width="20" height="20"></iconify-icon>
            </div>
            <div>
                <div style="font-weight: 600; font-size: 14px; color: #065f46;">
                    Selamat! Anda telah menyelesaikan KP di {{ $completedInternship->company->name }}.
                </div>
                <div style="font-size: 12.5px; color: #047857; margin-top: 2px;">
                    @if ($myExperience)
                        Ulasan Anda telah tersimpan dan membantu adik tingkat menentukan referensi KP mereka.
                    @else
                        Bagikan pengalaman Anda seputar proses seleksi dan suasana kerja untuk membantu adik-adik tingkat.
                    @endif
                </div>
            </div>
        </div>
        <a href="{{ route('mahasiswa.experiences.create') }}" class="btn-brand" style="background: #059669; font-size: 12.5px; padding: 8px 18px;">
            {{ $myExperience ? 'Edit Ulasan Anda' : 'Isi Form Ulasan Sekarang' }}
        </a>
    </div>
@else
    <div style="background: #f0f7ff; border: 1px solid #bfdbfe; border-radius: 14px; padding: 18px 20px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 14px;">
        <div style="width: 36px; height: 36px; border-radius: 10px; background: #dbeafe; color: #1d4ed8; display: grid; place-items: center; flex-shrink: 0; margin-top: 2px;">
            <iconify-icon icon="lucide:info" width="18" height="18"></iconify-icon>
        </div>
        <div style="flex: 1;">
            <div style="font-weight: 600; font-size: 13.5px; color: #1e40af; margin-bottom: 3px;">
                Ingin Berbagi Pengalaman KP Anda?
            </div>
            <p style="font-size: 12.5px; color: #2563eb; line-height: 1.55; margin: 0;">
                Fitur pengisian ulasan akan terbuka secara resmi setelah pelaksanaan Kuliah Praktik Anda selesai dan dinyatakan <strong>Lulus Sidang KP (Tahap 5)</strong>. Saat ini, Anda dapat membaca dan mempelajari seluruh ulasan dari alumni terdahulu di bawah ini sebagai bekal berharga sebelum memulai KP.
            </p>
        </div>
    </div>
@endif

<!-- FILTER & SEARCH BAR -->
<div class="panel" style="margin-bottom: 24px; padding: 18px 22px; border-radius: 16px;">
    <form action="{{ route('mahasiswa.experiences.index') }}" method="GET" style="display: flex; gap: 14px; flex-wrap: wrap; align-items: center; justify-content: space-between;">
        <div style="position: relative; flex: 1; min-width: 280px;">
            <iconify-icon icon="lucide:search" width="16" height="16" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></iconify-icon>
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari berdasarkan posisi, keterampilan, instansi, atau nama alumni..."
                style="width: 100%; padding: 10px 14px 10px 38px; border: 1px solid var(--border-color); border-radius: 25px; font-size: 13px; background: #f8fafc;"
            >
        </div>

        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <select
                name="company_id"
                onchange="this.form.submit()"
                style="padding: 10px 16px; border: 1px solid var(--border-color); border-radius: 20px; font-size: 12.5px; background: #ffffff; color: var(--text-main);"
            >
                <option value="">-- Semua Instansi --</option>
                @foreach ($companies as $comp)
                    <option value="{{ $comp->id }}" {{ $selectedCompanyId == $comp->id ? 'selected' : '' }}>
                        {{ $comp->name }}
                    </option>
                @endforeach
            </select>

            @if ($search || $selectedCompanyId)
                <a href="{{ route('mahasiswa.experiences.index') }}" class="btn-outline-custom" style="border-radius: 20px; font-size: 12px; padding: 7px 14px;">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- EXPERIENCES DIRECTORY GRID -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 320px), 1fr)); gap: 20px; align-items: stretch;">
    @forelse ($experiences as $exp)
        <div class="panel" style="display: flex; flex-direction: column; padding: 22px 24px; border-radius: 16px;">
            
            <!-- CARD HEADER: COMPANY & VALIDATED BADGE -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; margin-bottom: 12px;">
                <div>
                    <div style="font-size: 11.5px; color: #64748b; font-weight: 500; display: inline-flex; align-items: center; gap: 4px;">
                        <iconify-icon icon="lucide:building-2" width="13" height="13" style="color: #64748b;"></iconify-icon>
                        <span>{{ $exp->company->name }}</span>
                    </div>
                    <h3 style="font-size: 15.5px; font-weight: 600; color: var(--text-main); margin: 4px 0 0 0; line-height: 1.4;">
                        {{ $exp->position }}
                    </h3>
                </div>

                <span style="font-size: 10.5px; font-weight: 600; color: #047857; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 3px 9px; border-radius: 12px; white-space: nowrap; display: inline-flex; align-items: center; gap: 4px;">
                    <iconify-icon icon="lucide:check-circle" width="12" height="12"></iconify-icon>
                    <span>Tervalidasi</span>
                </span>
            </div>

            <!-- AUTHOR INFO -->
            <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #64748b; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                <div style="width: 26px; height: 26px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: grid; place-items: center; font-weight: 700; font-size: 11px;">
                    {{ strtoupper(substr($exp->student->user->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <span style="font-weight: 500; color: #0f172a;">{{ $exp->student->user->name }}</span>
                    <span style="color: #94a3b8;">• NPM: {{ $exp->student->npm }}</span>
                </div>
            </div>

            <!-- SKILLS USED -->
            <div style="margin-bottom: 14px;">
                <div style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px;">
                    Keterampilan / Teknologi:
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                    @foreach (explode(',', $exp->skills_used) as $skill)
                        <span style="font-size: 11px; font-weight: 500; color: #1e40af; background: #eff6ff; border: 1px solid #dbeafe; padding: 2px 8px; border-radius: 6px;">
                            {{ trim($skill) }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- PROSES SELEKSI -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px; margin-bottom: 12px;">
                <div style="font-size: 11px; font-weight: 600; color: #334155; margin-bottom: 4px; display: flex; align-items: center; gap: 5px;">
                    <iconify-icon icon="lucide:file-text" width="13" height="13" style="color: #2563eb;"></iconify-icon>
                    <span>Proses Seleksi &amp; Perekrutan:</span>
                </div>
                <p style="font-size: 12px; color: #475569; line-height: 1.5; margin: 0;">
                    {{ Str::limit($exp->selection_process, 120) }}
                </p>
            </div>

            <!-- REVIEW PENGALAMAN -->
            <div style="margin-bottom: 16px;">
                <div style="font-size: 11px; font-weight: 600; color: #334155; margin-bottom: 4px; display: flex; align-items: center; gap: 5px;">
                    <iconify-icon icon="lucide:message-square-quote" width="13" height="13" style="color: #059669;"></iconify-icon>
                    <span>Ulasan Pelaksanaan KP:</span>
                </div>
                <p style="font-size: 12.5px; color: #334155; line-height: 1.55; font-style: italic; margin: 0;">
                    "{{ Str::limit($exp->experience_review, 140) }}"
                </p>
            </div>

            <!-- CARD FOOTER: LINK TO COMPANY PROFILE -->
            <div style="margin-top: auto; padding-top: 14px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11.5px; color: #94a3b8;">
                    {{ $exp->created_at->format('d M Y') }}
                </span>
                <a href="{{ route('mahasiswa.companies.show', $exp->company_id) }}" style="font-size: 12px; color: #2563eb; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;">
                    <span>Lihat Profil Instansi</span>
                    <iconify-icon icon="lucide:chevron-right" width="14" height="14"></iconify-icon>
                </a>
            </div>

        </div>
    @empty
        <div class="panel" style="grid-column: 1 / -1; text-align: center; padding: 48px 24px; border-radius: 16px;">
            <div style="margin-bottom: 12px;">
                <iconify-icon icon="lucide:message-square-off" width="38" height="38" style="color: #94a3b8;"></iconify-icon>
            </div>
            <h3 style="font-size: 16px; font-weight: 600; color: var(--text-main);">Belum Ditemukan Ulasan Alumni</h3>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">
                Belum ada ulasan yang cocok dengan kata kunci pencarian Anda.
            </p>
            <a href="{{ route('mahasiswa.experiences.index') }}" class="btn-outline-custom" style="margin-top: 14px; border-radius: 20px; display: inline-flex;">
                Reset Filter
            </a>
        </div>
    @endforelse
</div>

<div style="margin-top: 24px;">
    {{ $experiences->links() }}
</div>
@endsection
