<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMKN 1 Surabaya — Beranda</title>
    <meta name="description"
        content="SMK Negeri 1 Surabaya - Sekolah Kejuruan terbaik di Surabaya. Membentuk lulusan berkarakter, kompeten, dan siap bersaing di kancah nasional maupun global.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Vite Styles & Scripts with Fallback -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        /* ===== Hero ===== */
        .hero-section {
            position: relative;
            min-height: 560px;
            overflow: hidden;
        }

        .hero-bg-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            filter: blur(8px);
            transform: scale(1.05);
        }

        .hero-bg-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
        }

        /* ===== Photo Cards (side by side with gap) ===== */
        .hero-photos-wrapper {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
        }

        @media (min-width: 640px) {
            .hero-photos-wrapper {
                flex-direction: row;
                gap: 24px;
            }
        }

        .hero-photo-card {
            border-radius: 16px;
            overflow: hidden;
            border: 3px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px -8px rgba(0, 0, 0, 0.4);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
            flex-shrink: 0;
        }

        .hero-photo-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 28px 50px -10px rgba(0, 0, 0, 0.5);
        }

        .hero-photo-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .hero-photo-card-1 {
            width: 200px;
            height: 280px;
        }

        .hero-photo-card-2 {
            width: 180px;
            height: 260px;
        }

        @media (min-width: 640px) {
            .hero-photo-card-1 {
                width: 240px;
                height: 340px;
            }

            .hero-photo-card-2 {
                width: 200px;
                height: 300px;
            }
        }

        @media (min-width: 1024px) {
            .hero-photo-card-1 {
                width: 260px;
                height: 370px;
            }

            .hero-photo-card-2 {
                width: 220px;
                height: 320px;
            }
        }

        /* ===== Feature cards hover ===== */
        .feature-card {
            background: #2196F3 !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .feature-card:hover {
            background: #eab308 !important;
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(234, 179, 8, 0.45);
        }

        .feature-card h3 { color: #fff !important; }
        .feature-card p { color: rgba(255, 255, 255, 0.85) !important; }
        .feature-card > div:first-child { background: rgba(255, 255, 255, 0.2) !important; }
        .feature-card:hover h3 { color: #0b192c !important; }
        .feature-card:hover p { color: rgba(11, 25, 44, 0.8) !important; }
        .feature-card:hover > div:first-child { background: rgba(0, 0, 0, 0.15) !important; }

        /* ===== Pusat Karir hero card (match pusat-karir page) ===== */
        .pk-hero {
            position: relative;
            overflow: hidden;
            border-radius: 1.25rem;
            min-height: 280px;
            display: flex;
            align-items: center;
            background-color: #061d36;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .pk-hero__bg {
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            width: 58%;
            z-index: 0;
        }

        .pk-hero__bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .pk-hero__overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            background:
                linear-gradient(90deg,
                    #061d36 0%,
                    #061d36 40%,
                    rgba(6, 29, 54, 0.85) 55%,
                    rgba(6, 29, 54, 0.4) 70%,
                    rgba(6, 29, 54, 0) 88%
                ),
                linear-gradient(0deg,
                    rgba(6, 29, 54, 0.4) 0%,
                    rgba(6, 29, 54, 0) 25%
                );
        }

        .pk-hero__content {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 2.5rem 2.5rem 2.25rem;
        }

        .pk-hero__title {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 0.625rem;
        }

        .pk-hero__subtitle {
            font-size: 0.95rem;
            font-weight: 400;
            color: rgba(203, 213, 225, 0.9);
            max-width: 480px;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .pk-hero__search {
            display: flex;
            align-items: center;
            background: #ffffff;
            border-radius: 0.625rem;
            overflow: hidden;
            max-width: 560px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            margin-bottom: 1.25rem;
        }

        .pk-hero__search input {
            flex: 1;
            border: none;
            outline: none;
            padding: 0.875rem 1.125rem;
            font-size: 0.9rem;
            color: #334155;
            background: transparent;
        }

        .pk-hero__search input::placeholder {
            color: #94a3b8;
        }

        .pk-hero__search button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            margin: 4px;
            border: none;
            border-radius: 0.5rem;
            background: #2563eb;
            color: #ffffff;
            cursor: pointer;
            transition: background 0.2s ease;
            flex-shrink: 0;
        }

        .pk-hero__search button:hover {
            background: #1d4ed8;
        }

        .pk-hero__search button svg {
            width: 20px;
            height: 20px;
        }

        .pk-hero__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pk-hero__actions a {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #fff;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .pk-hero__actions a:first-child {
            color: #024089;
            background: #fff;
            border-color: #fff;
        }

        .pk-hero__actions a:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .pk-hero__actions a:first-child:hover {
            background: #eff6ff;
        }

        @media (max-width: 768px) {
            .pk-hero__bg {
                width: 100%;
                left: 0;
            }

            .pk-hero__overlay {
                background: linear-gradient(180deg,
                    #061d36 0%,
                    rgba(6, 29, 54, 0.92) 65%,
                    rgba(6, 29, 54, 0.75) 100%
                );
            }

            .pk-hero__content {
                padding: 2rem 1.25rem 1.75rem;
            }

            .pk-hero__search {
                max-width: 100%;
            }
        }

        /* ===== Scroll-triggered fade-in ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease-out, transform 0.7s ease-out;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== Prakata quote ===== */
        .prakata-quote {
            position: relative;
            padding: 32px 40px 32px 36px;
            border-left: 4px solid #024089;
            background: linear-gradient(135deg, rgba(2, 64, 137, 0.04) 0%, rgba(251, 191, 36, 0.03) 100%);
            border-radius: 0 16px 16px 0;
        }

        .prakata-quote::before {
            content: '\201C';
            position: absolute;
            top: -8px;
            left: 16px;
            font-size: 96px;
            color: rgba(2, 64, 137, 0.12);
            font-family: Georgia, 'Times New Roman', serif;
            line-height: 1;
            pointer-events: none;
        }

        .prakata-quote::after {
            content: '\201D';
            position: absolute;
            bottom: -20px;
            right: 24px;
            font-size: 96px;
            color: rgba(2, 64, 137, 0.08);
            font-family: Georgia, 'Times New Roman', serif;
            line-height: 1;
            pointer-events: none;
        }

        /* ===== Search bar glow ===== */
        .search-glow:focus-within {
            box-shadow: 0 0 0 4px rgba(251, 191, 36, 0.25);
            border-color: #fbbf24;
        }

        /* ===== Teacher card ===== */
        .teacher-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            aspect-ratio: 3 / 4;
        }

        .teacher-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: grayscale(100%);
            transition: filter 0.5s ease;
        }

        .teacher-card:hover img {
            filter: grayscale(0%);
        }

        /* ===== News card ===== */
        .news-main {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            aspect-ratio: 16 / 10;
        }

        .news-main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .news-main:hover img {
            transform: scale(1.05);
        }

        /* ===== Prakata Kepala Sekolah Section ===== */
        .prakata-top-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
            align-items: center;
        }

        @media (min-width: 992px) {
            .prakata-top-grid {
                grid-template-columns: 1fr 320px;
                gap: 48px;
            }
        }

        .prakata-bottom-bg {
            background-color: #eef3f8;
            position: relative;
            overflow: hidden;
        }

        .prakata-bottom-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 48px 24px 64px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 48px;
        }

        @media (min-width: 992px) {
            .prakata-bottom-container {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .stat-cards-wrapper {
            position: relative;
            width: 100%;
            max-width: 540px;
            height: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .stat-star-bg {
            position: absolute;
            width: 380px;
            height: auto;
            opacity: 0.95;
            pointer-events: none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
        }

        .stat-card {
            position: absolute;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(2, 64, 137, 0.12), 0 4px 10px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .stat-card-1 {
            left: 10px;
            top: 15px;
            width: 150px;
            height: 150px;
            transform: rotate(-25deg);
            z-index: 1;
        }

        .stat-card-2 {
            left: 170px;
            top: 75px;
            width: 170px;
            height: 170px;
            transform: rotate(0deg);
            z-index: 3;
            box-shadow: 0 16px 36px rgba(2, 64, 137, 0.18), 0 6px 14px rgba(0, 0, 0, 0.06);
        }

        .stat-card-3 {
            right: 10px;
            top: 40px;
            width: 160px;
            height: 160px;
            transform: rotate(25deg);
            z-index: 2;
        }

        @media (max-width: 640px) {
            .stat-cards-wrapper {
                height: auto;
                flex-direction: row;
                flex-wrap: wrap;
                gap: 16px;
                justify-content: center;
            }

            .stat-star-bg {
                width: 280px;
            }

            .stat-card {
                position: relative !important;
                top: auto !important;
                left: auto !important;
                right: auto !important;
                transform: rotate(0deg) !important;
                width: 130px !important;
                height: 130px !important;
            }

            .stat-card-inner {
                transform: rotate(0deg) !important;
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased" style="display:flex;flex-direction:column;min-height:100vh;">

    {{-- Header / Navbar --}}
    @include('partials.navbar', [
        'activePage' => 'beranda',
        'berandaUrl' => route('beranda'),
    ])

    <main style="flex:1 1 0%;">

        {{-- ==================== HERO SECTION ==================== --}}
        <section class="hero-section">
            {{-- Blurred Background Image --}}
            <img src="{{ asset('images/smkn1.png') }}" alt="Gedung SMKN 1 Surabaya" class="hero-bg-image">
            {{-- Dark overlay --}}
            <div class="hero-bg-overlay"></div>

            {{-- Content --}}
            <div style="position:relative;z-index:2;max-width:1280px;margin:0 auto;padding:80px 24px 88px;">
                <div style="display:grid;grid-template-columns:1fr;gap:40px;align-items:center;"
                    class="lg:!grid-cols-2 lg:!gap-64px">

                    {{-- Left Column: Text + CTAs --}}
                    <div style="order:2;" class="lg:!order-1">
                        <h1
                            style="font-size:clamp(2.25rem, 5vw, 3.5rem);font-weight:800;letter-spacing:-0.02em;color:#fff;margin-bottom:24px;line-height:1.1;">
                            SMKN 1 SURABAYA
                        </h1>

                        {{-- Italic Quote (yellow tint) --}}
                        <p
                            style="font-size:clamp(0.95rem, 2vw, 1.1rem);color:#fbbf24;font-style:italic;font-weight:500;line-height:1.7;max-width:480px;margin-bottom:36px;">
                            &ldquo;Tidak ada ahli yang langsung jago dari lahir.
                            Semua profesional berawal dari yang namanya
                            &lsquo;salah coba&rsquo;, &lsquo;perbaiki&rsquo;, lalu &lsquo;biasa&rsquo;.&rdquo;
                        </p>

                        {{-- CTA Buttons (yellow themed) --}}
                        <div style="display:flex;flex-wrap:wrap;gap:16px;">
                            <a href="{{ route('spmb.index') }}"
                                style="display:inline-flex;align-items:center;justify-content:center;padding:14px 32px;font-size:14px;font-weight:700;color:#0f172a;background:#fbbf24;border:2px solid #fbbf24;border-radius:8px;box-shadow:0 8px 20px rgba(251,191,36,0.3);text-decoration:none;transition:all 0.3s ease;"
                                onmouseover="this.style.background='#f59e0b';this.style.borderColor='#f59e0b';this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 28px rgba(251,191,36,0.4)'"
                                onmouseout="this.style.background='#fbbf24';this.style.borderColor='#fbbf24';this.style.transform='translateY(0)';this.style.boxShadow='0 8px 20px rgba(251,191,36,0.3)'">
                                Daftar SPMB
                            </a>
                            <a href="{{ route('visi-misi') }}"
                                style="display:inline-flex;align-items:center;justify-content:center;padding:14px 32px;font-size:14px;font-weight:700;color:#fbbf24;border:2px solid #fbbf24;border-radius:8px;text-decoration:none;background:transparent;transition:all 0.3s ease;"
                                onmouseover="this.style.background='rgba(251,191,36,0.12)';this.style.transform='translateY(-2px)'"
                                onmouseout="this.style.background='transparent';this.style.transform='translateY(0)'">
                                Tentang kami &rarr;
                            </a>
                        </div>
                    </div>

                    {{-- Right Column: Photo Cards (side by side with gap) --}}
                    <div style="order:1;display:flex;justify-content:center;" class="lg:!order-2 lg:!justify-end">
                        <div class="hero-photos-wrapper">
                            <div class="hero-photo-card hero-photo-card-1">
                                <img src="{{ asset('images/image 4.png') }}" alt="Siswa SMKN 1 Surabaya berprestasi">
                            </div>
                            <div class="hero-photo-card hero-photo-card-2">
                                <img src="{{ asset('images/image 5.png') }}" alt="Siswa SMKN 1 Surabaya">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ==================== PRAKATA KEPALA SEKOLAH ==================== --}}
        <section style="background:#ffffff; overflow:hidden;">
            {{-- Top Container: White Background --}}
            <div style="max-width:1240px; margin:0 auto; padding:64px 24px 48px;" class="fade-up">
                <div class="prakata-top-grid">

                    {{-- Left Column: Title & Quote --}}
                    <div>
                        <h2
                            style="font-size:clamp(2rem, 4vw, 2.75rem); font-weight:800; color:#0b192c; line-height:1.2; margin:0 0 28px 0;">
                            Prakata kepala sekolah
                        </h2>
                        <div class="prakata-quote">
                            <blockquote style="margin:0; position:relative; z-index:1;">
                                <p
                                    style="font-size:clamp(0.95rem, 1.5vw, 1.1rem); color:#334155; font-style:italic; font-weight:600; line-height:1.9; text-align:justify; margin:0;">
                                    {{ $prakata['quote'] }}
                                </p>
                            </blockquote>
                        </div>
                    </div>

                    {{-- Right Column: Headmaster Photo --}}
                    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
                        <img src="{{ asset($prakata['foto']) }}" alt="{{ $prakata['nama'] }}"
                            style="width:260px; max-width:100%; height:auto; display:block;">
                        <p
                            style="margin-top:12px; font-size:0.95rem; font-weight:700; color:#0b192c; text-align:center;">
                            {{ $prakata['nama'] }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Bottom Container: Light Blue Background with Student Photo & Stat Cards --}}
            <div class="prakata-bottom-bg">
                <div class="prakata-bottom-container fade-up">

                    {{-- Left: Monochrome Student Photo + Social Links --}}
                    <div style="display:flex; flex-direction:column; align-items:flex-start; gap:24px; flex-shrink:0;">
                        {{-- Student Monochrome Photo --}}
                        <div
                            style="transform:rotate(-4deg); border-radius:16px; overflow:hidden; box-shadow:0 14px 32px rgba(0,0,0,0.14); width:290px; max-width:100%; background:#fff; border:4px solid #ffffff;">
                            <img src="{{ asset('images/image 7.png') }}" alt="Siswa SMKN 1 Surabaya"
                                style="width:100%; height:auto; display:block; filter:grayscale(100%);">
                        </div>

                        {{-- Social Handles --}}
                        <div style="display:flex; flex-direction:column; gap:10px; margin-left:4px;">
                            <a href="https://instagram.com/semkanisanet" target="_blank" rel="noopener noreferrer"
                                style="display:inline-flex; align-items:center; gap:10px; font-size:0.95rem; font-weight:700; color:#024089; text-decoration:none;">
                                <svg style="width:20px; height:20px;" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                                @semkanisanet
                            </a>
                            <a href="https://instagram.com/smkn1sby.official" target="_blank" rel="noopener noreferrer"
                                style="display:inline-flex; align-items:center; gap:10px; font-size:0.95rem; font-weight:700; color:#024089; text-decoration:none;">
                                <svg style="width:20px; height:20px;" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                                @smkn1sby.official
                            </a>
                        </div>
                    </div>

                    {{-- Right: Star Vector Background + 3 Tilted Cards --}}
                    <div class="stat-cards-wrapper">
                        {{-- Group 159 Background --}}
                        <img src="{{ asset('images/Group 159.png') }}" alt="Decorative Star" class="stat-star-bg">

                        {{-- Card 1: 9 Jurusan --}}
                        <div class="stat-card stat-card-1">
                            <div class="stat-card-inner" style="transform:rotate(25deg); text-align:center;">
                                <span
                                    style="font-size:2.25rem; font-weight:800; color:#024089; line-height:1; display:block;">9</span>
                                <span
                                    style="font-size:0.875rem; font-weight:700; color:#024089; margin-top:4px; display:block;">Jurusan</span>
                            </div>
                        </div>

                        {{-- Card 2: 689+ Pengajar --}}
                        <div class="stat-card stat-card-2">
                            <div class="stat-card-inner" style="text-align:center;">
                                <span
                                    style="font-size:2.6rem; font-weight:800; color:#024089; line-height:1; display:block;">120+</span>
                                <span
                                    style="font-size:0.875rem; font-weight:700; color:#024089; margin-top:8px; display:block;">Pengajar</span>
                            </div>
                        </div>

                        {{-- Card 3: 700+ Siswa/Siswi --}}
                        <div class="stat-card stat-card-3">
                            <div class="stat-card-inner" style="transform:rotate(-25deg); text-align:center;">
                                <span
                                    style="font-size:2.25rem; font-weight:800; color:#024089; line-height:1; display:block;">1200+</span>
                                <span
                                    style="font-size:0.875rem; font-weight:700; color:#024089; margin-top:4px; display:block;">Siswa/Siswi</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ==================== KENAPA HARUS SMKN 1 SURABAYA? ==================== --}}
        <section style="padding:64px 0 80px;background:#eef2f6;">
            <div style="max-width:1280px;margin:0 auto;padding:0 24px;">
                {{-- Title: Left-aligned --}}
                <div style="margin-bottom:40px;" class="fade-up">
                    <h2 style="font-size:clamp(2rem, 4vw, 2.75rem);font-weight:800;color:#0b192c;line-height:1.2;">
                        Kenapa harus <span style="color:#1a8cff;">SMKN 1<br>Surabaya?</span>
                    </h2>
                </div>

                {{-- Feature Cards Grid: 3 columns --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(300px, 1fr));gap:20px;"
                    class="fade-up">

                    {{-- Card 1 --}}
                    <div class="feature-card"
                        style="border-radius:0;padding:28px 24px;border:none;box-shadow:none;">
                        <div
                            style="width:40px;height:40px;border-radius:50%;background:rgba(0,0,0,0.15);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <svg style="width:20px;height:20px;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <h3 style="font-size:1.05rem;font-weight:800;color:#0b192c;margin-bottom:10px;line-height:1.3;">
                            Pilihan Jurusan Relevan dengan Industri</h3>
                        <p style="font-size:0.875rem;color:rgba(11,25,44,0.8);line-height:1.6;">
                            SMK Negeri 1 Surabaya menyediakan 9 keahlian mulai dari IT, multimedia, bisnis, hingga
                            perhotelan yang disesuaikan dengan kebutuhan industri masa kini.
                        </p>
                    </div>

                    {{-- Card 2: BLUE --}}
                    <div class="feature-card"
                        style="background:#2196F3;border-radius:0;padding:28px 24px;border:none;box-shadow:none;">
                        <div
                            style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <svg style="width:20px;height:20px;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <h3 style="font-size:1.05rem;font-weight:800;color:#fff;margin-bottom:10px;line-height:1.3;">
                            Lulus Berbekal Sertifikat Profesi BNSP</h3>
                        <p style="font-size:0.875rem;color:rgba(255,255,255,0.85);line-height:1.6;">
                            Lulusan dibekali sertifikat kompetensi nasional berlogo Garuda melalui program Uji
                            Sertifikasi Keahlian sebagai bukti kelayakan kerja profesional.
                        </p>
                    </div>

                    {{-- Card 3: BLUE --}}
                    <div class="feature-card"
                        style="background:#2196F3;border-radius:0;padding:28px 24px;border:none;box-shadow:none;">
                        <div
                            style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <svg style="width:20px;height:20px;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <h3 style="font-size:1.05rem;font-weight:800;color:#fff;margin-bottom:10px;line-height:1.3;">
                            Praktik Nyata Lewat Fasilitas Teaching Factory</h3>
                        <p style="font-size:0.875rem;color:rgba(255,255,255,0.85);line-height:1.6;">
                            Didukung laboratorium modern dan fasilitas Teaching Factory, siswa langsung belajar menangani
                            proyek kerja riil berstandar industri.
                        </p>
                    </div>

                    {{-- Card 4: BLUE --}}
                    <div class="feature-card"
                        style="background:#2196F3;border-radius:0;padding:28px 24px;border:none;box-shadow:none;">
                        <div
                            style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <svg style="width:20px;height:20px;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <h3 style="font-size:1.05rem;font-weight:800;color:#fff;margin-bottom:10px;line-height:1.3;">
                            Akses Penyaluran Kerja via BKK dan Mitra Industri</h3>
                        <p style="font-size:0.875rem;color:rgba(255,255,255,0.85);line-height:1.6;">
                            Melalui kerja sama dunia usaha, unit Bursa Kerja Khusus siap menjembatani siswa ke berbagai
                            peluang magang dan rekrutmen kerja.
                        </p>
                    </div>

                    {{-- Card 5: BLUE --}}
                    <div class="feature-card"
                        style="background:#2196F3;border-radius:0;padding:28px 24px;border:none;box-shadow:none;">
                        <div
                            style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <svg style="width:20px;height:20px;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <h3 style="font-size:1.05rem;font-weight:800;color:#fff;margin-bottom:10px;line-height:1.3;">
                            Tata Kelola Pendidikan Berstandar Mutu ISO</h3>
                        <p style="font-size:0.875rem;color:rgba(255,255,255,0.85);line-height:1.6;">
                            Tata kelola pendidikan dan pembelajaran berjalan terstruktur di bawah sistem manajemen mutu
                            sertifikasi ISO.
                        </p>
                    </div>

                    {{-- Card 6: BLUE --}}
                    <div class="feature-card"
                        style="background:#2196F3;border-radius:0;padding:28px 24px;border:none;box-shadow:none;">
                        <div
                            style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <svg style="width:20px;height:20px;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <h3 style="font-size:1.05rem;font-weight:800;color:#fff;margin-bottom:10px;line-height:1.3;">
                            Kultur Berprestasi di Lokasi yang Sangat Strategis</h3>
                        <p style="font-size:0.875rem;color:rgba(255,255,255,0.85);line-height:1.6;">
                            Sekolah ini rutin berprestasi di ajang Lomba Kompetensi Siswa (LKS) dan bertempat di kawasan
                            Wonokromo yang mudah dijangkau transportasi umum.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        {{-- ==================== GURU DAN TENAGA KEPENDIDIKAN ==================== --}}
        <section style="padding:64px 0 80px;background:#fff;">
            <div style="max-width:1280px;margin:0 auto;padding:0 16px;">
                <div style="text-align:center;margin-bottom:48px;" class="fade-up">
                    <h2 style="font-size:clamp(1.75rem, 4vw, 2.25rem);font-weight:800;color:#0f172a;line-height:1.3;">
                        Guru dan Tenaga Kependidikan
                    </h2>
                </div>

                {{-- Carousel Wrapper --}}
                <div class="fade-up" style="position:relative;">

                    {{-- Left Arrow --}}
                    <button id="guru-prev" type="button" aria-label="Sebelumnya"
                        style="position:absolute;left:-8px;top:50%;transform:translateY(-70%);z-index:10;width:44px;height:44px;border-radius:50%;background:#fff;border:2px solid #e2e8f0;box-shadow:0 4px 12px rgba(0,0,0,0.1);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.3s ease;"
                        onmouseover="this.style.background='#024089';this.style.borderColor='#024089';this.querySelector('svg').style.color='#fff'"
                        onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.querySelector('svg').style.color='#0f172a'">
                        <svg style="width:20px;height:20px;color:#0f172a;transition:color 0.3s;" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    {{-- Right Arrow --}}
                    <button id="guru-next" type="button" aria-label="Selanjutnya"
                        style="position:absolute;right:-8px;top:50%;transform:translateY(-70%);z-index:10;width:44px;height:44px;border-radius:50%;background:#fff;border:2px solid #e2e8f0;box-shadow:0 4px 12px rgba(0,0,0,0.1);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.3s ease;"
                        onmouseover="this.style.background='#024089';this.style.borderColor='#024089';this.querySelector('svg').style.color='#fff'"
                        onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.querySelector('svg').style.color='#0f172a'">
                        <svg style="width:20px;height:20px;color:#0f172a;transition:color 0.3s;" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    {{-- Scrollable Track --}}
                    <div id="guru-carousel"
                        style="display:flex;gap:24px;overflow-x:auto;scroll-behavior:smooth;padding:8px 32px 16px;-ms-overflow-style:none;scrollbar-width:none;">
                        <style>
                            #guru-carousel::-webkit-scrollbar {
                                display: none;
                            }
                        </style>

                        {{-- Teacher Card 1: Sari Okta --}}
                        <div style="flex:0 0 280px;text-align:center;">
                            <div
                                style="position:relative;width:280px;height:340px;border-radius:16px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.1);margin-bottom:16px;">
                                <img src="{{ asset('images/sari-okta-rahmalina-spd 1.png') }}"
                                    alt="Sari Okta Rahmalina, S.Pd."
                                    style="width:100%;height:100%;object-fit:cover;object-position:top;transition:transform 0.5s ease;">
                                <div
                                    style="position:absolute;inset:0;background:linear-gradient(to top, rgba(15,23,42,0.5), transparent 40%);">
                                </div>
                            </div>
                            <p style="font-size:0.9rem;font-weight:700;color:#0f172a;">Sari Okta</p>
                            <p style="font-size:0.8rem;font-weight:500;color:#64748b;">Guru bahasa Indonesia</p>
                        </div>

                        {{-- Teacher Card 2: Sidik Dwi Widodo --}}
                        <div style="flex:0 0 280px;text-align:center;">
                            <div
                                style="position:relative;width:280px;height:340px;border-radius:16px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.1);margin-bottom:16px;">
                                <img src="{{ asset('images/drs-sidik-dwi-widodo-mm-mpd 1.png') }}"
                                    alt="Drs. Sidik Dwi Widodo, M.M., M.Pd."
                                    style="width:100%;height:100%;object-fit:cover;object-position:top;transition:transform 0.5s ease;">
                                <div
                                    style="position:absolute;inset:0;background:linear-gradient(to top, rgba(15,23,42,0.5), transparent 40%);">
                                </div>
                            </div>
                            <p style="font-size:0.9rem;font-weight:700;color:#0f172a;">Sidik Dwi Widodo</p>
                            <p style="font-size:0.8rem;font-weight:500;color:#64748b;">Guru Matematika</p>
                        </div>

                        {{-- Teacher Card 3: Pak Adi --}}
                        <div style="flex:0 0 280px;text-align:center;">
                            <div
                                style="position:relative;width:280px;height:340px;border-radius:16px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.1);margin-bottom:16px;">
                                <img src="{{ asset('images/pak-adi 5.png') }}" alt="Pak Adi"
                                    style="width:100%;height:100%;object-fit:cover;object-position:top;transition:transform 0.5s ease;">
                                <div
                                    style="position:absolute;inset:0;background:linear-gradient(to top, rgba(15,23,42,0.5), transparent 40%);">
                                </div>
                            </div>
                            <p style="font-size:0.9rem;font-weight:700;color:#0f172a;">Pak Adi</p>
                            <p style="font-size:0.8rem;font-weight:500;color:#64748b;">Guru Pendidikan Agama Islam</p>
                        </div>

                        {{-- Teacher Card 4: Anton Sujarwo (Kepala Sekolah) --}}
                        <div style="flex:0 0 280px;text-align:center;">
                            <div
                                style="position:relative;width:280px;height:340px;border-radius:16px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.1);margin-bottom:16px;">
                                <img src="{{ asset('images/anton-sujarwo 2.png') }}"
                                    alt="Dr. Drs. Anton Sujarwo, M.Pd."
                                    style="width:100%;height:100%;object-fit:cover;object-position:top;transition:transform 0.5s ease;">
                                <div
                                    style="position:absolute;inset:0;background:linear-gradient(to top, rgba(15,23,42,0.5), transparent 40%);">
                                </div>
                            </div>
                            <p style="font-size:0.9rem;font-weight:700;color:#0f172a;">Dr. Drs. Anton Sujarwo, M.Pd.
                            </p>
                            <p style="font-size:0.8rem;font-weight:500;color:#64748b;">Kepala Sekolah</p>
                        </div>

                    </div>
                </div>

                {{-- Selengkapnya Button --}}
                <div style="text-align:center;margin-top:32px;" class="fade-up">
                    <a href="{{ route('guru-dan-tenaga-kependidikan') }}"
                        style="display:inline-flex;align-items:center;justify-content:center;padding:12px 28px;font-size:0.875rem;font-weight:700;color:#024089;background:#fff;border:2px solid #024089;border-radius:8px;text-decoration:none;transition:all 0.3s ease;"
                        onmouseover="this.style.background='#024089';this.style.color='#fff'"
                        onmouseout="this.style.background='#fff';this.style.color='#024089'">
                        Selengkapnya..
                    </a>
                </div>
            </div>
        </section>

        {{-- ==================== TEMUKAN JURUSANMU ==================== --}}
        <section style="padding:64px 0 80px;background:#f8fafc;">
            <div style="max-width:1280px;margin:0 auto;padding:0 16px;">
                <div style="text-align:center;margin-bottom:40px;" class="fade-up">
                    <h2
                        style="font-size:clamp(1.75rem, 4vw, 2.25rem);font-weight:800;color:#0f172a;line-height:1.3;margin-bottom:16px;">
                        Temukan Jurusanmu,<br>Buka Peluang Karirmu
                    </h2>

                    {{-- Search icon --}}
                    <div style="display:flex;justify-content:center;margin-bottom:32px;">
                        <div
                            style="width:64px;height:64px;border-radius:50%;background:#fff;box-shadow:0 4px 12px rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:center;">
                            <svg style="width:28px;height:28px;color:#024089;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div style="max-width:640px;margin:0 auto 32px;" class="fade-up">
                    <div class="search-glow"
                        style="display:flex;align-items:center;background:#fff;border-radius:12px;border:2px solid #e2e8f0;box-shadow:0 1px 2px rgba(0,0,0,0.04);overflow:hidden;transition:all 0.3s ease;">
                        <div style="padding:0 12px 0 20px;">
                            <svg style="width:20px;height:20px;color:#94a3b8;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" placeholder="Senang di JHIK, coba pengolahan di bawah ini"
                            style="flex:1;padding:16px 16px 16px 0;font-size:0.875rem;color:#334155;border:none;outline:none;background:transparent;">
                    </div>
                </div>

                {{-- CTA Button --}}
                <div style="text-align:center;" class="fade-up">
                    <a href="{{ route('jurusan') }}"
                        style="display:inline-flex;align-items:center;justify-content:center;padding:14px 32px;font-size:0.875rem;font-weight:700;color:#fff;background:#f59e0b;border-radius:8px;text-decoration:none;box-shadow:0 4px 6px rgba(0,0,0,0.1);transition:all 0.3s ease;"
                        onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
                        Mulai Cari &rarr;
                    </a>
                </div>
            </div>
        </section>

        {{-- ==================== PUSAT KARIR SMKN 1 SURABAYA ==================== --}}
        <section style="padding:64px 0 80px;background:#fff;">
            <div style="max-width:1280px;margin:0 auto;padding:0 16px;">
                <div class="pk-hero fade-up">
                    <div class="pk-hero__bg">
                        <img src="{{ asset('images/smkn1.png') }}" alt="Background Pusat Karir">
                    </div>
                    <div class="pk-hero__overlay"></div>
                    <div class="pk-hero__content">
                        <h2 class="pk-hero__title">Pusat Karir SMKN 1 Surabaya</h2>
                        <p class="pk-hero__subtitle">
                            Temukan lowongan kerja, magang, dan peluang karier terbaik
                            untuk alumni dan siswa SMKN 1 Surabaya.
                        </p>

                        <form class="pk-hero__search" action="{{ route('pusat-karir.katalog-lowongan') }}" method="GET">
                            <input type="text" name="q" placeholder="Cari perusahaan, posisi, atau tempat magang..."
                                autocomplete="off">
                            <button type="submit" aria-label="Cari">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </button>
                        </form>

                        <div class="pk-hero__actions">
                            <a href="{{ route('pusat-karir.katalog-lowongan') }}">Lowongan Kerja</a>
                            <a href="{{ route('pusat-karir.katalog-magang') }}">Program Magang</a>
                            <a href="{{ route('pusat-karir.katalog-mitra') }}">Mitra DUDI</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== BERITA SMKN 1 SURABAYA ==================== --}}
        <section style="padding:64px 0 80px;background:#f8fafc;">
            <div style="max-width:1280px;margin:0 auto;padding:0 16px;">
                <div style="text-align:center;margin-bottom:48px;" class="fade-up">
                    <h2 style="font-size:clamp(1.75rem, 4vw, 2.25rem);font-weight:800;color:#0f172a;line-height:1.3;">
                        Berita SMKN 1 Surabaya
                    </h2>
                </div>

                <div style="display:grid;grid-template-columns:1fr;gap:24px;" class="fade-up" id="berita-grid">
                    {{-- Berita Terbaru --}}
                    @foreach ($artikels->take(4) as $artikel)
                        <a href="{{ route('pusat-karir.detail-artikel', $artikel->slug) }}" class="block group">
                            <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                                @if ($artikel->display_image)
                                    <img src="{{ $artikel->display_image }}" alt="{{ $artikel->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                @endif
                                <div class="p-5">
                                    <h3 class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $artikel->title }}</h3>
                                    <p class="text-sm text-slate-500 mt-2">{{ $artikel->excerpt ?? Str::limit(strip_tags($artikel->content), 120) }}</p>
                                </div>
                            </article>
                        </a>
                    @endforeach
                </div>

                <div style="text-align:center;margin-top:40px;" class="fade-up">
                    <a href="{{ route('informasi') }}"
                        style="font-size:0.875rem;font-weight:700;color:#024089;text-decoration:none;transition:color 0.3s;"
                        onmouseover="this.style.color='#013572'" onmouseout="this.style.color='#024089'">
                        Lihat semua berita &rarr;
                    </a>
                </div>
            </div>
        </section>

    </main>

    {{-- ==================== FOOTER ==================== --}}
    <footer style="background:#023775;color:#fff;padding:48px 0 32px;border-top:1px solid rgba(30,58,138,0.6);">
        <div style="max-width:1280px;margin:0 auto;padding:0 16px;">
            <div style="display:grid;grid-template-columns:1fr;gap:32px;margin-bottom:48px;" id="footer-grid">

                {{-- Column 1: Map --}}
                <div
                    style="background:rgba(255,255,255,0.05);padding:8px;border-radius:16px;border:1px solid rgba(255,255,255,0.1);">
                    <div
                        style="position:relative;width:100%;height:224px;border-radius:12px;overflow:hidden;background:#e2e8f0;border:1px solid rgba(255,255,255,0.1);">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.391219278278!2d112.73646547585098!3d-7.309880892698264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb9e5030e4ef%3A0x6b4ef84a73fc5268!2sSMK%20Negeri%201%20Surabaya!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" title="Lokasi SMK Negeri 1 Surabaya"></iframe>
                    </div>
                    <div
                        style="padding:10px 8px 4px;display:flex;align-items:center;justify-content:space-between;font-size:0.75rem;color:rgba(191,219,254,0.8);">
                        <span style="display:inline-flex;align-items:center;gap:6px;font-weight:500;">
                            <span
                                style="width:8px;height:8px;border-radius:50%;background:#34d399;display:inline-block;"></span>
                            Jl. Smea No. 4, Wonokromo, Surabaya
                        </span>
                        <a href="https://maps.google.com/?q=SMK+Negeri+1+Surabaya" target="_blank"
                            rel="noopener noreferrer" style="color:#fbbf24;text-decoration:none;font-weight:700;">
                            Buka Peta &rarr;
                        </a>
                    </div>
                </div>

                {{-- Column 2: Tentang Kami --}}
                <div style="font-size:0.875rem;line-height:1.7;color:rgba(191,219,254,0.9);">
                    <h3
                        style="font-size:1.5rem;font-weight:800;color:#fbbf24;margin-bottom:16px;letter-spacing:-0.02em;">
                        Tentang Kami
                    </h3>
                    <p style="margin-bottom:16px;text-align:justify;">
                        Sekolah Kejuruan di Surabaya, Jawa Timur yang berlokasi di Jl. Smea No. 4, Wonokromo Surabaya,
                        SMK Negeri 1 Surabaya bertekad mencapai perbaikan yang berkesinambungan berdasarkan sistem
                        manajemen mutu ISO 9001:2008.
                    </p>
                    <div style="font-size:0.75rem;color:rgba(191,219,254,0.9);margin-bottom:20px;">
                        <p style="margin-bottom:6px;"><strong style="color:#fff;">Telp:</strong> 031-8292038</p>
                        <p style="margin-bottom:6px;"><strong style="color:#fff;">FAX:</strong> 031-8292039</p>
                        <p><strong style="color:#fff;">Email:</strong> <a href="mailto:info@smkn1-sby.sch.id"
                                style="color:#fcd34d;text-decoration:none;">info@smkn1-sby.sch.id</a></p>
                    </div>

                    {{-- Social Media Icons --}}
                    <div style="display:flex;align-items:center;gap:12px;">
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                            aria-label="Instagram"
                            style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;transition:all 0.3s;"
                            onmouseover="this.style.background='#fbbf24';this.style.color='#0f172a'"
                            onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.color='#fff'">
                            <svg style="width:16px;height:16px;" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube"
                            style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;transition:all 0.3s;"
                            onmouseover="this.style.background='#fbbf24';this.style.color='#0f172a'"
                            onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.color='#fff'">
                            <svg style="width:16px;height:16px;" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Column 3: Jelajahi Smeas --}}
                <div style="border-left:2px solid #fbbf24;padding-left:24px;">
                    <h3
                        style="font-size:1.5rem;font-weight:800;color:#fbbf24;margin-bottom:16px;letter-spacing:-0.02em;">
                        Jelajahi Smeas
                    </h3>
                    <ul style="list-style:none;padding:0;margin:0;">
                        <li style="margin-bottom:12px;">
                            <a href="{{ route('pusat-karir.index') }}"
                                style="display:inline-flex;align-items:center;gap:8px;font-size:0.875rem;font-weight:600;color:rgba(219,234,254,1);text-decoration:none;transition:color 0.3s;"
                                onmouseover="this.style.color='#fbbf24'"
                                onmouseout="this.style.color='rgba(219,234,254,1)'">
                                <span style="color:#fbbf24;">&bull;</span> Pusat Karir
                            </a>
                        </li>
                        <li style="margin-bottom:12px;">
                            <a href="{{ route('blud.index') }}"
                                style="display:inline-flex;align-items:center;gap:8px;font-size:0.875rem;font-weight:600;color:rgba(219,234,254,1);text-decoration:none;transition:color 0.3s;"
                                onmouseover="this.style.color='#fbbf24'"
                                onmouseout="this.style.color='rgba(219,234,254,1)'">
                                <span style="color:#fbbf24;">&bull;</span> BLUD
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('spmb.index') }}"
                                style="display:inline-flex;align-items:center;gap:8px;font-size:0.875rem;font-weight:600;color:rgba(219,234,254,1);text-decoration:none;transition:color 0.3s;"
                                onmouseover="this.style.color='#fbbf24'"
                                onmouseout="this.style.color='rgba(219,234,254,1)'">
                                <span style="color:#fbbf24;">&bull;</span> PPDB / SPMB
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

            {{-- Bottom Copyright --}}
            <div
                style="padding-top:32px;border-top:1px solid rgba(255,255,255,0.1);text-align:center;font-size:0.75rem;color:rgba(191,219,254,0.7);font-weight:500;">
                &copy;{{ date('Y') }} | SMKN 1 Surabaya
            </div>
        </div>
    </footer>

    {{-- ==================== SCRIPTS ==================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== Responsive grid layouts via JS =====
            function applyResponsiveLayouts() {
                const w = window.innerWidth;

                // Hero grid: 2 cols on lg
                const heroGrid = document.querySelector('.hero-section [style*="grid-template-columns"]');
                if (heroGrid) {
                    heroGrid.style.gridTemplateColumns = w >= 1024 ? '1fr 1fr' : '1fr';
                    const textCol = heroGrid.children[0];
                    const photoCol = heroGrid.children[1];
                    if (textCol && photoCol) {
                        if (w >= 1024) {
                            textCol.style.order = '1';
                            photoCol.style.order = '2';
                        } else {
                            textCol.style.order = '2';
                            photoCol.style.order = '1';
                        }
                    }
                }

                // Prakata top row: side-by-side on md+
                const prakataTopRow = document.getElementById('prakata-top-row');
                if (prakataTopRow) {
                    if (w >= 768) {
                        prakataTopRow.style.flexDirection = 'row';
                        prakataTopRow.style.alignItems = 'flex-start';
                        prakataTopRow.style.justifyContent = 'space-between';
                    } else {
                        prakataTopRow.style.flexDirection = 'column';
                        prakataTopRow.style.alignItems = 'flex-start';
                        prakataTopRow.style.justifyContent = 'flex-start';
                    }
                }

                // Footer grid: 3 cols on md
                const footerGrid = document.getElementById('footer-grid');
                if (footerGrid) {
                    if (w >= 768) {
                        footerGrid.style.gridTemplateColumns = '4fr 5fr 3fr';
                    } else {
                        footerGrid.style.gridTemplateColumns = '1fr';
                    }
                }
            }

            applyResponsiveLayouts();
            window.addEventListener('resize', applyResponsiveLayouts);

            // ===== Guru Carousel Navigation =====
            const carousel = document.getElementById('guru-carousel');
            const prevBtn = document.getElementById('guru-prev');
            const nextBtn = document.getElementById('guru-next');

            if (carousel && prevBtn && nextBtn) {
                const scrollAmount = 304; // card width (280) + gap (24)

                prevBtn.addEventListener('click', function() {
                    carousel.scrollBy({
                        left: -scrollAmount,
                        behavior: 'smooth'
                    });
                });

                nextBtn.addEventListener('click', function() {
                    carousel.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                });
            }

            // ===== Scroll-triggered fade-in =====
            const fadeEls = document.querySelectorAll('.fade-up');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });

            fadeEls.forEach(el => observer.observe(el));
        });
    </script>

</body>

</html>
