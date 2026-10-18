<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa | SIMPUL</title>

    <style>
        :root {
            --blue: #0878f9;
            --blue-dark: #174b91;
            --blue-light: #e8f3ff;
            --bg: #f2f8ff;
            --text: #15294b;
            --muted: #71839d;
            --border: #dce9f8;
            --white: #ffffff;
            --green: #18a875;
            --red: #f05b5b;
            --yellow: #f5a623;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 25px;
        }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 0% 0%, #dcefff 0, transparent 28%),
                var(--bg);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input {
            font: inherit;
        }

        button, a {
            -webkit-tap-highlight-color: transparent;
        }

        button {
            cursor: pointer;
        }

        .app {
            min-height: 100vh;
        }

        /* HEADER */

        .topbar {
            height: 76px;
            position: sticky;
            top: 0;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
            padding: 0 30px;
            background: rgba(255, 255, 255, .96);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(14px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .brand-icon {
            width: 45px;
            height: 45px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: white;
            background: linear-gradient(145deg, #48a4ff, #0865e8);
            font-size: 24px;
            font-weight: 800;
            box-shadow: 0 6px 16px #0878f925;
        }

        .brand-name {
            color: var(--blue-dark);
            font-size: 21px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .brand-subtitle {
            margin-top: 3px;
            color: var(--muted);
            font-size: 10px;
        }

        .search-box {
            width: min(440px, 42%);
            height: 44px;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 15px;
            border: 1px solid var(--border);
            border-radius: 30px;
            background: #f8fbff;
            box-shadow: 0 3px 12px #173b6706;
        }

        .search-icon {
            color: #71839d;
            font-size: 21px;
        }

        .search-box input {
            width: 100%;
            min-width: 0;
            border: none;
            outline: none;
            background: transparent;
            color: var(--text);
            font-size: 12px;
        }

        .search-box input::placeholder {
            color: #8797ae;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header-icon {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: white;
            color: var(--blue-dark);
            font-size: 19px;
        }

        .header-icon:hover {
            background: var(--blue-light);
        }

        .account-name {
            max-width: 145px;
            overflow: hidden;
            color: var(--blue-dark);
            font-size: 11px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* MAIN LAYOUT */

        .layout {
            display: grid;
            grid-template-columns: 225px minmax(0, 1fr);
            min-height: calc(100vh - 76px);
        }

        /* SIDEBAR */

        .sidebar {
            display: flex;
            flex-direction: column;
            padding: 24px 14px;
            background: rgba(255, 255, 255, .92);
            border-right: 1px solid var(--border);
        }

        .nav-label {
            margin: 0 12px 13px;
            color: #91a2ba;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            margin-bottom: 5px;
            border-radius: 11px;
            color: #536783;
            font-size: 12px;
            transition: .2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--blue);
            background: var(--blue-light);
        }

        .nav-icon {
            width: 23px;
            flex-shrink: 0;
            text-align: center;
            font-size: 18px;
        }

        .sidebar-note {
            margin-top: 26px;
            padding: 16px;
            border: 1px solid var(--border);
            border-radius: 15px;
            background: linear-gradient(145deg, #f8fbff, #eaf4ff);
        }

        .note-icon {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            margin-bottom: 12px;
            border-radius: 12px;
            background: #fff0ce;
            font-size: 20px;
        }

        .sidebar-note h3 {
            color: var(--blue-dark);
            font-size: 12px;
        }

        .sidebar-note p {
            margin: 9px 0 13px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-top: auto;
            padding: 14px 8px 0;
        }

        .avatar {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 50%;
            background: #e0efff;
            font-size: 21px;
        }

        .profile-info {
            min-width: 0;
        }

        .profile-info strong {
            display: block;
            overflow-wrap: anywhere;
            color: var(--blue-dark);
            font-size: 11px;
        }

        .profile-info span {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 10px;
        }

        /* BUTTONS */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 11px 17px;
            border: 0;
            border-radius: 11px;
            font-size: 11px;
            font-weight: 700;
            transition: .2s;
        }

        .btn-primary {
            color: white;
            background: var(--blue);
            box-shadow: 0 5px 13px #0878f91a;
        }

        .btn-primary:hover {
            background: #0866d9;
            transform: translateY(-1px);
        }

        .btn-outline {
            border: 1px solid var(--border);
            background: white;
            color: var(--blue-dark);
        }

        .btn-outline:hover {
            background: var(--blue-light);
        }

        .btn-full {
            width: 100%;
        }

        /* CONTENT */

        .content {
            width: 100%;
            min-width: 0;
            max-width: 1700px;
            padding: 28px;
            margin: 0 auto;
        }

        .page-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 20px;
        }

        .breadcrumb {
            margin-bottom: 9px;
            color: var(--muted);
            font-size: 10px;
        }

        .page-top h1 {
            color: var(--blue-dark);
            font-size: 25px;
            letter-spacing: -.5px;
        }

        .page-top p {
            margin-top: 7px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .period-badge {
            flex-shrink: 0;
            padding: 11px 13px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: white;
            color: var(--blue-dark);
            font-size: 11px;
            font-weight: 600;
        }

        /* DASHBOARD GRID */

        .dashboard-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 285px;
            align-items: start;
            gap: 19px;
        }

        .main-column,
        .right-column {
            display: grid;
            align-content: start;
            gap: 18px;
            min-width: 0;
        }

        /* WELCOME BANNER */

        .welcome-banner {
            position: relative;
            overflow: hidden;
            min-height: 250px;
            padding: 28px;
            border: 1px solid #c9e3ff;
            border-radius: 19px;
            background:
                radial-gradient(circle at 95% 0%, #c0e0ff 0, transparent 37%),
                linear-gradient(120deg, #ffffff 0%, #e8f4ff 65%, #dceeff 100%);
            box-shadow: 0 9px 25px #173b6708;
        }

        .welcome-banner::after {
            content: "";
            position: absolute;
            right: -55px;
            bottom: -100px;
            width: 220px;
            height: 220px;
            border: 30px solid #0878f90b;
            border-radius: 50%;
        }

        .eyebrow {
            position: relative;
            z-index: 1;
            margin-bottom: 17px;
            color: var(--blue);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .welcome-banner h2 {
            position: relative;
            z-index: 1;
            max-width: 440px;
            color: #12264a;
            font-size: clamp(25px, 3vw, 36px);
            line-height: 1.2;
            letter-spacing: -1px;
        }

        .welcome-banner h2 span {
            color: var(--blue);
        }

        .welcome-banner .welcome-text {
            position: relative;
            z-index: 1;
            max-width: 390px;
            margin: 13px 0 19px;
            color: #536b8a;
            font-size: 12px;
            line-height: 1.8;
        }

        .welcome-banner .btn {
            position: relative;
            z-index: 2;
            padding: 12px 19px;
        }

        /* SECTION HEADINGS */

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .section-heading h2 {
            color: var(--blue-dark);
            font-size: 15px;
        }

        .section-heading p {
            margin-top: 5px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.7;
        }

        .text-link {
            flex-shrink: 0;
            color: var(--blue);
            font-size: 11px;
            font-weight: 700;
        }

        .text-link:hover {
            text-decoration: underline;
        }

        /* CONTINUE PROCESS */

        .progress-card {
            display: flex;
            align-items: center;
            gap: 17px;
            padding: 15px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: white;
            box-shadow: 0 5px 18px #173b6708;
        }

        .progress-illustration {
            width: 110px;
            min-height: 100px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 12px;
            background: linear-gradient(145deg, #e6f4ff, #c8e5ff);
            font-size: 43px;
        }

        .progress-detail {
            flex: 1;
            min-width: 0;
        }

        .progress-detail h3 {
            margin-bottom: 7px;
            color: var(--blue-dark);
            font-size: 13px;
        }

        .progress-detail p {
            color: var(--muted);
            font-size: 10px;
            line-height: 1.7;
        }

        .progress-track {
            height: 9px;
            overflow: hidden;
            margin-top: 13px;
            border-radius: 20px;
            background: #dbeaff;
        }

        .progress-fill {
            width: 0;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #0878f9, #57adff);
        }

        .progress-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 7px;
            color: var(--blue);
            font-size: 11px;
            font-weight: 800;
        }

        .progress-card .btn {
            flex-shrink: 0;
        }

        /* SERVICE CARDS */

        .service-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .service-card {
            display: block;
            min-width: 0;
            padding: 17px;
            border: 1px solid transparent;
            border-radius: 16px;
            transition: .2s;
        }

        .service-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 9px 22px #173b6710;
        }

        .service-card.blue {
            background: #e1efff;
            border-color: #d3e7ff;
        }

        .service-card.red {
            background: #fff0ef;
            border-color: #ffe2df;
        }

        .service-card.green {
            background: #e1f8ef;
            border-color: #d3f2e6;
        }

        .service-card.yellow {
            background: #fff4dd;
            border-color: #ffebc6;
        }

        .service-icon {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            margin-bottom: 13px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .75);
            font-size: 21px;
        }

        .service-card h3 {
            margin-bottom: 7px;
            color: var(--text);
            font-size: 12px;
            line-height: 1.5;
        }

        .service-card p {
            color: #61738d;
            font-size: 10px;
            line-height: 1.7;
        }

        .service-arrow {
            display: block;
            margin-top: 10px;
            color: var(--blue-dark);
            text-align: right;
            font-size: 17px;
        }

        /* COMPANY REFERENCES */

        .company-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
        }

        .company-card {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 13px;
            background: white;
            transition: .2s;
        }

        .company-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 18px #173b6710;
        }

        .company-image {
            height: 100px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #d6ebff, #eef7ff);
            font-size: 36px;
        }

        .company-info {
            padding: 11px;
        }

        .company-info h3 {
            color: var(--blue-dark);
            font-size: 11px;
            line-height: 1.5;
        }

        .company-info p {
            margin-top: 4px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.5;
        }

        .company-arrow {
            display: block;
            margin-top: 7px;
            color: var(--blue);
            text-align: right;
            font-size: 15px;
        }

        /* RIGHT COLUMN PANELS */

        .panel {
            min-width: 0;
            padding: 19px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: white;
            box-shadow: 0 5px 20px #173b6706;
        }

        .panel-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 9px;
            margin-bottom: 17px;
        }

        .panel-title h2 {
            color: var(--text);
            font-size: 14px;
        }

        .small-badge {
            padding: 6px 8px;
            border-radius: 8px;
            background: var(--blue-light);
            color: var(--blue);
            font-size: 9px;
            font-weight: 700;
        }

        /* CIRCULAR PROGRESS */

        .target-overview {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .circle-progress {
            --progress: 60%;
            position: relative;
            width: 125px;
            height: 125px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 50%;
            background: conic-gradient(
                var(--blue) var(--progress),
                #dfedff var(--progress)
            );
        }

        .circle-progress::before {
            content: "";
            position: absolute;
            inset: 10px;
            border-radius: 50%;
            background: white;
        }

        .circle-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .circle-content .circle-icon {
            display: block;
            margin-bottom: 5px;
            font-size: 22px;
        }

        .circle-content strong {
            display: block;
            color: var(--text);
            font-size: 15px;
        }

        .circle-content span {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 10px;
        }

        .target-copy {
            min-width: 0;
        }

        .target-copy strong {
            display: block;
            color: var(--text);
            font-size: 12px;
            line-height: 1.6;
        }

        .target-copy p {
            margin-top: 7px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.7;
        }

        .step-track {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 4px;
            margin-top: 23px;
        }

        .step {
            min-width: 0;
            text-align: center;
        }

        .step-dot {
            width: 23px;
            height: 23px;
            display: grid;
            place-items: center;
            margin: 0 auto 7px;
            border: 2px solid #d3e2f5;
            border-radius: 50%;
            background: white;
            color: white;
            font-size: 11px;
        }

        .step.done .step-dot {
            border-color: var(--blue);
            background: var(--blue);
        }

        .step span {
            display: block;
            color: var(--muted);
            font-size: 8px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        /* STATUS LIST */

        .status-list {
            display: grid;
            gap: 4px;
        }

        .status-row {
            display: grid;
            grid-template-columns: 22px 34px minmax(0, 1fr);
            align-items: center;
            gap: 9px;
            padding: 10px 6px;
            border-radius: 10px;
        }

        .status-row.highlight {
            background: #eaf4ff;
        }

        .rank {
            width: 22px;
            height: 22px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #e6eef8;
            color: #6c7e96;
            font-size: 10px;
            font-weight: 800;
        }

        .rank.first {
            background: #ffb52e;
            color: white;
        }

        .rank.third {
            background: #ef9146;
            color: white;
        }

        .person-avatar {
            width: 33px;
            height: 33px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #e5f1ff;
            font-size: 19px;
        }

        .status-person {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 7px;
            min-width: 0;
        }

        .status-person strong {
            min-width: 0;
            overflow: hidden;
            color: var(--text);
            font-size: 10px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .status-label {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 9px;
            line-height: 1.5;
        }

        .status-symbol {
            flex-shrink: 0;
            font-size: 12px;
        }

        .status-symbol.success {
            color: var(--green);
        }

        .status-symbol.waiting {
            color: var(--yellow);
        }

        .status-symbol.revision {
            color: #ef9146;
        }

        .status-symbol.running {
            color: var(--blue);
        }

        /* SIDANG PANEL */

        .sidang-card {
            overflow: hidden;
            background: linear-gradient(145deg, white, #edf6ff);
        }

        .sidang-illustration {
            width: 76px;
            height: 76px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 18px;
            background: #deedff;
            font-size: 42px;
        }

        .sidang-top {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 15px;
        }

        .sidang-copy h3 {
            margin-bottom: 6px;
            color: var(--blue-dark);
            font-size: 12px;
        }

        .sidang-copy p {
            color: var(--muted);
            font-size: 10px;
            line-height: 1.7;
        }

        .mini-track {
            height: 8px;
            overflow: hidden;
            margin: 14px 0 7px;
            border-radius: 20px;
            background: #dbeaff;
        }

        .mini-track span {
            display: block;
            width: 60%;
            height: 100%;
            border-radius: inherit;
            background: var(--blue);
        }

        .mini-progress-label {
            margin-bottom: 14px;
            color: var(--muted);
            font-size: 10px;
            text-align: right;
        }

        /* SEARCH FEEDBACK */

        .empty-search {
            display: none;
            padding: 20px;
            border: 1px dashed var(--border);
            border-radius: 12px;
            color: var(--muted);
            background: white;
            font-size: 12px;
            text-align: center;
        }

        .empty-search.show {
            display: block;
        }

        /* FOOTER */

        .footer {
            padding: 20px;
            border-top: 1px solid var(--border);
            background: white;
            color: var(--muted);
            font-size: 10px;
            text-align: center;
            line-height: 1.8;
        }

        /* RESPONSIVE */

        @media (min-width: 1500px) {
            .content {
                padding: 36px;
            }

            .dashboard-grid {
                grid-template-columns: minmax(0, 1fr) 310px;
                gap: 22px;
            }

            .welcome-banner {
                min-height: 275px;
                padding: 34px;
            }
        }

        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .right-column {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                align-items: start;
            }

            .sidang-card {
                grid-column: 1 / -1;
            }

            .layout {
                grid-template-columns: 205px minmax(0, 1fr);
            }

            .content {
                padding: 23px;
            }
        }

        @media (max-width: 760px) {
            .topbar {
                height: auto;
                min-height: 70px;
                flex-wrap: wrap;
                gap: 12px;
                padding: 12px 16px;
            }

            .brand-icon {
                width: 39px;
                height: 39px;
            }

            .brand-name {
                font-size: 18px;
            }

            .search-box {
                order: 3;
                width: 100%;
                max-width: none;
            }

            .header-actions {
                gap: 8px;
            }

            .account-name {
                display: none;
            }

            .layout {
                display: block;
            }

            .sidebar {
                position: sticky;
                top: 0;
                z-index: 10;
                flex-direction: row;
                gap: 5px;
                overflow-x: auto;
                padding: 10px;
                border-right: none;
                border-bottom: 1px solid var(--border);
            }

            .nav-label,
            .sidebar-note,
            .sidebar-profile {
                display: none;
            }

            .nav-link {
                flex-shrink: 0;
                margin: 0;
                padding: 10px 12px;
                font-size: 11px;
            }

            .nav-icon {
                width: auto;
            }

            .content {
                padding: 20px 15px;
            }

            .page-top h1 {
                font-size: 22px;
            }

            .period-badge {
                font-size: 9px;
            }

            .welcome-banner {
                min-height: auto;
                padding: 23px;
            }

            .welcome-banner h2 {
                font-size: 28px;
            }

            .right-column {
                grid-template-columns: 1fr;
            }

            .sidang-card {
                grid-column: auto;
            }

            .progress-card {
                flex-wrap: wrap;
            }

            .progress-illustration {
                width: 75px;
                min-height: 75px;
            }

            .progress-card .btn {
                width: 100%;
            }
        }

        @media (max-width: 450px) {
            .page-top {
                display: block;
            }

            .period-badge {
                display: inline-block;
                margin-top: 12px;
            }

            .service-grid,
            .company-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 9px;
            }

            .service-card {
                padding: 12px;
            }

            .service-card h3 {
                font-size: 11px;
            }

            .company-image {
                height: 78px;
            }

            .progress-illustration {
                display: none;
            }

            .welcome-banner h2 {
                font-size: 25px;
            }

            .circle-progress {
                width: 110px;
                height: 110px;
            }

            .target-overview {
                gap: 10px;
            }

            .panel {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
<div class="app">

    <!-- HEADER -->
    <header class="topbar">
        <a href="{{ route('dashboard') }}" class="brand">
            <div class="brand-icon">S</div>
            <div>
                <div class="brand-name">SIMPUL</div>
                <div class="brand-subtitle">
                    Sistem Informasi Manajemen Praktik
                </div>
            </div>
        </a>

        <label class="search-box">
            <span class="search-icon">⌕</span>
            <input
                type="search"
                id="dashboardSearch"
                placeholder="Cari layanan, pengalaman KP, atau dokumen..."
                aria-label="Cari layanan dashboard"
            >
        </label>

        <div class="header-actions">
            <a href="#status-pengajuan" class="header-icon" title="Status pengajuan">
                ♧
            </a>

            <a href="#profil" class="header-icon" title="Profil pengguna">
                ◉
            </a>

            <span class="account-name">
                {{ auth()->user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <div class="layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="nav-label">MENU UTAMA</div>

            <a href="{{ route('dashboard') }}" class="nav-link active">
                <span class="nav-icon">⌂</span>
                Dashboard
            </a>

            <a href="#referensi" class="nav-link">
                <span class="nav-icon">▦</span>
                Eksplorasi Perusahaan
            </a>

            <a href="#pengajuan" class="nav-link">
                <span class="nav-icon">▤</span>
                Pengajuan KP
            </a>

            <a href="#logbook" class="nav-link">
                <span class="nav-icon">▣</span>
                Logbook
            </a>

            <a href="#progres" class="nav-link">
                <span class="nav-icon">▥</span>
                Progres KP
            </a>

            <a href="#kelompok" class="nav-link">
                <span class="nav-icon">♧</span>
                Kelompok KP
            </a>

            <a href="#pengalaman" class="nav-link">
                <span class="nav-icon">▧</span>
                Pengalaman KP
            </a>

            <a href="#panduan" class="nav-link">
                <span class="nav-icon">☆</span>
                Panduan KP
            </a>

            <div class="sidebar-note" id="panduan">
                <div class="note-icon">🏆</div>
                <h3>Panduan KP</h3>
                <p>
                    Temukan panduan, persyaratan, dan informasi untuk
                    mempersiapkan pelaksanaan Kuliah Praktik.
                </p>
                <a href="#tahapan" class="btn btn-primary btn-full">
                    Lihat Panduan →
                </a>
            </div>

            <div class="sidebar-profile" id="profil">
                <div class="avatar">👩🏻‍🎓</div>
                <div class="profile-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span>Mahasiswa SIMPUL</span>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="content">
            <div class="page-top">
                <div>
                    <div class="breadcrumb">SIMPUL / Dashboard Mahasiswa</div>
                    <h1>Dashboard Mahasiswa</h1>
                    <p>
                        Ringkasan dan informasi pelaksanaan Kuliah Praktik kamu.
                    </p>
                </div>

                <div class="period-badge">
                    ▣ Periode KP 2026
                </div>
            </div>

            <div class="dashboard-grid">

                <!-- KOLOM UTAMA -->
                <div class="main-column">

                    <!-- WELCOME -->
                    <section class="welcome-banner">
                        <div class="eyebrow">
                            KULIAH PRAKTIK · UNIVERSITAS LAMPUNG
                        </div>

                        <h2>
                            Selamat datang,<br>
                            <span>{{ auth()->user()->name }}! </span>
                        </h2>

                        <p class="welcome-text">
                            Satu langkah lebih dekat menuju pengalaman kerja
                            profesional. Temukan tempat KP, persiapkan dokumen,
                            dan pantau perjalanan Kuliah Praktikmu melalui SIMPUL.
                        </p>

                        <a href="#pengajuan" class="btn btn-primary">
                            Lanjutkan Proses KP <span>→</span>
                        </a>
                    </section>

                    <!-- PROSES KP -->
                    <section id="pengajuan">
                        <div class="section-heading">
                            <div>
                                <h2>Lanjutkan Proses KP</h2>
                                <p>Informasi layanan dan persiapan Kuliah Praktik.</p>
                            </div>

                            <a href="#tahapan" class="text-link">Lihat Semua →</a>
                        </div>

                        <div class="progress-card searchable-card">
                            <div class="progress-illustration">🏢</div>

                            <div class="progress-detail">
                                <h3>Pengajuan Kuliah Praktik</h3>
                                <p>Dokumen persyaratan · Status pengajuan</p>

                                <div class="progress-track">
                                    <div class="progress-fill"></div>
                                </div>

                                <div class="progress-meta">
                                    <span>Belum ada data pengajuan</span>
                                    <span>—</span>
                                </div>
                            </div>

                            <a href="#tahapan" class="btn btn-primary">
                                Lihat Detail →
                            </a>
                        </div>
                    </section>

                    <!-- LAYANAN -->
                    <section>
                        <div class="section-heading">
                            <div>
                                <h2>Kembangkan Persiapanmu</h2>
                                <p>Pilih layanan yang ingin kamu lihat.</p>
                            </div>
                        </div>

                        <div class="service-grid">
                            <a href="#referensi"
                               class="service-card blue searchable-card">
                                <div class="service-icon">🏢</div>
                                <h3>Eksplorasi Perusahaan</h3>
                                <p>Cari referensi tempat KP dan bidang pekerjaan.</p>
                                <span class="service-arrow">→</span>
                            </a>

                            <a href="#pengajuan"
                               class="service-card red searchable-card">
                                <div class="service-icon">📋</div>
                                <h3>Pengajuan KP</h3>
                                <p>Persiapkan dokumen dan administrasi pengajuan.</p>
                                <span class="service-arrow">→</span>
                            </a>

                            <a href="#logbook"
                               class="service-card green searchable-card">
                                <div class="service-icon">📖</div>
                                <h3>Logbook Harian</h3>
                                <p>Catat aktivitas selama pelaksanaan KP.</p>
                                <span class="service-arrow">→</span>
                            </a>

                            <a href="#laporan"
                               class="service-card yellow searchable-card">
                                <div class="service-icon">📑</div>
                                <h3>Laporan dan Sidang</h3>
                                <p>Pantau persiapan laporan dan jadwal sidang.</p>
                                <span class="service-arrow">→</span>
                            </a>
                        </div>
                    </section>

                    <!-- REFERENSI PERUSAHAAN -->
                    <section id="referensi">
                        <div class="section-heading">
                            <div>
                                <h2>Referensi Tempat KP</h2>
                                <p>Contoh kategori tempat yang dapat dieksplorasi.</p>
                            </div>

                            <a href="#pengalaman" class="text-link">
                                Lihat Semua →
                            </a>
                        </div>

                        <div class="company-grid">
                            <a href="#pengalaman"
                               class="company-card searchable-card">
                                <div class="company-image">🏢</div>
                                <div class="company-info">
                                    <h3>Perusahaan Teknologi</h3>
                                    <p>Software Development</p>
                                    <span class="company-arrow">→</span>
                                </div>
                            </a>

                            <a href="#pengalaman"
                               class="company-card searchable-card">
                                <div class="company-image">💻</div>
                                <div class="company-info">
                                    <h3>Bidang Data</h3>
                                    <p>Data Analyst</p>
                                    <span class="company-arrow">→</span>
                                </div>
                            </a>

                            <a href="#pengalaman"
                               class="company-card searchable-card">
                                <div class="company-image">👩🏻‍💻</div>
                                <div class="company-info">
                                    <h3>Bidang Web</h3>
                                    <p>Web Development</p>
                                    <span class="company-arrow">→</span>
                                </div>
                            </a>

                            <a href="#pengalaman"
                               class="company-card searchable-card">
                                <div class="company-image">🏛️</div>
                                <div class="company-info">
                                    <h3>Instansi Pemerintah</h3>
                                    <p>Sistem Informasi</p>
                                    <span class="company-arrow">→</span>
                                </div>
                            </a>
                        </div>
                    </section>

                    <!-- LOGBOOK -->
                    <section id="logbook">
                        <div class="section-heading">
                            <div>
                                <h2>Logbook Harian</h2>
                                <p>Informasi pencatatan aktivitas selama KP.</p>
                            </div>
                        </div>

                        <div class="panel searchable-card">
                            <h3>Catatan Aktivitas KP</h3>
                            <p style="color: var(--muted); font-size: 11px; line-height: 1.8;">
                                Belum ada catatan logbook yang ditampilkan.
                                Aktivitas dapat dicatat setelah fitur logbook
                                terhubung dengan database.
                            </p>
                        </div>
                    </section>

                    <!-- PENGALAMAN -->
                    <section id="pengalaman">
                        <div class="section-heading">
                            <div>
                                <h2>Pengalaman KP</h2>
                                <p>Ruang informasi pengalaman Kuliah Praktik.</p>
                            </div>
                        </div>

                        <div class="panel searchable-card">
                            <h3>Referensi Pengalaman Mahasiswa</h3>
                            <p style="color: var(--muted); font-size: 11px; line-height: 1.8;">
                                Informasi pengalaman mahasiswa akan ditampilkan
                                setelah data dan fitur terkait tersedia.
                            </p>
                        </div>
                    </section>

                    <!-- TAHAPAN -->
                    <section id="tahapan">
                        <div class="section-heading">
                            <div>
                                <h2>Tahapan Kuliah Praktik</h2>
                                <p>Gambaran alur pelaksanaan KP di SIMPUL.</p>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="process-list">
                                <div class="process-item">
                                    <div class="process-number">1</div>
                                    <div>
                                        <h3>Eksplorasi tempat KP</h3>
                                        <p style="color: var(--muted); font-size: 11px; line-height: 1.8;">
                                            Cari referensi perusahaan atau instansi
                                            yang sesuai dengan kebutuhan KP.
                                        </p>
                                    </div>
                                </div>

                                <div class="process-item">
                                    <div class="process-number">2</div>
                                    <div>
                                        <h3>Persiapan dan pengajuan</h3>
                                        <p style="color: var(--muted); font-size: 11px; line-height: 1.8;">
                                            Siapkan dokumen dan ajukan persyaratan
                                            Kuliah Praktik untuk diverifikasi.
                                        </p>
                                    </div>
                                </div>

                                <div class="process-item">
                                    <div class="process-number">3</div>
                                    <div>
                                        <h3>Pelaksanaan dan monitoring</h3>
                                        <p style="color: var(--muted); font-size: 11px; line-height: 1.8;">
                                            Laksanakan KP, isi logbook, dan ikuti
                                            bimbingan dosen pembimbing.
                                        </p>
                                    </div>
                                </div>

                                <div class="process-item">
                                    <div class="process-number">4</div>
                                    <div>
                                        <h3>Laporan akhir dan sidang</h3>
                                        <p style="color: var(--muted); font-size: 11px; line-height: 1.8;">
                                            Persiapkan laporan dan lengkapi
                                            persyaratan pengajuan sidang KP.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- KELOMPOK -->
                    <section id="kelompok">
                        <div class="section-heading">
                            <div>
                                <h2>Kelompok KP</h2>
                                <p>Informasi pelaksanaan KP secara kelompok.</p>
                            </div>
                        </div>

                        <div class="panel searchable-card">
                            <h3>Informasi Kelompok</h3>
                            <p style="color: var(--muted); font-size: 11px; line-height: 1.8;">
                                Informasi kelompok akan muncul setelah data
                                kelompok KP tersedia. Setiap mahasiswa tetap
                                menggunakan akun dan data pribadinya.
                            </p>
                        </div>
                    </section>

                    <!-- LAPORAN -->
                    <section id="laporan">
                        <div class="section-heading">
                            <div>
                                <h2>Laporan Akhir dan Sidang</h2>
                                <p>Persiapan penyelesaian Kuliah Praktik.</p>
                            </div>
                        </div>

                        <div class="panel searchable-card">
                            <h3>Persiapan Laporan KP</h3>
                            <p style="color: var(--muted); font-size: 11px; line-height: 1.8;">
                                Belum ada laporan yang ditampilkan. Fitur unggah
                                laporan dan pengajuan sidang dapat dihubungkan
                                setelah implementasi modul terkait.
                            </p>
                        </div>
                    </section>

                </div>

                <!-- KOLOM KANAN -->
                <aside class="right-column">

                    <!-- TARGET PROGRES -->
                    <section class="panel" id="progres">
                        <div class="panel-title">
                            <h2>Target Progres KP</h2>
                            <span class="small-badge">Periode KP</span>
                        </div>

                        <div class="target-overview">
                            <div class="circle-progress">
                                <div class="circle-content">
                                    <span class="circle-icon">▤</span>
                                    <strong>0 dari 5</strong>
                                    <span>Tahapan</span>
                                </div>
                            </div>

                            <div class="target-copy">
                                <strong>Mulai perjalanan KP-mu!</strong>
                                <p>
                                    Pantau setiap tahapan Kuliah Praktik
                                    melalui dashboard SIMPUL.
                                </p>
                            </div>
                        </div>

                        <div class="step-track">
                            <div class="step">
                                <div class="step-dot">1</div>
                                <span>Pengajuan</span>
                            </div>

                            <div class="step">
                                <div class="step-dot">2</div>
                                <span>Persetujuan</span>
                            </div>

                            <div class="step">
                                <div class="step-dot">3</div>
                                <span>Logbook</span>
                            </div>

                            <div class="step">
                                <div class="step-dot">4</div>
                                <span>Laporan</span>
                            </div>

                            <div class="step">
                                <div class="step-dot">5</div>
                                <span>Sidang</span>
                            </div>
                        </div>
                    </section>

                    <!-- STATUS PENGAJUAN -->
                    <section class="panel" id="status-pengajuan">
                        <div class="panel-title">
                            <h2>Status Pengajuan KP</h2>
                            <span class="small-badge">Periode ini</span>
                        </div>

                        <div class="status-list">
                            <div class="status-row">
                                <div class="rank first">1</div>
                                <div class="person-avatar">👩🏻‍🎓</div>
                                <div>
                                    <div class="status-person">
                                        <strong>{{ auth()->user()->name }}</strong>
                                        <span class="status-symbol waiting">●</span>
                                    </div>
                                    <span class="status-label">
                                        Belum ada pengajuan
                                    </span>
                                </div>
                            </div>

                            <div class="status-row">
                                <div class="rank">2</div>
                                <div class="person-avatar">👨🏻‍🎓</div>
                                <div>
                                    <div class="status-person">
                                        <strong>Status verifikasi</strong>
                                        <span class="status-symbol running">◷</span>
                                    </div>
                                    <span class="status-label">
                                        Menunggu data pengajuan
                                    </span>
                                </div>
                            </div>

                            <div class="status-row">
                                <div class="rank third">3</div>
                                <div class="person-avatar">👩🏻‍💻</div>
                                <div>
                                    <div class="status-person">
                                        <strong>Dokumen KP</strong>
                                        <span class="status-symbol revision">!</span>
                                    </div>
                                    <span class="status-label">
                                        Belum ada data dokumen
                                    </span>
                                </div>
                            </div>
                        </div>

                        <p style="margin-top: 12px; color: var(--muted); font-size: 10px; line-height: 1.7;">
                            Status di atas merupakan tampilan awal,
                            bukan hasil verifikasi dari database.
                        </p>
                    </section>

                    <!-- PERSIAPAN SIDANG -->
                    <section class="panel sidang-card">
                        <div class="panel-title">
                            <h2>Persiapkan Sidang KP</h2>
                        </div>

                        <div class="sidang-top">
                            <div class="sidang-illustration">📋</div>
                            <div class="sidang-copy">
                                <h3>Siapkan dokumenmu</h3>
                                <p>
                                    Pastikan laporan akhir dan dokumen
                                    persyaratan sudah disiapkan.
                                </p>
                            </div>
                        </div>

                        <div class="mini-track">
                            <span></span>
                        </div>

                        <div class="mini-progress-label">
                            Progres belum tersedia
                        </div>

                        <a href="#laporan" class="btn btn-primary btn-full">
                            Lihat Persyaratan →
                        </a>
                    </section>

                    <!-- PROFIL -->
                    <section class="panel">
                        <div class="panel-title">
                            <h2>Profil Pengguna</h2>
                        </div>

                        <div class="profile-row">
                            <span>Nama</span>
                            <strong>{{ auth()->user()->name }}</strong>
                        </div>

                        <div class="profile-row">
                            <span>Email</span>
                            <strong>{{ auth()->user()->email }}</strong>
                        </div>

                        <div class="profile-row">
                            <span>Role</span>
                            <strong>Mahasiswa</strong>
                        </div>

                        <div class="info-box" style="margin-top: 15px;">
                            <strong>Informasi SIMPUL</strong>
                            <p>
                                Gunakan SIMPUL untuk mencari referensi tempat KP,
                                menyiapkan dokumen, dan memantau tahapan
                                pelaksanaan Kuliah Praktik.
                            </p>
                        </div>
                    </section>

                </aside>
            </div>
        </main>
    </div>

    <footer class="footer">
        © {{ date('Y') }} SIMPUL · Universitas Lampung
        <br>
        Sistem Informasi Manajemen Praktik
    </footer>
</div>

<script>
    // Pencarian sederhana untuk menyaring kartu dan bagian dashboard.
    const searchInput = document.getElementById('dashboardSearch');
    const searchableCards = document.querySelectorAll('.searchable-card');
    const sections = document.querySelectorAll(
        '.main-column > section, .right-column > section'
    );

    searchInput.addEventListener('input', function () {
        const keyword = this.value.trim().toLowerCase();

        searchableCards.forEach(function (card) {
            const matches = card.textContent.toLowerCase().includes(keyword);
            card.style.display = matches ? '' : 'none';
        });

        sections.forEach(function (section) {
            const cards = section.querySelectorAll('.searchable-card');

            if (cards.length === 0) {
                section.style.display = '';
                return;
            }

            const visibleCard = Array.from(cards).some(function (card) {
                return card.style.display !== 'none';
            });

            section.style.display = visibleCard ? '' : 'none';
        });
    });

    // Menandai menu sidebar yang sedang dipilih.
    document.querySelectorAll('.sidebar .nav-link').forEach(function (link) {
        link.addEventListener('click', function () {
            document.querySelectorAll('.sidebar .nav-link').forEach(function (item) {
                item.classList.remove('active');
            });

            this.classList.add('active');
        });
    });
</script>
</body>
</html>
