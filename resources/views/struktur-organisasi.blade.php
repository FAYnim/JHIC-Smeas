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
        'berandaUrl' => route('beranda')
    ])

    <main class="flex-grow">
        {{-- HERO --}}
        <section class="relative bg-gradient-to-br from-[#024089] via-[#0452b0] to-[#013572] text-white pt-14 pb-28 md:pt-20 md:pb-36 overflow-hidden hero-banner-pattern">
            <div class="absolute inset-0 grid-pattern-overlay pointer-events-none"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-amber-400/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
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
            @if ($kepala)
            <section class="bg-white rounded-2xl md:rounded-3xl shadow-[0_15px_40px_-10px_rgba(2,64,137,0.12)] border border-slate-100 p-6 sm:p-8 lg:p-12 mb-8">
                <div class="flex flex-col items-center text-center">
                    @if ($kepala->foto_url)
                        <div class="w-28 h-28 rounded-full overflow-hidden shadow-lg shadow-blue-600/20 mb-5 ring-4 ring-amber-400/30">
                            <img src="{{ $kepala->foto_url }}" alt="{{ $kepala->nama }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-28 h-28 rounded-full bg-gradient-to-br from-[#024089] to-[#013572] flex items-center justify-center shadow-lg shadow-blue-600/20 mb-5 ring-4 ring-amber-400/30">
                            <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="inline-block px-3 py-1 rounded-full bg-amber-400 text-slate-900 text-xs font-extrabold uppercase tracking-wider mb-3">
                        {{ $kepala->jabatan ?: 'Kepala Sekolah' }}
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-[#023775] mb-1">
                        {{ $kepala->nama }}
                    </h2>
                    @if ($kepala->nip)
                        <p class="text-sm text-slate-500 font-medium">NIP. {{ $kepala->nip }}</p>
                    @endif
                </div>
            </section>
            @endif

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
    @include('partials.footer')
</body>

</html>
