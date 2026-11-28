<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru | SIMPUL</title>

    <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">

    <style>
        :root { --ink-headline: #091e3a; --ink-body: #1e293b; --ink-subtext: #475569; --ink-muted: #64748b; --sky-dark: #1d4ed8; --sky-primary: #2563eb; --sky-vibrant: #3b82f6; --border-soft: #e2e8f0; }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px 14px; overflow-x: hidden; font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: var(--ink-body); background: linear-gradient(180deg, #1d4ed8 0%, #2563eb 20%, #3b82f6 42%, #60a5fa 65%, #93c5fd 82%, #dbeafe 93%, #fff 100%); background-attachment: fixed; -webkit-font-smoothing: antialiased; }
        body::before, body::after { content: ''; position: fixed; inset: -20%; z-index: 0; pointer-events: none; filter: blur(48px); background: radial-gradient(ellipse at 35% 30%, rgba(255,255,255,.3), transparent 60%); animation: ambient 16s ease-in-out infinite alternate; }
        body::after { background: radial-gradient(ellipse at 70% 60%, rgba(147,197,253,.35), transparent 58%); animation-duration: 20s; }
        @keyframes ambient { to { transform: translate(30px, 24px) scale(1.06); } }
        a { color: var(--sky-primary); text-decoration: none; }
        .login-stage-container { position: relative; z-index: 1; width: min(1050px, 100%); margin: auto; }
        .dual-pane-card { display: grid; grid-template-columns: 1.05fr .95fr; gap: 16px; padding: 16px; border: 1px solid rgba(255,255,255,.85); border-radius: 28px; background: #fff; box-shadow: 0 25px 60px -12px rgba(37,99,235,.22); }
        .showcase-pane { position: relative; min-height: 600px; padding: 38px 40px 34px; border-radius: 22px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; color: #fff; background: linear-gradient(150deg,#091e3a 0%,#1d4ed8 45%,#2563eb 80%,#3b82f6 100%); }
        .showcase-glow { position: absolute; top: 15%; right: -15%; width: 300px; height: 300px; border-radius: 50%; background: radial-gradient(circle,rgba(96,165,250,.5),transparent 70%); filter: blur(30px); }
        .showcase-back-bar, .showcase-bottom-block { position: relative; z-index: 1; }
        .showcase-back-btn { color: rgba(255,255,255,.88); font-size: 13px; font-weight: 600; }
        .showcase-visual-hub { position: relative; z-index: 1; height: 225px; display: flex; align-items: center; justify-content: center; }
        .ui-float-card-chart, .ui-float-card-pie, .ui-pill-badge { position: absolute; border: 1px solid rgba(255,255,255,.3); background: rgba(255,255,255,.14); backdrop-filter: blur(12px); box-shadow: 0 14px 28px rgba(0,20,60,.2); }
        .ui-float-card-chart { top: 12%; left: 0; width: 60%; padding: 14px; border-radius: 14px; }
        .chart-header, .pie-label { color: #dbeafe; font-size: 11px; font-weight: 600; }
        .chart-header { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .chart-dot, .badge-pulse-dot { width: 7px; height: 7px; border-radius: 50%; background: #38bdf8; }
        .chart-svg { width: 100%; height: 52px; }
        .ui-float-card-pie { right: 0; bottom: 8%; width: 120px; padding: 14px; border-radius: 15px; text-align: center; }
        .pie-ring-wrap { position: relative; width: 58px; height: 58px; margin: 0 auto 6px; }
        .pie-ring-svg { width: 58px; height: 58px; transform: rotate(-90deg); }
        .pie-ring-bg, .pie-ring-fill { fill: none; stroke-width: 5; }
        .pie-ring-bg { stroke: rgba(255,255,255,.2); }
        .pie-ring-fill { stroke: #38bdf8; stroke-linecap: round; stroke-dasharray: 175; stroke-dashoffset: 44; }
        .pie-center-text { position: absolute; inset: 0; display: grid; place-items: center; font-size: 12px; font-weight: 700; }
        .ui-pill-badge { display: inline-flex; align-items: center; gap: 7px; padding: 7px 12px; border-radius: 20px; font-size: 10px; font-weight: 600; }
        .pill-badge-top { top: 2%; right: 4%; }
        .pill-badge-bot { bottom: 0; left: 4%; }
        .badge-pulse-dot { background: #10b981; }
        .showcase-headline { margin-bottom: 9px; font-size: 22px; font-weight: 700; line-height: 1.25; letter-spacing: -.4px; }
        .showcase-desc { margin-bottom: 15px; color: #e0f2fe; font-size: 12px; line-height: 1.65; }
        .carousel-dot { display: inline-block; width: 5px; height: 4px; margin-right: 4px; border-radius: 4px; background: rgba(255,255,255,.4); }
        .carousel-dot.active { width: 20px; background: #fff; }
        .form-pane { min-width: 0; padding: 30px 42px 26px; border-radius: 22px; display: flex; flex-direction: column; justify-content: center; }
        .back-link { align-self: flex-start; margin-bottom: 14px; font-size: 11px; }
        .form-header-block { margin-bottom: 18px; text-align: center; }
        .form-headline { margin-bottom: 4px; color: var(--ink-headline); font-size: 23px; font-weight: 700; line-height: 1.2; letter-spacing: -.3px; }
        .form-subtitle { color: var(--ink-muted); font-size: 12px; line-height: 1.5; }
        .alert-error { margin-bottom: 12px; padding: 9px 12px; border: 1px solid #fecaca; border-radius: 9px; background: #fef2f2; color: #b91c1c; font-size: 11px; line-height: 1.5; }
        .role-section { margin-bottom: 12px; }
        .role-title, .field label { display: block; margin-bottom: 5px; color: var(--ink-body); font-size: 11.5px; font-weight: 600; }
        .role-card { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 7px; padding: 9px 11px; border: 1px solid #cbd5e1; border-radius: 10px; background: #fff; cursor: pointer; }
        .role-card.active { border-color: var(--sky-primary); background: #f4f8ff; }
        .role-card input { margin-top: 3px; accent-color: var(--sky-primary); }
        .role-name { display: block; margin-bottom: 2px; font-size: 11px; font-weight: 700; }
        .role-description { display: block; color: var(--ink-subtext); font-size: 10px; line-height: 1.45; }
        .role-notice { margin-top: 8px; padding: 9px 10px; border: 1px solid #bfdbfe; border-radius: 9px; background: #eff6ff; color: #536b8b; font-size: 10px; line-height: 1.5; }
        .field { margin-bottom: 13px; }
        .field input, .field select { width: 100%; height: 44px; padding: 0 14px; border: 1px solid #cbd5e1; border-radius: 10px; outline: none; background: #f8fafc; color: var(--ink-headline); font: 13px inherit; font-family: inherit; font-size: 13px; transition: .2s; }
        .field input:focus, .field select:focus { border-color: var(--sky-primary); background: #fff; box-shadow: 0 0 0 3px rgba(37,99,235,.12); }
        .field input::placeholder { color: #94a3b8; }
        .field select:disabled { background: #f3f6fa; color: #94a3b8; cursor: not-allowed; }
        .field-hint, .field-error { display: block; margin-top: 5px; font-size: 10px; }
        .field-hint { color: var(--ink-muted); }
        .field-error { color: #b91c1c; }
        .client-error { display: block; margin-top: 5px; color: #b91c1c; font-size: 10px; }
        .copyright { display: none; }
        .step-indicator { margin: 0 0 15px; }
        .step-topline { display: flex; justify-content: space-between; margin-bottom: 7px; color: var(--ink-muted); font-size: 10px; }
        .progress-track { height: 5px; overflow: hidden; border-radius: 5px; background: #e2e8f0; }
        .progress-fill { height: 100%; border-radius: inherit; background: linear-gradient(90deg,#1d4ed8,#3b82f6); transition: width .35s ease; }
        .form-step { display: none; animation: stepIn .28s ease both; }
        .form-step.active { display: block; }
        @keyframes stepIn { from { opacity: 0; transform: translateX(8px); } to { opacity: 1; transform: translateX(0); } }
        .step-actions { display: flex; gap: 10px; margin-top: 5px; }
        .step-btn { min-height: 46px; padding: 0 18px; border: 0; border-radius: 11px; font-family: inherit; font-size: 13px; font-weight: 600; cursor: pointer; }
        .step-btn.next, .step-btn.submit { flex: 1; background: linear-gradient(135deg,#1d4ed8,#3b82f6); color: #fff; box-shadow: 0 8px 24px rgba(37,99,235,.3); }
        .step-btn.previous { border: 1px solid #cbd5e1; background: #fff; color: #475569; }
        .form-signup-prompt { margin-top: 13px; text-align: center; color: var(--ink-muted); font-size: 11px; }
        .form-signup-prompt a { color: var(--sky-primary); font-weight: 600; }
        @media (max-width: 900px) { body { align-items: flex-start; padding: 14px 12px; } .login-stage-container { max-width: 540px; } .dual-pane-card { grid-template-columns: 1fr; padding: 12px; gap: 12px; border-radius: 24px; } .showcase-pane { min-height: 300px; padding: 20px 22px; border-radius: 18px; } .showcase-visual-hub { height: 145px; margin: 8px 0; } .showcase-bottom-block { display: block; } .showcase-headline { font-size: 19px; } .form-pane { padding: 24px 28px 22px; border-radius: 18px; } }
        @media (max-width: 480px) { body { padding: 8px; } .dual-pane-card { padding: 8px; border-radius: 20px; } .showcase-pane { min-height: 245px; padding: 16px; } .showcase-visual-hub { height: 125px; } .ui-float-card-chart { width: 58%; } .ui-float-card-pie { width: 105px; padding: 10px; } .form-pane { padding: 20px 14px 18px; } .form-headline { font-size: 20px; } .step-btn { padding: 0 13px; } }

    </style>
</head>

<body>
    <main class="login-stage-container">
        <div class="dual-pane-card">
            <section class="showcase-pane" aria-label="Informasi SIMPUL">
                <div class="showcase-glow"></div>
                <div class="showcase-back-bar"><a href="{{ url('/') }}" class="showcase-back-btn">&lt; Kembali</a></div>
                <div class="showcase-visual-hub" aria-hidden="true">
                    <div class="ui-pill-badge pill-badge-top"><span class="badge-pulse-dot"></span><span>Mulai Perjalanan KP</span></div>
                    <div class="ui-float-card-chart"><div class="chart-header"><span>Aktivitas Mingguan</span><span class="chart-dot"></span></div><svg class="chart-svg" viewBox="0 0 160 48" fill="none"><path d="M0,38 Q30,12 60,26 T120,8 T160,22" stroke="#38bdf8" stroke-width="2.5" fill="none" stroke-linecap="round"/><circle cx="60" cy="26" r="3.5" fill="#fff" stroke="#38bdf8" stroke-width="2"/><circle cx="120" cy="8" r="3.5" fill="#fff" stroke="#38bdf8" stroke-width="2"/></svg></div>
                    <div class="ui-float-card-pie"><div class="pie-ring-wrap"><svg class="pie-ring-svg" viewBox="0 0 64 64"><circle class="pie-ring-bg" cx="32" cy="32" r="26"/><circle class="pie-ring-fill" cx="32" cy="32" r="26"/></svg><span class="pie-center-text">75%</span></div><div class="pie-label">Progres KP</div></div>
                    <div class="ui-pill-badge pill-badge-bot"><span>OK</span><span>Logbook Terpantau</span></div>
                </div>
                <div class="showcase-bottom-block"><h2 class="showcase-headline">Bergabung dengan SIMPUL</h2><p class="showcase-desc">Mulai perjalanan Kuliah Praktikmu dengan lebih mudah. Daftarkan akun untuk mengakses layanan administrasi, pengajuan KP, pemantauan logbook, hingga proses penyelesaian Kuliah Praktik dalam satu platform.</p><div><span class="carousel-dot active"></span><span class="carousel-dot"></span><span class="carousel-dot"></span></div></div>
            </section>
            <section class="form-pane">

            <a href="{{ route('login') }}" class="back-link">
                ← Kembali ke login
            </a>

            <div class="form-header-block"><h1 class="form-headline">Buat Akun Baru</h1><p class="form-subtitle">Lengkapi informasi berikut untuk mendaftar ke SIMPUL</p></div>

            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register.process') }}" id="registerForm" novalidate>
                @csrf
                <div class="step-indicator" aria-live="polite"><div class="step-topline"><span id="stepLabel">Step 1 dari 3: Informasi Pengguna</span><span id="stepPercent">33%</span></div><div class="progress-track"><div class="progress-fill" id="progressFill" style="width: 33.333%"></div></div></div>
                <div class="form-step active" data-step="0">

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
                    @error('name')<small class="field-error">{{ $message }}</small>@enderror
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
                    @error('npm')<small class="field-error">{{ $message }}</small>@enderror
                </div>

                </div>
                <div class="form-step" data-step="1">
                <!-- FAKULTAS -->
                <div class="field">
                    <label for="faculty">Fakultas</label>

                    <select id="faculty" name="faculty" required>
                        <option value="">Pilih fakultas</option>
                    </select>
                    @error('faculty')<small class="field-error">{{ $message }}</small>@enderror
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
                    @error('major')<small class="field-error">{{ $message }}</small>@enderror
                </div>

                </div>
                <div class="form-step" data-step="2">
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
                    @error('email')<small class="field-error">{{ $message }}</small>@enderror
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
                    @error('password')<small class="field-error">{{ $message }}</small>@enderror
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
                    @error('password_confirmation')<small class="field-error">{{ $message }}</small>@enderror
                    <small class="field-error" id="passwordMatchError" hidden>Konfirmasi password harus sama.</small>
                </div>

                </div>
                <div class="step-actions"><button type="button" class="step-btn previous" id="previousStep" hidden>Previous</button><button type="button" class="step-btn next" id="nextStep">Next</button><button type="submit" class="step-btn submit" id="submitRegistration" hidden>Daftar Sekarang</button></div>
                <button type="submit" class="submit-btn" id="legacySubmit" hidden>
                    Daftar sebagai Mahasiswa →
                </button>

            </form>

            <div class="form-signup-prompt">
                Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>

            </section>
        </div>
    </main>

    <footer class="copyright">
        © {{ date('Y') }} SIMPUL · Universitas Lampung
    </footer>

    <script>
        const formSteps = Array.from(document.querySelectorAll('.form-step'));
        const stepNames = ['Informasi Pengguna', 'Informasi Akademik', 'Informasi Akun'];
        const nextStepButton = document.getElementById('nextStep');
        const previousStepButton = document.getElementById('previousStep');
        const submitRegistrationButton = document.getElementById('submitRegistration');
        const stepLabel = document.getElementById('stepLabel');
        const progressFill = document.getElementById('progressFill');
        const stepPercent = document.getElementById('stepPercent');
        const passwordConfirmation = document.getElementById('password_confirmation');
        const passwordMatchError = document.getElementById('passwordMatchError');
        let currentStep = @if ($errors->has('email') || $errors->has('password')) 2 @elseif ($errors->has('faculty') || $errors->has('major')) 1 @else 0 @endif;

        function showStep(step) {
            currentStep = step;
            formSteps.forEach(function(panel, index) {
                panel.classList.toggle('active', index === step);
            });
            previousStepButton.hidden = step === 0;
            nextStepButton.hidden = step === formSteps.length - 1;
            submitRegistrationButton.hidden = step !== formSteps.length - 1;
            stepLabel.textContent = `Step ${step + 1} dari ${formSteps.length}: ${stepNames[step]}`;
            const progress = ((step + 1) / formSteps.length) * 100;
            progressFill.style.width = `${progress}%`;
            stepPercent.textContent = `${Math.round(progress)}%`;
        }

        function validateCurrentStep() {
            const fields = Array.from(formSteps[currentStep].querySelectorAll('input[required], select[required]'));
            formSteps[currentStep].querySelectorAll('.client-error').forEach(function(message) { message.remove(); });
            const invalidField = fields.find(function(field) { return !field.checkValidity(); });
            if (invalidField) {
                const message = document.createElement('small');
                message.className = 'client-error';
                message.textContent = invalidField.validity.valueMissing ? 'Bagian ini wajib diisi.' : 'Masukkan format yang valid.';
                invalidField.insertAdjacentElement('afterend', message);
                invalidField.reportValidity();
                invalidField.focus();
                return false;
            }
            return true;
        }

        nextStepButton.addEventListener('click', function() {
            if (validateCurrentStep()) { showStep(currentStep + 1); }
        });
        previousStepButton.addEventListener('click', function() { showStep(currentStep - 1); });
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password');
            if (!validateCurrentStep() || password.value !== passwordConfirmation.value) {
                event.preventDefault();
                passwordMatchError.hidden = password.value === passwordConfirmation.value;
                if (password.value !== passwordConfirmation.value) { passwordConfirmation.focus(); }
            }
        });
        passwordConfirmation.addEventListener('input', function() {
            passwordMatchError.hidden = this.value === document.getElementById('password').value;
        });
        showStep(currentStep);

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
