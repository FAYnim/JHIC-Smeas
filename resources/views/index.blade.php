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
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
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
        }

        .prakata-quote::before {
            content: '\201C';
            position: absolute;
            top: -24px;
            left: -12px;
            font-size: 80px;
            color: rgba(2, 64, 137, 0.08);
            font-family: Georgia, serif;
            line-height: 1;
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
                        <div style="max-width:720px;">
                            <p
                                style="font-size:clamp(0.95rem, 1.5vw, 1.05rem); color:#1e293b; font-weight:700; line-height:1.8; text-align:justify; margin:0;">
                                Era globalisasi membawa perubahan yang cepat dalam berbagai aspek kehidupan. Oleh karena
                                itu, pendidikan memiliki peran penting dalam menyiapkan sumber daya manusia yang mampu
                                menghadapi perubahan tersebut. Sekolah perlu memiliki arah pengembangan yang jelas dan
                                berkelanjutan, sekaligus mampu menyesuaikan diri dengan kebutuhan dan permasalahan
                                masyarakat saat ini.
                            </p>
                        </div>
                    </div>

                    {{-- Right Column: Headmaster Photo --}}
                    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
                        <img src="{{ asset('images/Group 198.png') }}" alt="Dr. Drs. Anton Sujarwo, M.Pd."
                            style="width:260px; max-width:100%; height:auto; display:block;">
                        <p
                            style="margin-top:12px; font-size:0.95rem; font-weight:700; color:#0b192c; text-align:center;">
                            Dr. Drs. Anton Sujarwo, M.Pd.
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
        <section style="padding:64px 0 80px;background:#f8fafc;">
            <div style="max-width:1280px;margin:0 auto;padding:0 16px;">
                <div style="text-align:center;margin-bottom:48px;" class="fade-up">
                    <h2 style="font-size:clamp(1.75rem, 4vw, 2.25rem);font-weight:800;color:#0f172a;line-height:1.3;">
                        Kenapa harus <span style="color:#024089;">SMKN 1 Surabaya</span>?
                    </h2>
                </div>

                {{-- Feature Cards Grid --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(300px, 1fr));gap:24px;"
                    class="fade-up">

                    {{-- Card 1 --}}
                    <div class="feature-card"
                        style="background:#fff;border-radius:16px;padding:24px;border:1px solid #f1f5f9;box-shadow:0 1px 2px rgba(0,0,0,0.04);">
                        <div
                            style="width:48px;height:48px;border-radius:12px;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <svg style="width:24px;height:24px;color:#024089;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 style="font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:8px;">Fasilitas Lengkap
                            dan Iklim sekolah yang Kondusif</h3>
                        <p style="font-size:0.875rem;color:#64748b;line-height:1.6;">
                            Didukung laboratorium modern, bengkel praktik lengkap, dan lingkungan belajar yang nyaman
                            untuk mendukung perkembangan siswa.
                        </p>
                    </div>

                    {{-- Card 2 --}}
                    <div class="feature-card"
                        style="background:#fff;border-radius:16px;padding:24px;border:1px solid #f1f5f9;box-shadow:0 1px 2px rgba(0,0,0,0.04);">
                        <div
                            style="width:48px;height:48px;border-radius:12px;background:#fffbeb;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <svg style="width:24px;height:24px;color:#f59e0b;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <h3 style="font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:8px;">Lulusan
                            Bersertifikat Keahlian Standar Industri</h3>
                        <p style="font-size:0.875rem;color:#64748b;line-height:1.6;">
                            Siswa mendapatkan sertifikasi kompetensi yang diakui industri, meningkatkan daya saing di
                            dunia kerja.
                        </p>
                    </div>

                    {{-- Card 3 --}}
                    <div class="feature-card"
                        style="background:#fff;border-radius:16px;padding:24px;border:1px solid #f1f5f9;box-shadow:0 1px 2px rgba(0,0,0,0.04);">
                        <div
                            style="width:48px;height:48px;border-radius:12px;background:#ecfdf5;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <svg style="width:24px;height:24px;color:#10b981;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 style="font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:8px;">Pendidik
                            Berpengalaman dan Berkualitas Tinggi</h3>
                        <p style="font-size:0.875rem;color:#64748b;line-height:1.6;">
                            Tim pengajar profesional bersertifikat dengan pengalaman industri dan akademis yang mumpuni.
                        </p>
                    </div>

                    {{-- Card 4 --}}
                    <div class="feature-card"
                        style="background:#fff;border-radius:16px;padding:24px;border:1px solid #f1f5f9;box-shadow:0 1px 2px rgba(0,0,0,0.04);">
                        <div
                            style="width:48px;height:48px;border-radius:12px;background:#faf5ff;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <svg style="width:24px;height:24px;color:#a855f7;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 style="font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:8px;">Mitra Industri
                            Berkelas dan Terpercaya</h3>
                        <p style="font-size:0.875rem;color:#64748b;line-height:1.6;">
                            Bermitra dengan ratusan perusahaan dan instansi ternama untuk program magang dan penempatan
                            kerja.
                        </p>
                    </div>

                    {{-- Card 5 --}}
                    <div class="feature-card"
                        style="background:#fff;border-radius:16px;padding:24px;border:1px solid #f1f5f9;box-shadow:0 1px 2px rgba(0,0,0,0.04);">
                        <div
                            style="width:48px;height:48px;border-radius:12px;background:#fff1f2;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <svg style="width:24px;height:24px;color:#f43f5e;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 style="font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:8px;">Kurikulum Terbaru
                            Berbasis DUDI</h3>
                        <p style="font-size:0.875rem;color:#64748b;line-height:1.6;">
                            Kurikulum yang selalu diperbarui sesuai kebutuhan Dunia Usaha dan Dunia Industri (DUDI)
                            terkini.
                        </p>
                    </div>

                    {{-- Card 6 --}}
                    <div class="feature-card"
                        style="background:#fff;border-radius:16px;padding:24px;border:1px solid #f1f5f9;box-shadow:0 1px 2px rgba(0,0,0,0.04);">
                        <div
                            style="width:48px;height:48px;border-radius:12px;background:#f0f9ff;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <svg style="width:24px;height:24px;color:#0ea5e9;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <h3 style="font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:8px;">Segudang Prestasi
                            Nasional & Internasional</h3>
                        <p style="font-size:0.875rem;color:#64748b;line-height:1.6;">
                            Secara konsisten meraih prestasi di berbagai bidang lomba dan kompetisi tingkat nasional
                            hingga internasional.
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
                <div class="fade-up"
                    style="background:linear-gradient(135deg, #024089, #013572);border-radius:24px;padding:40px;box-shadow:0 20px 40px -12px rgba(2,64,137,0.3);">
                    <h2 style="font-size:clamp(1.5rem, 3vw, 1.875rem);font-weight:800;color:#fff;margin-bottom:24px;">
                        Pusat Karir SMKN 1 Surabaya
                    </h2>

                    {{-- Search inside card --}}
                    <div style="max-width:560px;margin-bottom:24px;">
                        <div
                            style="display:flex;align-items:center;background:rgba(255,255,255,0.1);border-radius:12px;border:1px solid rgba(255,255,255,0.2);overflow:hidden;">
                            <div style="padding:0 12px 0 16px;">
                                <svg style="width:20px;height:20px;color:rgba(255,255,255,0.6);" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" placeholder="Cari lowongan kerja, magang, atau mitra..."
                                style="flex:1;padding:14px 16px 14px 0;font-size:0.875rem;color:#fff;border:none;outline:none;background:transparent;"
                                class="placeholder:text-white/50">
                        </div>
                    </div>

                    {{-- Quick Action Buttons --}}
                    <div style="display:flex;flex-wrap:wrap;gap:12px;">
                        <a href="{{ route('pusat-karir.katalog-lowongan') }}"
                            style="display:inline-flex;align-items:center;padding:10px 20px;font-size:0.75rem;font-weight:700;color:#024089;background:#fff;border-radius:8px;text-decoration:none;box-shadow:0 1px 2px rgba(0,0,0,0.1);transition:background 0.3s;"
                            onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='#fff'">
                            Lowongan Kerja
                        </a>
                        <a href="{{ route('pusat-karir.katalog-magang') }}"
                            style="display:inline-flex;align-items:center;padding:10px 20px;font-size:0.75rem;font-weight:700;color:#fff;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.2);border-radius:8px;text-decoration:none;transition:background 0.3s;"
                            onmouseover="this.style.background='rgba(255,255,255,0.25)'"
                            onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                            Program Magang
                        </a>
                        <a href="{{ route('pusat-karir.katalog-mitra') }}"
                            style="display:inline-flex;align-items:center;padding:10px 20px;font-size:0.75rem;font-weight:700;color:#fff;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.2);border-radius:8px;text-decoration:none;transition:background 0.3s;"
                            onmouseover="this.style.background='rgba(255,255,255,0.25)'"
                            onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                            Mitra DUDI
                        </a>
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
                    {{-- Main Featured Article --}}
                    <a href="{{ route('informasi') }}" class="news-main"
                        style="text-decoration:none;display:block;box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                        <img src="{{ asset('images/VBG - WEB DEV COMPTETITION.jpg') }}"
                            alt="Berita Terbaru SMKN 1 Surabaya">
                        <div
                            style="position:absolute;inset:0;background:linear-gradient(to top, rgba(15,23,42,0.85), rgba(15,23,42,0.2) 50%, transparent);">
                        </div>
                        <div style="position:absolute;bottom:0;left:0;right:0;padding:24px;">
                            <span
                                style="display:inline-block;padding:4px 12px;font-size:0.75rem;font-weight:700;color:#024089;background:#fbbf24;border-radius:9999px;margin-bottom:12px;">
                                Berita Terbaru
                            </span>
                            <h3
                                style="font-size:clamp(1.1rem, 2vw, 1.25rem);font-weight:700;color:#fff;line-height:1.4;">
                                VBG — Web Dev Competition 2026
                            </h3>
                            <p style="font-size:0.875rem;color:rgba(191,219,254,0.8);margin-top:8px;">
                                Siswa SMKN 1 Surabaya berhasil meraih juara dalam kompetisi pengembangan web tingkat
                                nasional.
                            </p>
                        </div>
                    </a>

                    {{-- Side Articles Container --}}
                    <div style="display:flex;flex-direction:column;gap:16px;" id="berita-side">
                        {{-- Article 2 --}}
                        <a href="{{ route('informasi') }}"
                            style="display:flex;gap:16px;background:#fff;border-radius:12px;padding:16px;border:1px solid #f1f5f9;box-shadow:0 1px 2px rgba(0,0,0,0.04);text-decoration:none;transition:box-shadow 0.3s;"
                            onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'"
                            onmouseout="this.style.boxShadow='0 1px 2px rgba(0,0,0,0.04)'">
                            <div
                                style="width:96px;height:96px;border-radius:8px;overflow:hidden;flex-shrink:0;background:#f1f5f9;">
                                <img src="{{ asset('images/image 4.png') }}" alt="Berita"
                                    style="width:100%;height:100%;object-fit:cover;">
                            </div>
                            <div style="flex:1;min-width:0;">
                                <span style="font-size:0.75rem;font-weight:700;color:#024089;">Prestasi</span>
                                <h4
                                    style="font-size:0.875rem;font-weight:700;color:#0f172a;margin-top:4px;line-height:1.4;">
                                    Siswa Raih Medali Emas LKS Tingkat Nasional
                                </h4>
                                <p style="font-size:0.75rem;color:#94a3b8;margin-top:4px;">3 hari yang lalu</p>
                            </div>
                        </a>

                        {{-- Article 3 --}}
                        <a href="{{ route('informasi') }}"
                            style="display:flex;gap:16px;background:#fff;border-radius:12px;padding:16px;border:1px solid #f1f5f9;box-shadow:0 1px 2px rgba(0,0,0,0.04);text-decoration:none;transition:box-shadow 0.3s;"
                            onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'"
                            onmouseout="this.style.boxShadow='0 1px 2px rgba(0,0,0,0.04)'">
                            <div
                                style="width:96px;height:96px;border-radius:8px;overflow:hidden;flex-shrink:0;background:#f1f5f9;">
                                <img src="{{ asset('images/image 5.png') }}" alt="Berita"
                                    style="width:100%;height:100%;object-fit:cover;">
                            </div>
                            <div style="flex:1;min-width:0;">
                                <span style="font-size:0.75rem;font-weight:700;color:#024089;">Kegiatan</span>
                                <h4
                                    style="font-size:0.875rem;font-weight:700;color:#0f172a;margin-top:4px;line-height:1.4;">
                                    Upacara Hari Pendidikan Nasional
                                </h4>
                                <p style="font-size:0.75rem;color:#94a3b8;margin-top:4px;">5 hari yang lalu</p>
                            </div>
                        </a>

                        {{-- Article 4 --}}
                        <a href="{{ route('informasi') }}"
                            style="display:flex;gap:16px;background:#fff;border-radius:12px;padding:16px;border:1px solid #f1f5f9;box-shadow:0 1px 2px rgba(0,0,0,0.04);text-decoration:none;transition:box-shadow 0.3s;"
                            onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'"
                            onmouseout="this.style.boxShadow='0 1px 2px rgba(0,0,0,0.04)'">
                            <div
                                style="width:96px;height:96px;border-radius:8px;overflow:hidden;flex-shrink:0;background:#f1f5f9;">
                                <img src="{{ asset('images/smkn1.png') }}" alt="Berita"
                                    style="width:100%;height:100%;object-fit:cover;">
                            </div>
                            <div style="flex:1;min-width:0;">
                                <span style="font-size:0.75rem;font-weight:700;color:#f59e0b;">Pengumuman</span>
                                <h4
                                    style="font-size:0.875rem;font-weight:700;color:#0f172a;margin-top:4px;line-height:1.4;">
                                    Jadwal SPMB Tahun Ajaran 2026/2027
                                </h4>
                                <p style="font-size:0.75rem;color:#94a3b8;margin-top:4px;">1 minggu yang lalu</p>
                            </div>
                        </a>
                    </div>
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

                // Berita grid: side-by-side on lg
                const beritaGrid = document.getElementById('berita-grid');
                if (beritaGrid) {
                    beritaGrid.style.gridTemplateColumns = w >= 1024 ? '7fr 5fr' : '1fr';
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
