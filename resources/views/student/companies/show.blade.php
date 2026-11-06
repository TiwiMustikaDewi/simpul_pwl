@extends('layouts.student')

@section('title', $company->name . ' - Detail & Pengalaman KP')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('mahasiswa.companies.index') }}" style="font-size: 13px; color: var(--brand-primary); font-weight: 600;">
        ← Kembali ke Katalog Perusahaan
    </a>
</div>

<!-- HEADER PERUSAHAAN & KUOTA -->
<div class="panel" style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;">
        <div>
            <div style="font-size: 11px; font-weight: 600; color: var(--muted); text-transform: uppercase;">
                📍 {{ $company->city }}
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
    <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
        <span>📊</span> Keterisian Kuota Periode Berjalan
    </h3>

    @if ($quota['has_group'])
        <div style="padding: 14px; background: #eff6ff; border-radius: 8px; font-size: 13px; line-height: 1.5;">
            <strong>Instansi ini telah terpenuhi oleh 1 Kelompok KP:</strong>
            <div style="margin-top: 4px; color: #1e40af;">
                👥 {{ $quota['occupants'][0] }}
            </div>
            <div style="font-size: 12px; color: var(--muted); margin-top: 6px;">
                Mahasiswa lain tidak dapat mendaftarkan diri ke instansi ini pada periode berjalan karena batas kuota 1 kelompok telah tercapai.
            </div>
        </div>
    @elseif ($quota['individual_count'] > 0)
        <div style="padding: 14px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; font-size: 13px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <strong>Terisi {{ $quota['individual_count'] }} dari 3 Mahasiswa Individu</strong>
                <span style="font-weight: 700; color: {{ $quota['is_full'] ? '#b91c1c' : '#b45309' }};">
                    {{ $quota['remaining_individual'] }} Slot Individu Tersisa
                </span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 10px;">
                @foreach ($quota['occupants'] as $idx => $occName)
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 12.5px;">
                        <span style="color: #3b82f6;">●</span>
                        <span>{{ $occName }} (Mahasiswa {{ $idx + 1 }})</span>
                    </div>
                @endforeach
            </div>

            @if ($quota['can_accept_individual'])
                <div style="font-size: 12px; color: #047857; font-weight: 500;">
                    ✓ Pendaftaran individu masih dibuka untuk {{ $quota['remaining_individual'] }} orang lagi. (Pendaftaran kelompok ditutup karena sudah ada individu).
                </div>
            @else
                <div style="font-size: 12px; color: #b91c1c; font-weight: 500;">
                    ✕ Kuota individu telah penuh (3/3).
                </div>
            @endif
        </div>
    @else
        <div style="padding: 14px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; font-size: 13px; color: #166534;">
            ✓ Kuota masih kosong sepenuhnya. Instansi ini dapat menerima <strong>1 Kelompok KP</strong> ATAU hingga <strong>3 Mahasiswa Individu</strong>.
        </div>
    @endif

    <div style="margin-top: 16px;">
        @if ($quota['is_full'])
            <button class="btn-brand disabled" disabled style="padding: 10px 24px;">
                Kuota Instansi Telah Penuh
            </button>
        @else
            <a href="{{ route('mahasiswa.applications.create', ['company_id' => $company->id]) }}" class="btn-brand" style="padding: 10px 24px;">
                Daftar KP ke Instansi Ini Sekarang →
            </a>
        @endif
    </div>
</div>

<!-- REKAM JEJAK PENGALAMAN ALUMNI -->
<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
        <div>
            <h3 style="font-size: 16px; font-weight: 700; color: var(--text);">
                ⭐ Rekam Jejak Pengalaman Mahasiswa Sebelumnya
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
