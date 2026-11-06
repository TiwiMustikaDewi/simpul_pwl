@extends('layouts.student')

@section('title', 'Bagikan Pengalaman Kuliah Praktik')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="font-size: 22px; font-weight: 700; color: var(--text);">Bagikan Rekam Jejak Pengalaman KP (Alumni Review)</h2>
    <p style="font-size: 13px; color: var(--muted); margin-top: 4px;">
        Bantu mahasiswa angkatan berikutnya dengan membagikan informasi mengenai posisi pekerjaan, keterampilan yang dibutuhkan, proses seleksi, dan ulasan pengalamanmu di {{ $internship->company->name }}.
    </p>
</div>

<div class="panel" style="max-width: 800px; margin: 0 auto;">
    @if ($experience && $experience->is_validated)
        <div class="alert-box success" style="margin-bottom: 20px;">
            <span>✓</span>
            <div>
                <strong>Ulasan Anda Telah Divalidasi oleh Admin Jurusan!</strong> Ulasan ini kini tampil di halaman profil {{ $internship->company->name }} sebagai referensi bagi mahasiswa lain.
            </div>
        </div>
    @elseif ($experience)
        <div class="alert-box info" style="margin-bottom: 20px;">
            <span>ℹ</span>
            <div>
                <strong>Ulasan Sedang Ditinjau Admin:</strong> Ulasan pengalaman Anda telah tersimpan dan sedang menunggu validasi oleh Admin Jurusan.
            </div>
        </div>
    @endif

    <form action="{{ route('mahasiswa.experiences.store') }}" method="POST">
        @csrf

        <div style="padding: 14px; background: #f8fbff; border-radius: 8px; margin-bottom: 20px; font-size: 13px;">
            <div style="color: var(--muted);">Instansi KP:</div>
            <strong style="font-size: 15px; color: var(--brand-dark);">{{ $internship->company->name }}</strong> ({{ $internship->company->city }})
        </div>

        <div style="margin-bottom: 18px;">
            <label for="position" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 5px;">
                Posisi / Role Pekerjaan Saat KP <span style="color: red;">*</span>
            </label>
            <input
                type="text"
                name="position"
                id="position"
                value="{{ old('position', $experience?->position) }}"
                required
                placeholder="Contoh: Frontend Web Developer Intern, Database Administrator, dsb."
                style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px;"
            >
        </div>

        <div style="margin-bottom: 18px;">
            <label for="skills_used" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 5px;">
                Keterampilan & Teknologi yang Digunakan (Pisahkan dengan koma) <span style="color: red;">*</span>
            </label>
            <input
                type="text"
                name="skills_used"
                id="skills_used"
                value="{{ old('skills_used', $experience?->skills_used) }}"
                required
                placeholder="Contoh: Laravel, PostgreSQL, Docker, Figma, Git, Tailwind CSS"
                style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px;"
            >
            <div style="font-size: 11px; color: var(--muted); margin-top: 4px;">
                Teknologi yang kamu sebutkan akan membantu adik tingkat mempersiapkan diri sebelum mendaftar.
            </div>
        </div>

        <div style="margin-bottom: 18px;">
            <label for="selection_process" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 5px;">
                Proses Seleksi & Persyaratan Masuk <span style="color: red;">*</span>
            </label>
            <textarea
                name="selection_process"
                id="selection_process"
                rows="3"
                required
                placeholder="Ceritakan bagaimana alur kamu diterima: surat pengantar jurusan, tes teknis, wawancara portofolio, dll."
                style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px;"
            >{{ old('selection_process', $experience?->selection_process) }}</textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label for="experience_review" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 5px;">
                Ulasan & Saran Selama Pelaksanaan Kuliah Praktik <span style="color: red;">*</span>
            </label>
            <textarea
                name="experience_review"
                id="experience_review"
                rows="4"
                required
                placeholder="Bagaimana bimbingan mentor di tempat KP? Suasana kerja, fasilitas, kendala, serta rekomendasi untuk mahasiswa berikutnya..."
                style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px;"
            >{{ old('experience_review', $experience?->experience_review) }}</textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid var(--border);">
            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline" style="border-radius: 25px; padding: 10px 20px;">
                Kembali ke Dashboard
            </a>
            <button type="submit" class="btn-brand" style="padding: 10px 26px;">
                Simpan & Kirim Ulasan untuk Validasi Admin →
            </button>
        </div>
    </form>
</div>
@endsection
