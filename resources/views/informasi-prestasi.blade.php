<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestasi — SMK Negeri 1 Surabaya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

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

        .category-tab {
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .category-tab:hover {
            background-color: #f1f5f9;
        }

        .category-tab.active {
            background-color: #eff6ff;
            border-left-color: #fbbf24;
        }

        .filter-pill {
            transition: all 0.2s ease;
        }

        .filter-pill:hover {
            border-color: #93c5fd;
            color: #1d4ed8;
        }

        .filter-pill.active {
            background-color: #024089;
            border-color: #024089;
            color: #ffffff;
        }

        .prestasi-card {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .prestasi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 4px 6px -4px rgba(15, 23, 42, 0.04);
        }

        .prestasi-card.is-hidden {
            display: none;
        }

        .berita-card {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .berita-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.1), 0 8px 10px -6px rgba(15, 23, 42, 0.05);
        }

        .berita-card:hover .berita-img {
            transform: scale(1.05);
        }

        .berita-img {
            transition: transform 0.4s ease;
        }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased flex flex-col min-h-screen">

    @include('partials.navbar', [
        'activePage' => 'informasi',
        'berandaUrl' => route('beranda')
    ])

    <main class="flex-grow">
        {{-- ==================== HERO SECTION ==================== --}}
        <section class="relative bg-gradient-to-br from-[#024089] via-[#0452b0] to-[#013572] text-white pt-14 pb-28 md:pt-20 md:pb-36 overflow-hidden hero-banner-pattern">
            <div class="absolute inset-0 grid-pattern-overlay pointer-events-none"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-amber-400/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-5 leading-[1.15]">
                        Event &amp; Informasi Terkini
                    </h1>

                    <div class="w-20 h-1.5 bg-gradient-to-r from-amber-400 to-amber-300 rounded-full mb-6"></div>

                    <p class="text-base sm:text-lg text-blue-100/90 font-normal leading-relaxed max-w-2xl">
                        Semua kabar terbaru dari SMK Negeri 1 Surabaya, mulai dari agenda kegiatan sampai capaian siswa, dalam satu halaman.
                    </p>
                </div>
            </div>
        </section>

        {{-- ==================== CONTENT CONTAINER ==================== --}}
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 md:-mt-20 z-10 pb-20">

            {{-- ==================== EVENT & CATEGORY SECTION ==================== --}}
            <section class="bg-white rounded-2xl md:rounded-3xl shadow-[0_15px_40px_-10px_rgba(2,64,137,0.12)] border border-slate-100 p-4 sm:p-6 lg:p-8 mb-12 sm:mb-16">
                <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">

                    {{-- Category Sidebar --}}
                    <div class="lg:w-64 shrink-0">
                        <div class="flex flex-row lg:flex-col gap-2 overflow-x-auto lg:overflow-visible pb-2 lg:pb-0">
                            {{-- Agenda Sekolah --}}
                            <a href="{{ route('informasi') }}"
                                class="category-tab flex items-center gap-3 px-4 py-3 rounded-xl text-left min-w-[160px] lg:min-w-0">
                                <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900">Agenda Sekolah</div>
                                    <div class="text-xs text-slate-500">Jadwal kegiatan & event terbaru.</div>
                                </div>
                            </a>

                            {{-- Prestasi --}}
                            <a href="{{ route('informasi.prestasi') }}"
                                class="category-tab active flex items-center gap-3 px-4 py-3 rounded-xl text-left min-w-[160px] lg:min-w-0">
                                <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.023 6.023 0 01-2.77.665 6.023 6.023 0 01-2.77-.665" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900">Prestasi</div>
                                    <div class="text-xs text-slate-500">Capaian siswa & sekolah.</div>
                                </div>
                            </a>



                            {{-- Info Akademik --}}
                            <a href="{{ route('informasi.akademik') }}"
                                class="category-tab flex items-center gap-3 px-4 py-3 rounded-xl text-left min-w-[160px] lg:min-w-0">
                                <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900">Info Akademik</div>
                                    <div class="text-xs text-slate-500">Jadwal ujian & kalender belajar.</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- Prestasi Content --}}
                    <div class="flex-1 space-y-6">

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="bg-[#024089] rounded-2xl px-6 py-7 text-center text-white shadow-[0_10px_28px_-8px_rgba(2,64,137,0.35)]">
                                <div class="text-4xl font-extrabold text-amber-400 leading-none mb-2">42+</div>
                                <div class="text-sm text-blue-100/90 font-medium">Total Prestasi 2024–2026</div>
                            </div>
                            <div class="bg-slate-50 rounded-2xl border border-slate-200/80 px-6 py-7 text-center">
                                <div class="text-4xl font-extrabold text-[#024089] leading-none mb-2">9</div>
                                <div class="text-sm text-slate-500 font-medium">Prestasi Tingkat Nasional</div>
                            </div>
                            <div class="bg-slate-50 rounded-2xl border border-slate-200/80 px-6 py-7 text-center">
                                <div class="text-4xl font-extrabold text-[#024089] leading-none mb-2">9</div>
                                <div class="text-sm text-slate-500 font-medium">Jurusan Berkontribusi</div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2" id="prestasi-filters">
                            <button type="button" data-filter="semua"
                                class="filter-pill active px-4 py-2 rounded-full border border-slate-200 bg-white text-sm font-semibold text-slate-600">
                                Semua
                            </button>
                            <button type="button" data-filter="nasional"
                                class="filter-pill px-4 py-2 rounded-full border border-slate-200 bg-white text-sm font-semibold text-slate-600">
                                Nasional
                            </button>
                            <button type="button" data-filter="provinsi"
                                class="filter-pill px-4 py-2 rounded-full border border-slate-200 bg-white text-sm font-semibold text-slate-600">
                                Provinsi
                            </button>
                            <button type="button" data-filter="kota"
                                class="filter-pill px-4 py-2 rounded-full border border-slate-200 bg-white text-sm font-semibold text-slate-600">
                                Kota
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="prestasi-grid">

                            <article data-level="nasional" class="prestasi-card bg-slate-50/50 rounded-xl border border-slate-200/80 p-5 hover:bg-white hover:border-blue-200">
                                <div class="text-xs font-bold text-slate-400 tracking-wide mb-3">2026</div>
                                <div class="w-11 h-11 rounded-xl bg-amber-400 flex items-center justify-center mb-4">
                                    <svg class="w-5 h-5 text-[#024089]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.023 6.023 0 01-2.77.665 6.023 6.023 0 01-2.77-.665" />
                                    </svg>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug mb-1">Juara 1 — LKS Akuntansi Tingkat Nasional</h3>
                                <p class="text-xs sm:text-sm text-slate-500">Jurusan Akuntansi</p>
                            </article>

                            <article data-level="provinsi" class="prestasi-card bg-slate-50/50 rounded-xl border border-slate-200/80 p-5 hover:bg-white hover:border-blue-200">
                                <div class="text-xs font-bold text-slate-400 tracking-wide mb-3">2025</div>
                                <div class="w-11 h-11 rounded-xl bg-amber-400 flex items-center justify-center mb-4">
                                    <svg class="w-5 h-5 text-[#024089]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.023 6.023 0 01-2.77.665 6.023 6.023 0 01-2.77-.665" />
                                    </svg>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug mb-1">Juara 1 — Accounting Competition Jawa Timur</h3>
                                <p class="text-xs sm:text-sm text-slate-500">Jurusan Akuntansi</p>
                            </article>

                            <article data-level="kota" class="prestasi-card bg-slate-50/50 rounded-xl border border-slate-200/80 p-5 hover:bg-white hover:border-blue-200">
                                <div class="text-xs font-bold text-slate-400 tracking-wide mb-3">2025</div>
                                <div class="w-11 h-11 rounded-xl bg-amber-400 flex items-center justify-center mb-4">
                                    <svg class="w-5 h-5 text-[#024089]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.023 6.023 0 01-2.77.665 6.023 6.023 0 01-2.77-.665" />
                                    </svg>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug mb-1">Juara 2 — Lomba Debat Bahasa Inggris Kota Surabaya</h3>
                                <p class="text-xs sm:text-sm text-slate-500">Jurusan Umum</p>
                            </article>

                            <article data-level="provinsi" class="prestasi-card bg-slate-50/50 rounded-xl border border-slate-200/80 p-5 hover:bg-white hover:border-blue-200">
                                <div class="text-xs font-bold text-slate-400 tracking-wide mb-3">2025</div>
                                <div class="w-11 h-11 rounded-xl bg-amber-400 flex items-center justify-center mb-4">
                                    <svg class="w-5 h-5 text-[#024089]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.023 6.023 0 01-2.77.665 6.023 6.023 0 01-2.77-.665" />
                                    </svg>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug mb-1">Juara 1 — LKS Desain Komunikasi Visual</h3>
                                <p class="text-xs sm:text-sm text-slate-500">Jurusan DKV</p>
                            </article>

                            <article data-level="nasional" class="prestasi-card bg-slate-50/50 rounded-xl border border-slate-200/80 p-5 hover:bg-white hover:border-blue-200">
                                <div class="text-xs font-bold text-slate-400 tracking-wide mb-3">2024</div>
                                <div class="w-11 h-11 rounded-xl bg-amber-400 flex items-center justify-center mb-4">
                                    <svg class="w-5 h-5 text-[#024089]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.023 6.023 0 01-2.77.665 6.023 6.023 0 01-2.77-.665" />
                                    </svg>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug mb-1">Juara 1 — Kompetisi Jaringan & Keamanan Siber</h3>
                                <p class="text-xs sm:text-sm text-slate-500">Jurusan TKJ</p>
                            </article>

                            <article data-level="provinsi" class="prestasi-card bg-slate-50/50 rounded-xl border border-slate-200/80 p-5 hover:bg-white hover:border-blue-200">
                                <div class="text-xs font-bold text-slate-400 tracking-wide mb-3">2024</div>
                                <div class="w-11 h-11 rounded-xl bg-amber-400 flex items-center justify-center mb-4">
                                    <svg class="w-5 h-5 text-[#024089]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.023 6.023 0 01-2.77.665 6.023 6.023 0 01-2.77-.665" />
                                    </svg>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug mb-1">Juara 3 — Lomba Inovasi Aplikasi Siswa SMK</h3>
                                <p class="text-xs sm:text-sm text-slate-500">Jurusan RPL</p>
                            </article>

                        </div>

                        <p id="prestasi-empty" class="hidden text-center text-sm text-slate-500 py-8">
                            Belum ada prestasi pada tingkat ini.
                        </p>

                    </div>

                </div>
            </section>

            {{-- ==================== BERITA TERBARU SECTION ==================== --}}
            <div class="flex items-center gap-4 mb-8 sm:mb-10">
                <div class="w-3.5 h-8 bg-blue-600 rounded-full"></div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Berita Terbaru
                    </h2>
                </div>
            </div>

            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @forelse ($artikels as $artikel)
                    <a href="{{ route('pusat-karir.detail-artikel', $artikel->slug) }}" class="block group">
                        <div class="berita-card bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs hover:border-blue-300">
                            <div class="aspect-[16/10] overflow-hidden bg-slate-200">
                                @if ($artikel->image_path)
                                    <img src="{{ asset('storage/' . $artikel->image_path) }}" alt="{{ $artikel->title }}" class="berita-img w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-slate-200 to-slate-300"></div>
                                @endif
                            </div>
                            <div class="p-5 sm:p-6">
                                <h3 class="text-base font-bold text-slate-900 leading-snug group-hover:text-blue-700 transition-colors">
                                    {{ $artikel->title }}
                                </h3>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-slate-500 col-span-3">Belum ada artikel prestasi.</p>
                @endforelse
            </section>
        </div>
    </main>

    {{-- ==================== FOOTER ==================== --}}
    @include('partials.footer')
<script>
        document.addEventListener('DOMContentLoaded', () => {
            const pills = document.querySelectorAll('#prestasi-filters .filter-pill');
            const cards = document.querySelectorAll('#prestasi-grid .prestasi-card');
            const empty = document.getElementById('prestasi-empty');

            pills.forEach(pill => {
                pill.addEventListener('click', () => {
                    const filter = pill.dataset.filter;
                    pills.forEach(p => p.classList.remove('active'));
                    pill.classList.add('active');

                    let visible = 0;
                    cards.forEach(card => {
                        const match = filter === 'semua' || card.dataset.level === filter;
                        card.classList.toggle('is-hidden', !match);
                        if (match) visible += 1;
                    });

                    if (empty) empty.classList.toggle('hidden', visible > 0);
                });
            });
        });
    </script>

</body>

</html>
