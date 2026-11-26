@extends('layouts.dosen')

@section('title', 'Profil Dosen')

@section('content')
    <div class="page-top">
        <div>
            <div class="breadcrumb">SIMPUL / Dosen / Profil Saya</div>
            <h1>Profil Dosen Pembimbing</h1>
            <p>Kelola data identitas akademik, nomor kontak, dan pantau ringkasan rekam bimbingan Anda.</p>
        </div>
        <a href="{{ route('dosen.dashboard') }}" class="btn btn-outline">← Dashboard</a>
    </div>

    @if (session('success'))
        <div class="notice notice-success" role="status">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="notice notice-error" role="alert">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="notice notice-error" role="alert">
            <strong>Terjadi kesalahan validasi:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="workflow-grid">
        <!-- FORM EDIT PROFIL -->
        <section class="panel workflow-panel">
            <div class="panel-title">
                <h2>Informasi Akun &amp; Identitas Dosen</h2>
                <span class="small-badge">Dosen Pembimbing</span>
            </div>

            <form action="{{ route('dosen.profile.update') }}" method="POST" class="workflow-form form-grid">
                @csrf
                @method('PUT')

                <label class="form-field form-field-wide">
                    <span>Nama Lengkap &amp; Gelar</span>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="form-control"
                        required
                        maxlength="255"
                    >
                    <small style="color: var(--muted); font-size: 10px;">Sertakan gelar akademik lengkap (contoh: Dr. Budi Santoso, M.Kom.).</small>
                </label>

                <label class="form-field">
                    <span>Alamat Email (Login)</span>
                    <input
                        type="email"
                        value="{{ $user->email }}"
                        class="form-control"
                        disabled
                        style="background: #f1f4f9; cursor: not-allowed;"
                    >
                    <small style="color: var(--muted); font-size: 10px;">Email dikelola oleh akun sistem SSO.</small>
                </label>

                <label class="form-field">
                    <span>Nomor Induk Pegawai (NIP)</span>
                    <input
                        type="text"
                        name="nip"
                        value="{{ old('nip', $supervisor->nip) }}"
                        class="form-control"
                        required
                        maxlength="50"
                    >
                    <small style="color: var(--muted); font-size: 10px;">NIP resmi untuk berita acara &amp; penilaian.</small>
                </label>

                <label class="form-field">
                    <span>Jurusan / Program Studi</span>
                    <input
                        type="text"
                        name="department"
                        value="{{ old('department', $supervisor->department) }}"
                        class="form-control"
                        required
                        maxlength="255"
                    >
                    <small style="color: var(--muted); font-size: 10px;">Contoh: Ilmu Komputer, Sistem Informasi.</small>
                </label>

                <label class="form-field">
                    <span>Nomor Telepon / WhatsApp</span>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $supervisor->phone) }}"
                        class="form-control"
                        placeholder="Contoh: 081234567890"
                        maxlength="50"
                    >
                    <small style="color: var(--muted); font-size: 10px;">Nomor kontak untuk koordinasi bimbingan.</small>
                </label>

                <div class="form-field-wide form-actions" style="margin-top: 14px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan Profil</button>
                </div>
            </form>
        </section>

        <!-- KARTU RINGKASAN REKAM BIMBINGAN -->
        <section class="panel workflow-panel">
            <div class="panel-title">
                <h2>Rekapitulasi Bimbingan</h2>
                <span class="small-badge">Statistik Akademik</span>
            </div>

            <div style="display: flex; align-items: center; gap: 14px; padding-bottom: 16px; border-bottom: 1px solid var(--border);">
                @php
                    $cleanName = preg_replace('/^(Dr\.|Prof\.|Ir\.|Drs\.|H\.|Hj\.|Ing\.)\s+/i', '', $user->name);
                    $parts = array_values(array_filter(explode(' ', trim($cleanName))));
                    $profInitials = count($parts) >= 2 ? strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1)) : strtoupper(substr($cleanName, 0, 2));
                @endphp
                <div class="avatar" style="width: 52px; height: 52px; font-size: 17px; font-weight: 800; background: linear-gradient(135deg, #e0efff, #cce4fc); color: var(--blue-dark); box-shadow: 0 4px 10px #173b6710;">
                    {{ $profInitials ?: 'DP' }}
                </div>
                <div>
                    <strong style="font-size: 15px; color: var(--blue-dark); display: block;">{{ $user->name }}</strong>
                    <span style="font-size: 11px; color: var(--muted); font-weight: 600;">NIP: {{ $supervisor->nip }}</span>
                    <span style="font-size: 11px; color: var(--blue); font-weight: 700; display: block; margin-top: 2px;">{{ $supervisor->department }}</span>
                </div>
            </div>

            <div class="detail-grid" style="margin-top: 16px;">
                <div class="detail-item">
                    <span class="label">Total Mahasiswa Bimbingan</span>
                    <span class="val">{{ $stats['total_students'] }} Orang</span>
                </div>

                <div class="detail-item">
                    <span class="label">Bimbingan Sedang Aktif</span>
                    <span class="val" style="color: var(--blue);">{{ $stats['active_students'] }} Orang</span>
                </div>

                <div class="detail-item">
                    <span class="label">Bimbingan Selesai / Lulus</span>
                    <span class="val" style="color: var(--green);">{{ $stats['completed_students'] }} Orang</span>
                </div>

                <div class="detail-item">
                    <span class="label">Catatan Logbook Ditinjau</span>
                    <span class="val">{{ $stats['reviewed_logs'] }} Kegiatan</span>
                </div>

                <div class="detail-item">
                    <span class="label">Laporan Akhir Dievaluasi</span>
                    <span class="val">{{ $stats['reviewed_reports'] }} Berkas</span>
                </div>
            </div>

            <div style="margin-top: 16px; padding: 14px; background: var(--blue-light); border-radius: 12px; font-size: 11px; line-height: 1.8; color: var(--text);">
                <strong style="color: var(--blue-dark); display: block; margin-bottom: 6px;">📋 Panduan Peran Dosen Pembimbing:</strong>
                <ul style="padding-left: 18px; color: #405779;">
                    <li>Lakukan verifikasi berkala pada catatan kegiatan logbook mahasiswa setiap minggunya.</li>
                    <li>Berikan catatan bimbingan atau instruksi perbaikan bila terdapat aktivitas yang belum sesuai.</li>
                    <li>Periksa berkas draf laporan akhir KP dan berikan persetujuan sebelum mahasiswa melaksanakan sidang.</li>
                    <li>Lakukan evaluasi, berita acara, dan penginputan nilai pada pelaksanaan sidang Kuliah Praktik.</li>
                </ul>
            </div>
        </section>
    </div>
@endsection
