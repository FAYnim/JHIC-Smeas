<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guru & Tenaga Kependidikan — SMK Negeri 1 Surabaya</title>

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

        .staff-card {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .staff-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
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
                        Guru &amp; Tenaga Kependidikan
                    </h1>
                    <div class="w-20 h-1.5 bg-gradient-to-r from-amber-400 to-amber-300 rounded-full mb-6"></div>
                    <p class="text-base sm:text-lg text-blue-100/90 font-normal leading-relaxed max-w-2xl">
                        Tenaga pendidik dan kependidikan profesional yang berdedikasi dalam mencerdaskan kehidupan bangsa.
                    </p>
                </div>
            </div>
        </section>

        {{-- CONTENT --}}
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 md:-mt-20 z-10 pb-20">

            {{-- Guru --}}
            <div class="flex items-center gap-4 mb-8">
                <div class="w-3.5 h-8 bg-blue-600 rounded-full"></div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Guru</h2>
                    <p class="text-sm text-slate-500 font-medium">Guru produktur dan guru umum SMK Negeri 1 Surabaya</p>
                </div>
            </div>

            @php
                $guru = [
                    ['nama' => 'Yourini Erawati, S.Pd., M.M.', 'jabatan' => 'Ketua Program Akuntansi', 'mapel' => 'Akuntansi', 'warna' => 'from-blue-500 to-blue-700'],
                    ['nama' => 'Dra. Hj. Siti Aminah, M.M.', 'jabatan' => 'WKS Kurikulum', 'mapel' => 'Matematika', 'warna' => 'from-emerald-500 to-emerald-700'],
                    ['nama' => 'Rudi Hartono, S.Pd.', 'jabatan' => 'Guru Produktif', 'mapel' => 'TIK & Jaringan', 'warna' => 'from-violet-500 to-violet-700'],
                    ['nama' => 'Dewi Kartika, S.Pd.', 'jabatan' => 'Guru Produktif', 'mapel' => 'Perhotelan', 'warna' => 'from-rose-500 to-rose-700'],
                    ['nama' => 'Ahmad Fauzi, S.Kom.', 'jabatan' => 'Guru Produktif', 'mapel' => 'Pemrograman', 'warna' => 'from-amber-500 to-amber-700'],
                    ['nama' => 'Sri Wahyuni, S.Pd.', 'jabatan' => 'Guru Umum', 'mapel' => 'Bahasa Indonesia', 'warna' => 'from-cyan-500 to-cyan-700'],
                    ['nama' => 'Budi Santoso, S.Pd.', 'jabatan' => 'Guru Umum', 'mapel' => 'Bahasa Inggris', 'warna' => 'from-indigo-500 to-indigo-700'],
                    ['nama' => 'Rina Marlina, S.Pd.', 'jabatan' => 'Guru Umum', 'mapel' => 'PJOK', 'warna' => 'from-teal-500 to-teal-700'],
                    ['nama' => 'Hendra Wijaya, S.Pd.', 'jabatan' => 'Guru Produktif', 'mapel' => 'Otomotif', 'warna' => 'from-orange-500 to-orange-700'],
                    ['nama' => 'Nina Agustina, S.E.', 'jabatan' => 'Guru Produktif', 'mapel' => 'Bisnis Digital', 'warna' => 'from-pink-500 to-pink-700'],
                    ['nama' => 'Dedi Kurniawan, S.Kom.', 'jabatan' => 'Guru Produktif', 'mapel' => 'Jaringan Komputer', 'warna' => 'from-sky-500 to-sky-700'],
                    ['nama' => 'Putri Handayani, S.Pd.', 'jabatan' => 'Guru Umum', 'mapel' => 'IPS', 'warna' => 'from-lime-500 to-lime-700'],
                ];
            @endphp

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-14">
                @foreach ($guru as $item)
                    <div class="staff-card group bg-white rounded-2xl border border-slate-200/80 p-5 text-center shadow-xs hover:border-blue-500">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br {{ $item['warna'] }} flex items-center justify-center mx-auto mb-4 ring-2 ring-white shadow-md group-hover:scale-105 transition-transform">
                            <span class="text-white font-bold text-lg">
                                {{ strtoupper(substr(explode(' ', $item['nama'])[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', $item['nama'])[1] ?? '', 0, 1)) }}
                            </span>
                        </div>
                        <h3 class="text-sm font-extrabold text-[#023775] mb-1 leading-snug">{{ $item['nama'] }}</h3>
                        <p class="text-[11px] text-slate-400 font-semibold mb-2">{{ $item['jabatan'] }}</p>
                        <span class="inline-block px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-100">
                            {{ $item['mapel'] }}
                        </span>
                    </div>
                @endforeach
            </section>

            {{-- Tenaga Kependidikan --}}
            <div class="flex items-center gap-4 mb-8">
                <div class="w-3.5 h-8 bg-amber-500 rounded-full"></div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Tenaga Kependidikan</h2>
                    <p class="text-sm text-slate-500 font-medium">Staf administrasi dan pendukung operasional sekolah</p>
                </div>
            </div>

            @php
                $tendik = [
                    ['nama' => 'Eko Prasetyo', 'jabatan' => 'Kepala Tata Usaha', 'unit' => 'Tata Usaha', 'warna' => 'from-slate-500 to-slate-700'],
                    ['nama' => 'Mariatul Kiftiah', 'jabatan' => 'Bendahara', 'unit' => 'Keuangan', 'warna' => 'from-rose-500 to-rose-700'],
                    ['nama' => 'Sugeng Riyadi', 'jabatan' => 'Operator Sekolah', 'unit' => 'TIK', 'warna' => 'from-violet-500 to-violet-700'],
                    ['nama' => 'Tri Wahyuni', 'jabatan' => 'Staff Kurikulum', 'unit' => 'Kurikulum', 'warna' => 'from-emerald-500 to-emerald-700'],
                    ['nama' => 'Ari Supriyono', 'jabatan' => 'Kepala Perpustakaan', 'unit' => 'Perpustakaan', 'warna' => 'from-amber-500 to-amber-700'],
                    ['nama' => 'Dwi Fatimah', 'jabatan' => 'Staff Kesiswaan', 'unit' => 'Kesiswaan', 'warna' => 'from-cyan-500 to-cyan-700'],
                    ['nama' => 'Bambang Setiawan', 'jabatan' => 'Teknisi', 'unit' => 'Sarpras', 'warna' => 'from-indigo-500 to-indigo-700'],
                    ['nama' => 'Lestari', 'jabatan' => 'Pustakawan', 'unit' => 'Perpustakaan', 'warna' => 'from-pink-500 to-pink-700'],
                ];
            @endphp

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($tendik as $item)
                    <div class="staff-card group bg-white rounded-2xl border border-slate-200/80 p-5 text-center shadow-xs hover:border-amber-500">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br {{ $item['warna'] }} flex items-center justify-center mx-auto mb-4 ring-2 ring-white shadow-md group-hover:scale-105 transition-transform">
                            <span class="text-white font-bold text-lg">
                                {{ strtoupper(substr(explode(' ', $item['nama'])[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', $item['nama'])[1] ?? '', 0, 1)) }}
                            </span>
                        </div>
                        <h3 class="text-sm font-extrabold text-[#023775] mb-1 leading-snug">{{ $item['nama'] }}</h3>
                        <p class="text-[11px] text-slate-400 font-semibold mb-2">{{ $item['jabatan'] }}</p>
                        <span class="inline-block px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-[11px] font-bold border border-amber-100">
                            {{ $item['unit'] }}
                        </span>
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
