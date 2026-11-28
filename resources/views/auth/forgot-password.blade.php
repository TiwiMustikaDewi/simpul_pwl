<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi | SIMPUL</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --ink-headline: #091e3a;
            --ink-body: #1e293b;
            --ink-subtext: #475569;
            --ink-muted: #64748b;
            --sky-dark: #1d4ed8;
            --sky-primary: #2563eb;
            --sky-vibrant: #3b82f6;
            --border-soft: #e2e8f0;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body { min-height: 100%; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            padding: 20px 14px;
            color: var(--ink-body);
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(180deg, #1d4ed8 0%, #2563eb 20%, #3b82f6 42%, #60a5fa 65%, #93c5fd 82%, #dbeafe 93%, #fff 100%);
            background-attachment: fixed;
            -webkit-font-smoothing: antialiased;
        }

        body::before, body::after {
            position: fixed;
            z-index: 0;
            inset: -20%;
            content: '';
            pointer-events: none;
            filter: blur(48px);
            background: radial-gradient(ellipse at 35% 30%, rgba(255, 255, 255, .3), transparent 60%);
            animation: ambient 16s ease-in-out infinite alternate;
        }

        body::after {
            background: radial-gradient(ellipse at 70% 60%, rgba(147, 197, 253, .35), transparent 58%);
            animation-duration: 20s;
        }

        @keyframes ambient { to { transform: translate(30px, 24px) scale(1.06); } }

        a { color: var(--sky-primary); text-decoration: none; }

        a:hover { color: var(--sky-dark); }

        .login-stage-container {
            position: relative;
            z-index: 1;
            width: min(1050px, 100%);
            margin: auto;
        }

        .dual-pane-card {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 16px;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, .85);
            border-radius: 28px;
            background: #fff;
            box-shadow: 0 25px 60px -12px rgba(37, 99, 235, .22);
        }

        .showcase-pane {
            position: relative;
            min-height: 540px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            padding: 38px 40px 34px;
            border-radius: 22px;
            color: #fff;
            background: linear-gradient(150deg, #091e3a 0%, #1d4ed8 45%, #2563eb 80%, #3b82f6 100%);
        }

        .showcase-glow {
            position: absolute;
            top: 14%;
            right: -18%;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(96, 165, 250, .5), transparent 70%);
            filter: blur(34px);
        }

        .showcase-back-bar, .showcase-bottom-block { position: relative; z-index: 1; }

        .showcase-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: rgba(255, 255, 255, .88);
            font-size: 13px;
            font-weight: 600;
            transition: color .2s ease, transform .2s ease;
        }

        .showcase-back-btn:hover { color: #fff; transform: translateX(-2px); }

        .recovery-visual {
            position: relative;
            z-index: 1;
            min-height: 250px;
            display: grid;
            place-items: center;
        }

        .visual-orbit {
            position: absolute;
            width: 230px;
            height: 230px;
            border: 1px solid rgba(191, 219, 254, .25);
            border-radius: 50%;
            box-shadow: 0 0 0 22px rgba(255, 255, 255, .035), 0 0 0 46px rgba(255, 255, 255, .025);
        }

        .mail-card {
            position: absolute;
            top: 28px;
            left: 2%;
            width: 180px;
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 15px;
            background: rgba(255, 255, 255, .14);
            box-shadow: 0 14px 28px rgba(0, 20, 60, .2);
            backdrop-filter: blur(12px);
            transform: rotate(-5deg);
        }

        .mail-card-label { margin-bottom: 11px; color: #dbeafe; font-size: 10px; font-weight: 600; }

        .mail-envelope {
            height: 70px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 10px;
            background: rgba(255, 255, 255, .1);
            color: #7dd3fc;
        }

        .lock-card {
            position: absolute;
            right: 4%;
            bottom: 22px;
            width: 138px;
            padding: 17px 14px 14px;
            border: 1px solid rgba(255, 255, 255, .32);
            border-radius: 16px;
            background: rgba(255, 255, 255, .16);
            box-shadow: 0 16px 32px rgba(0, 20, 60, .25);
            text-align: center;
            backdrop-filter: blur(14px);
        }

        .lock-icon {
            width: 56px;
            height: 56px;
            display: grid;
            place-items: center;
            margin: 0 auto 8px;
            border: 2px solid rgba(125, 211, 252, .85);
            border-radius: 50%;
            color: #fff;
        }

        .lock-caption { color: #e0f2fe; font-size: 10px; font-weight: 600; }

        .secure-badge {
            position: absolute;
            right: 5%;
            top: 34px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 20px;
            background: rgba(255, 255, 255, .18);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        .secure-dot { width: 6px; height: 6px; border-radius: 50%; background: #34d399; box-shadow: 0 0 7px #34d399; }

        .showcase-headline {
            margin-bottom: 9px;
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            line-height: 1.25;
            letter-spacing: -.4px;
        }

        .showcase-desc { margin-bottom: 15px; color: #e0f2fe; font-size: 12px; line-height: 1.65; }

        .carousel-dot { display: inline-block; width: 5px; height: 4px; margin-right: 4px; border-radius: 4px; background: rgba(255, 255, 255, .4); }

        .carousel-dot.active { width: 20px; background: #fff; }

        .form-pane {
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 34px 42px 28px;
            border-radius: 22px;
        }

        .form-header-block { margin-bottom: 20px; text-align: center; }

        .form-headline {
            margin-bottom: 5px;
            color: var(--ink-headline);
            font-size: 23px;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -.3px;
        }

        .form-subtitle { color: var(--ink-muted); font-size: 12px; line-height: 1.55; }

        .back-link { display: inline-flex; align-items: center; gap: 6px; margin-bottom: 17px; font-size: 11px; font-weight: 500; }

        .alert-success, .alert-error {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 15px;
            padding: 10px 12px;
            border-radius: 9px;
            font-size: 11px;
            line-height: 1.55;
        }

        .alert-success { border: 1px solid #a7f3d0; background: #ecfdf5; color: #047857; }

        .alert-error { border: 1px solid #fecaca; background: #fef2f2; color: #b91c1c; }

        .alert-icon { flex: 0 0 auto; margin-top: 1px; }

        .field { margin-bottom: 16px; }

        .field label { display: block; margin-bottom: 6px; color: var(--ink-body); font-size: 11.5px; font-weight: 600; }

        .input-wrap { position: relative; display: flex; align-items: center; }

        .input-icon { position: absolute; left: 13px; display: flex; color: #94a3b8; pointer-events: none; }

        .form-input {
            width: 100%;
            height: 45px;
            padding: 0 14px 0 40px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            outline: none;
            background: #f8fafc;
            color: var(--ink-headline);
            font-family: inherit;
            font-size: 13px;
            transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
        }

        .form-input:focus { border-color: var(--sky-primary); background: #fff; box-shadow: 0 0 0 3px rgba(37, 99, 235, .12); }

        .form-input::placeholder { color: #94a3b8; }

        .field-error { display: block; margin-top: 5px; color: #b91c1c; font-size: 10px; }

        .btn-submit {
            width: 100%;
            min-height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            box-shadow: 0 8px 24px rgba(37, 99, 235, .3);
            color: #fff;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, opacity .2s ease;
        }

        .btn-submit:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 11px 28px rgba(37, 99, 235, .38); }

        .btn-submit:focus-visible { outline: 3px solid rgba(37, 99, 235, .28); outline-offset: 3px; }

        .btn-submit:disabled { cursor: wait; opacity: .8; }

        .spinner { width: 15px; height: 15px; border: 2px solid rgba(255, 255, 255, .45); border-top-color: #fff; border-radius: 50%; animation: spin .7s linear infinite; }

        @keyframes spin { to { transform: rotate(360deg); } }

        .form-footer { margin-top: 17px; text-align: center; color: var(--ink-muted); font-size: 11px; }

        .form-footer a { font-weight: 600; }

        @media (max-width: 900px) {
            body { align-items: flex-start; padding: 14px 12px; }
            .login-stage-container { width: 100%; max-width: 540px; margin: 10px auto; }
            .dual-pane-card { grid-template-columns: 1fr; gap: 12px; padding: 12px; border-radius: 24px; }
            .showcase-pane { min-height: 365px; padding: 20px 22px; border-radius: 18px; }
            .recovery-visual { min-height: 180px; }
            .mail-card { top: 16px; left: 3%; }
            .secure-badge { top: 16px; }
            .lock-card { right: 5%; bottom: 10px; }
            .form-pane { padding: 26px 28px 22px; border-radius: 18px; }
        }

        @media (max-width: 480px) {
            body { padding: 8px; }
            .dual-pane-card { gap: 9px; padding: 8px; border-radius: 20px; }
            .showcase-pane { min-height: 320px; padding: 16px; border-radius: 16px; }
            .recovery-visual { min-height: 155px; }
            .visual-orbit { width: 170px; height: 170px; }
            .mail-card { top: 12px; left: 0; width: 150px; padding: 11px; }
            .mail-envelope { height: 56px; }
            .secure-badge { right: 0; top: 12px; padding: 6px 9px; font-size: 9px; }
            .lock-card { right: 0; bottom: 4px; width: 112px; padding: 12px 10px 10px; }
            .lock-icon { width: 45px; height: 45px; }
            .showcase-headline { font-size: 19px; }
            .showcase-desc { font-size: 11px; }
            .form-pane { padding: 22px 14px 18px; }
            .form-headline { font-size: 20px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body>
    <main class="login-stage-container">
        <div class="dual-pane-card">
            <section class="showcase-pane" aria-label="Informasi pemulihan akun SIMPUL">
                <div class="showcase-glow"></div>
                <div class="showcase-back-bar">
                    <a href="{{ url('/') }}" class="showcase-back-btn"><span aria-hidden="true">&#8249;</span> Kembali</a>
                </div>

                <div class="recovery-visual" aria-hidden="true">
                    <div class="visual-orbit"></div>
                    <div class="secure-badge"><span class="secure-dot"></span> Pemulihan Aman</div>
                    <div class="mail-card">
                        <div class="mail-card-label">Tautan Reset Kata Sandi</div>
                        <div class="mail-envelope">
                            <svg width="48" height="38" viewBox="0 0 48 38" fill="none" aria-hidden="true">
                                <rect x="3" y="5" width="42" height="29" rx="5" stroke="currentColor" stroke-width="2"/>
                                <path d="m5 8 19 14L43 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="lock-card">
                        <div class="lock-icon">
                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="4" y="10" width="16" height="11" rx="2"/>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                <circle cx="12" cy="15" r="1"/>
                            </svg>
                        </div>
                        <div class="lock-caption">Akun Terlindungi</div>
                    </div>
                </div>

                <div class="showcase-bottom-block">
                    <h2 class="showcase-headline">Pulihkan Akses Akunmu</h2>
                    <p class="showcase-desc">Lupa kata sandi bukan masalah. Gunakan fitur pemulihan akun SIMPUL untuk mendapatkan kembali akses dan melanjutkan aktivitas Kuliah Praktik dengan mudah.</p>
                    <div aria-hidden="true"><span class="carousel-dot active"></span><span class="carousel-dot"></span><span class="carousel-dot"></span></div>
                </div>
            </section>

            <section class="form-pane">
                <a href="{{ route('login') }}" class="back-link"><span aria-hidden="true">&#8592;</span> Kembali ke login</a>

                <div class="form-header-block">
                    <h1 class="form-headline">Lupa Kata Sandi?</h1>
                    <p class="form-subtitle">Masukkan alamat email yang terdaftar untuk melanjutkan proses pengaturan ulang kata sandi.</p>
                </div>

                @if (session('status'))
                    <div class="alert-success" role="status" aria-live="polite">
                        <svg class="alert-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-error" role="alert">
                        <svg class="alert-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                    @csrf

                    <div class="field">
                        <label for="email">Alamat Email Terdaftar</label>
                        <div class="input-wrap">
                            <span class="input-icon" aria-hidden="true">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                            </span>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input"
                                value="{{ old('email') }}"
                                placeholder="Masukkan alamat email"
                                autocomplete="email"
                                maxlength="255"
                                required
                                autofocus
                            >
                        </div>
                        @error('email')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                    <button type="submit" class="btn-submit" id="sendResetLinkButton">
                        <span class="button-label">Kirim Tautan Reset Kata Sandi</span>
                    </button>
                </form>

                <div class="form-footer"><a href="{{ route('login') }}">Kembali ke halaman login</a></div>
            </section>
        </div>
    </main>

    <script>
        const forgotPasswordForm = document.getElementById('forgotPasswordForm');
        const sendResetLinkButton = document.getElementById('sendResetLinkButton');

        forgotPasswordForm.addEventListener('submit', function () {
            if (!this.reportValidity() || sendResetLinkButton.disabled) {
                return;
            }

            sendResetLinkButton.disabled = true;
            sendResetLinkButton.setAttribute('aria-busy', 'true');
            sendResetLinkButton.innerHTML = '<span class="spinner" aria-hidden="true"></span><span>Mengirim tautan...</span>';
        });
    </script>
</body>
</html>
