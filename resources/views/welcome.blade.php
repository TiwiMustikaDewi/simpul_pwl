<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPUL - Universitas Lampung</title>

    <style>
        :root {
            --blue: #1976e8;
            --blue-dark: #174b91;
            --blue-light: #e7f3ff;
            --sky: #cceaff;
            --bg: #f4f9ff;
            --white: #ffffff;
            --text: #183153;
            --muted: #70829c;
            --border: #e1ebf6;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background: var(--bg);
            line-height: 1.6;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .container {
            width: min(1180px, 92%);
            margin: auto;
        }

        /* NAVBAR */
        .navbar {
            background: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .nav-inner {
            min-height: 76px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            background: var(--blue);
            color: white;
            display: grid;
            place-items: center;
            font-size: 24px;
            font-weight: 800;
            box-shadow: 0 5px 14px #1976e82b;
        }

        .brand h2 {
            font-size: 21px;
            line-height: 1.3;
            color: var(--blue-dark);
        }

        .brand p {
            font-size: 11px;
            color: var(--muted);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
            font-size: 14px;
            font-weight: 600;
        }

        .nav-links a:not(.btn):hover {
            color: var(--blue);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 21px;
            border: none;
            border-radius: 11px;
            background: var(--blue);
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s ease;
        }

        .btn:hover {
            background: #1265ca;
            transform: translateY(-2px);
        }

        .btn-outline {
            background: white;
            border: 1px solid #b9d9fa;
            color: var(--blue-dark);
        }

        .btn-outline:hover {
            background: var(--blue-light);
            color: var(--blue-dark);
        }

        /* HERO */
        .hero {
            padding: 55px 0 48px;
            background: linear-gradient(125deg, #eaf5ff, #d7edff 62%, #f2f8ff);
            overflow: hidden;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr .85fr;
            align-items: center;
            gap: 45px;
        }

        .eyebrow {
            display: inline-block;
            padding: 7px 13px;
            border-radius: 20px;
            background: white;
            color: var(--blue-dark);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 19px;
        }

        .hero h1 {
            max-width: 650px;
            font-size: clamp(34px, 4vw, 51px);
            line-height: 1.18;
            letter-spacing: -1.4px;
            color: #153b70;
            margin-bottom: 20px;
        }

        .hero h1 span {
            color: var(--blue);
        }

        .hero-description {
            max-width: 580px;
            color: #607895;
            font-size: 16px;
            margin-bottom: 27px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .hero-note {
            margin-top: 22px;
            color: #7287a2;
            font-size: 12px;
        }

        /* RINGKASAN VISUAL */
        .overview {
            background: rgba(255, 255, 255, .86);
            border: 1px solid white;
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 15px 45px #3979ae12;
        }

        .overview-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 22px;
        }

        .overview-heading h2 {
            font-size: 18px;
            color: var(--blue-dark);
        }

        .status-label {
            font-size: 10px;
            font-weight: 800;
            color: #16805b;
            background: #e0f8ee;
            padding: 6px 10px;
            border-radius: 20px;
        }

        .overview-intro {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 17px;
        }

        .progress-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .progress-row span:last-child {
            color: var(--blue);
        }

        .progress-track {
            height: 10px;
            width: 100%;
            background: #e8f1fb;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 23px;
        }

        .progress-fill {
            height: 100%;
            width: 100%;
            background: linear-gradient(90deg, #1684f5, #54b8ff);
            border-radius: inherit;
        }

        .stage-list {
            display: grid;
            gap: 12px;
        }

        .stage {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px;
            border-radius: 14px;
            background: #f4f9ff;
        }

        .stage-icon {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 12px;
            background: #dceeff;
            color: var(--blue);
            font-size: 18px;
            font-weight: 800;
        }

        .stage h3 {
            font-size: 13px;
            margin-bottom: 2px;
        }

        .stage p {
            font-size: 11px;
            color: var(--muted);
        }

        .stage-arrow {
            margin-left: auto;
            color: var(--blue);
            font-size: 20px;
        }

        /* SECTION */
        .section {
            padding: 65px 0;
        }

        .section-heading {
            margin-bottom: 30px;
        }

        .section-heading .mini-title {
            color: var(--blue);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.3px;
        }

        .section-heading h2 {
            color: var(--blue-dark);
            font-size: 29px;
            line-height: 1.3;
            margin: 7px 0 10px;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 14px;
            max-width: 600px;
        }

        /* FITUR */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .feature {
            padding: 24px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 18px;
            transition: .2s ease;
        }

        .feature:hover {
            transform: translateY(-4px);
            border-color: #b8d9fc;
            box-shadow: 0 12px 30px #3979ae10;
        }

        .feature-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .feature-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            background: var(--blue-light);
            color: var(--blue);
            border-radius: 14px;
            font-size: 20px;
            font-weight: 800;
        }

        .feature-number {
            font-size: 11px;
            font-weight: 800;
            color: #8ca4c1;
        }

        .feature h3 {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .feature p {
            color: var(--muted);
            font-size: 13px;
        }

        /* ALUR */
        .process-section {
            background: #eaf5ff;
            border-top: 1px solid #dcecff;
            border-bottom: 1px solid #dcecff;
        }

        .process-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .process-item {
            padding: 20px 0;
            border-top: 3px solid var(--blue);
        }

        .process-label {
            color: var(--blue);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .process-item h3 {
            font-size: 16px;
            margin: 9px 0;
        }

        .process-item p {
            font-size: 13px;
            color: var(--muted);
        }

        /* CTA */
        .cta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            padding: 32px;
            background: linear-gradient(110deg, #dcefff, #eff8ff);
            border: 1px solid #d5e9fc;
            border-radius: 22px;
        }

        .cta h2 {
            font-size: 24px;
            color: var(--blue-dark);
            margin-bottom: 7px;
        }

        .cta p {
            font-size: 14px;
            color: var(--muted);
        }

        /* FOOTER */
        footer {
            background: white;
            border-top: 1px solid var(--border);
            padding: 25px 0;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 12px;
            color: var(--muted);
        }

        .footer-inner strong {
            color: var(--blue-dark);
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .overview {
                max-width: 600px;
            }

            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .process-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .nav-inner {
                padding: 13px 0;
                align-items: flex-start;
            }

            .brand p {
                max-width: 180px;
            }

            .nav-links {
                gap: 12px;
                font-size: 12px;
            }

            .nav-links a:not(.btn) {
                display: none;
            }

            .nav-links .btn {
                padding: 10px 14px;
            }

            .hero {
                padding: 38px 0;
            }

            .hero h1 {
                font-size: 35px;
            }

            .hero-description {
                font-size: 14px;
            }

            .overview {
                padding: 18px;
            }

            .section {
                padding: 45px 0;
            }

            .section-heading h2 {
                font-size: 25px;
            }

            .feature-grid,
            .process-grid {
                grid-template-columns: 1fr;
            }

            .cta {
                align-items: flex-start;
                flex-direction: column;
                padding: 24px;
            }

            .cta h2 {
                font-size: 21px;
            }

            .footer-inner {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    <header class="navbar">
        <div class="container nav-inner">
            <a href="/" class="brand">
                <div class="brand-icon">S</div>
                <div>
                    <h2>SIMPUL</h2>
                    <p>Sistem Informasi Manajemen Praktik</p>
                </div>
            </a>

            <nav class="nav-links">
                <a href="#beranda">Beranda</a>
                <a href="#fitur">Fitur</a>
                <a href="#alur">Alur KP</a>
                <a href="{{ route('login') }}" class="btn">Login →</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero" id="beranda">
            <div class="container hero-grid">

                <div>
                    <span class="eyebrow">
                        UNIVERSITAS LAMPUNG · KULIAH PRAKTIK
                    </span>

                    <h1>
                        Satu langkah lebih dekat dengan
                        <span>pengalaman profesionalmu!</span>
                    </h1>

                    <p class="hero-description">
                        SIMPUL membantu mahasiswa mengelola perjalanan Kuliah
                        Praktik, mulai dari persiapan dokumen, kegiatan logbook,
                        laporan, hingga pengajuan sidang dalam satu sistem.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn">
                            Masuk ke SIMPUL →
                        </a>

                        <a href="#fitur" class="btn btn-outline">
                            Jelajahi Fitur
                        </a>
                    </div>

                    <p class="hero-note">
                        Sistem Informasi Manajemen Praktik · Universitas Lampung
                    </p>
                </div>

                <div class="overview">
                    <div class="overview-heading">
                        <h2>Perjalanan Kuliah Praktik</h2>
                        <span class="status-label">4 TAHAP UTAMA</span>
                    </div>

                    <p class="overview-intro">
                        Kenali tahapan yang akan dilalui dalam pelaksanaan KP.
                    </p>

                    <div class="progress-row">
                        <span>Alur pelaksanaan KP</span>
                        <span>4 tahapan</span>
                    </div>

                    <div class="progress-track">
                        <div class="progress-fill"></div>
                    </div>

                    <div class="stage-list">
                        <div class="stage">
                            <div class="stage-icon">01</div>
                            <div>
                                <h3>Persiapan</h3>
                                <p>Informasi tempat dan dokumen KP</p>
                            </div>
                            <span class="stage-arrow">›</span>
                        </div>

                        <div class="stage">
                            <div class="stage-icon">02</div>
                            <div>
                                <h3>Pelaksanaan</h3>
                                <p>Kegiatan dan pencatatan logbook</p>
                            </div>
                            <span class="stage-arrow">›</span>
                        </div>

                        <div class="stage">
                            <div class="stage-icon">03</div>
                            <div>
                                <h3>Pelaporan</h3>
                                <p>Penyusunan dan pengumpulan laporan</p>
                            </div>
                            <span class="stage-arrow">›</span>
                        </div>

                        <div class="stage">
                            <div class="stage-icon">04</div>
                            <div>
                                <h3>Sidang KP</h3>
                                <p>Pengajuan sidang sesuai persyaratan</p>
                            </div>
                            <span class="stage-arrow">›</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="section" id="fitur">
            <div class="container">
                <div class="section-heading">
                    <span class="mini-title">FITUR SIMPUL</span>
                    <h2>Semua kebutuhan KP dalam satu tempat</h2>
                    <p>
                        Informasi dan layanan yang mendukung proses Kuliah
                        Praktik mahasiswa Universitas Lampung.
                    </p>
                </div>

                <div class="feature-grid">
                    <article class="feature">
                        <div class="feature-top">
                            <div class="feature-icon">⌕</div>
                            <span class="feature-number">01</span>
                        </div>
                        <h3>Informasi Tempat KP</h3>
                        <p>
                            Akses informasi instansi yang dapat menjadi
                            referensi pilihan tempat Kuliah Praktik.
                        </p>
                    </article>

                    <article class="feature">
                        <div class="feature-top">
                            <div class="feature-icon">▤</div>
                            <span class="feature-number">02</span>
                        </div>
                        <h3>Administrasi dan Dokumen</h3>
                        <p>
                            Persiapkan dan kumpulkan dokumen yang dibutuhkan
                            dalam proses pengajuan KP.
                        </p>
                    </article>

                    <article class="feature">
                        <div class="feature-top">
                            <div class="feature-icon">↗</div>
                            <span class="feature-number">03</span>
                        </div>
                        <h3>Logbook Kegiatan</h3>
                        <p>
                            Catat kegiatan selama pelaksanaan Kuliah Praktik
                            sebagai dokumentasi aktivitas.
                        </p>
                    </article>

                    <article class="feature">
                        <div class="feature-top">
                            <div class="feature-icon">◎</div>
                            <span class="feature-number">04</span>
                        </div>
                        <h3>Data Kelompok KP</h3>
                        <p>
                            Dukung pelaksanaan KP secara berkelompok dengan
                            tetap menyimpan data setiap mahasiswa.
                        </p>
                    </article>

                    <article class="feature">
                        <div class="feature-top">
                            <div class="feature-icon">▥</div>
                            <span class="feature-number">05</span>
                        </div>
                        <h3>Laporan KP</h3>
                        <p>
                            Kelola pengumpulan laporan sebagai bagian dari
                            tahapan penyelesaian Kuliah Praktik.
                        </p>
                    </article>

                    <article class="feature">
                        <div class="feature-top">
                            <div class="feature-icon">✓</div>
                            <span class="feature-number">06</span>
                        </div>
                        <h3>Pengajuan Sidang</h3>
                        <p>
                            Ajukan sidang setelah persyaratan penyelesaian
                            Kuliah Praktik terpenuhi.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section process-section" id="alur">
            <div class="container">
                <div class="section-heading">
                    <span class="mini-title">ALUR KULIAH PRAKTIK</span>
                    <h2>Kenali setiap tahapannya</h2>
                    <p>
                        Gambaran umum proses Kuliah Praktik yang dikelola
                        melalui SIMPUL.
                    </p>
                </div>

                <div class="process-grid">
                    <article class="process-item">
                        <span class="process-label">TAHAP 01</span>
                        <h3>Persiapan</h3>
                        <p>
                            Mencari informasi tempat KP dan menyiapkan
                            dokumen administrasi.
                        </p>
                    </article>

                    <article class="process-item">
                        <span class="process-label">TAHAP 02</span>
                        <h3>Pelaksanaan</h3>
                        <p>
                            Melaksanakan kegiatan KP dan mengisi catatan
                            kegiatan pada logbook.
                        </p>
                    </article>

                    <article class="process-item">
                        <span class="process-label">TAHAP 03</span>
                        <h3>Pelaporan</h3>
                        <p>
                            Menyusun dan mengumpulkan laporan sesuai
                            ketentuan yang berlaku.
                        </p>
                    </article>

                    <article class="process-item">
                        <span class="process-label">TAHAP 04</span>
                        <h3>Sidang KP</h3>
                        <p>
                            Mengajukan sidang setelah persyaratan
                            penyelesaian KP terpenuhi.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section" id="tentang">
            <div class="container">
                <div class="cta">
                    <div>
                        <h2>Siap memulai Kuliah Praktik?</h2>
                        <p>
                            Masuk ke SIMPUL untuk mengakses layanan
                            Kuliah Praktik Universitas Lampung.
                        </p>
                    </div>

                    <a href="{{ route('login') }}" class="btn">
                        Masuk ke Sistem →
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container footer-inner">
            <strong>SIMPUL · Universitas Lampung</strong>
            <span>Sistem Informasi Manajemen Praktik</span>
            <span>© {{ date('Y') }} SIMPUL</span>
        </div>
    </footer>

</body>
</html>
