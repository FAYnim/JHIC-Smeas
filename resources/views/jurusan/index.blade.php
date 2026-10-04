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

<body
    class="bg-[#f8fafc] text-slate-800 antialiased flex flex-col min-h-screen selection:bg-amber-400 selection:text-slate-950">

    {{-- ==================== NAVBAR ==================== --}}
    @include('partials.navbar', [
        'activePage' => 'jurusan',
        'berandaUrl' => route('beranda'),
    ])

    <main class="flex-grow">
        {{-- ==================== HERO SECTION (BLUE BANNER WITH STAT COUNTERS) ==================== --}}
        <section
            class="relative bg-gradient-to-br from-[#024089] via-[#0452b0] to-[#013572] text-white pt-14 pb-28 md:pt-18 md:pb-36 overflow-hidden hero-banner-pattern">
            {{-- Subtle Background Grid & Glows --}}
            <div class="absolute inset-0 grid-pattern-overlay pointer-events-none"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute -bottom-20 -left-20 w-80 h-80 bg-amber-400/10 rounded-full blur-2xl pointer-events-none">
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-10">

                    {{-- Left Hero Description --}}
                    <div class="max-w-2xl">
                        <h1
                            class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-5 leading-[1.15]">
                            Profil Jurusan
                        </h1>

                        <div class="w-20 h-1.5 bg-gradient-to-r from-amber-400 to-amber-300 rounded-full mb-6"></div>

                        <p class="text-base sm:text-lg text-blue-100/90 font-normal leading-relaxed max-w-2xl">
                            Sembilan jurusan unggulan SMK Negeri 1 Surabaya siap membekali Anda dengan kompetensi nyata,
                            dari bisnis dan teknologi hingga kreativitas dan pelayanan. Pembelajaran berbasis praktik
                            dan selaras dengan kebutuhan industri membantu Anda meraih karier yang gemilang.
                        </p>
                    </div>

                    {{-- Right Stat Boxes (9 Jurusan, 4 Bidang Keahlian) --}}
                    <div class="flex items-center gap-4 sm:gap-6 self-start lg:self-center shrink-0">
                        {{-- White Card (9 Jurusan) --}}
                        <div
                            class="w-32 sm:w-38 h-32 sm:h-38 rounded-2xl bg-white shadow-xl shadow-blue-950/20 flex flex-col items-center justify-center text-center p-4 border border-white/20">
                            <span class="text-4xl sm:text-5xl font-black text-[#023775] leading-none mb-2">9</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-600">Jurusan</span>
                        </div>

                        {{-- Yellow Card (4 Bidang Keahlian) --}}
                        <div
                            class="w-32 sm:w-38 h-32 sm:h-38 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-500 shadow-xl shadow-amber-950/20 flex flex-col items-center justify-center text-center p-4 border border-amber-300/40 text-slate-950">
                            <span class="text-4xl sm:text-5xl font-black text-slate-950 leading-none mb-2">4</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-900 leading-tight">Bidang
                                Keahlian</span>
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
            <div
                class="bg-white rounded-2xl shadow-[0_10px_30px_-5px_rgba(2,64,137,0.08)] border border-slate-200/80 p-3 sm:p-4 mb-10 flex items-center justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                    <span class="text-xs sm:text-sm font-bold text-slate-500 px-3 py-1.5 hidden sm:inline-block">Filter
                        bidang:</span>

                    <button type="button" data-filter="all"
                        class="filter-btn active px-4 py-2 rounded-xl text-xs sm:text-sm font-bold border border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                        Semua
                    </button>
                    <button type="button" data-filter="bisnis"
                        class="filter-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                        Bisnis &amp; Manajemen
                    </button>
                    <button type="button" data-filter="teknologi"
                        class="filter-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                        Teknologi
                    </button>
                    <button type="button" data-filter="kreatif"
                        class="filter-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                        Kreatif &amp; Media
                    </button>
                    <button type="button" data-filter="pariwisata"
                        class="filter-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                        Pariwisata
                    </button>
                </div>
            </div>

            {{-- ===== JURUSAN GRID (3x3 CARDS) ===== --}}
            <section id="jurusan-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">

                {{-- 01. Akuntansi --}}
                <a href="{{ route('jurusan.detail', 'akuntansi') }}"
                    class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block"
                    data-category="bisnis">
                    <div>
                        <img src="{{ asset('images/logo-akl-removebg-preview.webp') }}" alt="Logo Akuntansi"
                            class="h-12 sm:h-14 w-auto object-contain mb-4">
                        <h2
                            class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Akuntansi
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kuasai pencatatan keuangan, perpajakan, hingga aplikasi akuntansi modern untuk menjadi
                            tenaga keuangan yang teliti dan dipercaya.
                        </p>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 02. Bisnis Daring dan Pemasaran --}}
                <a href="{{ route('jurusan.detail', 'bisnis-daring-dan-pemasaran') }}"
                    class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block"
                    data-category="bisnis">
                    <div>
                        <img src="{{ asset('images/logo-smeas.webp') }}" alt="Logo Bisnis Daring dan Pemasaran"
                            class="h-12 sm:h-14 w-auto object-contain mb-4">
                        <h2
                            class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Bisnis Daring dan Pemasaran
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Pelajari strategi pemasaran digital, pengelolaan toko online, dan kewirausahaan untuk
                            berkembang di era ekonomi digital.
                        </p>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 03. Manajemen Perkantoran --}}
                <a href="{{ route('jurusan.detail', 'manajemen-perkantoran') }}"
                    class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block"
                    data-category="bisnis">
                    <div>
                        <img src="{{ asset('images/logo-smeas.webp') }}" alt="Logo Manajemen Perkantoran"
                            class="h-12 sm:h-14 w-auto object-contain mb-4">
                        <h2
                            class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Manajemen Perkantoran
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Latih keterampilan administrasi, komunikasi bisnis, dan pengelolaan dokumen berbasis
                            teknologi.
                        </p>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 04. Manajemen Logistik --}}
                <a href="{{ route('jurusan.detail', 'manajemen-logistik') }}"
                    class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block"
                    data-category="bisnis">
                    <div>
                        <img src="{{ asset('images/logo-smeas.webp') }}" alt="Logo Manajemen Logistik"
                            class="h-12 sm:h-14 w-auto object-contain mb-4">
                        <h2
                            class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Manajemen Logistik
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Pahami pergudangan, distribusi, dan pengelolaan persediaan barang yang dibutuhkan setiap
                            industri.
                        </p>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 05. Rekayasa Perangkat Lunak --}}
                <a href="{{ route('jurusan.detail', 'rekayasa-perangkat-lunak') }}"
                    class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block"
                    data-category="teknologi">
                    <div>
                        <img src="{{ asset('images/logo-rpl.webp') }}" alt="Logo Rekayasa Perangkat Lunak"
                            class="h-12 sm:h-14 w-auto object-contain mb-4">
                        <h2
                            class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Rekayasa Perangkat Lunak
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kembangkan aplikasi web, mobile, dan sistem digital melalui proyek nyata bersama calon
                            inovator teknologi.
                        </p>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 06. Teknik Komputer dan Jaringan --}}
                <a href="{{ route('jurusan.detail', 'teknik-komputer-dan-jaringan') }}"
                    class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block"
                    data-category="teknologi">
                    <div>
                        <img src="{{ asset('images/logo-tkj.webp') }}" alt="Logo Teknik Komputer dan Jaringan"
                            class="h-12 sm:h-14 w-auto object-contain mb-4">
                        <h2
                            class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Teknik Komputer dan Jaringan
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kuasai perakitan komputer, infrastruktur jaringan, dan keamanan sistem untuk peran teknisi
                            dan administrator jaringan.
                        </p>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 07. Desain Komunikasi Visual --}}
                <a href="{{ route('jurusan.detail', 'desain-komunikasi-visual') }}"
                    class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block"
                    data-category="kreatif">
                    <div>
                        <img src="{{ asset('images/logo-dkv.webp') }}" alt="Logo Desain Komunikasi Visual"
                            class="h-12 sm:h-14 w-auto object-contain mb-4">
                        <h2
                            class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Desain Komunikasi Visual
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Asah kreativitas lewat desain grafis, ilustrasi, branding, dan konten visual yang punya
                            pesan dan nilai.
                        </p>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 08. Produksi Siaran Program Pertelevisian --}}
                <a href="{{ route('jurusan.detail', 'produksi-siaran-program-pertelevisian') }}"
                    class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block"
                    data-category="kreatif">
                    <div>
                        <img src="{{ asset('images/logo-pspt.webp') }}"
                            alt="Logo Produksi Siaran Program Pertelevisian"
                            class="h-12 sm:h-14 w-auto object-contain mb-4">
                        <h2
                            class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Produksi Siaran Program Pertelevisian
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Belajar menulis naskah, mengoperasikan kamera, menyunting video, hingga menyiarkan program.
                        </p>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                {{-- 09. Perhotelan --}}
                <a href="{{ route('jurusan.detail', 'perhotelan') }}"
                    class="jurusan-card group bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 flex flex-col justify-between shadow-xs block"
                    data-category="pariwisata">
                    <div>
                        <img src="{{ asset('images/logo-smeas.webp') }}" alt="Logo Perhotelan"
                            class="h-12 sm:h-14 w-auto object-contain mb-4">
                        <h2
                            class="text-xl sm:text-2xl font-black text-[#023775] mb-2 group-hover:text-blue-700 transition-colors">
                            Perhotelan
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kembangkan keahlian layanan tamu, tata graha, dan tata hidang berstandar industri hotel dan
                            pariwisata.
                        </p>
                    </div>
                    <div
                        class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs sm:text-sm font-bold text-blue-600">
                        <span class="group-hover:underline">Lihat detail jurusan</span>
                        <svg class="arrow-icon w-4 h-4 transition-transform duration-200" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

            </section>
        </div>
    </main>

    {{-- ==================== RICH FOOTER (SMEAS IDENTITY) ==================== --}}
    @include('partials.footer')
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
                        b.classList.remove('active', 'bg-[#0250a3]', 'text-white',
                            'border-[#0250a3]', 'shadow-md');
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
