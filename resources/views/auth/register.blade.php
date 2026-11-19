<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | SIMPUL</title>

<<<<<<< HEAD
    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy:    #003B5C;
            --ocean:   #005C8A;
            --primary: #0095D9;
            --cyan:    #38BDF8;
            --teal:    #06B6D4;
            --fog:     #DCF1FB;
            --bg:      #F0F7FD;
            --white:   #FFFFFF;
            --text:    #09111E;
            --body:    #162238;
            --muted:   #2B3D56;
            --border:  #C8E1F5;
=======
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #003B5C;
            --ocean: #005C8A;
            --primary: #0095D9;
            --cyan: #38BDF8;
            --teal: #06B6D4;
            --fog: #DCF1FB;
            --bg: #F0F7FD;
            --white: #FFFFFF;
            --text: #09111E;
            --body: #162238;
            --muted: #2B3D56;
            --border: #C8E1F5;
            --blue: #2563EB;
            --blue-dark: #003B5C;
>>>>>>> af4810d (Update registrasi)
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
<<<<<<< HEAD
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
=======
            font-family: 'Poppins', sans-serif;
>>>>>>> af4810d (Update registrasi)
            color: var(--body);
            background:
                radial-gradient(ellipse 70% 50% at 10% 15%, rgba(0, 149, 217, 0.14) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 90% 85%, rgba(56, 189, 248, 0.12) 0%, transparent 60%),
                var(--bg);
        }

        a {
            color: var(--blue);
            text-decoration: none;
        }

        a:hover {
            color: var(--blue-dark);
        }

        .navbar {
            min-height: 75px;
            display: flex;
            align-items: center;
            padding: 0 6%;
            background: rgba(255, 255, 255, .92);
            border-bottom: 1px solid var(--border);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            background: var(--blue);
            color: white;
            border-radius: 12px;
            font-size: 23px;
            font-weight: 800;
            box-shadow: 0 5px 14px #1976e825;
        }

        .brand-name {
            font-size: 20px;
            line-height: 1.3;
            font-weight: 800;
            color: var(--blue-dark);
        }

        .brand-subtitle {
            font-size: 11px;
            color: var(--muted);
        }

        .main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px 20px;
        }

        .register-card {
            width: 100%;
            max-width: 440px;
            padding: 34px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 18px 55px #315b8814;
        }

        .back-link {
            display: inline-block;
            font-size: 12px;
            margin-bottom: 25px;
        }

        .register-card h1 {
            font-size: 28px;
            color: var(--blue-dark);
            margin-bottom: 8px;
        }

        .description {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .role-section {
            margin-bottom: 20px;
        }

        .role-title {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        .role-card {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 12px;
            margin-bottom: 9px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: #fff;
        }

        .role-card.active {
            border-color: var(--blue);
            background: #f4f8ff;
        }

        .role-card input {
            margin-top: 3px;
            accent-color: var(--blue);
        }

        .role-name {
            display: block;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .role-description {
            display: block;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
        }

        .role-notice {
            padding: 11px 12px;
            border-radius: 9px;
            background: #f1f7ff;
            border: 1px solid var(--border);
            color: #536b8b;
            font-size: 11px;
            line-height: 1.6;
            margin-top: 10px;
        }

        .alert-error {
            padding: 12px 13px;
            margin-bottom: 18px;
            background: #fff0f0;
            border: 1px solid #ffd7d7;
            border-radius: 9px;
            color: #c33434;
            font-size: 12px;
            line-height: 1.7;
        }

        .field {
            margin-bottom: 17px;
        }

        .field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .field input,
        .field select {
            width: 100%;
            height: 44px;
            padding: 0 13px;
            border: 1px solid #cfdded;
            border-radius: 9px;
            background: white;
            color: var(--text);
            font-family: inherit;
            font-size: 13px;
            outline: none;
            transition: .2s;
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px #1976e819;
        }

        .field input::placeholder,
        .field select:invalid {
            color: #a0aec0;
        }

        .field select:disabled {
            background: #f3f6fa;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .field-hint {
            display: block;
            margin-top: 6px;
            font-size: 10px;
            color: var(--muted);
        }

        .submit-btn {
            width: 100%;
            height: 46px;
            margin-top: 4px;
            border: none;
            border-radius: 10px;
            background: var(--blue);
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
            font-family: inherit;
        }

        .submit-btn:hover {
            background: #1265ca;
            transform: translateY(-1px);
        }

        .form-footer {
            margin-top: 22px;
            text-align: center;
            font-size: 12px;
            color: var(--muted);
        }

        .copyright {
            padding: 17px;
            text-align: center;
            color: var(--muted);
            font-size: 11px;
        }

        @media (max-width: 480px) {
            .navbar {
                min-height: 68px;
                padding: 0 20px;
            }

            .main {
                padding: 25px 15px;
            }

            .register-card {
                padding: 27px 22px;
                border-radius: 18px;
            }

            .register-card h1 {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>

    <header class="navbar">
        <a href="{{ url('/') }}" class="brand">
            <div class="brand-icon">S</div>
            <div>
                <div class="brand-name">SIMPUL</div>
                <div class="brand-subtitle">
                    Sistem Informasi Manajemen Praktik
                </div>
            </div>
        </a>
    </header>

    <main class="main">
        <section class="register-card">

            <a href="{{ route('login') }}" class="back-link">
                ← Kembali ke login
            </a>

            <h1>Buat akun baru</h1>

            <p class="description">
                Daftarkan akun mahasiswa untuk menggunakan layanan
                Kuliah Praktik Universitas Lampung.
            </p>

            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register.process') }}">
                @csrf

                <div class="role-section">
                    <span class="role-title">Peran pengguna SIMPUL</span>

                    <label class="role-card active">
                        <input
                            type="radio"
                            name="role"
                            value="student"
                            checked
                            required
                        >
                        <span>
                            <span class="role-name">Mahasiswa</span>
                            <span class="role-description">
                                Mendaftar akun untuk mengajukan dan memantau KP.
                            </span>
                        </span>
                    </label>

                    <div class="role-card">
                        <span>
                            <span class="role-name">Admin Jurusan</span>
                            <span class="role-description">
                                Mengelola administrasi, verifikasi berkas,
                                dan proses KP.
                            </span>
                        </span>
                    </div>

                    <div class="role-card">
                        <span>
                            <span class="role-name">Dosen Pembimbing</span>
                            <span class="role-description">
                                Memantau logbook, membimbing mahasiswa,
                                dan memeriksa laporan KP.
                            </span>
                        </span>
                    </div>

                    <div class="role-notice">
                        Pendaftaran mandiri saat ini tersedia untuk mahasiswa.
                        Akun Admin Jurusan dan Dosen Pembimbing ditetapkan
                        melalui pihak berwenang.
                    </div>
                </div>

                <!-- NAMA LENGKAP -->
                <div class="field">
                    <label for="name">Nama lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        autocomplete="name"
                        maxlength="255"
                        required
                        autofocus
                    >
                </div>

                <!-- NPM -->
                <div class="field">
                    <label for="npm">Nomor Pokok Mahasiswa (NPM)</label>
                    <input
                        type="text"
                        id="npm"
                        name="npm"
                        value="{{ old('npm') }}"
                        placeholder="Masukkan NPM"
                        maxlength="20"
                        required
                    >
                    <small class="field-hint">
                        Gunakan NPM sesuai identitas akademik kamu.
                    </small>
                </div>

                <!-- FAKULTAS -->
                <div class="field">
                    <label for="faculty">Fakultas</label>

                    <select id="faculty" name="faculty" required>
                        <option value="">Pilih fakultas</option>
                    </select>
                </div>

                <!-- PROGRAM STUDI -->
                <div class="field">
                    <label for="major">Program Studi</label>

                    <select
                        id="major"
                        name="major"
                        required
                        disabled
                    >
                        <option value="">Pilih fakultas terlebih dahulu</option>
                    </select>

                    <small class="field-hint">
                        Pilihan program studi akan menyesuaikan fakultas.
                    </small>
                </div>

                <!-- EMAIL -->
                <div class="field">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autocomplete="email"
                        maxlength="255"
                        required
                    >
                </div>

                <!-- PASSWORD -->
                <div class="field">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >
                    <small class="field-hint">
                        Gunakan password minimal 8 karakter.
                    </small>
                </div>

                <!-- KONFIRMASI PASSWORD -->
                <div class="field">
                    <label for="password_confirmation">
                        Konfirmasi password
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Masukkan ulang password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >
                </div>

                <button type="submit" class="submit-btn">
                    Daftar sebagai Mahasiswa →
                </button>

            </form>

            <div class="form-footer">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login di sini</a>
            </div>

        </section>
    </main>

    <footer class="copyright">
        © {{ date('Y') }} SIMPUL · Universitas Lampung
    </footer>

    <script>
        // Daftar fakultas dan program studi Universitas Lampung.
        // Nama program disertai jenjang agar program yang namanya sama
        // tetapi berbeda jenjang tetap dapat dibedakan.

        const studyPrograms = {
            "Fakultas Ekonomi dan Bisnis": [
                "D3 - Akuntansi",
                "D3 - Akuntansi PSDKU Way Kanan",
                "D3 - Keuangan dan Perbankan",
                "D3 - Manajemen Pemasaran",
                "D3 - Perbankan dan Keuangan PSDKU Lampung Tengah",
                "D3 - Perpajakan",
                "S1 - Akuntansi",
                "S1 - Bisnis Digital",
                "S1 - Ekonomi Pembangunan",
                "S1 - Manajemen",
                "S2 - Ilmu Akuntansi",
                "S2 - Ilmu Ekonomi",
                "S2 - Manajemen",
                "S3 - Ilmu Akuntansi",
                "S3 - Ilmu Ekonomi"
            ],

            "Fakultas Hukum": [
                "S1 - Ilmu Hukum",
                "S2 - Ilmu Hukum",
                "S3 - Ilmu Hukum"
            ],

            "Fakultas Keguruan dan Ilmu Pendidikan": [
                "S1 - Bimbingan dan Konseling",
                "S1 - Pendidikan Bahasa dan Sastra Indonesia",
                "S1 - Pendidikan Bahasa Inggris",
                "S1 - Pendidikan Bahasa Lampung",
                "S1 - Pendidikan Bahasa Perancis",
                "S1 - Pendidikan Biologi",
                "S1 - Pendidikan Ekonomi",
                "S1 - Pendidikan Fisika",
                "S1 - Pendidikan Geografi",
                "S1 - Pendidikan Guru Pendidikan Anak Usia Dini",
                "S1 - Pendidikan Guru Sekolah Dasar",
                "S1 - Pendidikan Jasmani",
                "S1 - Pendidikan Kimia",
                "S1 - Pendidikan Matematika",
                "S1 - Pendidikan Musik",
                "S1 - Pendidikan Pancasila dan Kewarganegaraan",
                "S1 - Pendidikan Sejarah",
                "S1 - Pendidikan Tari",
                "S1 - Pendidikan Teknologi Informasi",
                "Profesi - Pendidikan Profesi Guru (PPG)",
                "S2 - Administrasi Pendidikan",
                "S2 - Keguruan Guru Sekolah Dasar",
                "S2 - Pendidikan Bahasa dan Kebudayaan Lampung",
                "S2 - Pendidikan Bahasa dan Sastra Indonesia",
                "S2 - Pendidikan Bahasa Inggris",
                "S2 - Pendidikan Fisika",
                "S2 - Pendidikan Ilmu Pengetahuan Alam",
                "S2 - Pendidikan Ilmu Pengetahuan Sosial",
                "S2 - Pendidikan Matematika",
                "S2 - Teknologi Pendidikan",
                "S3 - Pendidikan"
            ],

            "Fakultas Pertanian": [
                "D3 - Perkebunan",
                "S1 - Agribisnis",
                "S1 - Agronomi",
                "S1 - Agroteknologi",
                "S1 - Budidaya Perairan",
                "S1 - Ilmu Kelautan",
                "S1 - Ilmu Tanah",
                "S1 - Kehutanan",
                "S1 - Nutrisi dan Teknologi Pakan Ternak",
                "S1 - Penyuluhan Pertanian",
                "S1 - Peternakan",
                "S1 - Proteksi Tanaman",
                "S1 - Sumberdaya Akuatik",
                "S1 - Teknik Pertanian",
                "S1 - Teknologi Hasil Pertanian",
                "S1 - Teknologi Industri Pertanian",
                "S2 - Agribisnis",
                "S2 - Agronomi",
                "S2 - Kehutanan",
                "S2 - Penyuluhan dan Komunikasi Pertanian",
                "S2 - Teknologi Industri Pertanian",
                "S3 - Ilmu Pertanian"
            ],

            "Fakultas Teknik": [
                "D3 - Teknik Mesin",
                "D3 - Teknik Sipil",
                "D3 - Teknik Survey dan Pemetaan",
                "D4 - Teknologi Rekayasa Otomotif",
                "S1 - Arsitektur",
                "S1 - Teknik Elektro",
                "S1 - Teknik Geodesi",
                "S1 - Teknik Geofisika",
                "S1 - Teknik Geologi",
                "S1 - Teknik Informatika",
                "S1 - Teknik Kimia",
                "S1 - Teknik Lingkungan",
                "S1 - Teknik Mesin",
                "S1 - Teknik Sipil",
                "Profesi - Pendidikan Profesi Insinyur (PPI)",
                "S2 - Teknik Elektro",
                "S2 - Teknik Mesin",
                "S2 - Teknik Sipil"
            ],

            "Fakultas Ilmu Sosial dan Ilmu Politik": [
                "D3 - Administrasi Perkantoran",
                "D3 - Hubungan Masyarakat",
                "D3 - Perpustakaan",
                "S1 - Hubungan Internasional",
                "S1 - Ilmu Administrasi Bisnis",
                "S1 - Ilmu Administrasi Negara",
                "S1 - Ilmu Komunikasi",
                "S1 - Ilmu Pemerintahan",
                "S1 - Sosiologi",
                "S2 - Ilmu Administrasi",
                "S2 - Ilmu Komunikasi",
                "S2 - Ilmu Pemerintahan",
                "S3 - Studi Pembangunan"
            ],

            "Fakultas Matematika dan Ilmu Pengetahuan Alam": [
                "D3 - Manajemen Informatika",
                "S1 - Biologi",
                "S1 - Biologi Terapan",
                "S1 - Fisika",
                "S1 - Ilmu Komputer",
                "S1 - Ilmu Komputer PSDKU Way Kanan",
                "S1 - Kimia",
                "S1 - Matematika",
                "S1 - Sistem Informasi",
                "S2 - Biologi",
                "S2 - Fisika",
                "S2 - Ilmu Komputer",
                "S2 - Kimia",
                "S2 - Matematika",
                "S3 - Matematika dan Ilmu Pengetahuan Alam"
            ],

            "Fakultas Kedokteran": [
                "S1 - Farmasi",
                "S1 - Gizi",
                "S1 - Kedokteran",
                "Profesi - Dokter",
                "S2 - Kesehatan Masyarakat",
                "Spesialis 1 - Pulmonologi dan Ilmu Kedokteran Respirasi"
            ],

            "Pascasarjana": [
                "S2 - Ilmu Lingkungan",
                "S2 - Ilmu Penyuluhan Pembangunan/Pemberdayaan Masyarakat",
                "S2 - Manajemen Wilayah Pesisir dan Laut",
                "S2 - Perencanaan Wilayah dan Kota",
                "S3 - Ilmu Lingkungan"
            ]
        };

        const facultySelect = document.getElementById('faculty');
        const majorSelect = document.getElementById('major');

        const oldFaculty = @json(old('faculty'));
        const oldMajor = @json(old('major'));

        // Mengisi pilihan fakultas.
        Object.keys(studyPrograms).forEach(function(faculty) {
            const option = document.createElement('option');

            option.value = faculty;
            option.textContent = faculty;

            if (faculty === oldFaculty) {
                option.selected = true;
            }

            facultySelect.appendChild(option);
        });

        // Mengisi program studi sesuai fakultas.
        function updateMajor(selectedFaculty, selectedMajor = '') {
            majorSelect.innerHTML = '';

            if (!selectedFaculty || !studyPrograms[selectedFaculty]) {
                majorSelect.disabled = true;

                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Pilih fakultas terlebih dahulu';

                majorSelect.appendChild(option);
                return;
            }

            majorSelect.disabled = false;

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Pilih program studi';
            placeholder.selected = true;

            majorSelect.appendChild(placeholder);

            studyPrograms[selectedFaculty].forEach(function(program) {
                const option = document.createElement('option');

                option.value = program;
                option.textContent = program;

                if (program === selectedMajor) {
                    option.selected = true;
                }

                majorSelect.appendChild(option);
            });
        }

        // Ketika fakultas dipilih, program studi diperbarui.
        facultySelect.addEventListener('change', function() {
            updateMajor(this.value);
        });

        // Memulihkan pilihan jika validasi sebelumnya gagal.
        if (oldFaculty) {
            updateMajor(oldFaculty, oldMajor);
        } else {
            updateMajor('');
        }
    </script>

</body>
</html>
