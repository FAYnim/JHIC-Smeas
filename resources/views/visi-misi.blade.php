<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi & Misi — SMK Negeri 1 Surabaya</title>

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
            /* amber-400 */
            border-radius: 9999px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .nav-hover-link:hover::after {
            transform: scaleX(1);
        }

        /* Ambient Glow & Background Patterns */
        .hero-banner-pattern {
            background-image:
                radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.4) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(30, 64, 175, 0.5) 0%, transparent 45%),
                radial-gradient(circle at 50% 50%, rgba(15, 23, 42, 0.3) 0%, transparent 60%);
        }

        .grid-pattern-overlay {
            background-size: 32px 32px;
            background-image:
                linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
        }

        /* Misi Card Floating Number Effect */
        .misi-card {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .misi-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
        }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased flex flex-col min-h-screen">

    {{-- Header / Navbar --}}
    @include('partials.navbar', [
        'activePage' => 'profil',
        'berandaUrl' => route('beranda'),
    ])

    <main class="flex-grow">
        {{-- ==================== HERO SECTION (BLUE BANNER) ==================== --}}
        <section
            class="relative bg-gradient-to-br from-[#024089] via-[#0452b0] to-[#013572] text-white pt-14 pb-28 md:pt-20 md:pb-36 overflow-hidden hero-banner-pattern">
            {{-- Decorative Grid Lines --}}
            <div class="absolute inset-0 grid-pattern-overlay pointer-events-none"></div>

            {{-- Subtle Background Glow Rings --}}
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute -bottom-20 -left-20 w-80 h-80 bg-amber-400/10 rounded-full blur-2xl pointer-events-none">
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    {{-- Main Title --}}
                    <h1
                        class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-5 leading-[1.15]">
                        Visi &amp; Misi
                    </h1>

                    {{-- Accent Bar --}}
                    <div class="w-20 h-1.5 bg-gradient-to-r from-amber-400 to-amber-300 rounded-full mb-6"></div>

                    {{-- Description --}}
                    <p class="text-base sm:text-lg text-blue-100/90 font-normal leading-relaxed max-w-2xl">
                        Arah dan komitmen SMK Negeri 1 Surabaya dalam membentuk lulusan yang berkarakter, kompeten, dan
                        siap bersaing di kancah nasional maupun global.
                    </p>
                </div>
            </div>
        </section>

        {{-- ==================== VISI & MISI CONTENT CONTAINER ==================== --}}
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 md:-mt-20 z-10 pb-20">

            {{-- ===== VISI CARD (Heroic Elevated Banner) ===== --}}
            <section
                class="bg-white rounded-2xl md:rounded-3xl shadow-[0_15px_40px_-10px_rgba(2,64,137,0.12)] border border-slate-100 p-6 sm:p-8 lg:p-12 mb-12 sm:mb-16">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6 lg:gap-10">
                    {{-- Large Golden Quote Box --}}
                    <div
                        class="w-18 h-18 sm:w-22 sm:h-22 lg:w-26 lg:h-26 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-500 shadow-lg shadow-amber-400/25 flex items-center justify-center shrink-0 text-slate-950">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                    </div>

                    {{-- Text Content --}}
                    <div class="flex-1">
                        <div
                            class="inline-block text-xs sm:text-sm font-extrabold uppercase tracking-widest text-amber-500 mb-2">
                            VISI SEKOLAH
                        </div>
                        <h2
                            class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#023775] leading-snug lg:leading-tight">
                            Terwujudnya SMK Negeri 1 Surabaya Yang Berkarakter Dan Unggul.
                        </h2>
                    </div>
                </div>
            </section>

            {{-- ===== MISI SECTION HEADER ===== --}}
            <div class="flex items-center gap-4 mb-8 sm:mb-10">
                <div class="w-3.5 h-8 bg-blue-600 rounded-full"></div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        MISI SEKOLAH
                    </h2>
                    <p class="text-sm text-slate-500 font-medium">Langkah strategis dalam merealisasikan visi SMK Negeri
                        1 Surabaya</p>
                </div>
            </div>

            {{-- ===== MISI CARDS GRID ===== --}}
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">

                {{-- Misi 01 --}}
                <div
                    class="misi-card group relative bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between overflow-hidden shadow-xs hover:border-blue-500">
                    <div
                        class="absolute -top-10 -right-6 text-7xl sm:text-8xl font-black text-slate-100 group-hover:text-blue-50 transition-colors select-none pointer-events-none">
                        01
                    </div>
                    <div>
                        <div
                            class="text-3xl sm:text-4xl font-black text-blue-600 mb-5 tracking-tight group-hover:scale-105 transition-transform origin-left">
                            01
                        </div>
                        <h3
                            class="text-base sm:text-lg font-extrabold text-[#013572] group-hover:text-blue-700 transition-colors leading-snug">
                            MENINGKATKAN KOMPETENSI PESERTA DIDIK SESUAI STANDAR KOMPETENSI LULUSAN DAN BERKARAKTER
                            PROFIL PELAJAR PANCASILA.
                        </h3>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-slate-400 group-hover:text-blue-600 transition-colors">
                        <span class="w-1.5 h-1.5 "></span>
                        Peserta Didik &amp; Karakter
                    </div>
                </div>

                {{-- Misi 02 --}}
                <div
                    class="misi-card group relative bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between overflow-hidden shadow-xs hover:border-blue-500">
                    <div
                        class="absolute -top-10 -right-6 text-7xl sm:text-8xl font-black text-slate-100 group-hover:text-blue-50 transition-colors select-none pointer-events-none">
                        02
                    </div>
                    <div>
                        <div
                            class="text-3xl sm:text-4xl font-black text-blue-600 mb-5 tracking-tight group-hover:scale-105 transition-transform origin-left">
                            02
                        </div>
                        <h3
                            class="text-base sm:text-lg font-extrabold text-[#013572] group-hover:text-blue-700 transition-colors leading-snug">
                            MENINGKATKAN KOMPETENSI SDM SESUAI ERA REVOLUSI INDUSTRI.
                        </h3>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-slate-400 group-hover:text-blue-600 transition-colors">
                        <span class="w-1.5 h-1.5"></span>
                        Pengembangan SDM &amp; Industri
                    </div>
                </div>

                {{-- Misi 03 --}}
                <div
                    class="misi-card group relative bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between overflow-hidden shadow-xs hover:border-blue-500">
                    <div
                        class="absolute -top-10 -right-6 text-7xl sm:text-8xl font-black text-slate-100 group-hover:text-blue-50 transition-colors select-none pointer-events-none">
                        03
                    </div>
                    <div>
                        <div
                            class="text-3xl sm:text-4xl font-black text-blue-600 mb-5 tracking-tight group-hover:scale-105 transition-transform origin-left">
                            03
                        </div>
                        <h3
                            class="text-base sm:text-lg font-extrabold text-[#013572] group-hover:text-blue-700 transition-colors leading-snug">
                            MEMPERKUAT KERJASAMA DENGAN DUDIKA UNTUK MENINGKATKAN DAYA SAING.
                        </h3>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-slate-400 group-hover:text-blue-600 transition-colors">
                        <span class="w-1.5 h-1.5"></span>
                        Kemitraan DUDIKA
                    </div>
                </div>

                {{-- Misi 04 --}}
                <div
                    class="misi-card group relative bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between overflow-hidden shadow-xs hover:border-blue-500 md:col-start-1 lg:col-start-auto">
                    <div
                        class="absolute -top-10 -right-6 text-7xl sm:text-8xl font-black text-slate-100 group-hover:text-blue-50 transition-colors select-none pointer-events-none">
                        04
                    </div>
                    <div>
                        <div
                            class="text-3xl sm:text-4xl font-black text-blue-600 mb-5 tracking-tight group-hover:scale-105 transition-transform origin-left">
                            04
                        </div>
                        <h3
                            class="text-base sm:text-lg font-extrabold text-[#013572] group-hover:text-blue-700 transition-colors leading-snug">
                            MELAKSANAKAN MANAJEMEN ISO MENUJU SEKOLAH ADAPTIF DAN AKUNTABEL.
                        </h3>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-slate-400 group-hover:text-blue-600 transition-colors">
                        <span class="w-1.5 h-1.5"></span>
                        Manajemen Mutu ISO
                    </div>
                </div>

                {{-- Misi 05 --}}
                <div
                    class="misi-card group relative bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between overflow-hidden shadow-xs hover:border-blue-500">
                    <div
                        class="absolute -top-10 -right-6 text-7xl sm:text-8xl font-black text-slate-100 group-hover:text-blue-50 transition-colors select-none pointer-events-none">
                        05
                    </div>
                    <div>
                        <div
                            class="text-3xl sm:text-4xl font-black text-blue-600 mb-5 tracking-tight group-hover:scale-105 transition-transform origin-left">
                            05
                        </div>
                        <h3
                            class="text-base sm:text-lg font-extrabold text-[#013572] group-hover:text-blue-700 transition-colors leading-snug">
                            MEWUJUDKAN SEKOLAH YANG MENYENANGKAN DAN BERWAWASAN LINGKUNGAN.
                        </h3>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-slate-400 group-hover:text-blue-600 transition-colors">
                        <span class="w-1.5 h-1.5"></span>
                        Lingkungan &amp; Kenyamanan
                    </div>
                </div>

            </section>
        </div>
    </main>

    {{-- ==================== RICH FOOTER (SMEAS IDENTITY) ==================== --}}
    <footer class="bg-[#023775] text-white pt-12 sm:pt-16 pb-8 border-t border-blue-900/60 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-start mb-12">

                {{-- Column 1: Map Vector Box / Location Visual --}}
                <div class="md:col-span-4 bg-white/5 p-2 rounded-2xl border border-white/10 backdrop-blur-xs">
                    <div
                        class="relative w-full h-56 rounded-xl overflow-hidden bg-slate-200 border border-white/10 group">
                        {{-- Interactive Google Maps Embed with SMEAS location --}}
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.391219278278!2d112.73646547585098!3d-7.309880892698264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb9e5030e4ef%3A0x6b4ef84a73fc5268!2sSMK%20Negeri%201%20Surabaya!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" title="Lokasi SMK Negeri 1 Surabaya"
                            class="w-full h-full filter saturate-90 contrast-105 group-hover:saturate-100 transition-all duration-300">
                        </iframe>
                    </div>
                    <div class="px-2 pt-2.5 pb-1 flex items-center justify-between text-xs text-blue-200/80">
                        <span class="inline-flex items-center gap-1.5 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            Jl. Smea No. 4, Wonokromo, Surabaya
                        </span>
                        <a href="https://maps.google.com/?q=SMK+Negeri+1+Surabaya" target="_blank"
                            rel="noopener noreferrer" class="text-amber-400 hover:underline font-bold">
                            Buka Peta &rarr;
                        </a>
                    </div>
                </div>

                {{-- Column 2: Tentang Kami --}}
                <div class="md:col-span-5 text-sm leading-relaxed text-blue-100/90">
                    <h3 class="text-2xl font-extrabold text-amber-400 mb-4 tracking-tight">
                        Tentang Kami
                    </h3>
                    <p class="mb-4 text-justify">
                        Sekolah Kejuruan di Surabaya, Jawa Timur yang berlokasi di Jl. Smea No. 4, Wonokromo Surabaya,
                        SMK Negeri 1 Surabaya bertekad mencapai perbaikan yang berkesinambungan berdasarkan sistem
                        manajemen mutu ISO 9001:2008.
                    </p>
                    <div class="space-y-1.5 text-xs text-blue-200/90 mb-5">
                        <p><strong class="text-white">Telp:</strong> 031-8292038</p>
                        <p><strong class="text-white">FAX:</strong> 031-8292039</p>
                        <p><strong class="text-white">Email:</strong> <a href="mailto:info@smkn1-sby.sch.id"
                                class="text-amber-300 hover:underline">info@smkn1-sby.sch.id</a></p>
                    </div>

                    {{-- Social Media Icons --}}
                    <div class="flex items-center gap-3">
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                            aria-label="Instagram SMKN 1 Surabaya"
                            class="w-9 h-9 rounded-lg bg-white/10 hover:bg-amber-400 hover:text-slate-950 transition-all flex items-center justify-center text-white">
                            <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer"
                            aria-label="YouTube SMKN 1 Surabaya"
                            class="w-9 h-9 rounded-lg bg-white/10 hover:bg-amber-400 hover:text-slate-950 transition-all flex items-center justify-center text-white">
                            <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Column 3: Jelajahi Smeas with Gold Vertical Accent Border --}}
                <div class="md:col-span-3 border-l-2 border-amber-400 pl-6 sm:pl-8 py-1">
                    <h3 class="text-2xl font-extrabold text-amber-400 mb-4 tracking-tight">
                        Jelajahi Smeas
                    </h3>
                    <ul class="space-y-3 text-sm font-semibold text-blue-100">
                        <li>
                            <a href="{{ route('pusat-karir.index') }}"
                                class="hover:text-amber-400 transition-colors inline-flex items-center gap-2">
                                <span class="text-amber-400">&bull;</span> Pusat Karir
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('blud.index') }}"
                                class="hover:text-amber-400 transition-colors inline-flex items-center gap-2">
                                <span class="text-amber-400">&bull;</span> BLUD
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('spmb.index') }}"
                                class="hover:text-amber-400 transition-colors inline-flex items-center gap-2">
                                <span class="text-amber-400">&bull;</span> PPDB / SPMB
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

            {{-- Bottom Copyright Strip --}}
            <div class="pt-8 border-t border-white/10 text-center text-xs text-blue-200/70 font-medium">
                &copy;{{ date('Y') }} | SMKN 1 Surabaya
            </div>
        </div>
    </footer>

</body>

</html>
