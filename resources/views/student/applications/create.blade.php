@extends('layouts.student')

@section('title', 'Form Pengajuan Kesiapan Kuliah Praktik')

@push('styles')
<style>
    .application-container {
        width: 100%;
    }

    .form-grid-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .guide-grid {
        display: grid;
        grid-template-columns: 1.55fr 1fr;
        gap: 18px;
    }

    /* Custom Interactive Dropdown */
    .custom-select-wrapper {
        position: relative;
        width: 100%;
        user-select: none;
    }

    .custom-select-trigger {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 14px;
        background: #ffffff;
        border: 1.5px solid var(--border-color);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        text-align: left;
    }

    .custom-select-trigger:hover {
        border-color: #93c5fd;
        background: #fbfdff;
    }

    .custom-select-wrapper.is-open .custom-select-trigger {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.12);
    }

    .custom-select-selected {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13.5px;
        font-weight: 500;
        color: var(--text-main);
    }

    .select-chevron {
        color: #64748b;
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), color 0.2s ease;
    }

    .custom-select-wrapper.is-open .select-chevron {
        transform: rotate(180deg);
        color: #2563eb;
    }

    .custom-select-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        background: #ffffff;
        border: 1.5px solid #dbeafe;
        border-radius: 12px;
        box-shadow: 0 14px 30px -4px rgba(15, 23, 42, 0.14), 0 4px 10px -2px rgba(15, 23, 42, 0.04);
        padding: 6px;
        z-index: 60;
        opacity: 0;
        transform: translateY(-8px) scale(0.98);
        pointer-events: none;
        visibility: hidden;
        transition: opacity 0.2s cubic-bezier(0.16, 1, 0.3, 1), transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.2s;
    }

    .custom-select-wrapper.is-open .custom-select-dropdown {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
        visibility: visible;
    }

    .custom-select-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.18s ease;
        margin-bottom: 2px;
    }

    .custom-select-option:last-child {
        margin-bottom: 0;
    }

    .custom-select-option:hover {
        background: #f0f7ff;
        transform: translateX(3px);
    }

    .custom-select-option.is-selected {
        background: #eff6ff;
    }

    .option-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .option-icon-box {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: grid;
        place-items: center;
        font-size: 16px;
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }

    .custom-select-option:hover .option-icon-box {
        transform: scale(1.08);
    }

    .option-icon-box.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .option-icon-box.emerald {
        background: #ecfdf5;
        color: #059669;
    }

    .option-icon-box.violet {
        background: #f5f3ff;
        color: #7c3aed;
    }

    .option-icon-box.gray {
        background: #f1f5f9;
        color: #64748b;
    }

    .option-text {
        display: flex;
        flex-direction: column;
        gap: 1px;
    }

    .option-title {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }

    .custom-select-option.is-selected .option-title {
        color: #1d4ed8;
    }

    .option-badge {
        font-size: 11px;
        color: #64748b;
    }

    .option-check {
        color: #2563eb;
        opacity: 0;
        transform: scale(0.6);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        font-size: 16px;
    }

    .custom-select-option.is-selected .option-check {
        opacity: 1;
        transform: scale(1);
    }

    .form-submit-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }

    @media (max-width: 768px) {
        .guide-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }
    }

    @media (max-width: 640px) {
        .form-grid-2col {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .form-submit-buttons {
            flex-direction: column-reverse;
            width: 100%;
        }

        .form-submit-buttons button,
        .form-submit-buttons a {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="application-container">

    <div style="margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
            <a href="{{ route('mahasiswa.dashboard') }}" style="display: inline-flex; align-items: center; gap: 4px; font-size: 12.5px; color: #64748b; text-decoration: none;">
                <iconify-icon icon="lucide:arrow-left" width="14" height="14"></iconify-icon>
                <span>Dashboard</span>
            </a>
            <span style="font-size: 12px; color: #cbd5e1;">/</span>
            <span style="font-size: 12.5px; color: #2563eb; font-weight: 500;">Pengajuan Kesiapan KP</span>
        </div>
        <h2 style="font-size: clamp(19px, 4.5vw, 22px); font-weight: 700; color: var(--text-main); margin: 0; line-height: 1.3;">
            Form Pengajuan Kesiapan Kuliah Praktik & Surat Pengantar
        </h2>
        <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px; margin-bottom: 0;">
            Tuliskan instansi tujuan, tentukan rencana periode pelaksanaan, dan ajukan permohonan surat pengantar resmi ke jurusan.
        </p>
    </div>

    <!-- PANDUAN ALUR & BATAS KUOTA (BISA DISEMBUNYIKAN / DITAMPILKAN) -->
    <div class="panel" style="margin-bottom: 24px; border-radius: 14px; border: 1.5px solid #bfdbfe; background: #ffffff; overflow: hidden; padding: 0;">
        <div
            onclick="togglePanduan()"
            style="padding: 14px 18px; background: #f8fbff; cursor: pointer; display: flex; align-items: center; justify-content: space-between; gap: 12px; user-select: none;"
        >
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: grid; place-items: center; flex-shrink: 0;">
                    <iconify-icon icon="lucide:book-open-check" width="18" height="18"></iconify-icon>
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 13.5px; color: #1e40af; display: flex; align-items: center; gap: 6px;">
                        <span>Alur Pengajuan & Batas Kuota Penerimaan</span>
                        <span style="font-size: 10.5px; font-weight: 600; color: #2563eb; background: #dbeafe; padding: 2px 7px; border-radius: 10px;">Info Panduan</span>
                    </div>
                    <div style="font-size: 11.5px; color: #64748b; margin-top: 1px;">
                        Klik untuk melihat atau menyembunyikan alur konfirmasi dan aturan kuota penerimaan.
                    </div>
                </div>
            </div>

            <button
                type="button"
                id="btnToggleGuide"
                style="background: #ffffff; border: 1px solid #cbd5e1; color: #1e40af; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; transition: all .2s;"
            >
                <span id="textToggleGuide">Sembunyikan</span>
                <iconify-icon id="iconToggleGuide" icon="lucide:chevron-up" width="14" height="14"></iconify-icon>
            </button>
        </div>

        <!-- ISI PANDUAN YANG BISA DILIPAT -->
        <div id="contentPanduan" style="display: block; padding: 18px 20px; border-top: 1px solid #e2e8f0; background: #ffffff;">
            <div class="guide-grid">
                <!-- CARD 1: ALUR SELEKSI & KONFIRMASI -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 18px;">
                    <div style="font-weight: 700; font-size: 13px; color: #1e3a8a; display: flex; align-items: center; gap: 6px; margin-bottom: 12px;">
                        <iconify-icon icon="lucide:workflow" width="16" height="16" style="color: #2563eb;"></iconify-icon>
                        <span>Alur Pengajuan & Konfirmasi KP</span>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 10px; font-size: 12px; color: #334155; line-height: 1.45;">
                        <div style="display: flex; gap: 8px;">
                            <span style="font-weight: 700; color: #2563eb; width: 18px; height: 18px; border-radius: 50%; background: #eff6ff; display: grid; place-items: center; font-size: 11px; flex-shrink: 0;">1</span>
                            <div><strong>Tuliskan Instansi:</strong> Tulis nama instansi tujuan. Sistem akan otomatis mencatatnya ke katalog.</div>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <span style="font-weight: 700; color: #2563eb; width: 18px; height: 18px; border-radius: 50%; background: #eff6ff; display: grid; place-items: center; font-size: 11px; flex-shrink: 0;">2</span>
                            <div><strong>Pengajuan Surat ke Jurusan:</strong> Pengajuan surat pengantar resmi diproses jurusan.</div>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <span style="font-weight: 700; color: #2563eb; width: 18px; height: 18px; border-radius: 50%; background: #eff6ff; display: grid; place-items: center; font-size: 11px; flex-shrink: 0;">3</span>
                            <div><strong>Pengumuman Seleksi:</strong> Perbarui status menjadi <strong>"Diterima"</strong> di dashboard setelah ada kabar kelulusan.</div>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <span style="font-weight: 700; color: #2563eb; width: 18px; height: 18px; border-radius: 50%; background: #eff6ff; display: grid; place-items: center; font-size: 11px; flex-shrink: 0;">4</span>
                            <div><strong>Kunci Kuota:</strong> Konfirmasi diterima akan langsung mengunci kuota tempat KP secara otomatis.</div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: ATURAN KUOTA -->
                <div style="background: #f0f7ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 16px 18px; display: flex; flex-direction: column; justify-content: center;">
                    <div style="display: flex; align-items: center; gap: 6px; font-weight: 700; font-size: 13px; color: #1e40af; margin-bottom: 8px;">
                        <iconify-icon icon="lucide:shield-alert" width="16" height="16" style="color: #2563eb;"></iconify-icon>
                        <span>Batas Kuota Penerimaan</span>
                    </div>
                    <p style="font-size: 12px; color: #1d4ed8; line-height: 1.6; margin: 0 0 10px 0;">
                        Setiap instansi hanya dapat menerima maksimal <strong>1 Kelompok</strong> atau <strong>3 Mahasiswa Individu</strong> pada periode aktif berjalan.
                    </p>
                    <div style="font-size: 11px; color: #1e40af; background: #ffffff; border: 1px dashed #93c5fd; border-radius: 8px; padding: 8px 10px; line-height: 1.4;">
                        Jika kuota terpenuhi oleh yang lebih awal konfirmasi diterima, pendaftar lain akan dialihkan.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN FORM -->
    <div class="panel" style="padding: 30px 32px; border-radius: 16px;">
        <form action="{{ route('mahasiswa.applications.store') }}" method="POST" id="formPengajuan">
            @csrf

            <!-- SECTION 1: TIPE PENDAFTARAN -->
            <div style="margin-bottom: 28px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 14px;">
                    <span style="width: 26px; height: 26px; border-radius: 50%; background: #eff6ff; color: #2563eb; font-weight: 700; font-size: 12px; display: grid; place-items: center;">1</span>
                    <h3 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin: 0;">
                        Tipe Pengajuan Kuliah Praktik <span style="color: #ef4444;">*</span>
                    </h3>
                </div>

                <div class="form-grid-2col">
                    <label style="display: flex; align-items: flex-start; gap: 12px; padding: 16px 18px; border: 2px solid {{ old('type', 'individual') === 'individual' ? 'var(--brand-primary)' : 'var(--border-color)' }}; background: {{ old('type', 'individual') === 'individual' ? '#f0f7ff' : '#ffffff' }}; border-radius: 14px; cursor: pointer; transition: all .2s;" id="labelIndividu">
                        <input type="radio" name="type" value="individual" {{ old('type', 'individual') === 'individual' ? 'checked' : '' }} onchange="toggleType('individual')" style="margin-top: 3px;">
                        <div>
                            <div style="font-weight: 700; font-size: 14px; color: var(--text-main); display: flex; align-items: center; gap: 6px;">
                                <iconify-icon icon="lucide:user" width="16" height="16" style="color: #2563eb;"></iconify-icon>
                                <span>Individu</span>
                            </div>
                            <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px; line-height: 1.4;">
                                Mendaftar secara mandiri (maks. 3 mahasiswa per instansi).
                            </div>
                        </div>
                    </label>

                    <label style="display: flex; align-items: flex-start; gap: 12px; padding: 16px 18px; border: 2px solid {{ old('type') === 'group' ? 'var(--brand-primary)' : 'var(--border-color)' }}; background: {{ old('type') === 'group' ? '#f0f7ff' : '#ffffff' }}; border-radius: 14px; cursor: pointer; transition: all .2s;" id="labelKelompok">
                        <input type="radio" name="type" value="group" {{ old('type') === 'group' ? 'checked' : '' }} onchange="toggleType('group')" style="margin-top: 3px;">
                        <div>
                            <div style="font-weight: 700; font-size: 14px; color: var(--text-main); display: flex; align-items: center; gap: 6px;">
                                <iconify-icon icon="lucide:users" width="16" height="16" style="color: #2563eb;"></iconify-icon>
                                <span>Kelompok / Tim</span>
                            </div>
                            <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px; line-height: 1.4;">
                                Mendaftar bersama rekan (maks. 1 kelompok per instansi).
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- SECTION KHUSUS KELOMPOK -->
            <div id="sectionKelompok" style="display: {{ old('type') === 'group' ? 'block' : 'none' }}; background: #f8fbff; border: 1px solid #bfdbfe; border-radius: 14px; padding: 20px; margin-bottom: 28px;">
                <h4 style="font-size: 14px; font-weight: 700; color: #1e40af; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    <iconify-icon icon="lucide:users" width="18" height="18"></iconify-icon>
                    <span>Formulir Anggota Kelompok KP</span>
                </h4>

                <!-- DATA KETUA KELOMPOK -->
                <div style="margin-bottom: 20px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; padding: 18px 20px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                        <label style="font-weight: 700; font-size: 13.5px; color: #1e40af; display: flex; align-items: center; gap: 6px; margin: 0;">
                            <iconify-icon icon="lucide:crown" width="16" height="16" style="color: #2563eb;"></iconify-icon>
                            <span>Ketua Kelompok <span style="color: #ef4444;">*</span></span>
                        </label>
                        <span style="font-size: 11px; color: #2563eb; background: #eff6ff; border: 1px solid #bfdbfe; padding: 2px 8px; border-radius: 6px; font-weight: 600;">
                            Ketua Tim
                        </span>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        <div>
                            <label for="leader_name" style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 5px;">
                                Nama Lengkap Ketua <span style="color: #ef4444;">*</span>
                            </label>
                            <input
                                type="text"
                                name="leader_name"
                                id="leader_name"
                                value="{{ old('leader_name', auth()->user()->name) }}"
                                placeholder="Tuliskan nama lengkap ketua"
                                style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13.5px; background: #ffffff;"
                            >
                        </div>
                        <div>
                            <label for="leader_npm" style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 5px;">
                                NPM Ketua <span style="color: #ef4444;">*</span>
                            </label>
                            <input
                                type="text"
                                name="leader_npm"
                                id="leader_npm"
                                value="{{ old('leader_npm', $student->npm) }}"
                                placeholder="Contoh: 2417051034"
                                style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13.5px; background: #ffffff;"
                            >
                        </div>
                        <div>
                            <label style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 5px;">
                                Program Studi Ketua <span style="color: #ef4444;">*</span>
                            </label>
                            @php
                                $selectedLeaderMajor = old('leader_major', in_array($student->major, ['S1 Ilmu Komputer', 'S1 Sistem Informasi', 'D3 Manajemen Informatika']) ? $student->major : 'S1 Ilmu Komputer');
                            @endphp
                            <div class="custom-select-wrapper">
                                <input type="hidden" name="leader_major" id="leader_major_val" value="{{ $selectedLeaderMajor }}">
                                <button type="button" class="custom-select-trigger" onclick="toggleCustomSelect(this)">
                                    <div class="custom-select-selected">
                                        <span class="option-icon-box {{ $selectedLeaderMajor === 'S1 Sistem Informasi' ? 'emerald' : ($selectedLeaderMajor === 'D3 Manajemen Informatika' ? 'violet' : 'blue') }}" style="width: 26px; height: 26px; font-size: 14px;">
                                            <iconify-icon icon="{{ $selectedLeaderMajor === 'S1 Sistem Informasi' ? 'lucide:network' : ($selectedLeaderMajor === 'D3 Manajemen Informatika' ? 'lucide:code-2' : 'lucide:laptop') }}"></iconify-icon>
                                        </span>
                                        <span class="selected-text" style="font-weight: 600; font-size: 13.5px; color: var(--text-main);">{{ $selectedLeaderMajor }}</span>
                                    </div>
                                    <iconify-icon icon="lucide:chevron-down" class="select-chevron" width="16" height="16"></iconify-icon>
                                </button>
                                <div class="custom-select-dropdown">
                                    <div class="custom-select-option {{ $selectedLeaderMajor === 'S1 Ilmu Komputer' ? 'is-selected' : '' }}" onclick="selectCustomOption(this, 'S1 Ilmu Komputer', 'lucide:laptop', 'blue')">
                                        <div class="option-left">
                                            <span class="option-icon-box blue">
                                                <iconify-icon icon="lucide:laptop"></iconify-icon>
                                            </span>
                                            <div class="option-text">
                                                <span class="option-title">S1 Ilmu Komputer</span>
                                                <span class="option-badge">Sarjana (S1) · Jurusan Ilmu Komputer</span>
                                            </div>
                                        </div>
                                        <iconify-icon icon="lucide:check" class="option-check"></iconify-icon>
                                    </div>
                                    <div class="custom-select-option {{ $selectedLeaderMajor === 'S1 Sistem Informasi' ? 'is-selected' : '' }}" onclick="selectCustomOption(this, 'S1 Sistem Informasi', 'lucide:network', 'emerald')">
                                        <div class="option-left">
                                            <span class="option-icon-box emerald">
                                                <iconify-icon icon="lucide:network"></iconify-icon>
                                            </span>
                                            <div class="option-text">
                                                <span class="option-title">S1 Sistem Informasi</span>
                                                <span class="option-badge">Sarjana (S1) · Jurusan Ilmu Komputer</span>
                                            </div>
                                        </div>
                                        <iconify-icon icon="lucide:check" class="option-check"></iconify-icon>
                                    </div>
                                    <div class="custom-select-option {{ $selectedLeaderMajor === 'D3 Manajemen Informatika' ? 'is-selected' : '' }}" onclick="selectCustomOption(this, 'D3 Manajemen Informatika', 'lucide:code-2', 'violet')">
                                        <div class="option-left">
                                            <span class="option-icon-box violet">
                                                <iconify-icon icon="lucide:code-2"></iconify-icon>
                                            </span>
                                            <div class="option-text">
                                                <span class="option-title">D3 Manajemen Informatika</span>
                                                <span class="option-badge">Diploma Tiga (D3) · Jurusan Ilmu Komputer</span>
                                            </div>
                                        </div>
                                        <iconify-icon icon="lucide:check" class="option-check"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="font-size: 11.5px; color: #64748b; margin-top: 10px; display: flex; align-items: center; gap: 4px;">
                        <iconify-icon icon="lucide:info" width="13" height="13" style="color: #3b82f6; flex-shrink: 0;"></iconify-icon>
                        <span>Default terisi profil akun Anda. Ubah isian di atas jika ketua kelompok adalah rekan lain.</span>
                    </div>
                </div>

                <!-- DATA REKAN ANGGOTA KELOMPOK -->
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                        <label style="font-weight: 700; font-size: 13.5px; color: var(--text-main); display: flex; align-items: center; gap: 6px; margin: 0;">
                            <iconify-icon icon="lucide:users" width="16" height="16" style="color: #2563eb;"></iconify-icon>
                            <span>Rekan Anggota Kelompok (Maksimal 2 Anggota)</span>
                        </label>
                        <span style="font-size: 11px; color: #64748b; background: #f1f5f9; border: 1px solid #e2e8f0; padding: 2px 8px; border-radius: 6px; font-weight: 500;">
                            Maks. 2 Rekan
                        </span>
                    </div>
                    <p style="font-size: 12px; color: var(--text-muted); margin: 0 0 14px 0; line-height: 1.4;">
                        Tuliskan nama, NPM, dan program studi rekan anggota tim Anda. Kosongkan formulir anggota jika kelompok hanya beranggotakan 2 orang (1 ketua + 1 rekan) atau tanpa rekan tambahan.
                    </p>

                    <!-- REKAN ANGGOTA 1 -->
                    <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; padding: 18px 20px; margin-bottom: 14px;">
                        <div style="font-size: 13px; font-weight: 700; color: #1e40af; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                            <iconify-icon icon="lucide:user-plus" width="15" height="15" style="color: #2563eb;"></iconify-icon>
                            <span>Identitas Rekan Anggota 1</span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 14px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 5px;">
                                    Nama Lengkap Anggota 1
                                </label>
                                <input
                                    type="text"
                                    name="members[0][name]"
                                    value="{{ old('members.0.name') }}"
                                    placeholder="Contoh: Yulia Nuritnasari"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13.5px; background: #ffffff;"
                                >
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 5px;">
                                    NPM Anggota 1
                                </label>
                                <input
                                    type="text"
                                    name="members[0][npm]"
                                    value="{{ old('members.0.npm') }}"
                                    placeholder="Contoh: 2457051008"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13.5px; background: #ffffff;"
                                >
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 5px;">
                                    Program Studi Anggota 1
                                </label>
                                @php
                                    $selectedMember0Major = old('members.0.major', '');
                                @endphp
                                <div class="custom-select-wrapper">
                                    <input type="hidden" name="members[0][major]" id="member_0_major_val" value="{{ $selectedMember0Major }}">
                                    <button type="button" class="custom-select-trigger" onclick="toggleCustomSelect(this)">
                                        <div class="custom-select-selected">
                                            <span class="option-icon-box {{ $selectedMember0Major === 'S1 Sistem Informasi' ? 'emerald' : ($selectedMember0Major === 'D3 Manajemen Informatika' ? 'violet' : ($selectedMember0Major === 'S1 Ilmu Komputer' ? 'blue' : 'gray')) }}" style="width: 26px; height: 26px; font-size: 14px;">
                                                <iconify-icon icon="{{ $selectedMember0Major === 'S1 Sistem Informasi' ? 'lucide:network' : ($selectedMember0Major === 'D3 Manajemen Informatika' ? 'lucide:code-2' : ($selectedMember0Major === 'S1 Ilmu Komputer' ? 'lucide:laptop' : 'lucide:graduation-cap')) }}"></iconify-icon>
                                            </span>
                                            <span class="selected-text" style="font-weight: 600; font-size: 13.5px; color: {{ $selectedMember0Major ? 'var(--text-main)' : '#94a3b8' }};">
                                                {{ $selectedMember0Major ?: 'Pilih Program Studi Anggota 1' }}
                                            </span>
                                        </div>
                                        <iconify-icon icon="lucide:chevron-down" class="select-chevron" width="16" height="16"></iconify-icon>
                                    </button>
                                    <div class="custom-select-dropdown">
                                        <div class="custom-select-option {{ $selectedMember0Major === 'S1 Ilmu Komputer' ? 'is-selected' : '' }}" onclick="selectCustomOption(this, 'S1 Ilmu Komputer', 'lucide:laptop', 'blue')">
                                            <div class="option-left">
                                                <span class="option-icon-box blue">
                                                    <iconify-icon icon="lucide:laptop"></iconify-icon>
                                                </span>
                                                <div class="option-text">
                                                    <span class="option-title">S1 Ilmu Komputer</span>
                                                    <span class="option-badge">Sarjana (S1) · Jurusan Ilmu Komputer</span>
                                                </div>
                                            </div>
                                            <iconify-icon icon="lucide:check" class="option-check"></iconify-icon>
                                        </div>
                                        <div class="custom-select-option {{ $selectedMember0Major === 'S1 Sistem Informasi' ? 'is-selected' : '' }}" onclick="selectCustomOption(this, 'S1 Sistem Informasi', 'lucide:network', 'emerald')">
                                            <div class="option-left">
                                                <span class="option-icon-box emerald">
                                                    <iconify-icon icon="lucide:network"></iconify-icon>
                                                </span>
                                                <div class="option-text">
                                                    <span class="option-title">S1 Sistem Informasi</span>
                                                    <span class="option-badge">Sarjana (S1) · Jurusan Ilmu Komputer</span>
                                                </div>
                                            </div>
                                            <iconify-icon icon="lucide:check" class="option-check"></iconify-icon>
                                        </div>
                                        <div class="custom-select-option {{ $selectedMember0Major === 'D3 Manajemen Informatika' ? 'is-selected' : '' }}" onclick="selectCustomOption(this, 'D3 Manajemen Informatika', 'lucide:code-2', 'violet')">
                                            <div class="option-left">
                                                <span class="option-icon-box violet">
                                                    <iconify-icon icon="lucide:code-2"></iconify-icon>
                                                </span>
                                                <div class="option-text">
                                                    <span class="option-title">D3 Manajemen Informatika</span>
                                                    <span class="option-badge">Diploma Tiga (D3) · Jurusan Ilmu Komputer</span>
                                                </div>
                                            </div>
                                            <iconify-icon icon="lucide:check" class="option-check"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- REKAN ANGGOTA 2 -->
                    <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; padding: 18px 20px;">
                        <div style="font-size: 13px; font-weight: 700; color: #1e40af; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                            <iconify-icon icon="lucide:user-plus" width="15" height="15" style="color: #2563eb;"></iconify-icon>
                            <span>Identitas Rekan Anggota 2 (Opsional)</span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 14px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 5px;">
                                    Nama Lengkap Anggota 2
                                </label>
                                <input
                                    type="text"
                                    name="members[1][name]"
                                    value="{{ old('members.1.name') }}"
                                    placeholder="Contoh: Dinar Aisa Artika"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13.5px; background: #ffffff;"
                                >
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 5px;">
                                    NPM Anggota 2
                                </label>
                                <input
                                    type="text"
                                    name="members[1][npm]"
                                    value="{{ old('members.1.npm') }}"
                                    placeholder="Contoh: 2417051020"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13.5px; background: #ffffff;"
                                >
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 5px;">
                                    Program Studi Anggota 2
                                </label>
                                @php
                                    $selectedMember1Major = old('members.1.major', '');
                                @endphp
                                <div class="custom-select-wrapper">
                                    <input type="hidden" name="members[1][major]" id="member_1_major_val" value="{{ $selectedMember1Major }}">
                                    <button type="button" class="custom-select-trigger" onclick="toggleCustomSelect(this)">
                                        <div class="custom-select-selected">
                                            <span class="option-icon-box {{ $selectedMember1Major === 'S1 Sistem Informasi' ? 'emerald' : ($selectedMember1Major === 'D3 Manajemen Informatika' ? 'violet' : ($selectedMember1Major === 'S1 Ilmu Komputer' ? 'blue' : 'gray')) }}" style="width: 26px; height: 26px; font-size: 14px;">
                                                <iconify-icon icon="{{ $selectedMember1Major === 'S1 Sistem Informasi' ? 'lucide:network' : ($selectedMember1Major === 'D3 Manajemen Informatika' ? 'lucide:code-2' : ($selectedMember1Major === 'S1 Ilmu Komputer' ? 'lucide:laptop' : 'lucide:graduation-cap')) }}"></iconify-icon>
                                            </span>
                                            <span class="selected-text" style="font-weight: 600; font-size: 13.5px; color: {{ $selectedMember1Major ? 'var(--text-main)' : '#94a3b8' }};">
                                                {{ $selectedMember1Major ?: 'Pilih Program Studi Anggota 2' }}
                                            </span>
                                        </div>
                                        <iconify-icon icon="lucide:chevron-down" class="select-chevron" width="16" height="16"></iconify-icon>
                                    </button>
                                    <div class="custom-select-dropdown">
                                        <div class="custom-select-option {{ $selectedMember1Major === 'S1 Ilmu Komputer' ? 'is-selected' : '' }}" onclick="selectCustomOption(this, 'S1 Ilmu Komputer', 'lucide:laptop', 'blue')">
                                            <div class="option-left">
                                                <span class="option-icon-box blue">
                                                    <iconify-icon icon="lucide:laptop"></iconify-icon>
                                                </span>
                                                <div class="option-text">
                                                    <span class="option-title">S1 Ilmu Komputer</span>
                                                    <span class="option-badge">Sarjana (S1) · Jurusan Ilmu Komputer</span>
                                                </div>
                                            </div>
                                            <iconify-icon icon="lucide:check" class="option-check"></iconify-icon>
                                        </div>
                                        <div class="custom-select-option {{ $selectedMember1Major === 'S1 Sistem Informasi' ? 'is-selected' : '' }}" onclick="selectCustomOption(this, 'S1 Sistem Informasi', 'lucide:network', 'emerald')">
                                            <div class="option-left">
                                                <span class="option-icon-box emerald">
                                                    <iconify-icon icon="lucide:network"></iconify-icon>
                                                </span>
                                                <div class="option-text">
                                                    <span class="option-title">S1 Sistem Informasi</span>
                                                    <span class="option-badge">Sarjana (S1) · Jurusan Ilmu Komputer</span>
                                                </div>
                                            </div>
                                            <iconify-icon icon="lucide:check" class="option-check"></iconify-icon>
                                        </div>
                                        <div class="custom-select-option {{ $selectedMember1Major === 'D3 Manajemen Informatika' ? 'is-selected' : '' }}" onclick="selectCustomOption(this, 'D3 Manajemen Informatika', 'lucide:code-2', 'violet')">
                                            <div class="option-left">
                                                <span class="option-icon-box violet">
                                                    <iconify-icon icon="lucide:code-2"></iconify-icon>
                                                </span>
                                                <div class="option-text">
                                                    <span class="option-title">D3 Manajemen Informatika</span>
                                                    <span class="option-badge">Diploma Tiga (D3) · Jurusan Ilmu Komputer</span>
                                                </div>
                                            </div>
                                            <iconify-icon icon="lucide:check" class="option-check"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: MENULIS SENDIRI INSTANSI KP -->
            <div style="margin-bottom: 28px; padding-top: 4px; border-top: 1px solid var(--border-color);">
                <div style="display: flex; align-items: center; gap: 8px; margin-top: 20px; margin-bottom: 14px;">
                    <span style="width: 26px; height: 26px; border-radius: 50%; background: #eff6ff; color: #2563eb; font-weight: 700; font-size: 12px; display: grid; place-items: center;">2</span>
                    <div>
                        <h3 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin: 0;">
                            Instansi / Tempat Kuliah Praktik Tujuan <span style="color: #ef4444;">*</span>
                        </h3>
                    </div>
                </div>

                <!-- NAMA INSTANSI (INPUT TEXT SENDIRI) -->
                <div style="margin-bottom: 16px;">
                    <label for="company_name" style="font-weight: 600; font-size: 13.5px; display: block; margin-bottom: 6px; color: var(--text-main);">
                        Nama Lengkap Instansi / Perusahaan <span style="color: #ef4444;">*</span>
                    </label>
                    <input
                        type="text"
                        name="company_name"
                        id="company_name"
                        required
                        autocomplete="off"
                        value="{{ old('company_name', $selectedCompanyName) }}"
                        placeholder="Tuliskan nama instansi, cth: Dinas Komunikasi dan Informatika Provinsi Lampung"
                        style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13.5px; background: #ffffff;"
                    >
                    <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 5px; display: flex; align-items: center; gap: 5px;">
                        <iconify-icon icon="lucide:info" width="14" height="14" style="color: #3b82f6; flex-shrink: 0;"></iconify-icon>
                        <span>Tuliskan nama instansi tujuan Anda secara mandiri. Instansi akan otomatis tercatat ke dalam sistem.</span>
                    </div>
                </div>

                <!-- KOTA & ALAMAT INSTANSI -->
                <div class="form-grid-2col" style="margin-bottom: 16px;">
                    <div>
                        <label for="company_city" style="font-weight: 600; font-size: 13.5px; display: block; margin-bottom: 6px; color: var(--text-main);">
                            Kota / Kabupaten Instansi <span style="color: #ef4444;">*</span>
                        </label>
                        <input
                            type="text"
                            name="company_city"
                            id="company_city"
                            required
                            value="{{ old('company_city', $prefillCompany?->city ?? 'Bandar Lampung') }}"
                            placeholder="Contoh: Bandar Lampung"
                            style="width: 100%; padding: 11px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13.5px;"
                        >
                    </div>

                    <div>
                        <label for="company_address" style="font-weight: 600; font-size: 13.5px; display: block; margin-bottom: 6px; color: var(--text-main);">
                            Alamat Lengkap Instansi
                        </label>
                        <input
                            type="text"
                            name="company_address"
                            id="company_address"
                            value="{{ old('company_address', $prefillCompany?->address) }}"
                            placeholder="Contoh: Jl. Wolter Monginsidi No. 69, Teluk Betung Utara"
                            style="width: 100%; padding: 11px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13.5px;"
                        >
                    </div>
                </div>
            </div>

            <!-- SECTION 3: RENCANA PERIODE PELAKSANAAN -->
            <div style="margin-bottom: 28px; padding-top: 4px; border-top: 1px solid var(--border-color);">
                <div style="display: flex; align-items: center; gap: 8px; margin-top: 20px; margin-bottom: 14px;">
                    <span style="width: 26px; height: 26px; border-radius: 50%; background: #eff6ff; color: #2563eb; font-weight: 700; font-size: 12px; display: grid; place-items: center;">3</span>
                    <h3 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin: 0;">
                        Rencana Periode Pelaksanaan KP <span style="color: #ef4444;">*</span>
                    </h3>
                </div>

                <div class="form-grid-2col">
                    <div>
                        <label for="start_date" style="font-weight: 600; font-size: 13.5px; display: block; margin-bottom: 6px; color: var(--text-main);">
                            Tanggal Mulai Pelaksanaan <span style="color: #ef4444;">*</span>
                        </label>
                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            value="{{ old('start_date') }}"
                            required
                            style="width: 100%; padding: 11px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13.5px;"
                        >
                    </div>

                    <div>
                        <label for="end_date" style="font-weight: 600; font-size: 13.5px; display: block; margin-bottom: 6px; color: var(--text-main);">
                            Tanggal Selesai Pelaksanaan <span style="color: #ef4444;">*</span>
                        </label>
                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            value="{{ old('end_date') }}"
                            required
                            style="width: 100%; padding: 11px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13.5px;"
                        >
                    </div>
                </div>
            </div>

            <!-- SUBMIT BUTTONS -->
            <div class="form-submit-buttons">
                <a href="{{ route('mahasiswa.dashboard') }}" class="btn-outline-custom">
                    Batal
                </a>
                <button type="submit" class="btn-brand">
                    <iconify-icon icon="lucide:send" width="16" height="16"></iconify-icon>
                    <span>Kirim Pengajuan Kesiapan KP</span>
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    function togglePanduan() {
        const content = document.getElementById('contentPanduan');
        const text = document.getElementById('textToggleGuide');
        const icon = document.getElementById('iconToggleGuide');

        if (content.style.display === 'none') {
            content.style.display = 'block';
            text.innerText = 'Sembunyikan';
            icon.setAttribute('icon', 'lucide:chevron-up');
        } else {
            content.style.display = 'none';
            text.innerText = 'Buka Panduan';
            icon.setAttribute('icon', 'lucide:chevron-down');
        }
    }

    function toggleType(type) {
        const sec = document.getElementById('sectionKelompok');
        const lInd = document.getElementById('labelIndividu');
        const lKel = document.getElementById('labelKelompok');

        if (type === 'group') {
            sec.style.display = 'block';
            lKel.style.borderColor = 'var(--brand-primary)';
            lKel.style.background = '#f0f7ff';
            lInd.style.borderColor = 'var(--border-color)';
            lInd.style.background = '#ffffff';
        } else {
            sec.style.display = 'none';
            lInd.style.borderColor = 'var(--brand-primary)';
            lInd.style.background = '#f0f7ff';
            lKel.style.borderColor = 'var(--border-color)';
            lKel.style.background = '#ffffff';
        }
    }

    function toggleCustomSelect(trigger) {
        const wrapper = trigger.closest('.custom-select-wrapper');
        const isOpen = wrapper.classList.contains('is-open');

        // Close all other dropdowns
        document.querySelectorAll('.custom-select-wrapper.is-open').forEach(el => {
            if (el !== wrapper) {
                el.classList.remove('is-open');
            }
        });

        wrapper.classList.toggle('is-open');
    }

    function selectCustomOption(optionEl, value, iconName, colorClass) {
        const wrapper = optionEl.closest('.custom-select-wrapper');
        const input = wrapper.querySelector('input[type="hidden"]');
        const selectedText = wrapper.querySelector('.selected-text');
        const iconBox = wrapper.querySelector('.custom-select-selected .option-icon-box');
        const iconEl = iconBox.querySelector('iconify-icon');

        input.value = value;
        selectedText.innerText = value;
        selectedText.style.color = 'var(--text-main)';

        iconBox.className = 'option-icon-box ' + colorClass;
        iconBox.style.width = '26px';
        iconBox.style.height = '26px';
        iconBox.style.fontSize = '14px';
        iconEl.setAttribute('icon', iconName);

        wrapper.querySelectorAll('.custom-select-option').forEach(opt => {
            opt.classList.remove('is-selected');
        });
        optionEl.classList.add('is-selected');

        wrapper.classList.remove('is-open');
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.custom-select-wrapper')) {
            document.querySelectorAll('.custom-select-wrapper.is-open').forEach(el => {
                el.classList.remove('is-open');
            });
        }
    });
</script>
@endsection
