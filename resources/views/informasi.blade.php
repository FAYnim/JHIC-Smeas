    <!DOCTYPE html>
    <html lang="id" class="scroll-smooth">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informasi — SMK Negeri 1 Surabaya</title>

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

            .event-card {
                transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .event-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 4px 6px -4px rgba(15, 23, 42, 0.04);
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
            'berandaUrl' => route('beranda'),
        ])

        <main class="flex-grow">
            {{-- ==================== HERO SECTION ==================== --}}
            <section
                class="relative bg-gradient-to-br from-[#024089] via-[#0452b0] to-[#013572] text-white pt-14 pb-28 md:pt-20 md:pb-36 overflow-hidden hero-banner-pattern">
                <div class="absolute inset-0 grid-pattern-overlay pointer-events-none"></div>
                <div
                    class="absolute -top-24 -right-24 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl pointer-events-none">
                </div>
                <div
                    class="absolute -bottom-20 -left-20 w-80 h-80 bg-amber-400/10 rounded-full blur-2xl pointer-events-none">
                </div>

                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <h1
                            class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-5 leading-[1.15]">
                            Event &amp; Informasi Terkini
                        </h1>

                        <div class="w-20 h-1.5 bg-gradient-to-r from-amber-400 to-amber-300 rounded-full mb-6"></div>

                        <p class="text-base sm:text-lg text-blue-100/90 font-normal leading-relaxed max-w-2xl">
                            Semua kabar terbaru dari SMK Negeri 1 Surabaya, mulai dari agenda kegiatan sampai capaian
                            siswa, dalam satu halaman.
                        </p>
                    </div>
                </div>
            </section>

            {{-- ==================== CONTENT CONTAINER ==================== --}}
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 md:-mt-20 z-10 pb-20">

                {{-- ==================== EVENT & CATEGORY SECTION ==================== --}}
                <section
                    class="bg-white rounded-2xl md:rounded-3xl shadow-[0_15px_40px_-10px_rgba(2,64,137,0.12)] border border-slate-100 p-4 sm:p-6 lg:p-8 mb-12 sm:mb-16">
                    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">

                        {{-- Category Sidebar --}}
                        <div class="lg:w-64 shrink-0">
                            <div
                                class="flex flex-row lg:flex-col gap-2 overflow-x-auto lg:overflow-visible pb-2 lg:pb-0">
                                {{-- Agenda Sekolah --}}
                                <a href="{{ route('informasi') }}#agenda"
                                    class="category-tab active flex items-center gap-3 px-4 py-3 rounded-xl text-left min-w-[160px] lg:min-w-0">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">Agenda Sekolah</div>
                                        <div class="text-xs text-slate-500">Jadwal kegiatan & event terbaru.</div>
                                    </div>
                                </a>

                                {{-- Prestasi --}}
                                <a href="{{ route('informasi.prestasi') }}"
                                    class="category-tab flex items-center gap-3 px-4 py-3 rounded-xl text-left min-w-[160px] lg:min-w-0">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.023 6.023 0 01-2.77.665 6.023 6.023 0 01-2.77-.665" />
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
                                    <div
                                        class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">Info Akademik</div>
                                        <div class="text-xs text-slate-500">Jadwal ujian & kalender belajar.</div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- Event List --}}
                        <div class="flex-1 space-y-4">
                            {{-- Event 1 --}}
                            <div
                                class="event-card flex items-center gap-4 sm:gap-5 p-4 sm:p-5 rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:border-blue-200">
                                <div
                                    class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl bg-white border border-slate-200 flex flex-col items-center justify-center shrink-0 shadow-xs">
                                    <span
                                        class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-none">18</span>
                                    <span
                                        class="text-[10px] sm:text-xs font-bold text-blue-600 uppercase tracking-wider">OKT</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug mb-1">Lomba
                                        Debat Bahasa Inggris Antar Kelas</h3>
                                    <p class="text-xs sm:text-sm text-slate-500">Aula Utama &middot; 08.00</p>
                                </div>
                            </div>

                            {{-- Event 2 --}}
                            <div
                                class="event-card flex items-center gap-4 sm:gap-5 p-4 sm:p-5 rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:border-blue-200">
                                <div
                                    class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl bg-white border border-slate-200 flex flex-col items-center justify-center shrink-0 shadow-xs">
                                    <span
                                        class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-none">22</span>
                                    <span
                                        class="text-[10px] sm:text-xs font-bold text-blue-600 uppercase tracking-wider">OKT</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug mb-1">
                                        Kunjungan Industri Jurusan RPL ke Perusahaan Teknologi</h3>
                                    <p class="text-xs sm:text-sm text-slate-500">Offsite &middot; 07.30</p>
                                </div>
                            </div>

                            {{-- Event 3 --}}
                            <div
                                class="event-card flex items-center gap-4 sm:gap-5 p-4 sm:p-5 rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:border-blue-200">
                                <div
                                    class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl bg-white border border-slate-200 flex flex-col items-center justify-center shrink-0 shadow-xs">
                                    <span
                                        class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-none">29</span>
                                    <span
                                        class="text-[10px] sm:text-xs font-bold text-blue-600 uppercase tracking-wider">OKT</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug mb-1">Seminar
                                        Karier &amp; Persiapan Dunia Kerja</h3>
                                    <p class="text-xs sm:text-sm text-slate-500">Aula Utama &middot; 09.00</p>
                                </div>
                            </div>

                            {{-- Event 4 --}}
                            <div
                                class="event-card flex items-center gap-4 sm:gap-5 p-4 sm:p-5 rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:border-blue-200">
                                <div
                                    class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl bg-white border border-slate-200 flex flex-col items-center justify-center shrink-0 shadow-xs">
                                    <span
                                        class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-none">05</span>
                                    <span
                                        class="text-[10px] sm:text-xs font-bold text-blue-600 uppercase tracking-wider">NOV</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug mb-1">Pentas
                                        Seni &amp; Pameran Karya Siswa</h3>
                                    <p class="text-xs sm:text-sm text-slate-500">Lapangan Sekolah &middot; 13.00</p>
                                </div>
                            </div>
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
                        <div class="berita-card group bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs hover:border-blue-300">
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
                    @empty
                        <p class="text-sm text-slate-500 col-span-3">Belum ada berita.</p>
                    @endforelse
                </section>
            </div>
        </main>

        {{-- ==================== FOOTER ==================== --}}
        <footer class="bg-[#023775] text-white pt-12 sm:pt-16 pb-8 border-t border-blue-900/60 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-start mb-12">

                    {{-- Column 1: Map --}}
                    <div class="md:col-span-4 bg-white/5 p-2 rounded-2xl border border-white/10 backdrop-blur-xs">
                        <div
                            class="relative w-full h-56 rounded-xl overflow-hidden bg-slate-200 border border-white/10 group">
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
                            Sekolah Kejuruan di Surabaya, Jawa Timur yang berlokasi di Jl. Smea No. 4, Wonokromo
                            Surabaya, SMK Negeri 1 Surabaya bertekad mencapai perbaikan yang berkesinambungan
                            berdasarkan sistem manajemen mutu ISO 9001:2008.
                        </p>
                        <div class="space-y-1.5 text-xs text-blue-200/90 mb-5">
                            <p><strong class="text-white">Telp:</strong> 031-8292038</p>
                            <p><strong class="text-white">FAX:</strong> 031-8292039</p>
                            <p><strong class="text-white">Email:</strong> <a href="mailto:info@smkn1-sby.sch.id"
                                    class="text-amber-300 hover:underline">info@smkn1-sby.sch.id</a></p>
                        </div>

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

                    {{-- Column 3: Jelajahi Smeas --}}
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

                <div class="pt-8 border-t border-white/10 text-center text-xs text-blue-200/70 font-medium">
                    &copy;{{ date('Y') }} | SMKN 1 Surabaya
                </div>
            </div>
        </footer>

        {{-- Category tab switching --}}


    </body>

    </html>
