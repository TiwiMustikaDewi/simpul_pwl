<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | SIMPUL</title>

    <style>
        :root {
            --blue: #1976e8;
            --blue-dark: #174b91;
            --bg: #f1f7ff;
            --text: #183153;
            --muted: #71839d;
            --border: #dce8f6;
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
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 10% 15%, #d9edff 0, transparent 30%),
                radial-gradient(circle at 90% 85%, #d9edff 0, transparent 30%),
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

        .field input {
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

        .field input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px #1976e819;
        }

        .field input::placeholder {
            color: #a0aec0;
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
</body>
</html>
