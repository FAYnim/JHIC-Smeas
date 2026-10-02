<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi — SMK Negeri 1 Surabaya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
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

        .org-card {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .org-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
        }

        .connector-line {
            position: relative;
        }

        .connector-line::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 2px;
            height: 24px;
            background: linear-gradient(to bottom, #024089, #93c5fd);
            transform: translateX(-50%);
        }

        .connector-line-h {
            position: relative;
        }

        .connector-line-h::before {
            content: '';
            position: absolute;
            top: -12px;
            left: 25%;
            width: 50%;
            height: 2px;
            background: linear-gradient(to right, #93c5fd, #024089, #93c5fd);
        }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased flex flex-col min-h-screen">

    @include('partials.navbar', [
        'activePage' => 'profil',
        'berandaUrl' => route('pusat-karir.index')
    ])

    <main class="flex-grow">
        {{-- HERO --}}
        <section class="relative bg-gradient-to-br from-[#024089] via-[#0452b0] to-[#013572] text-white pt-14 pb-28 md:pt-20 md:pb-36 overflow-hidden hero-banner-pattern">
            <div class="absolute inset-0 grid-pattern-overlay pointer-events-none"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-amber-400/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-amber-300 text-xs sm:text-sm font-bold tracking-wider uppercase mb-5">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        SMK NEGERI 1 SURABAYA
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-5 leading-[1.15]">
                        Struktur Organisasi
                    </h1>
                    <div class="w-20 h-1.5 bg-gradient-to-r from-amber-400 to-amber-300 rounded-full mb-6"></div>
                    <p class="text-base sm:text-lg text-blue-100/90 font-normal leading-relaxed max-w-2xl">
                        Hierarki dan susunan pimpinan SMK Negeri 1 Surabaya dalam menjalankan visi dan misi sekolah.
                    </p>
                </div>
            </div>
        </section>

        {{-- CONTENT --}}
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 md:-mt-20 z-10 pb-20">

            {{-- Kepala Sekolah --}}
            <section class="bg-white rounded-2xl md:rounded-3xl shadow-[0_15px_40px_-10px_rgba(2,64,137,0.12)] border border-slate-100 p-6 sm:p-8 lg:p-12 mb-8">
                <div class="flex flex-col items-center text-center">
                    <div class="w-28 h-28 rounded-full bg-gradient-to-br from-[#024089] to-[#013572] flex items-center justify-center shadow-lg shadow-blue-600/20 mb-5 ring-4 ring-amber-400/30">
                        <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="inline-block px-3 py-1 rounded-full bg-amber-400 text-slate-900 text-xs font-extrabold uppercase tracking-wider mb-3">
                        Kepala Sekolah
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-[#023775] mb-1">
                        Drs. H. Bambang Wijanarko, M.M.
                    </h2>
                    <p class="text-sm text-slate-500 font-medium">NIP. 19660415 199203 1 004</p>
                </div>
            </section>

            {{-- Wakil Kepala Sekolah --}}
            <div class="flex items-center gap-4 mb-8">
                <div class="w-3.5 h-8 bg-blue-600 rounded-full"></div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Wakil Kepala Sekolah
                    </h2>
                    <p class="text-sm text-slate-500 font-medium">Tim pimpinan yang membantu mengelola bidang akademik dan non-akademik</p>
                </div>
            </div>

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @foreach ($wakil as $item)
                    <div class="org-card group bg-white rounded-2xl border border-slate-200/80 p-6 text-center shadow-xs hover:border-blue-500">
                        @if ($item->foto_url)
                            <div class="w-20 h-20 rounded-full overflow-hidden mx-auto mb-4 ring-2 ring-slate-100 group-hover:ring-blue-300 transition-all">
                                <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center mx-auto mb-4 ring-2 ring-slate-100 group-hover:ring-blue-300 transition-all">
                                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                        @if ($item->bidang)
                            <div class="inline-block px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-[11px] font-bold uppercase tracking-wider mb-3 border border-blue-100">
                                {{ $item->bidang }}
                            </div>
                        @endif
                        <h3 class="text-sm font-extrabold text-[#023775] mb-1 leading-snug">
                            {{ $item->nama }}
                        </h3>
                        @if ($item->nip)
                            <p class="text-[11px] text-slate-400 font-medium">NIP. {{ $item->nip }}</p>
                        @endif
                    </div>
                @endforeach
            </section>

            {{-- Struktur Organisasi Visual --}}
            <div class="flex items-center gap-4 mb-8">
                <div class="w-3.5 h-8 bg-blue-600 rounded-full"></div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Bagian & Unit
                    </h2>
                    <p class="text-sm text-slate-500 font-medium">Unit kerja pendukung dalam struktur organisasi sekolah</p>
                </div>
            </div>

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($bagian as $item)
                    <div class="org-card group bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs hover:border-blue-500">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center shrink-0 group-hover:from-blue-600 group-hover:to-blue-700 transition-all duration-300">
                                @if ($item->icon === 'document-text')
                                    <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                @elseif ($item->icon === 'currency-dollar')
                                    <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @elseif ($item->icon === 'academic-cap')
                                    <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                @elseif ($item->icon === 'user-group')
                                    <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                @elseif ($item->icon === 'building-office')
                                    <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                @else
                                    <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-[#023775] mb-1 group-hover:text-blue-700 transition-colors">
                                    {{ $item->nama }}
                                </h3>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    {{ $item->deskripsi }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#023775] text-white pt-12 sm:pt-16 pb-8 border-t border-blue-900/60 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-start mb-12">
                <div class="md:col-span-4 bg-white/5 p-2 rounded-2xl border border-white/10 backdrop-blur-xs">
                    <div class="relative w-full h-56 rounded-xl overflow-hidden bg-slate-200 border border-white/10 group">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.391219278278!2d112.73646547585098!3d-7.309880892698264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb9e5030e4ef%3A0x6b4ef84a73fc5268!2sSMK%20Negeri%201%20Surabaya!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi SMK Negeri 1 Surabaya" class="w-full h-full filter saturate-90 contrast-105 group-hover:saturate-100 transition-all duration-300"></iframe>
                    </div>
                    <div class="px-2 pt-2.5 pb-1 flex items-center justify-between text-xs text-blue-200/80">
                        <span class="inline-flex items-center gap-1.5 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            Jl. Smea No. 4, Wonokromo, Surabaya
                        </span>
                        <a href="https://maps.google.com/?q=SMK+Negeri+1+Surabaya" target="_blank" rel="noopener noreferrer" class="text-amber-400 hover:underline font-bold">Buka Peta &rarr;</a>
                    </div>
                </div>

                <div class="md:col-span-5 text-sm leading-relaxed text-blue-100/90">
                    <h3 class="text-2xl font-extrabold text-amber-400 mb-4 tracking-tight">Tentang Kami</h3>
                    <p class="mb-4 text-justify">Sekolah Kejuruan di Surabaya, Jawa Timur yang berlokasi di Jl. Smea No. 4, Wonokromo Surabaya, SMK Negeri 1 Surabaya bertekad mencapai perbaikan yang berkesinambungan berdasarkan sistem manajemen mutu ISO 9001:2008.</p>
                    <div class="space-y-1.5 text-xs text-blue-200/90 mb-5">
                        <p><strong class="text-white">Telp:</strong> 031-8292038</p>
                        <p><strong class="text-white">FAX:</strong> 031-8292039</p>
                        <p><strong class="text-white">Email:</strong> <a href="mailto:info@smkn1-sby.sch.id" class="text-amber-300 hover:underline">info@smkn1-sby.sch.id</a></p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram SMKN 1 Surabaya" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-amber-400 hover:text-slate-950 transition-all flex items-center justify-center text-white">
                            <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube SMKN 1 Surabaya" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-amber-400 hover:text-slate-950 transition-all flex items-center justify-center text-white">
                            <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="md:col-span-3 border-l-2 border-amber-400 pl-6 sm:pl-8 py-1">
                    <h3 class="text-2xl font-extrabold text-amber-400 mb-4 tracking-tight">Jelajahi Smeas</h3>
                    <ul class="space-y-3 text-sm font-semibold text-blue-100">
                        <li><a href="{{ route('pusat-karir.index') }}" class="hover:text-amber-400 transition-colors inline-flex items-center gap-2"><span class="text-amber-400">&bull;</span> Pusat Karir</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors inline-flex items-center gap-2"><span class="text-amber-400">&bull;</span> BLUD</a></li>
                        <li><a href="{{ route('spmb.index') }}" class="hover:text-amber-400 transition-colors inline-flex items-center gap-2"><span class="text-amber-400">&bull;</span> PPDB / SPMB</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-white/10 text-center text-xs text-blue-200/70 font-medium">
                &copy;{{ date('Y') }} | SMKN 1 Surabaya
            </div>
        </div>
    </footer>

</body>

</html>
