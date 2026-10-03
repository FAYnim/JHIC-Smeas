<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lowongan->company_short ?? $lowongan->company_name }} | Pusat Karir SMKN 1 Surabaya</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Vite Styles & Scripts with Fallback -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            margin: 0;
        }

        /* Navbar hover underline effect */
        .nav-hover-link {
            position: relative;
        }

        .nav-hover-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: #fbbf24;
            border-radius: 9999px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .nav-hover-link:hover::after {
            transform: scaleX(1);
        }

        /* ===== Company Header Card ===== */
        .company-header {
            background: linear-gradient(135deg, #0a1628 0%, #0f2847 50%, #162e52 100%);
            border-radius: 1rem;
            padding: 1.75rem 2rem;
            margin-top: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.06);
            position: relative;
            overflow: hidden;
        }

        .company-header::before {
            content: '';
            position: absolute;
            top: -2px;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2563eb, #3b82f6, #60a5fa);
            border-radius: 4px 4px 0 0;
        }

        .company-header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        .company-header-left {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex: 1;
            min-width: 0;
        }

        .company-logo-wrap {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 900;
            font-size: 0.8rem;
            letter-spacing: 1.5px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .company-info-text {
            flex: 1;
            min-width: 0;
        }

        .company-name-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 0.4rem;
        }

        .company-name-row h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            line-height: 1.3;
        }

        .mou-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 999px;
        }

        .company-subtitle {
            font-size: 0.82rem;
            color: #94a3b8;
            margin: 0 0 0.75rem;
            line-height: 1.5;
        }

        .company-tags-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            align-items: center;
        }

        .company-tag {
            display: inline-flex;
            align-items: center;
            padding: 0.3rem 0.7rem;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 700;
        }

        .company-tag--blue {
            background: rgba(37, 99, 235, 0.2);
            color: #93c5fd;
        }

        .company-tag--green {
            background: rgba(16, 185, 129, 0.15);
            color: #6ee7b7;
        }

        .company-tag--amber {
            background: rgba(251, 191, 36, 0.15);
            color: #fde68a;
        }

        .company-tag--link {
            background: rgba(148, 163, 184, 0.15);
            color: #cbd5e1;
            cursor: pointer;
            text-decoration: none;
        }

        .company-tag--link:hover {
            color: #fff;
        }

        .company-stats-box {
            display: flex;
            gap: 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
            min-width: 240px;
            background: rgba(255, 255, 255, 0.04);
        }

        .stat-cell {
            flex: 1;
            text-align: center;
            padding: 0.85rem 0.5rem;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .stat-cell:last-child {
            border-right: none;
        }

        .stat-cell .stat-num {
            display: block;
            font-size: 1.6rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
        }

        .stat-cell .stat-lbl {
            display: block;
            font-size: 0.65rem;
            color: #94a3b8;
            font-weight: 600;
            margin-top: 0.15rem;
        }

        .company-footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
            padding-top: 0.85rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .company-location-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            color: #94a3b8;
        }

        .company-location-info svg {
            width: 14px;
            height: 14px;
            color: #ef4444;
            flex-shrink: 0;
        }

        .distance-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(251, 191, 36, 0.12);
            color: #fde68a;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
        }

        .kemitraan-sejak {
            font-size: 0.78rem;
            color: #94a3b8;
        }

        .kemitraan-sejak strong {
            color: #fff;
        }

        /* ===== Tabs ===== */
        .section-tabs {
            display: flex;
            gap: 0;
            border-bottom: 2px solid #e2e8f0;
            margin-top: 1.75rem;
        }

        .section-tab {
            border: none;
            background: transparent;
            padding: 0.9rem 1.25rem;
            font-weight: 600;
            font-size: 0.88rem;
            color: #64748b;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .section-tab:hover {
            color: #334155;
        }

        .section-tab.active {
            color: #0f172a;
            font-weight: 700;
            border-bottom-color: #2563eb;
        }

        /* ===== Filter Buttons ===== */
        .filter-row {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }

        .filter-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn:hover {
            border-color: #93c5fd;
            color: #1d4ed8;
        }

        .filter-btn.active {
            background: #0f172a;
            color: #ffffff;
            border-color: #0f172a;
        }

        /* ===== Two-column Layout ===== */
        .detail-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 340px;
            gap: 1.25rem;
            margin-top: 1.25rem;
        }

        .main-column {
            display: flex;
            flex-direction: column;
            gap: 1.1rem;
        }

        .side-column {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* ===== Job Card ===== */
        .job-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.4rem 1.35rem;
            position: relative;
            transition: border-color 0.2s;
        }

        .job-card:hover {
            border-color: #93c5fd;
        }

        .job-card--pkl {
            border-left: 4px solid #2563eb;
        }

        .job-card--loker {
            border-left: 4px solid #f97316;
        }

        .job-badges {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
            margin-bottom: 0.75rem;
        }

        .job-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.3rem 0.65rem;
            border-radius: 999px;
            font-size: 0.66rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .jb-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .jb-green {
            background: #dcfce7;
            color: #16a34a;
        }

        .jb-amber {
            background: #fef3c7;
            color: #92400e;
        }

        .jb-orange {
            background: #ffedd5;
            color: #c2410c;
        }

        .jb-purple {
            background: #f3e8ff;
            color: #7c3aed;
        }

        .job-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.6rem;
        }

        .job-card-top h2 {
            margin: 0;
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.35;
        }

        .bookmark-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            color: #94a3b8;
            transition: all 0.2s;
        }

        .bookmark-btn:hover {
            border-color: #2563eb;
            color: #2563eb;
        }

        .job-sub-text {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 0.75rem;
            line-height: 1.5;
        }

        .job-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem 0.75rem;
            margin-bottom: 0.75rem;
        }

        .job-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.76rem;
            color: #475569;
        }

        .job-meta-item svg {
            width: 14px;
            height: 14px;
            color: #94a3b8;
            flex-shrink: 0;
        }

        .job-meta-item strong {
            color: #1d4ed8;
            font-weight: 700;
        }

        .job-benefits-text {
            font-size: 0.78rem;
            color: #d97706;
            font-weight: 700;
            margin-bottom: 0.85rem;
        }

        .job-footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            flex-wrap: wrap;
            padding-top: 0.85rem;
            border-top: 1px solid #f1f5f9;
        }

        .deadline-text {
            font-size: 0.78rem;
            color: #64748b;
        }

        .deadline-text strong {
            color: #dc2626;
            font-weight: 800;
        }

        .card-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.65rem 1.15rem;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
            text-decoration: none;
            border: 1.5px solid #1d4ed8;
            color: #1d4ed8;
            background: #fff;
            cursor: pointer;
            transition: all 0.2s;
        }

        .card-action-btn:hover {
            background: #1d4ed8;
            color: #fff;
        }

        /* Salary text */
        .salary-text {
            font-size: 0.82rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.35rem;
        }

        /* ===== Benefits Section ===== */
        .benefits-section {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.5rem 1.35rem;
        }

        .benefits-section h3 {
            margin: 0 0 0.3rem;
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
        }

        .benefits-section .benefits-desc {
            font-size: 0.8rem;
            color: #64748b;
            margin: 0 0 1.25rem;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .benefit-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.1rem 1rem;
        }

        .benefit-card-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
            font-size: 1.3rem;
        }

        .benefit-card-icon--blue {
            background: #dbeafe;
        }

        .benefit-card-icon--green {
            background: #dcfce7;
        }

        .benefit-card-icon--amber {
            background: #fef3c7;
        }

        .benefit-card h4 {
            margin: 0 0 0.35rem;
            font-size: 0.88rem;
            font-weight: 800;
            color: #0f172a;
        }

        .benefit-card p {
            margin: 0;
            font-size: 0.74rem;
            color: #64748b;
            line-height: 1.6;
        }

        /* ===== Sidebar Cards ===== */

        /* Contact / Narahubung Card */
        .narahubung-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.25rem;
        }

        .narahubung-title {
            font-size: 0.92rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 0.15rem;
        }

        .narahubung-sub {
            font-size: 0.72rem;
            color: #64748b;
            margin: 0 0 1rem;
        }

        .narahubung-person {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.8rem;
            margin-bottom: 0.9rem;
        }

        .person-avatar {
            width: 40px;
            height: 40px;
            background: #dbeafe;
            color: #1d4ed8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .person-info {
            flex: 1;
            min-width: 0;
        }

        .person-name {
            font-size: 0.85rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .person-role {
            font-size: 0.72rem;
            color: #64748b;
            margin: 0;
        }

        .wa-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 0.7rem 1rem;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 800;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .wa-btn:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
        }

        .wa-btn svg {
            width: 18px;
            height: 18px;
        }

        .narahubung-note {
            font-size: 0.68rem;
            color: #94a3b8;
            margin-top: 0.75rem;
            font-style: italic;
            line-height: 1.5;
        }

        /* Location Card */
        .location-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.25rem;
        }

        .location-card-title {
            font-size: 0.92rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 0.85rem;
        }

        .map-placeholder {
            width: 100%;
            height: 160px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            margin-bottom: 0.85rem;
            position: relative;
            overflow: hidden;
        }

        .map-placeholder::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, transparent 39px, #e2e8f0 39px, #e2e8f0 40px, transparent 40px),
                linear-gradient(0deg, transparent 39px, #e2e8f0 39px, #e2e8f0 40px, transparent 40px);
            background-size: 40px 40px;
            opacity: 0.5;
        }

        .map-pin {
            position: relative;
            z-index: 1;
            width: 36px;
            height: 36px;
            background: #2563eb;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
        }

        .map-pin-inner {
            width: 12px;
            height: 12px;
            background: #fff;
            border-radius: 50%;
            transform: rotate(45deg);
        }

        .map-label {
            position: relative;
            z-index: 1;
            margin-top: 0.5rem;
            font-size: 0.72rem;
            font-weight: 600;
            color: #64748b;
        }

        .location-name {
            font-size: 0.92rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 0.25rem;
        }

        .location-address {
            font-size: 0.76rem;
            color: #64748b;
            line-height: 1.55;
            margin: 0 0 0.65rem;
        }

        .maps-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.78rem;
            font-weight: 700;
            color: #2563eb;
            text-decoration: none;
        }

        .maps-link:hover {
            text-decoration: underline;
        }

        /* Docs Download Card */
        .docs-card {
            background: linear-gradient(180deg, #0f2847 0%, #0a1628 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 1.25rem;
        }

        .docs-card-title {
            font-size: 0.92rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 0.2rem;
        }

        .docs-card-sub {
            font-size: 0.72rem;
            color: #94a3b8;
            margin: 0 0 1rem;
        }

        .doc-download-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 0.75rem 0.85rem;
            margin-bottom: 0.6rem;
        }

        .doc-download-item:last-child {
            margin-bottom: 0;
        }

        .doc-download-left {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex: 1;
            min-width: 0;
        }

        .doc-file-icon {
            width: 20px;
            height: 20px;
            color: #93c5fd;
            flex-shrink: 0;
        }

        .doc-file-name {
            font-size: 0.78rem;
            font-weight: 700;
            color: #e2e8f0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .doc-file-size {
            font-size: 0.65rem;
            color: #64748b;
            margin-top: 1px;
        }

        .doc-unduh-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 0.35rem 0.65rem;
            background: rgba(34, 197, 94, 0.15);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .doc-unduh-btn:hover {
            background: rgba(34, 197, 94, 0.25);
        }

        .doc-unduh-btn svg {
            width: 14px;
            height: 14px;
        }

        /* ===== Tab 2 — Info Kemitraan ===== */
        .info-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.5rem 1.35rem;
        }

        .info-card h3 {
            margin: 0 0 1rem;
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
        }

        .info-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .info-grid-item h4 {
            margin: 0 0 0.5rem;
            font-size: 0.82rem;
            font-weight: 700;
            color: #475569;
        }

        .info-grid-item ul {
            margin: 0;
            padding-left: 1rem;
            list-style: disc;
        }

        .info-grid-item li {
            font-size: 0.8rem;
            color: #0f172a;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .info-grid-item p {
            margin: 0;
            font-size: 0.8rem;
            color: #0f172a;
            font-weight: 600;
            line-height: 1.5;
        }

        /* Docs Grid */
        .docs-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .doc-card {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .doc-card:hover {
            border-color: #93c5fd;
            background: #f0f9ff;
        }

        .doc-card-icon {
            width: 20px;
            height: 20px;
            color: #64748b;
            flex-shrink: 0;
        }

        .doc-card-name {
            font-size: 0.78rem;
            font-weight: 700;
            color: #0f172a;
            flex: 1;
            min-width: 0;
        }

        .doc-card-dl {
            color: #94a3b8;
            flex-shrink: 0;
        }

        .doc-card-dl svg {
            width: 16px;
            height: 16px;
        }

        /* ===== Bottom CTA ===== */
        .bottom-cta {
            margin-top: 2rem;
            background: linear-gradient(135deg, #0f172a, #0f2f5b);
            border-radius: 18px;
            padding: 2rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
            color: #fff;
        }

        .bottom-cta-text h3 {
            margin: 0;
            font-size: clamp(1.25rem, 2vw, 1.65rem);
            font-weight: 800;
            line-height: 1.3;
        }

        .bottom-cta-text p {
            margin: 0.35rem 0 0;
            font-size: 0.8rem;
            color: #94a3b8;
            line-height: 1.5;
        }

        .cta-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.25);
            color: #4ade80;
            padding: 0.3rem 0.7rem;
            border-radius: 999px;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 0.6rem;
        }

        .cta-actions {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            min-width: 280px;
        }

        .cta-btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 0.85rem 1rem;
            background: #22c55e;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .cta-btn-primary:hover {
            background: #16a34a;
        }

        .cta-btn-secondary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 0.75rem 1rem;
            background: transparent;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .cta-btn-secondary:hover {
            border-color: rgba(255, 255, 255, 0.6);
        }

        /* ===== Success Popup ===== */
        .success-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            padding: 1.5rem;
        }

        .success-modal {
            position: relative;
            width: min(100%, 560px);
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 2.25rem 2rem 1.5rem;
            box-shadow: 0 24px 80px rgba(15, 23, 42, 0.2);
            text-align: center;
        }

        .success-close {
            position: absolute;
            top: 0.9rem;
            right: 1rem;
            border: none;
            background: transparent;
            color: #475569;
            font-size: 2rem;
            line-height: 1;
            cursor: pointer;
        }

        .success-checkmark {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: #22c55e;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
            box-shadow: 0 10px 30px rgba(34, 197, 94, 0.2);
        }

        .success-checkmark svg {
            width: 38px;
            height: 38px;
        }

        .success-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 1.25rem;
        }

        .success-registry-box {
            background: #dbeafe;
            border: 1px solid #93c5fd;
            border-radius: 12px;
            padding: 0.9rem 1rem;
            margin-bottom: 1rem;
        }

        .success-registry-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: #1d4ed8;
            text-align: left;
            margin-bottom: 0.35rem;
        }

        .success-registry-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .success-registry-code {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
        }

        .success-badge {
            background: #fef3c7;
            color: #92400e;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 0.3rem 0.65rem;
            border-radius: 8px;
            border: 1px solid #fde68a;
        }

        .success-detail-grid {
            background: #dbeafe;
            border: 1px solid #93c5fd;
            border-radius: 12px;
            overflow: hidden;
        }

        .success-detail-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(147, 197, 253, 0.4);
            text-align: left;
            font-size: 0.85rem;
        }

        .success-detail-row:last-child {
            border-bottom: none;
        }

        .success-detail-row span {
            color: #475569;
            font-weight: 600;
        }

        .success-detail-row strong {
            color: #0f172a;
            font-weight: 800;
            text-align: right;
        }

        .success-wa-btn {
            display: block;
            margin-top: 1.25rem;
            width: 100%;
            background: #22c55e;
            color: white;
            border-radius: 10px;
            padding: 0.85rem 1rem;
            font-weight: 800;
            font-size: 0.92rem;
            text-decoration: none;
            text-align: center;
            transition: background 0.2s;
        }

        .success-wa-btn:hover {
            background: #16a34a;
        }

        .success-download-btn {
            width: 100%;
            margin-top: 0.75rem;
            background: transparent;
            border: 2px solid #0f172a;
            color: #0f172a;
            border-radius: 10px;
            font-size: 0.92rem;
            font-weight: 700;
            padding: 0.75rem 1rem;
            cursor: pointer;
        }

        /* ===== Footer ===== */
        .site-footer {
            background: #1d4ed8;
            color: #ffffff;
            text-align: center;
            padding: 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 3rem;
        }

        /* ===== Responsive ===== */
        @media (max-width: 1024px) {
            .detail-layout {
                grid-template-columns: 1fr;
            }

            .company-header-inner {
                flex-direction: column;
                align-items: stretch;
            }

            .company-stats-box {
                min-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .company-header {
                padding: 1.25rem 1rem;
            }

            .company-header-left {
                flex-direction: column;
                align-items: flex-start;
            }

            .company-name-row h1 {
                font-size: 1.2rem;
            }

            .benefits-grid,
            .info-grid-3 {
                grid-template-columns: 1fr;
            }

            .docs-grid {
                grid-template-columns: 1fr;
            }

            .bottom-cta {
                flex-direction: column;
                align-items: stretch;
            }

            .cta-actions {
                min-width: 0;
            }

            .company-footer-row {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    @include('partials.navbar', ['activePage' => 'pusat-karir'])

    <!-- ========== Main Content ========== -->
    <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-5">

        <!-- Breadcrumbs -->
        <nav class="flex items-center text-xs gap-1.5 mb-4 flex-wrap">
            <a href="{{ route('beranda') }}" class="text-blue-600 hover:underline font-medium">Beranda</a>
            <span class="text-slate-400">/</span>
            <a href="{{ route('pusat-karir.index') }}" class="text-blue-600 hover:underline font-medium">Pusat Karir</a>
            <span class="text-slate-400">/</span>
            <a href="{{ route('pusat-karir.katalog-mitra') }}" class="text-blue-600 hover:underline font-medium">Mitra Industri (DUDI)</a>
            <span class="text-slate-400">/</span>
            <span class="text-slate-500 font-medium">{{ $lowongan->company_short ?? $lowongan->company_name }}</span>
        </nav>

        <!-- ===== Success Popup ===== -->
        @if (session('lamaran_success'))
            @php $lamaran = session('lamaran_success'); @endphp
            <div id="success-popup" class="success-overlay" style="display: flex;">
                <div class="success-modal">
                    <button type="button" class="success-close" aria-label="Tutup popup"
                        onclick="document.getElementById('success-popup').style.display='none'">×</button>

                    <div class="success-checkmark">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <h2 class="success-title">Pengajuan magang terkirim</h2>

                    <div class="success-registry-box">
                        <div class="success-registry-label">Nomor Registrasi PKL</div>
                        <div class="success-registry-row">
                            <span class="success-registry-code">#{{ $lamaran['registration_code'] }}</span>
                            <span class="success-badge">Tahap Verifikasi</span>
                        </div>
                    </div>

                    <div class="success-detail-grid">
                        <div class="success-detail-row">
                            <span>Nama Siswa</span>
                            <strong>{{ $lamaran['nama'] }}</strong>
                        </div>
                        <div class="success-detail-row">
                            <span>NISN</span>
                            <strong>{{ $lamaran['nisn'] }}</strong>
                        </div>
                        <div class="success-detail-row">
                            <span>Posisi Magang</span>
                            <strong>{{ $lowongan->title }}</strong>
                        </div>
                        <div class="success-detail-row">
                            <span>Mitra Industri</span>
                            <strong>{{ $lowongan->company_name }}</strong>
                        </div>
                    </div>

                    @if ($lowongan->pokja_wa)
                        <a href="https://wa.me/{{ $lowongan->pokja_wa }}" target="_blank"
                            class="success-wa-btn">
                            Konfirmasi ke WhatsApp Pokja
                        </a>
                    @endif

                </div>
            </div>
        @endif

        <!-- ===== Company Header Card ===== -->
        <div class="company-header">
            <div class="company-header-inner">
                <div class="company-header-left">
                    <!-- Company Logo -->
                    <div class="company-logo-wrap">
                        <span>{{ strtoupper(substr($lowongan->company_short ?? $lowongan->company_name, 0, 4)) }}</span>
                    </div>

                    <!-- Company Info -->
                    <div class="company-info-text">
                        <div class="company-name-row">
                            <h1>{{ $lowongan->company_name }}</h1>
                            @if ($lowongan->is_mitra_dudi)
                                <span class="mou-badge">
                                    <svg viewBox="0 0 20 20" fill="currentColor" width="12" height="12">
                                        <path fill-rule="evenodd"
                                            d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    MoU Aktif
                                </span>
                            @endif
                        </div>

                        <p class="company-subtitle">
                            {{ $lowongan->bidang_industri ?? $lowongan->company_name }}
                        </p>

                        <div class="company-tags-row">
                            @if ($lowongan->is_mitra_dudi)
                                <span class="company-tag company-tag--blue">Mitra DUDI</span>
                            @endif
                            <span class="company-tag company-tag--link">
                                {{ $lowongan->bidang_industri ?? $lowongan->company_name }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="company-stats-box">
                    <div class="stat-cell">
                        <span class="stat-num">{{ $lowongan->kuota }}</span>
                        <span class="stat-lbl">Kuota Tersedia</span>
                    </div>
                    <div class="stat-cell">
                        <span class="stat-num">{{ $lowongan->fresh_graduate_ok ? '✓' : '—' }}</span>
                        <span class="stat-lbl">Fresh Graduate</span>
                    </div>
                </div>
            </div>

            <!-- Footer Row -->
            <div class="company-footer-row">
                <div class="company-location-info">
                    <svg viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ $lowongan->location ?? $lowongan->company_name }}</span>
                </div>
                <div class="kemitraan-sejak">
                    Kemitraan Sejak: <strong>{{ $lowongan->created_at->format('Y') }}</strong>
                </div>
            </div>
        </div>

        <!-- ===== Tabs ===== -->
        <div class="section-tabs" role="tablist">
            <button type="button" class="section-tab active" data-tab="peluang" role="tab"
                aria-selected="true">
                Peluang & Lowongan Aktif
            </button>
            <button type="button" class="section-tab" data-tab="info" role="tab" aria-selected="false">
                Informasi Kemitraan & Dokumen
            </button>
        </div>

        <!-- ===== TAB 1 — Peluang & Lowongan ===== -->
        <div id="tab-peluang" class="tab-panel" style="display: block;">
            <div class="detail-layout">

                <!-- ====== Main Column ====== -->
                <div class="main-column">

                    <!-- Filter Buttons -->
                    <div class="filter-row" style="margin-top: 1.25rem;">
                        <button class="filter-btn active" data-filter="all">Semua</button>
                        <button class="filter-btn" data-filter="pkl">Magang PKL Siswa</button>
                    </div>

                    <!-- Job Card 1 — Magang PKL -->
                    <div class="job-card job-card--pkl" data-type="pkl">
                        <div class="job-badges">
                            <span class="job-badge jb-blue">MAGANG PKL</span>
                            <span class="job-badge jb-green">Sisa {{ $lowongan->kuota }} Kuota</span>
                            <span class="job-badge jb-amber">Verifikasi NISN</span>
                        </div>

                        <div class="job-card-top">
                            <div>
                                <h2>{{ $lowongan->title }}</h2>
                                <p class="job-sub-text">{{ $lowongan->bidang_industri }} • Rekomendasi Jurusan:
                                    <strong style="color:#1d4ed8;">{{ $lowongan->jurusan }}</strong>
                                </p>
                            </div>
                            <button class="bookmark-btn" title="Simpan">
                                <svg width="16" height="16" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                </svg>
                            </button>
                        </div>

                        <div class="job-meta-row">
                            <span class="job-meta-item">
                                <svg viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Durasi: {{ $lowongan->duration }}
                            </span>
                            <span class="job-meta-item">
                                <svg viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                        clip-rule="evenodd" />
                                </svg>
                                Skema: {{ $lowongan->metode_kerja }}
                            </span>
                        </div>

                        <div class="job-benefits-text">
                            🎁
                            {{ $lowongan->benefits ? implode(', ', $lowongan->benefits) : '' }}
                        </div>

                        <div class="job-footer-row">
                            <div class="deadline-text">
                                Batas Pengajuan Berkas:
                                <strong>{{ $lowongan->batas_pendaftaran->translatedFormat('d F Y') }}</strong>
                            </div>
                            <a href="{{ route('pusat-karir.lamar', $lowongan->slug) }}" class="card-action-btn">
                                Lihat & Ajukan Magang →
                            </a>
                        </div>
                    </div>

                    <!-- Keunggulan Section -->
                    <div class="benefits-section">
                        <h3>Keunggulan Program Kemitraan</h3>
                        <p class="benefits-desc">Manfaat untuk siswa aktif dan lulusan terdaftar SMKN 1 Surabaya.</p>

                        <div class="benefits-grid">
                            <div class="benefit-card">
                                <div class="benefit-card-icon benefit-card-icon--blue">🏫</div>
                                <h4>Kelas Industri</h4>
                                <p>Sinkronisasi kurikulum langsung bersama mentor ahli industri.</p>
                            </div>
                            <div class="benefit-card">
                                <div class="benefit-card-icon benefit-card-icon--green">🏅</div>
                                <h4>Sertifikasi Resmi</h4>
                                <p>Pengakuan kompetensi nasional pasca masa magang.</p>
                            </div>
                            <div class="benefit-card">
                                <div class="benefit-card-icon benefit-card-icon--amber">🚀</div>
                                <h4>Jalur Prioritas BKK</h4>
                                <p>Pelulusan berkinerja tinggi direkomendasikan saat kelulusan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ====== Sidebar ====== -->
                <aside class="side-column">

                    <!-- Narahubung Card -->
                    <div class="narahubung-card" style="margin-top: 1.25rem;">
                        <h3 class="narahubung-title">Narahubung Kemitraan Sekolah</h3>
                        <p class="narahubung-sub">Guru pengampu kerja sama
                            {{ $lowongan->company_short ?? $lowongan->company_name }}</p>

                        <div class="narahubung-person">
                            <div class="person-avatar">{{ strtoupper(substr($lowongan->pokja_koordinator ?? 'N', 0, 1)) }}</div>
                            <div class="person-info">
                                <p class="person-name">
                                    {{ $lowongan->pokja_koordinator ?? 'Narahubung' }}</p>
                                <p class="person-role">Pokja PKL & Kemitraan DUDI</p>
                            </div>
                        </div>

                        @if ($lowongan->pokja_wa)
                            <a href="https://wa.me/{{ $lowongan->pokja_wa }}" target="_blank"
                                class="wa-btn">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                Hubungi via WhatsApp Pokja
                            </a>
                        @endif

                        <p class="narahubung-note">Konsultasi ketersediaan kuota rombel dan surat izin Pokja.</p>
                    </div>

                    <!-- Location Card -->
                    <div class="location-card">
                        <h3 class="location-card-title">Lokasi Penempatan Industri</h3>

                        <div class="map-placeholder">
                            <div class="map-pin">
                                <div class="map-pin-inner"></div>
                            </div>
                            <span class="map-label">{{ $lowongan->company_short ?? $lowongan->company_name }}</span>
                        </div>

                        <h4 class="location-name">{{ $lowongan->company_name }}</h4>
                        <p class="location-address">{{ $lowongan->location }}</p>

                        <a href="https://maps.google.com/?q={{ urlencode($lowongan->company_name . ' ' . $lowongan->location) }}" target="_blank"
                            class="maps-link">
                            Buka Petunjuk Arah di Google Maps ↗
                        </a>
                    </div>

                    <!-- Docs Download Card -->
                    <div class="docs-card">
                        <h3 class="docs-card-title">Dokumen & Silabus Kemitraan</h3>
                        <p class="docs-card-sub">Unduh materi acuan resmi sebelum mendaftar.</p>

                        @if ($lowongan->dokumen)
                            @foreach ($lowongan->dokumen as $doc)
                                <div class="doc-download-item">
                                    <div class="doc-download-left">
                                        <svg class="doc-file-icon" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <div class="doc-file-name">{{ basename($doc) }}</div>
                                            <div class="doc-file-size">Dokumen Pendukung</div>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $doc) }}" download class="doc-unduh-btn">
                                        Unduh
                                        <svg viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                                            <path
                                                d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </aside>

            </div>
        </div>

        <!-- ===== TAB 2 — Informasi Kemitraan & Dokumen ===== -->
        <div id="tab-info" class="tab-panel" style="display: none;">
            <div class="detail-layout">

                <!-- Main Column -->
                <div class="main-column" style="margin-top: 1.25rem;">

                    <!-- Kelas Industri -->
                    <div class="info-card">
                        <h3>Kelas Industri</h3>
                <a href="{{ route('pusat-karir.katalog-mitra') }}" class="cta-btn-primary">
                    Lihat Mitra Industri →
                </a>
                @if ($lowongan->dokumen)
                    <a href="{{ asset('storage/' . $lowongan->dokumen[0]) }}" download class="cta-btn-secondary">
                        📄 Unduh Dokumen →
                    </a>
                @endif
            </div>
        </div>

    </main>

    <!-- Footer Bar -->
    <footer class="site-footer">
        Dibuat dengan <span style="color:#ef4444;">❤️</span> oleh Chicken Noodles Team
    </footer>

    <!-- ===== Scripts ===== -->
    <script>
        // Tab switching
        const tabBtns = document.querySelectorAll('.section-tab');
        const tabPanels = document.querySelectorAll('.tab-panel');

        tabBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                const target = btn.dataset.tab;

                tabBtns.forEach((b) => {
                    const isActive = b === btn;
                    b.classList.toggle('active', isActive);
                    b.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });

                tabPanels.forEach((panel) => {
                    const shouldShow = panel.id === `tab-${target}`;
                    panel.style.display = shouldShow ? 'block' : 'none';
                });
            });
        });

        // Filter buttons
        const filterBtns = document.querySelectorAll('.filter-btn');
        const jobCards = document.querySelectorAll('.job-card');

        filterBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.dataset.filter;

                jobCards.forEach((card) => {
                    if (filter === 'all') {
                        card.style.display = 'block';
                    } else {
                        card.style.display = card.dataset.type === filter ? 'block' : 'none';
                    }
                });
            });
        });
    </script>

</body>

</html>
