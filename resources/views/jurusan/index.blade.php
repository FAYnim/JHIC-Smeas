<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Jurusan — SMK Negeri 1 Surabaya</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
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

        /* Card Hover Effects */
        .jurusan-card {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .jurusan-card:hover {
            transform: translateY(-4px);
            border-color: #3b82f6;
            box-shadow: 0 16px 32px -8px rgba(2, 64, 137, 0.12);
        }

        .jurusan-card:hover .arrow-icon {
            transform: translateX(4px);
        }

        /* Active Filter Button */
        .filter-btn.active {
            background-color: #0250a3;
            color: #ffffff;
            border-color: #0250a3;
            box-shadow: 0 4px 12px rgba(2, 80, 163, 0.25);
        }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased flex flex-col min-h-screen selection:bg-amber-400 selection:text-slate-950">

    {{-- ==================== NAVBAR ==================== --}}
    @include('partials.navbar', [
        'activePage' => 'jurusan',
        'berandaUrl' => route('beranda')
    ])

    <main class="flex-grow">
        {{-- ==================== HERO SECTION (BLUE BANNER WITH STAT COUNTERS) ==================== --}}
        <section class="relative bg-gradient-to-br from-[#024089] via-[#0452b0] to-[#013572] text-white pt-14 pb-28 md:pt-18 md:pb-36 overflow-hidden hero-banner-pattern">
            {{-- Subtle Background Grid & Glows --}}
            <div class="absolute inset-0 grid-pattern-overlay pointer-events-none"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-amber-400/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-10">

                    {{-- Left Hero Description --}}
                    <div class="max-w-2xl">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-5 leading-[1.15]">
                            Profil Jurusan
                        </h1>

                        <div class="w-20 h-1.5 bg-gradient-to-r from-amber-400 to-amber-300 rounded-full mb-6"></div>

                        <p class="text-base sm:text-lg text-blue-100/90 font-normal leading-relaxed max-w-2xl">
                            Sembilan jurusan unggulan SMK Negeri 1 Surabaya siap membekali Anda dengan kompetensi nyata, dari bisnis dan teknologi hingga kreativitas dan pelayanan. Pembelajaran berbasis praktik dan selaras dengan kebutuhan industri membantu Anda meraih karier yang gemilang.
                        </p>
                    </div>

                    {{-- Right Stat Boxes (9 Jurusan, 4 Bidang Keahlian) --}}
                    <div class="flex items-center gap-4 sm:gap-6 self-start lg:self-center shrink-0">
                        {{-- White Card (9 Jurusan) --}}
                        <div class="w-32 sm:w-38 h-32 sm:h-38 rounded-2xl bg-white shadow-xl shadow-blue-950/20 flex flex-col items-center justify-center text-center p-4 border border-white/20">
                            <span class="text-4xl sm:text-5xl font-black text-[#023775] leading-none mb-2">9</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-600">Jurusan</span>
                        </div>

                        {{-- Yellow Card (4 Bidang Keahlian) --}}
                        <div class="w-32 sm:w-38 h-32 sm:h-38 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-500 shadow-xl shadow-amber-950/20 flex flex-col items-center justify-center text-center p-4 border border-amber-300/40 text-slate-950">
                            <span class="text-4xl sm:text-5xl font-black text-slate-950 leading-none mb-2">4</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-900 leading-tight">Bidang Keahlian</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ==================== MAIN CONTENT AREA ==================== --}}
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 sm:-mt-14 z-10 pb-20">

            {{-- ===== STATS ROW (Dynamic Stats from DB) ===== --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 text-center shadow-xs">
                    <div class="text-3xl sm:text-4xl font-extrabold text-blue-600">{{ $totalLowongan }}</div>
                    <div class="text-xs sm:text-sm font-bold text-slate-500 mt-1">Lowongan Aktif</div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 text-center shadow-xs">
                    <div class="text-3xl sm:text-4xl font-extrabold text-blue-600">{{ $totalAlumni }}</div>
                    <div class="text-xs sm:text-sm font-bold text-slate-500 mt-1">Alumni</div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 text-center shadow-xs">
                    <div class="text-3xl sm:text-4xl font-extrabold text-blue-600">{{ $totalMitra }}</div>
                    <div class="text-xs sm:text-sm font-bold text-slate-500 mt-1">Mitra Industri</div>
                </div>
            </div>

            {{-- ===== FILTER BAR (Floating White Container) ===== --}}
            <div class="bg-white rounded-2xl shadow-[0_10px_30px_-5px_rgba(2,64,137,0.08)] border border-slate-200/80 p-3 sm:p-4 mb-10 flex items-center justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                    <span class="text-xs sm:text-sm font-bold text-slate-500 px-3 py-1.5 hidden sm:inline-block">Filter bidang:</span>

                    <button type="button" data-filter="all" class="filter-btn active px-4 py-2 rounded-xl text-xs sm:text-sm font-bold border border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                        Semua
                    </button>
                    <button type="button" data-filter="bisnis" class="filter-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                        Bisnis &amp; Manajemen
                    </button>
                    <button type="button" data-filter="teknologi" class="filter-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                        Teknologi
                    </button>
                    <button type="button" data-filter="kreatif" class="filter-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                        Kreatif &amp; Media
                    </button>
                    <button type="button" data-filter="pariwisata" class="filter-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                        Pariwisata
                    </button>
                </div>
            </div>

            {{-- ===== JURUSAN GRID (3x3 CARDS) ===== --}}
            <section id="jurusan-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">

                {{-- 01. Akuntansi --}}
                <a href="{{ route('jurusan.detail', 'akuntansi') }}" class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block" data-category="bisnis">
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-200 group-hover:text-blue-200 transition-colors mb-4">
                            01
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Akuntansi
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kuasai pencatatan keuangan, perpajakan, hingga aplikasi akuntansi modern untuk menjadi tenaga keuangan yang teliti dan dipercaya.
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 02. Bisnis Daring dan Pemasaran --}}
                <a href="{{ route('jurusan.detail', 'bisnis-daring-dan-pemasaran') }}" class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block" data-category="bisnis">
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-200 group-hover:text-blue-200 transition-colors mb-4">
                            02
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Bisnis Daring dan Pemasaran
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Pelajari strategi pemasaran digital, pengelolaan toko online, dan kewirausahaan untuk berkembang di era ekonomi digital.
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 03. Manajemen Perkantoran --}}
                <a href="{{ route('jurusan.detail', 'manajemen-perkantoran') }}" class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block" data-category="bisnis">
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-200 group-hover:text-blue-200 transition-colors mb-4">
                            03
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Manajemen Perkantoran
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Latih keterampilan administrasi, komunikasi bisnis, dan pengelolaan dokumen berbasis teknologi.
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 04. Manajemen Logistik --}}
                <a href="{{ route('jurusan.detail', 'manajemen-logistik') }}" class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block" data-category="bisnis">
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-200 group-hover:text-blue-200 transition-colors mb-4">
                            04
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Manajemen Logistik
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Pahami pergudangan, distribusi, dan pengelolaan persediaan barang yang dibutuhkan setiap industri.
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 05. Rekayasa Perangkat Lunak --}}
                <a href="{{ route('jurusan.detail', 'rekayasa-perangkat-lunak') }}" class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block" data-category="teknologi">
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-200 group-hover:text-blue-200 transition-colors mb-4">
                            05
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Rekayasa Perangkat Lunak
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kembangkan aplikasi web, mobile, dan sistem digital melalui proyek nyata bersama calon inovator teknologi.
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 06. Teknik Komputer dan Jaringan --}}
                <a href="{{ route('jurusan.detail', 'teknik-komputer-dan-jaringan') }}" class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block" data-category="teknologi">
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-200 group-hover:text-blue-200 transition-colors mb-4">
                            06
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Teknik Komputer dan Jaringan
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kuasai perakitan komputer, infrastruktur jaringan, dan keamanan sistem untuk peran teknisi dan administrator jaringan.
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 07. Desain Komunikasi Visual --}}
                <a href="{{ route('jurusan.detail', 'desain-komunikasi-visual') }}" class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block" data-category="kreatif">
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-200 group-hover:text-blue-200 transition-colors mb-4">
                            07
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Desain Komunikasi Visual
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Asah kreativitas lewat desain grafis, ilustrasi, branding, dan konten visual yang punya pesan dan nilai.
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 08. Produksi Siaran Program Pertelevisian --}}
                <a href="{{ route('jurusan.detail', 'produksi-siaran-program-pertelevisian') }}" class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block" data-category="kreatif">
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-200 group-hover:text-blue-200 transition-colors mb-4">
                            08
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Produksi Siaran Program Pertelevisian
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Belajar menulis naskah, mengoperasikan kamera, menyunting video, hingga menyiarkan program.
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 09. Perhotelan --}}
                <a href="{{ route('jurusan.detail', 'perhotelan') }}" class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block" data-category="pariwisata">
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-200 group-hover:text-blue-200 transition-colors mb-4">
                            09
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Perhotelan
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kembangkan keahlian layanan tamu, tata graha, dan tata hidang berstandar industri hotel dan pariwisata.
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

            </section>
        </div>
    </main>

    {{-- ==================== RICH FOOTER (SMEAS IDENTITY) ==================== --}}
    <footer class="bg-[#023775] text-white pt-12 sm:pt-16 pb-8 border-t border-blue-900/60 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-start mb-12">

                {{-- Column 1: Map Vector Box / Location Visual --}}
                <div class="md:col-span-4 bg-white/5 p-2 rounded-2xl border border-white/10 backdrop-blur-xs">
                    <div class="relative w-full h-56 rounded-xl overflow-hidden bg-slate-200 border border-white/10 group">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.391219278278!2d112.73646547585098!3d-7.309880892698264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb9e5030e4ef%3A0x6b4ef84a73fc5268!2sSMK%20Negeri%201%20Surabaya!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi SMK Negeri 1 Surabaya"
                            class="w-full h-full filter saturate-90 contrast-105 group-hover:saturate-100 transition-all duration-300">
                        </iframe>
                    </div>
                    <div class="px-2 pt-2.5 pb-1 flex items-center justify-between text-xs text-blue-200/80">
                        <span class="inline-flex items-center gap-1.5 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            Jl. Smea No. 4, Wonokromo, Surabaya
                        </span>
                        <a href="https://maps.google.com/?q=SMK+Negeri+1+Surabaya" target="_blank" rel="noopener noreferrer" class="text-amber-400 hover:underline font-bold">
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
                        Sekolah Kejuruan di Surabaya, Jawa Timur yang berlokasi di Jl. Smea No. 4, Wonokromo Surabaya, SMK Negeri 1 Surabaya bertekad mencapai perbaikan yang berkesinambungan berdasarkan sistem manajemen mutu ISO 9001:2008.
                    </p>
                    <div class="space-y-1.5 text-xs text-blue-200/90 mb-5">
                        <p><strong class="text-white">Telp:</strong> 031-8292038</p>
                        <p><strong class="text-white">FAX:</strong> 031-8292039</p>
                        <p><strong class="text-white">Email:</strong> <a href="mailto:info@smkn1-sby.sch.id" class="text-amber-300 hover:underline">info@smkn1-sby.sch.id</a></p>
                    </div>

                    {{-- Social Media Icons --}}
                    <div class="flex items-center gap-3">
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram SMKN 1 Surabaya"
                            class="w-9 h-9 rounded-lg bg-white/10 hover:bg-amber-400 hover:text-slate-950 transition-all flex items-center justify-center text-white">
                            <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube SMKN 1 Surabaya"
                            class="w-9 h-9 rounded-lg bg-white/10 hover:bg-amber-400 hover:text-slate-950 transition-all flex items-center justify-center text-white">
                            <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
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
                            <a href="{{ route('pusat-karir.index') }}" class="hover:text-amber-400 transition-colors inline-flex items-center gap-2">
                                <span class="text-amber-400">&bull;</span> Pusat Karir
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('blud.index') }}" class="hover:text-amber-400 transition-colors inline-flex items-center gap-2">
                                <span class="text-amber-400">&bull;</span> BLUD
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('spmb.index') }}" class="hover:text-amber-400 transition-colors inline-flex items-center gap-2">
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

    {{-- Filter Interactive Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const cards = document.querySelectorAll('.jurusan-card');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const filter = btn.getAttribute('data-filter');

                    // Active state update
                    filterBtns.forEach(b => {
                        b.classList.remove('active', 'bg-[#0250a3]', 'text-white', 'border-[#0250a3]', 'shadow-md');
                        b.classList.add('text-slate-600', 'border-slate-200');
                    });

                    btn.classList.add('active');
                    btn.classList.remove('text-slate-600', 'border-slate-200');

                    // Filtering cards
                    cards.forEach(card => {
                        const cat = card.getAttribute('data-category');
                        if (filter === 'all' || cat === filter) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>

</body>

</html>
