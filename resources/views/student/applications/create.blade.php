@extends('layouts.student')

@section('title', 'Form Pengajuan Kesiapan Kuliah Praktik')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="font-size: 22px; font-weight: 700; color: var(--text);">Form Pengajuan Kesiapan Kuliah Praktik</h2>
    <p style="font-size: 13px; color: var(--muted); margin-top: 4px;">
        Pilih instansi tujuan, tentukan rencana tanggal pelaksanaan, dan tentukan apakah mendaftar secara individu atau kelompok.
    </p>
</div>

<div class="panel" style="max-width: 820px; margin: 0 auto;">
    <form action="{{ route('mahasiswa.applications.store') }}" method="POST" id="formPengajuan">
        @csrf

        <!-- PILIH TIPE PENDAFTARAN -->
        <div style="margin-bottom: 22px;">
            <label style="font-weight: 600; font-size: 13.5px; display: block; margin-bottom: 8px;">
                Tipe Pengajuan Kuliah Praktik <span style="color: red;">*</span>
            </label>
            <div style="display: flex; gap: 16px;">
                <label style="flex: 1; display: flex; align-items: center; gap: 10px; padding: 14px 18px; border: 2px solid var(--border); border-radius: 12px; cursor: pointer; transition: all .2s;" id="labelIndividu">
                    <input type="radio" name="type" value="individual" {{ old('type', 'individual') === 'individual' ? 'checked' : '' }} onchange="toggleType('individual')">
                    <div>
                        <div style="font-weight: 700; font-size: 14px;">Individu</div>
                        <div style="font-size: 11.5px; color: var(--muted);">Mendaftar secara mandiri (maks. 3 per instansi)</div>
                    </div>
                </label>

                <label style="flex: 1; display: flex; align-items: center; gap: 10px; padding: 14px 18px; border: 2px solid var(--border); border-radius: 12px; cursor: pointer; transition: all .2s;" id="labelKelompok">
                    <input type="radio" name="type" value="group" {{ old('type') === 'group' ? 'checked' : '' }} onchange="toggleType('group')">
                    <div>
                        <div style="font-weight: 700; font-size: 14px;">Kelompok / Tim</div>
                        <div style="font-size: 11.5px; color: var(--muted);">Mendaftar bersama rekan (maks. 1 kelompok per instansi)</div>
                    </div>
                </label>
            </div>
        </div>

        <!-- PILIH PERUSAHAAN -->
        <div style="margin-bottom: 22px;">
            <label for="company_id" style="font-weight: 600; font-size: 13.5px; display: block; margin-bottom: 6px;">
                Instansi / Perusahaan Tujuan <span style="color: red;">*</span>
            </label>
            <select
                name="company_id"
                id="company_id"
                required
                style="width: 100%; padding: 12px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 13.5px; background: #ffffff;"
            >
                <option value="">-- Pilih Instansi Tempat KP --</option>
                @foreach ($companies as $comp)
                    @php $q = $comp->quota_info; @endphp
                    <option
                        value="{{ $comp->id }}"
                        {{ old('company_id', $selectedCompanyId) == $comp->id ? 'selected' : '' }}
                        {{ $q['is_full'] ? 'disabled' : '' }}
                        data-can-group="{{ $q['can_accept_group'] ? '1' : '0' }}"
                        data-can-indiv="{{ $q['can_accept_individual'] ? '1' : '0' }}"
                    >
                        {{ $comp->name }} ({{ $comp->city }}) — {{ $q['status_label'] }}
                    </option>
                @endforeach
            </select>
            <div style="font-size: 11.5px; color: var(--muted); margin-top: 5px;">
                💡 Instansi yang kuotanya sudah penuh dinonaktifkan otomatis oleh sistem.
            </div>
        </div>

        <!-- SECTION KHUSUS KELOMPOK -->
        <div id="sectionKelompok" style="display: {{ old('type') === 'group' ? 'block' : 'none' }}; background: #f8fbff; border: 1px solid var(--border); border-radius: 12px; padding: 18px; margin-bottom: 22px;">
            <h4 style="font-size: 14px; font-weight: 700; color: var(--brand-dark); margin-bottom: 12px;">
                👥 Data Anggota Kelompok KP
            </h4>

            <div style="margin-bottom: 14px;">
                <label for="group_name" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 5px;">
                    Nama Kelompok / Tim <span style="color: red;">*</span>
                </label>
                <input
                    type="text"
                    name="group_name"
                    id="group_name"
                    value="{{ old('group_name') }}"
                    placeholder="Contoh: Kelompok Riset Web & Mobile"
                    style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px;"
                >
            </div>

            <div style="margin-bottom: 10px;">
                <label style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 5px;">
                    Ketua Kelompok:
                </label>
                <div style="padding: 10px 14px; background: #ffffff; border: 1px solid var(--border); border-radius: 8px; font-size: 13px; font-weight: 600; color: #1e40af;">
                    👑 {{ auth()->user()->name }} ({{ $student->npm }}) — Anda sebagai Ketua
                </div>
            </div>

            <div>
                <label style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">
                    Pilih Rekan Anggota Kelompok (Maksimal 2 anggota):
                </label>
                <div style="max-height: 160px; overflow-y: auto; background: #ffffff; border: 1px solid var(--border); border-radius: 8px; padding: 10px;">
                    @forelse ($availableStudents as $mhs)
                        <label style="display: flex; align-items: center; gap: 8px; padding: 6px 4px; font-size: 12.5px; cursor: pointer;">
                            <input
                                type="checkbox"
                                name="member_ids[]"
                                value="{{ $mhs->id }}"
                                {{ in_array($mhs->id, old('member_ids', [])) ? 'checked' : '' }}
                            >
                            <span><strong>{{ $mhs->user->name }}</strong> (NPM: {{ $mhs->npm }})</span>
                        </label>
                    @empty
                        <div style="font-size: 12px; color: var(--muted); padding: 6px;">
                            Tidak ada rekan mahasiswa lain yang belum terdaftar KP saat ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- JUDUL RENCANA KP -->
        <div style="margin-bottom: 22px;">
            <label for="title" style="font-weight: 600; font-size: 13.5px; display: block; margin-bottom: 6px;">
                Judul / Topik Rencana Kuliah Praktik <span style="color: red;">*</span>
            </label>
            <input
                type="text"
                name="title"
                id="title"
                value="{{ old('title') }}"
                required
                placeholder="Contoh: Perancangan Sistem Informasi Manajemen Pelayanan Pasien Berbasis Web"
                style="width: 100%; padding: 12px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 13.5px;"
            >
        </div>

        <!-- RENTANG TANGGAL -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
            <div>
                <label for="start_date" style="font-weight: 600; font-size: 13.5px; display: block; margin-bottom: 6px;">
                    Tanggal Mulai Pelaksanaan <span style="color: red;">*</span>
                </label>
                <input
                    type="date"
                    name="start_date"
                    id="start_date"
                    value="{{ old('start_date') }}"
                    required
                    style="width: 100%; padding: 11px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 13.5px;"
                >
            </div>

            <div>
                <label for="end_date" style="font-weight: 600; font-size: 13.5px; display: block; margin-bottom: 6px;">
                    Tanggal Selesai Pelaksanaan <span style="color: red;">*</span>
                </label>
                <input
                    type="date"
                    name="end_date"
                    id="end_date"
                    value="{{ old('end_date') }}"
                    required
                    style="width: 100%; padding: 11px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 13.5px;"
                >
            </div>
        </div>

        <!-- SUBMIT BUTTONS -->
        <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 18px; border-top: 1px solid var(--border);">
            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline" style="border-radius: 25px; padding: 10px 20px;">
                Batal
            </a>
            <button type="submit" class="btn-brand" style="padding: 11px 28px;">
                Kirim Pengajuan Kesiapan KP →
            </button>
        </div>
    </form>
</div>

<script>
    function toggleType(type) {
        const sec = document.getElementById('sectionKelompok');
        const lInd = document.getElementById('labelIndividu');
        const lKel = document.getElementById('labelKelompok');

        if (type === 'group') {
            sec.style.display = 'block';
            lKel.style.borderColor = 'var(--brand-primary)';
            lKel.style.background = '#f0f7ff';
            lInd.style.borderColor = 'var(--border)';
            lInd.style.background = '#ffffff';
        } else {
            sec.style.display = 'none';
            lInd.style.borderColor = 'var(--brand-primary)';
            lInd.style.background = '#f0f7ff';
            lKel.style.borderColor = 'var(--border)';
            lKel.style.background = '#ffffff';
        }
    }
</script>
@endsection
