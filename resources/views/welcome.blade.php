<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPUL – Sistem Informasi Manajemen Praktik Universitas Lampung</title>

    <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════════════════════════
           DESIGN TOKENS: Monopol-Inspired Sky-Blue to Pure White Gradient
        ═══════════════════════════════════════════════════════════════ */
        :root {
            --ink-headline:       #091e3a;
            --ink-body:           #1e293b;
            --ink-subtext:        #334155;

            /* Luminous Cerulean & Sky-Blue Palette (Monopol Inspired) */
            --sky-dark:           #1d4ed8;
            --sky-primary:        #2563eb;
            --sky-vibrant:        #3b82f6;
            --sky-light:          #60a5fa;
            --sky-pastel:         #93c5fd;
            --sky-ice:            #bfdbfe;
            --sky-powder:         #dbeafe;
            --sky-ghost:          #f0f7ff;
            --canvas-bg:          #f8fbff;
            --surface-card:       #ffffff;
            --border-soft:        #e2e8f0;
            --border-sky:         #bae6fd;

            /* Elevation & Hover Pop Shadows */
            --shadow-subtle:      0 4px 16px rgba(15, 23, 42, 0.04);
            --shadow-card:        0 14px 34px rgba(37, 99, 235, 0.08);
            --shadow-popup:       0 22px 46px -8px rgba(37, 99, 235, 0.22), 0 0 0 1.5px rgba(59, 130, 246, 0.45);
            --shadow-float:       0 20px 48px rgba(15, 23, 42, 0.12);
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--ink-body);
            background: #ffffff;
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .container {
            width: min(1200px, 92%);
            margin: auto;
        }

        /* ═══════════════════════════════════════════════════════════════
           POP-UP ANIMATION FOR INTERACTIVE BOXES (Springy & Responsive)
        ═══════════════════════════════════════════════════════════════ */
        .pop-card {
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1),
                        box-shadow 0.35s ease,
                        border-color 0.3s ease;
            will-change: transform, box-shadow;
        }

        .pop-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-popup);
            border-color: var(--sky-vibrant) !important;
        }

        /* ═══════════════════════════════════════════════════════════════
           NAVBAR (Frosted Crystal Glass)
        ═══════════════════════════════════════════════════════════════ */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(59, 130, 246, 0.12);
            transition: all .25s ease;
        }

        .navbar.is-scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
        }

        .nav-inner {
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-logo-badge {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            color: #ffffff !important;
            display: grid;
            place-items: center;
            font-size: 19px;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }

        .brand-text-block h1 {
            font-size: 17.5px;
            font-weight: 700;
            color: var(--ink-headline);
            line-height: 1.15;
            letter-spacing: -0.2px;
        }

        .brand-text-block p {
            font-size: 10.5px;
            font-weight: 400;
            color: var(--ink-subtext);
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 24px;
            font-size: 13px;
            font-weight: 500;
        }

        .nav-menu a:not(.btn-nav-login) {
            color: var(--ink-body);
            transition: color .2s ease;
            position: relative;
        }

        .nav-menu a:not(.btn-nav-login)::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--sky-primary);
            border-radius: 2px;
            transition: width .25s ease;
        }

        .nav-menu a:not(.btn-nav-login):hover {
            color: var(--sky-primary);
        }

        .nav-menu a:not(.btn-nav-login):hover::after {
            width: 100%;
        }

        .btn-nav-login {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 22px;
            border-radius: 9px;
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.32);
            transition: all .25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .btn-nav-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
            color: #ffffff !important;
        }

        /* ═══════════════════════════════════════════════════════════════
           HERO: MONOPOL-STYLE SKY-BLUE TO WHITE GRADIENT STAGE
        ═══════════════════════════════════════════════════════════════ */
        .monopol-hero-wrapper {
            position: relative;
            background: linear-gradient(180deg, 
                #1d4ed8 0%, 
                #2563eb 20%, 
                #3b82f6 42%, 
                #60a5fa 65%, 
                #93c5fd 82%, 
                #dbeafe 93%, 
                #ffffff 100%
            );
            overflow: hidden;
            padding: 56px 0 70px;
            color: white;
        }

        /* ── Dynamic Flowing Ambient Waves (Animasi Berjalan Halus) ── */
        .flowing-wave-1 {
            position: absolute;
            top: -28%;
            left: -15%;
            width: 130%;
            height: 105%;
            background: radial-gradient(ellipse 65% 50% at 35% 30%, rgba(255, 255, 255, 0.35) 0%, rgba(96, 165, 250, 0.3) 40%, transparent 75%);
            filter: blur(46px);
            pointer-events: none;
            z-index: 1;
            animation: flowMotion1 15s ease-in-out infinite alternate;
        }

        .flowing-wave-2 {
            position: absolute;
            top: -22%;
            right: -20%;
            width: 130%;
            height: 100%;
            background: radial-gradient(ellipse 60% 45% at 65% 35%, rgba(147, 197, 253, 0.4) 0%, rgba(37, 99, 235, 0.28) 45%, transparent 75%);
            filter: blur(50px);
            pointer-events: none;
            z-index: 1;
            animation: flowMotion2 17s ease-in-out infinite alternate;
        }

        .flowing-light-sweep {
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, 
                transparent 15%, 
                rgba(255, 255, 255, 0.2) 45%, 
                rgba(191, 219, 254, 0.25) 55%, 
                transparent 80%
            );
            background-size: 250% 100%;
            animation: sweepStream 12s ease-in-out infinite;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes flowMotion1 {
            0% {
                transform: translate3d(0, 0, 0) scale(1) rotate(0deg);
            }
            50% {
                transform: translate3d(85px, 35px, 0) scale(1.12) rotate(3deg);
            }
            100% {
                transform: translate3d(-45px, 55px, 0) scale(0.96) rotate(-2.5deg);
            }
        }

        @keyframes flowMotion2 {
            0% {
                transform: translate3d(0, 0, 0) scale(1) rotate(0deg);
            }
            50% {
                transform: translate3d(-90px, 40px, 0) scale(1.15) rotate(-3.5deg);
            }
            100% {
                transform: translate3d(60px, -25px, 0) scale(0.95) rotate(2.5deg);
            }
        }

        @keyframes sweepStream {
            0% {
                background-position: 220% 0;
                opacity: 0.4;
            }
            50% {
                opacity: 0.85;
            }
            100% {
                background-position: -120% 0;
                opacity: 0.4;
            }
        }

        /* Hero Layout & Content */
        .hero-layout {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1.08fr 0.92fr;
            align-items: center;
            gap: 46px;
        }

        .hero-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 14px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(10px);
            color: #ffffff;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.8px;
            margin-bottom: 16px;
        }

        .hero-chip-icon {
            display: inline-flex;
            color: #ffffff;
        }

        .hero-headline {
            font-size: clamp(28px, 3.2vw, 42px);
            font-weight: 700;
            line-height: 1.22;
            letter-spacing: -0.8px;
            color: #ffffff;
            margin-bottom: 16px;
            text-shadow: 0 2px 14px rgba(29, 78, 216, 0.25);
        }

        .hero-headline .highlight-phrase {
            color: #ffffff;
            text-decoration: underline;
            text-decoration-color: rgba(255, 255, 255, 0.5);
            text-underline-offset: 6px;
        }

        .hero-subtext {
            font-size: 14.5px;
            font-weight: 400;
            color: #ffffff;
            max-width: 490px;
            line-height: 1.7;
            margin-bottom: 24px;
            opacity: 0.95;
        }

        .hero-cta-group {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .btn-cta-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 28px;
            border-radius: 30px;
            background: #4079ea;
            color: #ffffff !important;
            font-size: 13.5px;
            font-weight: 600;
            border: none;
            box-shadow: 0 8px 24px rgba(29, 78, 216, 0.35);
            transition: all .25s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }

        .btn-cta-primary:hover {
            transform: translateY(-2px);
            background: #2563eb;
            color: #ffffff !important;
            box-shadow: 0 12px 28px rgba(29, 78, 216, 0.45);
        }

        .btn-cta-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 12px 24px;
            border-radius: 30px;
            background: #ffffff;
            color: #2563eb !important;
            font-size: 13.5px;
            font-weight: 600;
            border: none;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
            transition: all .25s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }

        .btn-cta-secondary:hover {
            background: #f8fafc;
            color: #1d4ed8 !important;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.18);
        }

        .hero-trust-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 11.5px;
            font-weight: 500;
            color: #ffffff;
            opacity: 0.92;
        }

        /* ═══════════════════════════════════════════════════════════════
           HERO RIGHT: FLOATING WHITE SERVICE HUB CARD (MONOPOL STYLE)
        ═══════════════════════════════════════════════════════════════ */
        .system-hub-card {
            position: relative;
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 22px;
            box-shadow: var(--shadow-float);
            overflow: hidden;
            color: var(--ink-body);
        }

        .hub-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 20px;
            background: linear-gradient(90deg, #f0f7ff 0%, #e0f2fe 100%);
            border-bottom: 1px solid var(--border-soft);
        }

        .hub-title-block {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
            color: var(--sky-dark);
        }

        .live-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 10px;
            font-weight: 600;
            color: #047857;
            background: #d1fae5;
            padding: 3px 9px;
            border-radius: 20px;
        }

        .pulsing-green-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25);
            animation: dotBlink 1.8s infinite;
        }

        @keyframes dotBlink {
            0%, 100% { transform: scale(1); opacity: 1; }
            50%      { transform: scale(1.3); opacity: 0.6; }
        }

        .hub-card-body {
            padding: 18px 20px;
        }

        .hub-lead-text {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--ink-body);
            margin-bottom: 12px;
        }

        .hub-modules-grid {
            display: grid;
            gap: 9px;
            margin-bottom: 14px;
        }

        .hub-module-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            background: #fbfdff;
            border: 1px solid var(--border-soft);
            transition: all .25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .hub-module-item:hover {
            border-color: var(--sky-vibrant);
            background: #f0f7ff;
            transform: translateX(4px);
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.12);
        }

        .module-icon-wrap {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            color: var(--sky-dark);
            display: grid;
            place-items: center;
            flex-shrink: 0;
            transition: transform .25s ease;
        }

        .hub-module-item:hover .module-icon-wrap {
            transform: scale(1.1) rotate(-4deg);
            color: var(--sky-primary);
        }

        .module-info-wrap h4 {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink-headline);
            line-height: 1.2;
            margin-bottom: 2px;
        }

        .module-info-wrap p {
            font-size: 11px;
            font-weight: 400;
            color: var(--ink-subtext);
        }

        .module-badge-tag {
            margin-left: auto;
            font-size: 10px;
            font-weight: 600;
            color: var(--sky-dark);
            background: #e0f2fe;
            padding: 2.5px 8px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .hub-card-footer {
            padding: 11px 14px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11.5px;
        }

        .hub-card-footer span {
            font-weight: 500;
            color: var(--ink-body);
        }

        .hub-card-footer a {
            color: var(--sky-primary);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: gap .2s ease;
        }

        .hub-card-footer a:hover {
            color: var(--sky-dark);
            gap: 6px;
        }

        /* ═══════════════════════════════════════════════════════════════
           SECTION: EKOSISTEM TERINTEGRASI (SEAMLESS CANVAS INTEGRATION)
           No disconnected dark box; sits seamlessly on light blue-white canvas
        ═══════════════════════════════════════════════════════════════ */
        .ecosystem-section {
            position: relative;
            background: linear-gradient(180deg, #ffffff 0%, #f0f7ff 50%, #ffffff 100%);
            color: var(--ink-body);
            padding: 70px 0 85px;
            overflow: hidden;
        }

        .ecosystem-grid {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 0.96fr 1.04fr;
            align-items: center;
            gap: 55px;
        }

        .eco-badge-kicker {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--sky-primary);
            margin-bottom: 12px;
        }

        .ecosystem-info h2 {
            font-size: clamp(26px, 3.2vw, 36px);
            font-weight: 600;
            color: var(--ink-headline);
            line-height: 1.28;
            margin-bottom: 14px;
            letter-spacing: -0.4px;
        }

        .ecosystem-info h2 strong {
            font-weight: 700;
            color: var(--sky-primary);
        }

        .ecosystem-info p {
            font-size: 14.5px;
            font-weight: 400;
            color: var(--ink-subtext);
            line-height: 1.75;
            margin-bottom: 24px;
        }

        /* Interactive Role Chips (Poppins Font Guaranteed) */
        .eco-role-selector {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .eco-chip-btn {
            font-family: 'Poppins', sans-serif !important;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 20px;
            background: #ffffff;
            border: 1px solid var(--border-soft);
            color: var(--ink-body);
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
            transition: all .25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .eco-chip-btn span {
            font-family: 'Poppins', sans-serif !important;
        }

        .eco-chip-btn:hover {
            border-color: var(--sky-vibrant);
            color: var(--sky-primary);
            transform: translateY(-2px);
        }

        .eco-chip-btn.active {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            border-color: transparent;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }

        /* Dynamic Feature Spotlight Card */
        .eco-feature-spotlight {
            background: #ffffff;
            border: 1px solid var(--border-soft);
            border-left: 3px solid var(--sky-primary);
            border-radius: 14px;
            padding: 18px 22px;
            margin-bottom: 0;
            min-height: 85px;
            box-shadow: var(--shadow-subtle);
        }

        .eco-feature-spotlight h4 {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--sky-dark);
            margin-bottom: 4px;
        }

        .eco-feature-spotlight p {
            font-size: 13px;
            color: var(--ink-body);
            line-height: 1.65;
            margin: 0;
        }

        .btn-eco-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 28px;
            border-radius: 10px;
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            color: #ffffff !important;
            font-size: 13.5px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
            transition: all .25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .btn-eco-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.42);
        }

        /* High-Tech Mission Control Radar Console (Luminous Sky-Blue Gradient) */
        .network-stage-wrap {
            position: relative !important;
            height: 410px;
            background: linear-gradient(145deg, #1d4ed8 0%, #2563eb 32%, #3b82f6 68%, #60a5fa 100%) !important;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.45);
            box-shadow: 0 20px 48px -10px rgba(37, 99, 235, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .network-stage-wrap::before {
            content: '';
            position: absolute;
            top: -25%;
            left: -15%;
            width: 130%;
            height: 130%;
            background: radial-gradient(circle at 35% 30%, rgba(255, 255, 255, 0.28) 0%, transparent 65%);
            pointer-events: none;
            z-index: 1;
        }

        .radar-svg-canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        .radar-pulse-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            border: 1.5px solid rgba(255, 255, 255, 0.55);
            transform: translate(-50%, -50%);
            animation: radarPulse 3s cubic-bezier(0.2, 0.8, 0.2, 1) infinite;
            pointer-events: none;
            z-index: 2;
        }

        .radar-pulse-ring-delayed {
            animation-delay: 1.5s;
        }

        @keyframes radarPulse {
            0%   { width: 70px; height: 70px; opacity: 0.95; }
            100% { width: 330px; height: 330px; opacity: 0; }
        }

        .network-center-hub {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 10px 22px;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(14px);
            border: 1.5px solid rgba(255, 255, 255, 0.65);
            border-radius: 50px;
            color: #ffffff;
            font-family: 'Poppins', sans-serif !important;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
            z-index: 10;
            box-shadow: 0 10px 32px rgba(15, 23, 42, 0.2);
        }

        .hub-sparkle-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ffffff;
            box-shadow: 0 0 12px #ffffff;
            animation: dotBlink 1.5s infinite;
        }

        /* Persona Nodes for the 3 Roles */
        .network-node-pod {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 7px;
            z-index: 10;
            cursor: pointer;
        }

        .node-circle-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #ffffff;
            color: var(--sky-primary);
            display: grid;
            place-items: center;
            border: 3px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.22);
            animation: podFloat 3.8s ease-in-out infinite alternate;
            transition: all .25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes podFloat {
            from { transform: translateY(0); }
            to   { transform: translateY(-7px); }
        }

        .network-node-pod:hover .node-circle-icon,
        .network-node-pod.is-highlighted .node-circle-icon {
            transform: scale(1.16);
            border-color: #ffffff;
            color: #1d4ed8;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.85), 0 14px 32px rgba(15, 23, 42, 0.3);
        }

        .node-caption-text {
            font-family: 'Poppins', sans-serif !important;
            font-size: 11px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            text-shadow: 0 2px 8px rgba(15, 23, 42, 0.3);
            white-space: nowrap;
        }

        /* 3-Role Coordinates */
        .pod-top-center { top: 6%;  left: 50%; transform: translateX(-50%); }
        .pod-bot-left   { bottom: 9%; left: 9%; }
        .pod-bot-right  { bottom: 9%; right: 9%; }

        /* ═══════════════════════════════════════════════════════════════
           SECTION: FITUR PLATFORM (POP-CARD ENABLED)
        ═══════════════════════════════════════════════════════════════ */
        .features-section {
            padding: 80px 0;
            background: #ffffff;
        }

        .section-header-centered {
            text-align: center;
            max-width: 880px;
            margin: 0 auto 44px;
        }

        .badge-kicker {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--sky-primary);
            margin-bottom: 8px;
        }

        .section-title-refined {
            font-size: clamp(22px, 2.7vw, 33px);
            font-weight: 600;
            color: var(--ink-headline);
            line-height: 1.28;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .section-title-refined strong {
            font-weight: 700;
            color: var(--sky-primary);
        }

        .section-desc-clean {
            font-size: 14.5px;
            font-weight: 400;
            color: var(--ink-subtext);
            line-height: 1.7;
            max-width: 620px;
            margin: 0 auto;
        }

        .features-grid-refined {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .feature-card-clean {
            position: relative;
            background: #ffffff;
            border: 1px solid var(--border-soft);
            border-radius: 18px;
            padding: 28px 24px;
            overflow: hidden;
            box-shadow: var(--shadow-subtle);
        }

        .feature-card-clean::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 44px;
            height: 3px;
            background: linear-gradient(90deg, var(--sky-dark), var(--sky-light));
            transition: width .35s ease;
        }

        .feature-card-clean:hover::before {
            width: 100%;
        }

        .feature-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .feature-icon-badge {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: #f0f7ff;
            color: var(--sky-primary);
            display: grid;
            place-items: center;
            border: 1px solid #dbeafe;
            transition: all .25s ease;
        }

        .feature-card-clean:hover .feature-icon-badge {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.32);
            transform: scale(1.08) rotate(-4deg);
        }

        .feature-number-tag {
            font-size: 12px;
            font-weight: 600;
            color: #94a3b8;
        }

        .feature-card-clean h3 {
            font-size: 16.5px;
            font-weight: 600;
            color: var(--ink-headline);
            margin-bottom: 8px;
            line-height: 1.35;
        }

        .feature-card-clean p {
            font-size: 13.5px;
            font-weight: 400;
            color: var(--ink-body);
            line-height: 1.65;
        }

        /* ═══════════════════════════════════════════════════════════════
           SECTION: ALUR KULIAH PRAKTIK (POP-CARD ENABLED)
        ═══════════════════════════════════════════════════════════════ */
        .timeline-section {
            padding: 80px 0 90px;
            background: var(--canvas-bg);
            position: relative;
        }

        .timeline-row-layout {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            position: relative;
        }

        .timeline-step-card {
            background: white;
            border: 1px solid var(--border-soft);
            border-radius: 18px;
            padding: 26px 20px;
            text-align: center;
            position: relative;
            box-shadow: var(--shadow-subtle);
        }

        .step-bubble {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            color: white;
            font-size: 15px;
            font-weight: 700;
            display: grid;
            place-items: center;
            margin: 0 auto 14px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
            transition: transform .25s ease;
        }

        .timeline-step-card:hover .step-bubble {
            transform: scale(1.15) rotate(6deg);
        }

        .step-phase-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--sky-primary);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .timeline-step-card h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--ink-headline);
            margin-bottom: 8px;
        }

        .timeline-step-card p {
            font-size: 13px;
            font-weight: 400;
            color: var(--ink-body);
            line-height: 1.6;
        }

        /* ═══════════════════════════════════════════════════════════════
           CTA BANNER (POP-CARD ENABLED)
        ═══════════════════════════════════════════════════════════════ */
        .cta-section {
            padding: 60px 0 75px;
            background: #ffffff;
        }

        .cta-glass-box {
            border-radius: 22px;
            padding: 46px 52px;
            background: linear-gradient(135deg, #e0f2fe 0%, #f0f7ff 50%, #dbeafe 100%);
            border: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 36px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-subtle);
        }

        .cta-glass-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--sky-dark), var(--sky-primary), var(--sky-light));
        }

        .cta-text-side h2 {
            font-size: 26px;
            font-weight: 600;
            color: var(--ink-headline);
            letter-spacing: -0.4px;
            margin-bottom: 8px;
        }

        .cta-text-side p {
            font-size: 14.5px;
            font-weight: 400;
            color: var(--ink-subtext);
            max-width: 500px;
        }

        .cta-glass-box .btn-cta-primary {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            color: #ffffff !important;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
        }

        .cta-glass-box .btn-cta-primary:hover {
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
            color: #ffffff !important;
        }

        /* ═══════════════════════════════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════════════════════════════ */
        footer {
            background: #0f172a;
            color: #cbd5e1;
            padding: 40px 0;
        }

        .footer-inner-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            font-size: 13px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .footer-brand-badge {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            color: #ffffff !important;
            display: grid;
            place-items: center;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }

        .footer-brand h4 {
            font-size: 15px;
            font-weight: 600;
            color: white;
        }

        .footer-brand p {
            font-size: 11px;
            color: #94a3b8;
        }

        .footer-links-list {
            display: flex;
            gap: 24px;
            font-size: 13px;
        }

        .footer-links-list a {
            color: #cbd5e1;
            transition: color .2s;
        }

        .footer-links-list a:hover {
            color: var(--sky-light);
        }

        /* ═══════════════════════════════════════════════════════════════
           SCROLL REVEAL UTILITIES
        ═══════════════════════════════════════════════════════════════ */
        .reveal-node {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity .6s cubic-bezier(0.16, 1, 0.3, 1), transform .6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-node.in-view {
            opacity: 1;
            transform: translateY(0);
        }

        .stagger-1 { transition-delay: .08s; }
        .stagger-2 { transition-delay: .16s; }

        /* ═══════════════════════════════════════════════════════════════
           RESPONSIVE STYLES
        ═══════════════════════════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .hero-layout { grid-template-columns: 1fr; gap: 36px; }
            .ecosystem-grid { grid-template-columns: 1fr; gap: 38px; }
            .features-grid-refined { grid-template-columns: repeat(2, 1fr); }
            .timeline-row-layout { grid-template-columns: repeat(2, 1fr); }
            .cta-glass-box { flex-direction: column; align-items: flex-start; padding: 34px; }
        }

        @media (max-width: 680px) {
            .nav-menu a:not(.btn-nav-login) { display: none; }
            .hero-headline { font-size: 27px; }
            .features-grid-refined { grid-template-columns: 1fr; }
            .timeline-row-layout { grid-template-columns: 1fr; }
            .network-stage-wrap { height: 320px; }
            .footer-inner-wrap { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

    <!-- ═══════════════════════════════════════════════════════════════
         NAVBAR
    ═══════════════════════════════════════════════════════════════ -->
    <header class="navbar" id="appNavbar">
        <div class="container nav-inner">
            <a href="/" class="brand-link">
                <div class="brand-logo-badge">S</div>
                <div class="brand-text-block">
                    <h1>SIMPUL</h1>
                    <p>Sistem Informasi Manajemen Praktik</p>
                </div>
            </a>

            <nav class="nav-menu">
                <a href="#beranda">Beranda</a>
                <a href="#komunitas">Ekosistem</a>
                <a href="#fitur">Fitur</a>
                <a href="#alur">Alur KP</a>
            </nav>
        </div>
    </header>

    <main>

        <!-- ═══════════════════════════════════════════════════════════════
             HERO: MONOPOL-STYLE SKY-BLUE TO WHITE GRADIENT CANVAS
        ═══════════════════════════════════════════════════════════════ -->
        <div class="monopol-hero-wrapper" id="beranda">
            <!-- Flowing Gradient & Dynamic Luminous Light Waves (Animasi Berjalan) -->
            <div class="flowing-wave-1"></div>
            <div class="flowing-wave-2"></div>
            <div class="flowing-light-sweep"></div>

            <section class="container hero-layout">

                <!-- Left: Clean, Legible Hero Headline & Value Props -->
                <div class="reveal-node">
                    <div class="hero-chip">
                        <span class="hero-chip-icon">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                            </svg>
                        </span>
                        <span>UNIVERSITAS LAMPUNG &bull; KULIAH PRAKTIK</span>
                    </div>

                    <!-- Judul Proporsional & Elegan -->
                    <h1 class="hero-headline">
                        Satu Platform untuk Semua<br>
                        <span class="highlight-phrase">Kebutuhan Kuliah Praktik</span>
                    </h1>

                    <p class="hero-subtext">
                        Tinggalkan birokrasi manual. SIMPUL mendigitalkan pemilihan instansi, pemantauan logbook harian, dan pendaftaran sidang KP dalam satu ekosistem yang terpadu.
                    </p>

                    <div class="hero-cta-group">
                        <a href="{{ route('login') }}" class="btn-cta-primary">
                            <span>Masuk</span>
                        </a>

                        <a href="#alur" class="btn-cta-secondary">
                            <span>Pelajari Alur KP</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                    </div>

                    <div class="hero-trust-badge">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <span>Platform Resmi Pengelolaan Kuliah Praktik Universitas Lampung</span>
                    </div>
                </div>

                <!-- Right: White Floating Service Hub Card (Monopol Style) -->
                <div class="system-hub-card pop-card reveal-node stagger-2">
                    <div class="hub-card-header">
                        <div class="hub-title-block">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                <line x1="12" y1="17" x2="12" y2="21"></line>
                            </svg>
                            <span>Layanan Terpadu SIMPUL Unila</span>
                        </div>
                        <div class="live-status-pill">
                            <span class="pulsing-green-dot"></span>
                            <span>Sistem Aktif</span>
                        </div>
                    </div>

                    <div class="hub-card-body">
                        <p class="hub-lead-text">Pusat kendali proses akademik Kuliah Praktik mahasiswa:</p>

                        <!-- 4 Modul Layanan Riil -->
                        <div class="hub-modules-grid">
                            <div class="hub-module-item">
                                <div class="module-icon-wrap">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    </svg>
                                </div>
                                <div class="module-info-wrap">
                                    <h4>Direktori Mitra &amp; Kuota</h4>
                                    <p>Aturan kuota: Maks 1 kelompok / 3 mahasiswa</p>
                                </div>
                                <span class="module-badge-tag">Tervalidasi</span>
                            </div>

                            <div class="hub-module-item">
                                <div class="module-icon-wrap">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </div>
                                <div class="module-info-wrap">
                                    <h4>Logbook Kegiatan Harian</h4>
                                    <p>Pencatatan aktivitas kerja terpantau pembimbing</p>
                                </div>
                                <span class="module-badge-tag">Tersinkron</span>
                            </div>

                            <div class="hub-module-item">
                                <div class="module-icon-wrap">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                    </svg>
                                </div>
                                <div class="module-info-wrap">
                                    <h4>Pemberkasan &amp; Laporan</h4>
                                    <p>Surat pengantar, konfirmasi, &amp; draft naskah</p>
                                </div>
                                <span class="module-badge-tag">Terarsip</span>
                            </div>

                            <div class="hub-module-item">
                                <div class="module-icon-wrap">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                        <circle cx="12" cy="8" r="7"></circle>
                                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                    </svg>
                                </div>
                                <div class="module-info-wrap">
                                    <h4>Pendaftaran Sidang KP</h4>
                                    <p>Validasi syarat kelulusan &amp; jadwal penguji</p>
                                </div>
                                <span class="module-badge-tag">Terintegrasi</span>
                            </div>
                        </div>

                        <div class="hub-card-footer">
                            <span>Ingin mengakses layanan sistem?</span>
                            <a href="{{ route('login') }}">
                                <span>Masuk Sekarang</span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

            </section>
        </div>

        <!-- ═══════════════════════════════════════════════════════════════
             SECTION: EKOSISTEM TERINTEGRASI (RADAR CONSTELLATION)
             Connected directly on light blue-white canvas (No Disjointed Blocks)
        ═══════════════════════════════════════════════════════════════ -->
        <section class="ecosystem-section" id="komunitas">
            <div class="container ecosystem-grid">

                <!-- Left: Luminous Sky-Blue Console (3-Role Interconnected Triad) -->
                <div class="network-stage-wrap pop-card reveal-node stagger-1">
                    <!-- Radar Pulse Waves -->
                    <div class="radar-pulse-ring"></div>
                    <div class="radar-pulse-ring radar-pulse-ring-delayed"></div>

                    <!-- SVG Constellation Laser Connections for 3 Roles -->
                    <svg class="radar-svg-canvas" viewBox="0 0 400 410" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Orbiting Rings -->
                        <ellipse cx="200" cy="205" rx="155" ry="155" stroke="rgba(255,255,255,0.22)" stroke-width="1.5" stroke-dasharray="6 6"/>
                        <ellipse cx="200" cy="205" rx="100" ry="100" stroke="rgba(255,255,255,0.32)" stroke-width="1.5"/>

                        <!-- Triangle Perimeter Interconnecting The 3 Roles -->
                        <line x1="200" y1="62" x2="95" y2="335" stroke="rgba(255,255,255,0.35)" stroke-width="1.5" stroke-dasharray="5 5"/>
                        <line x1="200" y1="62" x2="305" y2="335" stroke="rgba(255,255,255,0.35)" stroke-width="1.5" stroke-dasharray="5 5"/>
                        <line x1="95" y1="335" x2="305" y2="335" stroke="rgba(255,255,255,0.35)" stroke-width="1.5" stroke-dasharray="5 5"/>

                        <!-- Flowing Laser Rays into SIMPUL Digital Core -->
                        <line x1="200" y1="62" x2="200" y2="182" stroke="rgba(255,255,255,0.85)" stroke-width="2.5" stroke-dasharray="6 6">
                            <animate attributeName="stroke-dashoffset" from="0" to="24" dur="2s" repeatCount="indefinite"/>
                        </line>
                        <line x1="95" y1="335" x2="165" y2="230" stroke="rgba(255,255,255,0.85)" stroke-width="2.5" stroke-dasharray="6 6">
                            <animate attributeName="stroke-dashoffset" from="0" to="24" dur="2.4s" repeatCount="indefinite"/>
                        </line>
                        <line x1="305" y1="335" x2="235" y2="230" stroke="rgba(255,255,255,0.85)" stroke-width="2.5" stroke-dasharray="6 6">
                            <animate attributeName="stroke-dashoffset" from="0" to="24" dur="2.2s" repeatCount="indefinite"/>
                        </line>

                        <!-- Glowing Intersection Dots -->
                        <circle cx="200" cy="62" r="5" fill="#ffffff"/>
                        <circle cx="95" cy="335" r="5" fill="#ffffff"/>
                        <circle cx="305" cy="335" r="5" fill="#ffffff"/>
                    </svg>

                    <!-- Center Hub -->
                    <div class="network-center-hub">
                        <span class="hub-sparkle-dot"></span>
                        <span>SIMPUL Digital Core</span>
                    </div>

                    <!-- Role 1: Mahasiswa (Top Center) -->
                    <div class="network-node-pod pod-top-center is-highlighted" id="pod-mahasiswa" onclick="activateEcoRole('mahasiswa')">
                        <div class="node-circle-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        </div>
                        <span class="node-caption-text">Mahasiswa</span>
                    </div>

                    <!-- Role 2: Dosen Pembimbing (Bottom Left) -->
                    <div class="network-node-pod pod-bot-left" id="pod-dosen" onclick="activateEcoRole('dosen')">
                        <div class="node-circle-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <span class="node-caption-text">Dosen Pembimbing</span>
                    </div>

                    <!-- Role 3: Admin Jurusan (Bottom Right) -->
                    <div class="network-node-pod pod-bot-right" id="pod-admin" onclick="activateEcoRole('admin')">
                        <div class="node-circle-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        </div>
                        <span class="node-caption-text">Admin Jurusan</span>
                    </div>
                </div>

                <!-- Right: Text & Interactive Role Chips -->
                <div class="ecosystem-info reveal-node stagger-2">
                    <span class="eco-badge-kicker">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="18" cy="5" r="3"></circle>
                            <circle cx="6" cy="12" r="3"></circle>
                            <circle cx="18" cy="19" r="3"></circle>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                        </svg>
                        KOLABORASI DIGITAL MULTI-PENGGUNA
                    </span>

                    <h2>
                        Ekosistem Kuliah Praktik yang <strong>Saling Terhubung</strong>
                    </h2>

                    <p>
                        Seluruh pihak berkoordinasi secara langsung di dalam sistem. Pilih peran di bawah untuk melihat bagaimana SIMPUL menghubungkan alur kerja masing-masing entitas:
                    </p>

                    <!-- Interactive Role Chips (Hanya 3 Role Sesuai Sistem SIMPUL) -->
                    <div class="eco-role-selector">
                        <button class="eco-chip-btn active" onclick="activateEcoRole('mahasiswa', this)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                            <span>Mahasiswa</span>
                        </button>
                        <button class="eco-chip-btn" onclick="activateEcoRole('dosen', this)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>Dosen Pembimbing</span>
                        </button>
                        <button class="eco-chip-btn" onclick="activateEcoRole('admin', this)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                            <span>Admin Jurusan</span>
                        </button>
                    </div>

                    <!-- Dynamic Spotlight Feature Box with Pop -->
                    <div class="eco-feature-spotlight pop-card" id="ecoSpotlight">
                        <h4 id="ecoSpotlightTitle">Fokus Peran: Mahasiswa KP</h4>
                        <p id="ecoSpotlightText">
                            Mengeksplorasi referensi tempat KP dari rekam jejak alumni, mengajukan kesiapan KP &amp; berkas persyaratan, mengisi logbook harian, mengunggah laporan akhir, serta mendaftar sidang kelulusan secara mandiri.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════════
             SECTION: FITUR PLATFORM (POP-CARD ENABLED)
        ═══════════════════════════════════════════════════════════════ -->
        <section class="features-section" id="fitur">
            <div class="container">
                <div class="section-header-centered reveal-node">
                    <span class="badge-kicker">FITUR SIMPUL</span>
                    <h2 class="section-title-refined">
                        Semua kebutuhan KP <strong>dalam satu sistem</strong>
                    </h2>
                    <p class="section-desc-clean">
                        Fasilitas digital yang mempermudah mahasiswa, dosen, dan pengelola jurusan dalam menyelesaikan setiap tahapan kerja praktik.
                    </p>
                </div>

                <div class="features-grid-refined">
                    <!-- Feature 1 -->
                    <article class="feature-card-clean pop-card reveal-node stagger-1">
                        <div class="feature-header-row">
                            <div class="feature-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </div>
                            <span class="feature-number-tag">01</span>
                        </div>
                        <h3>Katalog Perusahaan Mitra</h3>
                        <p>Akses informasi daftar perusahaan dan instansi mitra resmi yang siap menerima mahasiswa Kuliah Praktik.</p>
                    </article>

                    <!-- Feature 2 -->
                    <article class="feature-card-clean pop-card reveal-node stagger-2">
                        <div class="feature-header-row">
                            <div class="feature-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                </svg>
                            </div>
                            <span class="feature-number-tag">02</span>
                        </div>
                        <h3>Manajemen Dokumen Administrasi</h3>
                        <p>Pengumpulan berkas prasyarat seperti surat pengantar, persetujuan jurusan, dan bukti penerimaan secara tertib.</p>
                    </article>

                    <!-- Feature 3 -->
                    <article class="feature-card-clean pop-card reveal-node stagger-1">
                        <div class="feature-header-row">
                            <div class="feature-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                            </div>
                            <span class="feature-number-tag">03</span>
                        </div>
                        <h3>Logbook Aktivitas Harian</h3>
                        <p>Pencatatan kegiatan harian mahasiswa selama magang yang dapat ditinjau dan divalidasi langsung oleh pembimbing.</p>
                    </article>

                    <!-- Feature 4 -->
                    <article class="feature-card-clean pop-card reveal-node stagger-2">
                        <div class="feature-header-row">
                            <div class="feature-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <span class="feature-number-tag">04</span>
                        </div>
                        <h3>Validasi Kuota Perusahaan</h3>
                        <p>Penerapan aturan kuota sistematis (maksimal 1 kelompok atau 3 individu per tempat KP) untuk pemerataan penempatan.</p>
                    </article>

                    <!-- Feature 5 -->
                    <article class="feature-card-clean pop-card reveal-node stagger-1">
                        <div class="feature-header-row">
                            <div class="feature-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                    <line x1="12" y1="11" x2="12" y2="17"></line>
                                    <line x1="9" y1="14" x2="15" y2="14"></line>
                                </svg>
                            </div>
                            <span class="feature-number-tag">05</span>
                        </div>
                        <h3>Bimbingan Laporan Akhir</h3>
                        <p>Pengumpulan naskah laporan komprehensif dengan histori revisi dan catatan persetujuan dosen pembimbing.</p>
                    </article>

                    <!-- Feature 6 -->
                    <article class="feature-card-clean pop-card reveal-node stagger-2">
                        <div class="feature-header-row">
                            <div class="feature-icon-badge">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="7"></circle>
                                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                </svg>
                            </div>
                            <span class="feature-number-tag">06</span>
                        </div>
                        <h3>Penjadwalan Sidang KP</h3>
                        <p>Pengajuan jadwal sidang akhir, penugasan dewan penguji oleh jurusan, dan evaluasi nilai kelulusan Kuliah Praktik.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════════
             SECTION: ALUR KULIAH PRAKTIK (POP-CARD ENABLED)
        ═══════════════════════════════════════════════════════════════ -->
        <section class="timeline-section" id="alur">
            <div class="container">
                <div class="section-header-centered reveal-node">
                    <span class="badge-kicker">TAHAPAN SISTEMATIS</span>
                    <h2 class="section-title-refined">
                        Empat langkah pelaksanaan <strong>Kuliah Praktik</strong>
                    </h2>
                    <p class="section-desc-clean">
                        Alur terstruktur yang memandu mahasiswa dari tahap pendaftaran hingga penyelesaian sidang akhir.
                    </p>
                </div>

                <div class="timeline-row-layout">
                    <!-- Step 1 -->
                    <article class="timeline-step-card pop-card reveal-node stagger-1">
                        <div class="step-bubble">1</div>
                        <div class="step-phase-label">TAHAP 01</div>
                        <h3>Persiapan</h3>
                        <p>Pemilihan mitra perusahaan, pendaftaran anggota kelompok, dan penerbitan surat pengantar resmi.</p>
                    </article>

                    <!-- Step 2 -->
                    <article class="timeline-step-card pop-card reveal-node stagger-2">
                        <div class="step-bubble">2</div>
                        <div class="step-phase-label">TAHAP 02</div>
                        <h3>Pelaksanaan</h3>
                        <p>Pelaksanaan tugas magang di lapangan dengan pengisian berkala pada logbook kegiatan digital.</p>
                    </article>

                    <!-- Step 3 -->
                    <article class="timeline-step-card pop-card reveal-node stagger-1">
                        <div class="step-bubble">3</div>
                        <div class="step-phase-label">TAHAP 03</div>
                        <h3>Pelaporan</h3>
                        <p>Penyusunan naskah laporan akhir dan proses bimbingan revisi bersama dosen pembimbing.</p>
                    </article>

                    <!-- Step 4 -->
                    <article class="timeline-step-card pop-card reveal-node stagger-2">
                        <div class="step-bubble">4</div>
                        <div class="step-phase-label">TAHAP 04</div>
                        <h3>Sidang KP</h3>
                        <p>Pendaftaran sidang kelulusan, penetapan tim penguji, serta evaluasi nilai akhir Kuliah Praktik.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════════
             CTA BANNER (POP-CARD ENABLED)
        ═══════════════════════════════════════════════════════════════ -->
        <section class="cta-section" id="tentang">
            <div class="container">
                <div class="cta-glass-box pop-card reveal-node">
                    <div class="cta-text-side">
                        <h2>Siap memulai perjalanan Kuliah Praktik?</h2>
                        <p>Masuk ke akun SIMPUL untuk mengakses layanan administrasi, mengisi logbook, dan memantau status secara terstruktur.</p>
                    </div>
                    <a href="{{ route('login') }}" class="btn-cta-primary" style="white-space:nowrap; flex-shrink:0;">
                        <span>Masuk</span>
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- ═══════════════════════════════════════════════════════════════
         FOOTER
    ═══════════════════════════════════════════════════════════════ -->
    <footer>
        <div class="container footer-inner-wrap">
            <div class="footer-brand">
                <div class="footer-brand-badge">S</div>
                <div>
                    <h4>SIMPUL &bull; Universitas Lampung</h4>
                    <p>Sistem Informasi Manajemen Praktik Terpadu</p>
                </div>
            </div>

            <nav class="footer-links-list">
                <a href="#beranda">Beranda</a>
                <a href="#komunitas">Ekosistem</a>
                <a href="#fitur">Fitur</a>
                <a href="#alur">Alur KP</a>
            </nav>

            <span style="font-size:12px; color:#94a3b8;">&copy; {{ date('Y') }} SIMPUL &bull; Universitas Lampung</span>
        </div>
    </footer>

    <!-- ═══════════════════════════════════════════════════════════════
         INTERACTIVE SCRIPTS
    ═══════════════════════════════════════════════════════════════ -->
    <script>
        // ── 1. Navbar elevation on scroll ──
        const appNavbar = document.getElementById('appNavbar');
        window.addEventListener('scroll', () => {
            appNavbar.classList.toggle('is-scrolled', window.scrollY > 20);
        }, { passive: true });

        // ── 2. Scroll Reveal Observer ──
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.reveal-node').forEach(el => observer.observe(el));

        // ── 3. Interactive Ecosystem Role Switcher Logic (3 Role Utama SIMPUL) ──
        const ecoRoleData = {
            mahasiswa: {
                title: "Fokus Peran: Mahasiswa KP",
                text: "Mengeksplorasi referensi tempat KP dari rekam jejak alumni, mengajukan kesiapan KP & berkas persyaratan, mengisi logbook harian, mengunggah laporan akhir, serta mendaftar sidang kelulusan secara mandiri.",
                podId: "pod-mahasiswa"
            },
            dosen: {
                title: "Fokus Peran: Dosen Pembimbing",
                text: "Memantau progres kegiatan mahasiswa bimbingan secara real-time, memeriksa dan memvalidasi logbook harian, serta memberikan catatan revisi pada naskah laporan akhir KP.",
                podId: "pod-dosen"
            },
            admin: {
                title: "Fokus Peran: Admin Jurusan",
                text: "Mengelola referensi mitra perusahaan, memvalidasi berkas kesiapan KP dengan aturan pembatasan kuota (maksimal 1 kelompok / 3 individu), menetapkan dosen pembimbing, serta mengatur jadwal sidang KP.",
                podId: "pod-admin"
            }
        };

        function activateEcoRole(roleKey, btnElement) {
            document.querySelectorAll('.eco-chip-btn').forEach(b => b.classList.remove('active'));
            if (btnElement) {
                btnElement.classList.add('active');
            } else {
                const btn = Array.from(document.querySelectorAll('.eco-chip-btn')).find(b =>
                    b.innerText.toLowerCase().includes(roleKey.toLowerCase())
                );
                if (btn) btn.classList.add('active');
            }

            const data = ecoRoleData[roleKey];
            if (!data) return;

            document.querySelectorAll('.network-node-pod').forEach(pod => pod.classList.remove('is-highlighted'));
            const targetPod = document.getElementById(data.podId);
            if (targetPod) targetPod.classList.add('is-highlighted');

            const spotlight = document.getElementById('ecoSpotlight');
            spotlight.style.opacity = '0.3';
            setTimeout(() => {
                document.getElementById('ecoSpotlightTitle').textContent = data.title;
                document.getElementById('ecoSpotlightText').textContent = data.text;
                spotlight.style.opacity = '1';
            }, 120);
        }
    </script>

</body>
</html>
