<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke SIMPUL | Sistem Informasi Manajemen Praktik Unila</title>

    <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════════════════════════
           DESIGN TOKENS: Monopol Sky-Blue to White Ambient Palette
        ═══════════════════════════════════════════════════════════════ */
        :root {
            --ink-headline:       #091e3a;
            --ink-body:           #1e293b;
            --ink-subtext:        #475569;
            --ink-muted:          #64748b;

            /* Luminous Cerulean & Sky-Blue Palette */
            --sky-dark:           #1d4ed8;
            --sky-primary:        #2563eb;
            --sky-vibrant:        #3b82f6;
            --sky-light:          #60a5fa;
            --sky-pastel:         #93c5fd;
            --sky-ice:            #bfdbfe;
            --sky-powder:         #dbeafe;
            --sky-ghost:          #f0f7ff;
            --border-soft:        #e2e8f0;

            /* Shadows */
            --shadow-subtle:      0 4px 16px rgba(15, 23, 42, 0.04);
            --shadow-card:        0 20px 48px -10px rgba(15, 23, 42, 0.14);
            --shadow-float:       0 25px 60px -12px rgba(37, 99, 235, 0.22);
            --shadow-btn:         0 8px 24px rgba(37, 99, 235, 0.35);
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            min-height: 100vh;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--ink-body);
            background: linear-gradient(180deg, 
                #1d4ed8 0%, 
                #2563eb 20%, 
                #3b82f6 42%, 
                #60a5fa 65%, 
                #93c5fd 82%, 
                #dbeafe 93%, 
                #ffffff 100%
            );
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 14px;
            overflow-x: hidden;
            position: relative;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Dynamic Flowing Ambient Waves (Animasi Berjalan Halus) ── */
        .flowing-wave-1 {
            position: fixed;
            top: -25%;
            left: -15%;
            width: 130%;
            height: 90%;
            background: radial-gradient(ellipse 65% 50% at 35% 30%, rgba(255, 255, 255, 0.35) 0%, rgba(96, 165, 250, 0.3) 40%, transparent 75%);
            filter: blur(48px);
            pointer-events: none;
            z-index: 0;
            animation: flowMotion1 16s ease-in-out infinite alternate;
        }

        .flowing-wave-2 {
            position: fixed;
            top: -20%;
            right: -20%;
            width: 130%;
            height: 90%;
            background: radial-gradient(ellipse 60% 45% at 65% 35%, rgba(147, 197, 253, 0.4) 0%, rgba(37, 99, 235, 0.28) 45%, transparent 75%);
            filter: blur(50px);
            pointer-events: none;
            z-index: 0;
            animation: flowMotion2 18s ease-in-out infinite alternate;
        }

        .flowing-light-sweep {
            position: fixed;
            inset: 0;
            background: linear-gradient(120deg, 
                transparent 15%, 
                rgba(255, 255, 255, 0.22) 45%, 
                rgba(191, 219, 254, 0.25) 55%, 
                transparent 80%
            );
            background-size: 250% 100%;
            animation: sweepStream 12s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes flowMotion1 {
            0% { transform: translate3d(0, 0, 0) scale(1) rotate(0deg); }
            50% { transform: translate3d(70px, 30px, 0) scale(1.1) rotate(3deg); }
            100% { transform: translate3d(-40px, 50px, 0) scale(0.96) rotate(-2deg); }
        }

        @keyframes flowMotion2 {
            0% { transform: translate3d(0, 0, 0) scale(1) rotate(0deg); }
            50% { transform: translate3d(-80px, 35px, 0) scale(1.12) rotate(-3deg); }
            100% { transform: translate3d(50px, -20px, 0) scale(0.96) rotate(2deg); }
        }

        @keyframes sweepStream {
            0% { background-position: 220% 0; opacity: 0.4; }
            50% { opacity: 0.85; }
            100% { background-position: -120% 0; opacity: 0.4; }
        }

        /* ── Main Dual-Pane Stage Container (Balanced Proportions) ── */
        .login-stage-container {
            position: relative;
            z-index: 10;
            width: min(1050px, 92%);
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dual-pane-card {
            width: 100%;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: var(--shadow-float);
            border: 1px solid rgba(255, 255, 255, 0.85);
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            overflow: hidden;
            padding: 16px;
            gap: 16px;
        }

        /* ── LEFT PANE: SHOWCASE CARD (Rich Royal Blue Gradient) ── */
        .showcase-pane {
            position: relative;
            background: linear-gradient(150deg, #091e3a 0%, #1d4ed8 45%, #2563eb 80%, #3b82f6 100%) !important;
            border-radius: 22px;
            padding: 38px 40px 34px;
            min-height: 540px;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.35);
        }

        /* Ambient Glow Inside Showcase */
        .showcase-glow {
            position: absolute;
            top: 20%;
            right: -20%;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.45) 0%, transparent 70%);
            filter: blur(40px);
            pointer-events: none;
        }

        /* Back Button on Showcase Pane (Pure text + chevron) */
        .showcase-back-bar {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            z-index: 2;
        }

        .showcase-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0;
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s ease;
        }

        .showcase-back-btn:hover {
            color: #ffffff;
            transform: translateX(-3px);
        }

        .showcase-back-btn svg {
            transition: transform .2s ease;
        }

        .showcase-back-btn:hover svg {
            transform: translateX(-2px);
        }

        /* Floating UI Mockups in Center */
        .showcase-visual-hub {
            position: relative;
            z-index: 2;
            margin: 20px 0;
            height: 195px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Floating Analytics Mini Card */
        .ui-float-card-chart {
            position: absolute;
            left: 2%;
            top: 6%;
            width: 195px;
            padding: 12px 16px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.28);
            backdrop-filter: blur(14px);
            box-shadow: 0 14px 28px rgba(0, 20, 60, 0.25);
            animation: cardFloat1 5s ease-in-out infinite alternate;
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 10.5px;
            font-weight: 600;
            color: #bae6fd;
            margin-bottom: 6px;
        }

        .chart-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #38bdf8;
            box-shadow: 0 0 8px #38bdf8;
        }

        .chart-svg {
            width: 100%;
            height: 44px;
            overflow: visible;
        }

        /* Floating Metric Circle / Pie Widget */
        .ui-float-card-pie {
            position: absolute;
            right: 4%;
            bottom: 6%;
            width: 140px;
            padding: 12px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.32);
            backdrop-filter: blur(14px);
            box-shadow: 0 16px 32px rgba(0, 20, 60, 0.3);
            text-align: center;
            animation: cardFloat2 5.6s ease-in-out infinite alternate;
        }

        .pie-ring-wrap {
            position: relative;
            width: 58px;
            height: 58px;
            margin: 0 auto 5px;
        }

        .pie-ring-svg {
            transform: rotate(-90deg);
            width: 58px;
            height: 58px;
        }

        .pie-ring-bg {
            fill: none;
            stroke: rgba(255, 255, 255, 0.2);
            stroke-width: 5;
        }

        .pie-ring-fill {
            fill: none;
            stroke: #38bdf8;
            stroke-width: 5;
            stroke-linecap: round;
            stroke-dasharray: 175;
            stroke-dashoffset: 44;
        }

        .pie-center-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 12.5px;
            font-weight: 700;
            color: #ffffff;
        }

        .pie-label {
            font-size: 10px;
            font-weight: 500;
            color: #e0f2fe;
        }

        /* Floating Pill Badges */
        .ui-pill-badge {
            position: absolute;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.35);
            backdrop-filter: blur(10px);
            font-size: 10.5px;
            font-weight: 600;
            color: #ffffff;
            box-shadow: 0 6px 16px rgba(0, 20, 60, 0.2);
        }

        .pill-badge-top {
            top: 0%;
            right: 18%;
            animation: cardFloat1 4.8s ease-in-out infinite alternate;
        }

        .pill-badge-bot {
            bottom: 0%;
            left: 12%;
            animation: cardFloat2 6.2s ease-in-out infinite alternate;
        }

        .badge-pulse-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 6px #10b981;
        }

        @keyframes cardFloat1 {
            0% { transform: translateY(0); }
            100% { transform: translateY(-8px); }
        }

        @keyframes cardFloat2 {
            0% { transform: translateY(0); }
            100% { transform: translateY(8px); }
        }

        /* Showcase Bottom Copy */
        .showcase-bottom-block {
            z-index: 2;
        }

        .showcase-headline {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.25;
            letter-spacing: -0.4px;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .showcase-desc {
            font-size: 12px;
            font-weight: 400;
            line-height: 1.6;
            color: #e0f2fe;
            margin-bottom: 14px;
            opacity: 0.92;
        }

        .showcase-carousel-dots {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .carousel-dot {
            height: 4px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.35);
            transition: all .25s ease;
        }

        .carousel-dot.active {
            width: 20px;
            background: #ffffff;
        }

        .carousel-dot:not(.active) {
            width: 5px;
        }

        /* ── RIGHT PANE: LOGIN FORM (Balanced Height) ── */
        .form-pane {
            background: #ffffff;
            border-radius: 22px;
            padding: 34px 42px 28px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .form-header-block {
            margin-bottom: 18px;
            text-align: center;
        }

        .form-headline {
            font-size: 23px;
            font-weight: 700;
            color: var(--ink-headline);
            line-height: 1.2;
            letter-spacing: -0.3px;
            margin-bottom: 4px;
        }

        .form-subtitle {
            font-size: 12px;
            font-weight: 400;
            color: var(--ink-muted);
            line-height: 1.45;
        }

        /* Alerts */
        .alert-success,
        .alert-error {
            padding: 9px 13px;
            border-radius: 9px;
            font-size: 11.5px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 7px;
            line-height: 1.4;
        }

        .alert-success {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* Form Inputs & Fields */
        .form-group {
            margin-bottom: 12px;
        }

        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--ink-body);
            margin-bottom: 5px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            height: 44px;
            padding: 0 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            background: #f8fafc;
            color: var(--ink-headline);
            font-family: inherit;
            font-size: 13px;
            outline: none;
            transition: all .2s ease;
        }

        .form-input:focus {
            background: #ffffff;
            border-color: var(--sky-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .select-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-select {
            width: 100%;
            height: 44px;
            padding: 0 46px 0 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            background: #f8fafc;
            color: var(--ink-headline);
            font-family: inherit;
            font-size: 13px;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            transition: all .2s ease;
        }

        .form-select:focus {
            background: #ffffff;
            border-color: var(--sky-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .select-chevron-icon {
            position: absolute;
            right: 18px;
            pointer-events: none;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color .2s ease;
        }

        .select-wrap:hover .select-chevron-icon,
        .form-select:focus ~ .select-chevron-icon {
            color: var(--sky-primary);
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        /* Password Eye Toggle */
        .password-toggle-btn {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px;
            display: grid;
            place-items: center;
            transition: color .2s ease;
        }

        .password-toggle-btn:hover {
            color: var(--sky-primary);
        }

        /* Form Meta (Remember Me & Forgot Password) */
        .form-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 12px 0 16px;
            font-size: 11.5px;
        }

        .remember-checkbox-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--ink-subtext);
            cursor: pointer;
            user-select: none;
        }

        .remember-checkbox-label input {
            accent-color: var(--sky-primary);
            width: 14px;
            height: 14px;
            cursor: pointer;
        }

        .forgot-password-link {
            color: var(--sky-primary);
            font-weight: 600;
            text-decoration: none;
            transition: color .2s ease;
        }

        .forgot-password-link:hover {
            color: var(--sky-dark);
            text-decoration: underline;
        }

        /* Submit Button (Vibrant Blue Pill) */
        .btn-submit-login {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            color: #ffffff;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: var(--shadow-btn);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all .25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .btn-submit-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.42);
        }

        .btn-submit-login:active {
            transform: translateY(0);
        }

        /* Sign Up Callout */
        .form-signup-prompt {
            margin-top: 12px;
            text-align: center;
            font-size: 12px;
            color: var(--ink-muted);
        }

        .form-signup-prompt a {
            color: var(--sky-primary);
            font-weight: 600;
            text-decoration: none;
            transition: color .2s ease;
        }

        .form-signup-prompt a:hover {
            color: var(--sky-dark);
            text-decoration: underline;
        }

        /* Footer Terms & Policy */
        .form-legal-links {
            margin-top: 14px;
            padding-top: 10px;
            border-top: 1px solid #f1f5f9;
            text-align: center;
            font-size: 10.5px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .form-legal-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: color .2s ease;
        }

        .form-legal-links a:hover {
            color: var(--sky-primary);
        }

        /* ── Responsive Rules (Mobile: Showcase Visual Graphic On Top, Form Below) ── */
        @media (max-width: 900px) {
            body {
                padding: 16px 12px;
                min-height: 100vh;
                align-items: flex-start;
            }

            .login-stage-container {
                width: 100%;
                max-width: 480px;
                margin: 10px auto;
            }

            .dual-pane-card {
                grid-template-columns: 1fr;
                padding: 12px;
                gap: 12px;
                border-radius: 24px;
            }

            .showcase-pane {
                display: flex;
                flex-direction: column;
                padding: 18px 20px 16px;
                min-height: auto;
                border-radius: 18px;
            }

            .showcase-back-bar {
                justify-content: flex-start;
            }

            .showcase-visual-hub {
                height: 165px;
                margin: 10px 0;
                transform: scale(0.92);
                transform-origin: center center;
            }

            /* Sembunyikan teks headline & deskripsi pada mobile sesuai request, tampilkan visual animasinya saja */
            .showcase-bottom-block {
                display: none !important;
            }

            .form-pane {
                padding: 24px 20px 20px;
                border-radius: 18px;
            }

            .form-headline {
                font-size: 20px;
            }
        }

        @media (max-width: 440px) {
            .showcase-visual-hub {
                height: 150px;
                transform: scale(0.82);
            }

            .showcase-pane {
                padding: 16px 14px 14px;
            }

            .form-pane {
                padding: 20px 16px 18px;
            }
        }
    </style>
</head>

<body>

    <!-- Dynamic Flowing Ambient Waves (Animasi Berjalan) -->
    <div class="flowing-wave-1"></div>
    <div class="flowing-wave-2"></div>
    <div class="flowing-light-sweep"></div>

    <!-- Main Dual-Pane Stage (Centered Viewport) -->
    <main class="login-stage-container">
        <div class="dual-pane-card">

            <!-- ═══════════════════════════════════════════════════════════
                 LEFT PANE: SHOWCASE CARD (Cliqk Inspired)
            ═══════════════════════════════════════════════════════════════ -->
            <section class="showcase-pane">
                <div class="showcase-glow"></div>

                <!-- Back Link Inside Showcase (Moved to Top-Left) -->
                <div class="showcase-back-bar">
                    <a href="{{ url('/') }}" class="showcase-back-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                        <span>Kembali</span>
                    </a>
                </div>

                <!-- Floating UI Analytics & Charts (Cliqk Signature) -->
                <div class="showcase-visual-hub">
                    <!-- Top Pill Badge -->
                    <div class="ui-pill-badge pill-badge-top">
                        <span class="badge-pulse-dot"></span>
                        <span>Logbook Terverifikasi</span>
                    </div>

                    <!-- Left Glass Chart Card -->
                    <div class="ui-float-card-chart">
                        <div class="chart-header">
                            <span>Aktivitas Mingguan</span>
                            <span class="chart-dot"></span>
                        </div>
                        <svg class="chart-svg" viewBox="0 0 160 48" fill="none">
                            <path d="M0,38 Q30,12 60,26 T120,8 T160,22" stroke="#38bdf8" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                            <circle cx="60" cy="26" r="3.5" fill="#ffffff" stroke="#38bdf8" stroke-width="2"/>
                            <circle cx="120" cy="8" r="3.5" fill="#ffffff" stroke="#38bdf8" stroke-width="2"/>
                        </svg>
                    </div>

                    <!-- Right Circular Progress Widget -->
                    <div class="ui-float-card-pie">
                        <div class="pie-ring-wrap">
                            <svg class="pie-ring-svg" viewBox="0 0 64 64">
                                <circle class="pie-ring-bg" cx="32" cy="32" r="26"/>
                                <circle class="pie-ring-fill" cx="32" cy="32" r="26"/>
                            </svg>
                            <span class="pie-center-text">75%</span>
                        </div>
                        <div class="pie-label">Progres KP</div>
                    </div>

                    <!-- Bottom Pill Badge -->
                    <div class="ui-pill-badge pill-badge-bot">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Kuota Instansi Valid</span>
                    </div>
                </div>

                <!-- Showcase Bottom Copy & Carousel Dots -->
                <div class="showcase-bottom-block">
                    <h2 class="showcase-headline">
                        Kelola KP Lebih Cepat.<br>Raih Hasil Nyata.
                    </h2>
                    <p class="showcase-desc">
                        Akses seluruh administrasi kerja praktik, pantau bimbingan logbook secara real-time, dan ajukan sidang kelulusan dalam satu ekosistem digital terpadu.
                    </p>

                    <div class="showcase-carousel-dots">
                        <span class="carousel-dot active"></span>
                        <span class="carousel-dot"></span>
                        <span class="carousel-dot"></span>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 RIGHT PANE: LOGIN FORM (Cliqk Inspired)
            ═══════════════════════════════════════════════════════════════ -->
            <section class="form-pane">
                <div class="form-header-block">
                    <h1 class="form-headline">Masuk ke SIMPUL</h1>
                    <p class="form-subtitle">Masukkan detail kredensial untuk mengakses akun Anda</p>
                </div>

                @if (session('success'))
                    <div class="alert-success">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-error">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.process') }}">
                    @csrf

                    <!-- Role Selector -->
                    <div class="form-group">
                        <label for="role" class="form-label">Masuk sebagai</label>
                        <div class="select-wrap">
                            <select id="role" name="role" class="form-select" required>
                                <option value="student" {{ old('role', request('role', 'student')) === 'student' ? 'selected' : '' }}>
                                    Mahasiswa
                                </option>
                                <option value="supervisor" {{ old('role', request('role')) === 'supervisor' ? 'selected' : '' }}>
                                    Dosen Pembimbing
                                </option>
                                <option value="admin" {{ old('role', request('role')) === 'admin' ? 'selected' : '' }}>
                                    Admin Jurusan
                                </option>
                            </select>
                            <span class="select-chevron-icon" aria-hidden="true">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-wrap">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                autocomplete="email"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <!-- Password Input with Toggle Eye -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input"
                                placeholder="Masukkan password Anda"
                                autocomplete="current-password"
                                required
                            >
                            <button type="button" class="password-toggle-btn" id="togglePasswordBtn" aria-label="Tampilkan / Sembunyikan password">
                                <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password Row -->
                    <div class="form-meta-row">
                        <label class="remember-checkbox-label" for="remember">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                value="1"
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            <span>Ingat saya</span>
                        </label>

                        <a href="{{ route('password.request') }}" class="forgot-password-link">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit-login">
                        <span>Masuk</span>
                    </button>
                </form>

                <!-- Sign Up Prompt -->
                <div class="form-signup-prompt">
                    Belum memiliki akun? 
                    <a href="{{ route('register') }}">Daftar Sekarang</a>
                </div>

                <!-- Terms and Privacy Links -->
                <div class="form-legal-links">
                    <a href="#">Syarat &amp; Ketentuan</a>
                    <span>&bull;</span>
                    <a href="#">Kebijakan Privasi</a>
                </div>
            </section>

        </div>
    </main>

    <!-- Interactive Script: Password Toggle -->
    <script>
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', () => {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                // Toggle eye icon appearance
                if (isPassword) {
                    eyeIcon.innerHTML = `
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    `;
                } else {
                    eyeIcon.innerHTML = `
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    `;
                }
            });
        }
    </script>

</body>
</html>
