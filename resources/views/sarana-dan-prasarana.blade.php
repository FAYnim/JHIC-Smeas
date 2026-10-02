<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarana & Prasarana — SMK Negeri 1 Surabaya</title>

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

        .facility-card {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .facility-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
        }

        .facility-card:hover .facility-icon {
            transform: scale(1.1);
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
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-5 leading-[1.15]">
                        Sarana &amp; Prasarana
                    </h1>
                    <div class="w-20 h-1.5 bg-gradient-to-r from-amber-400 to-amber-300 rounded-full mb-6"></div>
                    <p class="text-base sm:text-lg text-blue-100/90 font-normal leading-relaxed max-w-2xl">
                        Fasilitas lengkap yang mendukung kegiatan belajar mengajar dan pengembangan kompetensi siswa.
                    </p>
                </div>
            </div>
        </section>

        {{-- CONTENT --}}
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 md:-mt-20 z-10 pb-20">

            {{-- Fasilitas Pembelajaran --}}
            <div class="flex items-center gap-4 mb-8">
                <div class="w-3.5 h-8 bg-blue-600 rounded-full"></div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Fasilitas Pembelajaran</h2>
                    <p class="text-sm text-slate-500 font-medium">Ruang dan laboratorium untuk kegiatan akademik</p>
                </div>
            </div>

            @php
                $fasilitasPembelajaran = [
                    ['nama' => 'Ruang Kelas', 'icon' => 'building', 'desc' => 'Ruang kelas ber AC dengan kapasitas 32 siswa per kelas, dilengkapi proyektor dan papan tulis digital.', 'jumlah' => '72 Ruang'],
                    ['nama' => 'Lab Komputer', 'icon' => 'computer', 'desc' => 'Laboratorium komputer dengan perangkat terbaru untuk pembelajaran TIK, pemrograman, dan jaringan.', 'jumlah' => '6 Lab'],
                    ['nama' => 'Lab Akuntansi', 'icon' => 'calculator', 'desc' => 'Laboratorium khusus akuntansi dengan software MYOB dan Accurate untuk praktik pembukuan.', 'jumlah' => '2 Lab'],
                    ['nama' => 'Perpustakaan', 'icon' => 'book', 'desc' => 'Perpustakaan modern dengan koleksi buku, jurnal, dan akses e-learning untuk seluruh siswa.', 'jumlah' => '1 Gedung'],
                    ['nama' => 'Ruang Multimedia', 'icon' => 'film', 'desc' => 'Studio multimedia untuk pembelajaran desain, video editing, dan produksi konten digital.', 'jumlah' => '2 Ruang'],
                    ['nama' => 'Lab Bahasa', 'icon' => 'language', 'desc' => 'Laboratorium bahasa dengan sistem audio digital untuk pelatihan listening dan speaking.', 'jumlah' => '1 Lab'],
                ];
            @endphp

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-14">
                @foreach ($fasilitasPembelajaran as $item)
                    <div class="facility-card group bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs hover:border-blue-500">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="facility-icon w-14 h-14 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center shrink-0 group-hover:from-blue-600 group-hover:to-blue-700 transition-all duration-300">
                                @if ($item['icon'] === 'building')
                                    <svg class="w-7 h-7 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                @elseif ($item['icon'] === 'computer')
                                    <svg class="w-7 h-7 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                @elseif ($item['icon'] === 'calculator')
                                    <svg class="w-7 h-7 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                @elseif ($item['icon'] === 'book')
                                    <svg class="w-7 h-7 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                @elseif ($item['icon'] === 'film')
                                    <svg class="w-7 h-7 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                @else
                                    <svg class="w-7 h-7 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="text-base font-extrabold text-[#023775] mb-1 group-hover:text-blue-700 transition-colors">
                                    {{ $item['nama'] }}
                                </h3>
                                <span class="inline-block px-2 py-0.5 rounded-full bg-amber-400 text-slate-900 text-[10px] font-extrabold uppercase tracking-wider">
                                    {{ $item['jumlah'] }}
                                </span>
                            </div>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            {{ $item['desc'] }}
                        </p>
                    </div>
                @endforeach
            </section>

            {{-- Fasilitas Pendukung --}}
            <div class="flex items-center gap-4 mb-8">
                <div class="w-3.5 h-8 bg-amber-500 rounded-full"></div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Fasilitas Pendukung</h2>
                    <p class="text-sm text-slate-500 font-medium">Sarana pendukung kegiatan sekolah dan ekstrakurikuler</p>
                </div>
            </div>

            @php
                $fasilitasPendukung = [
                    ['nama' => 'Masjid Al-Ikhlas', 'icon' => 'mosque', 'desc' => 'Masjid sekolah untuk kegiatan ibadah dan pembinaan karakter religius siswa.'],
                    ['nama' => 'Aula Serbaguna', 'icon' => 'stage', 'desc' => 'Aula besar untuk upacara, seminar, pameran, dan kegiatan kemasyarakatan lainnya.'],
                    ['nama' => 'Lapangan Olahraga', 'icon' => 'sport', 'desc' => 'Lapangan basket, voli, dan futsal untuk kegiatan olahraga dan ekstrakurikuler.'],
                    ['nama' => 'Kantin Sekolah', 'icon' => 'food', 'desc' => 'Area makan yang bersih dan hygienis dengan berbagai pilihan makanan bergizi.'],
                    ['nama' => 'Ruang UKS', 'icon' => 'medical', 'desc' => 'Unit kesehatan sekolah dengan peralatan dasar untuk penanganan siswa yang sakit.'],
                    ['nama' => 'Parkir & Area Hijau', 'icon' => 'tree', 'desc' => 'Area parkir yang luas dan taman hijau yang asri untuk kenyamanan lingkungan sekolah.'],
                ];
            @endphp

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($fasilitasPendukung as $item)
                    <div class="facility-card group bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs hover:border-amber-500">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="facility-icon w-14 h-14 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 flex items-center justify-center shrink-0 group-hover:from-amber-500 group-hover:to-amber-600 transition-all duration-300">
                                @if ($item['icon'] === 'mosque')
                                    <svg class="w-7 h-7 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                                @elseif ($item['icon'] === 'stage')
                                    <svg class="w-7 h-7 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                @elseif ($item['icon'] === 'sport')
                                    <svg class="w-7 h-7 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                @elseif ($item['icon'] === 'food')
                                    <svg class="w-7 h-7 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                @elseif ($item['icon'] === 'medical')
                                    <svg class="w-7 h-7 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                @else
                                    <svg class="w-7 h-7 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="text-base font-extrabold text-[#023775] mb-1 group-hover:text-amber-700 transition-colors">
                                    {{ $item['nama'] }}
                                </h3>
                            </div>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            {{ $item['desc'] }}
                        </p>
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
