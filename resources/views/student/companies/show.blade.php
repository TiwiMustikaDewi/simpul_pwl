@extends('layouts.student')

@section('title', $company->name . ' - Detail & Pengalaman KP')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('mahasiswa.companies.index') }}" style="font-size: 13px; color: var(--brand-primary); font-weight: 500; display: inline-flex; align-items: center; gap: 4px; text-decoration: none;">
        <iconify-icon icon="lucide:chevron-left" width="16" height="16"></iconify-icon>
        <span>Kembali ke Katalog Perusahaan</span>
    </a>
</div>

<!-- HEADER PERUSAHAAN & KUOTA -->
<div class="panel" style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;">
        <div>
            <div style="font-size: 11px; font-weight: 600; color: var(--muted); text-transform: uppercase; display: flex; align-items: center; gap: 4px;">
                <iconify-icon icon="lucide:map-pin" width="12" height="12"></iconify-icon>
                <span>{{ $company->city }}</span>
            </div>
            <h1 style="font-size: 24px; font-weight: 800; color: var(--text); margin-top: 4px;">
                {{ $company->name }}
            </h1>
            <p style="font-size: 13px; color: var(--muted); margin-top: 4px; max-width: 650px;">
                {{ $company->address }}
            </p>
        </div>

        <div>
            <span class="badge-quota {{ $quota['badge_variant'] }}" style="font-size: 12px; padding: 6px 14px;">
                {{ $quota['status_label'] }}
            </span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border);">
        <div>
            <span style="font-size: 11px; color: var(--muted);">Contact Person:</span>
            <div style="font-weight: 600; font-size: 13px; color: var(--text);">
                {{ $company->contact_person ?? 'Hubungi Admin Jurusan' }}
            </div>
        </div>
        <div>
            <span style="font-size: 11px; color: var(--muted);">Nomor Telepon:</span>
            <div style="font-weight: 600; font-size: 13px; color: var(--text);">
                {{ $company->phone ?? '-' }}
            </div>
        </div>
        <div>
            <span style="font-size: 11px; color: var(--muted);">Aturan Kuota:</span>
            <div style="font-weight: 600; font-size: 13px; color: var(--text);">
                Maksimal 1 Kelompok atau 3 Individu
            </div>
        </div>
    </div>
</div>

<!-- DETAIL KETERISIAN KUOTA SAAT INI -->
<div class="panel" style="margin-bottom: 24px; border-left: 4px solid {{ $quota['is_full'] ? '#ef4444' : '#3b82f6' }};">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 10px;">
        <h3 style="font-size: 15px; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 8px;">
            <iconify-icon icon="lucide:pie-chart" width="18" height="18" style="color: var(--brand-primary);"></iconify-icon>
            <span>Keterisian Kuota & Status Seleksi Periode Berjalan</span>
        </h3>

        <div style="display: flex; gap: 8px;">
            <span style="font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 20px; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                {{ $quota['has_group'] ? '1 Kelompok Diterima' : $quota['individual_count'] . ' / 3 Diterima' }}
            </span>
            <span style="font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 20px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                {{ $quota['pending_count'] }} Mengajukan
            </span>
        </div>
    </div>

    @if ($quota['has_group'])
        <div style="padding: 14px; background: #eff6ff; border-radius: 8px; font-size: 13px; line-height: 1.5;">
            <strong>Instansi ini telah terpenuhi oleh 1 Kelompok KP yang telah diterima:</strong>
            <div style="margin-top: 4px; color: #1e40af; display: flex; align-items: center; gap: 5px;">
                <iconify-icon icon="lucide:users" width="15" height="15"></iconify-icon>
                <span>{{ $quota['occupants'][0] }}</span>
            </div>
            <div style="font-size: 12px; color: var(--muted); margin-top: 6px;">
                Tempat KP sudah diisi oleh kelompok yang lebih dulu diterima. Pendaftaran baru ditutup untuk periode berjalan.
            </div>
        </div>
    @elseif ($quota['individual_count'] > 0)
        <div style="padding: 14px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; font-size: 13px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <strong>Terisi {{ $quota['individual_count'] }} dari 3 Mahasiswa Individu Diterima</strong>
                <span style="font-weight: 700; color: {{ $quota['is_full'] ? '#b91c1c' : '#b45309' }};">
                    {{ $quota['remaining_individual'] }} Slot Individu Tersisa
                </span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 10px;">
                @foreach ($quota['occupants'] as $idx => $occName)
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 12.5px;">
                        <span style="color: #10b981;">●</span>
                        <span>{{ $occName }} (Mahasiswa {{ $idx + 1 }} - Diterima)</span>
                    </div>
                @endforeach
            </div>

            @if ($quota['can_accept_individual'])
                <div style="font-size: 12px; color: #047857; font-weight: 500;">
                    ✓ Pendaftaran individu masih dibuka untuk {{ $quota['remaining_individual'] }} orang lagi. (Pendaftaran kelompok ditutup karena sudah ada individu).
                </div>
            @else
                <div style="font-size: 12px; color: #b91c1c; font-weight: 500;">
                    Tempat KP sudah diisi penuh (3/3 mahasiswa diterima).
                </div>
            @endif
        </div>
    @else
        <div style="padding: 14px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; font-size: 13px; color: #166534;">
            ✓ Belum ada mahasiswa yang fix diterima di instansi ini. Kuota dapat menerima <strong>1 Kelompok KP</strong> ATAU hingga <strong>3 Mahasiswa Individu</strong>.
        </div>
    @endif

    @if ($quota['pending_count'] > 0)
        <div style="margin-top: 12px; padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 12.5px; color: #475569;">
            <div style="font-weight: 600; color: #334155; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                <iconify-icon icon="lucide:clock" width="14" height="14" style="color: #f59e0b;"></iconify-icon>
                <span>Daftar Mahasiswa yang Sedang Mengajukan Pendaftaran ({{ $quota['pending_count'] }} Orang):</span>
            </div>
            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                @foreach ($quota['applicants'] as $app)
                    <span style="background: #ffffff; border: 1px solid #cbd5e1; padding: 2px 8px; border-radius: 6px; font-size: 11.5px;">
                        {{ $app }}
                    </span>
                @endforeach
            </div>
        </div>
    @endif

    <div style="margin-top: 18px;">
        @if ($quota['is_full'])
            <button class="btn-brand disabled" disabled style="padding: 10px 24px; background: #e2e8f0; color: #94a3b8 !important; border: 1px solid #cbd5e1; cursor: not-allowed; box-shadow: none;">
                Tempat KP Sudah Diisi
            </button>
        @else
            <a href="{{ route('mahasiswa.applications.create', ['company_id' => $company->id, 'company_name' => $company->name]) }}" class="btn-brand" style="padding: 10px 24px;">
                Daftar KP ke Instansi Ini Sekarang
            </a>
        @endif
    </div>
</div>

<!-- REKAM JEJAK PENGALAMAN ALUMNI -->
<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
        <div>
            <h3 style="font-size: 16px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 6px;">
                <iconify-icon icon="lucide:star" width="18" height="18" style="color: #eab308;"></iconify-icon>
                <span>Rekam Jejak Pengalaman Mahasiswa Sebelumnya</span>
            </h3>
            <p style="font-size: 12px; color: var(--muted); margin-top: 2px;">
                Ulasan resmi dari alumni yang telah menyelesaikan KP di {{ $company->name }} dan tervalidasi oleh Admin Jurusan.
            </p>
        </div>

        <span style="font-size: 12px; font-weight: 600; color: var(--brand-primary);">
            {{ $experiences->count() }} Ulasan Tervalidasi
        </span>
    </div>

    @forelse ($experiences as $exp)
        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 12px; padding: 18px; margin-bottom: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 12px;">
                <div>
                    <h4 style="font-size: 15px; font-weight: 700; color: var(--brand-dark);">
                        {{ $exp->position }}
                    </h4>
                    <div style="font-size: 12px; color: var(--muted); margin-top: 2px;">
                        Oleh: <strong>{{ $exp->student->user->name }}</strong> ({{ $exp->student->npm }}) • {{ $exp->created_at->format('d M Y') }}
                    </div>
                </div>

                <span style="background: #ecfdf5; color: #047857; font-size: 10.5px; font-weight: 600; padding: 3px 8px; border-radius: 12px; border: 1px solid #a7f3d0;">
                    ✓ Tervalidasi Jurusan
                </span>
            </div>

            <!-- SKILLS CHIPS -->
            <div style="margin-bottom: 12px;">
                <span style="font-size: 11px; font-weight: 600; color: var(--muted); display: block; margin-bottom: 4px;">Keterampilan / Teknologi yang Digunakan:</span>
                <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                    @foreach (explode(',', $exp->skills_used) as $skill)
                        <span style="background: #eff6ff; color: #1d4ed8; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 6px;">
                            {{ trim($skill) }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- PROSES SELEKSI -->
            <div style="margin-bottom: 12px; padding: 10px 12px; background: #f8fbff; border-radius: 8px; font-size: 12.5px;">
                <strong style="color: var(--text);">Proses Seleksi & Perekrutan:</strong>
                <p style="color: #475569; margin-top: 4px; line-height: 1.5;">
                    {{ $exp->selection_process }}
                </p>
            </div>

            <!-- REVIEW PENGALAMAN -->
            <div style="font-size: 13px; line-height: 1.6; color: var(--text);">
                <strong>Ulasan Selama Pelaksanaan KP:</strong>
                <p style="color: #334155; margin-top: 4px; font-style: italic;">
                    "{{ $exp->experience_review }}"
                </p>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 30px; background: #f8fbff; border-radius: 10px; color: var(--muted); font-size: 13px;">
            Belum ada ulasan alumni yang diunggah untuk instansi ini. Jadilah mahasiswa pertama yang membagikan pengalamanmu setelah menyelesaikan KP di sini!
        </div>
    @endforelse
</div>
@endsection
