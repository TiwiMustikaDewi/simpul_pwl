<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi | SIMPUL</title>

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
            height: 75px;
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
            text-decoration: none;
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
            padding: 40px 20px;
        }

        .card {
            width: 100%;
            max-width: 420px;
            padding: 35px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 18px 55px #315b8814;
        }

        .back-link {
            display: inline-block;
            font-size: 12px;
            margin-bottom: 28px;
        }

        .card h1 {
            font-size: 28px;
            color: var(--blue-dark);
            margin-bottom: 9px;
        }

        .description {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .alert-success,
        .alert-error {
            padding: 12px 13px;
            border-radius: 9px;
            font-size: 12px;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .alert-success {
            background: #e5f8ee;
            color: #18784c;
            border: 1px solid #c2ecd5;
        }

        .alert-error {
            background: #fff0f0;
            color: #c33434;
            border: 1px solid #ffd7d7;
        }

        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .field input {
            width: 100%;
            height: 45px;
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

        .submit-btn {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 10px;
            background: var(--blue);
            color: white;
            font-size: 13px;
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
        }

        .copyright {
            padding: 17px;
            text-align: center;
            color: var(--muted);
            font-size: 11px;
        }

        @media (max-width: 480px) {
            .navbar {
                height: 68px;
                padding: 0 20px;
            }

            .main {
                padding: 25px 15px;
            }

            .card {
                padding: 27px 22px;
                border-radius: 18px;
            }

            .card h1 {
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
        <section class="card">

            <a href="{{ route('login') }}" class="back-link">
                ← Kembali ke login
            </a>

            <h1>Lupa Kata Sandi?</h1>

            <p class="description">
                Masukkan alamat email yang terdaftar untuk melanjutkan
                proses pengaturan ulang kata sandi.
            </p>

            @if (session('status'))
                <div class="alert-success">
                    Permintaan pengaturan ulang kata sandi telah diproses.
                    Silakan periksa log email aplikasi untuk melihat tautan
                    pengaturan ulang kata sandi.
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="field">
                    <label for="email">Alamat Email Terdaftar</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan alamat email"
                        autocomplete="email"
                        required
                        autofocus
                    >
                </div>

                <button type="submit" class="submit-btn">
                    Kirim Tautan Reset Kata Sandi
                </button>
            </form>

            <div class="form-footer">
                <a href="{{ route('login') }}">
                    Kembali ke halaman login
                </a>
            </div>

        </section>
    </main>

    <footer class="copyright">
        © {{ date('Y') }} SIMPUL · Universitas Lampung
    </footer>

</body>
</html>
