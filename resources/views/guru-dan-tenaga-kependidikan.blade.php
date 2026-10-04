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

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-14">
                @foreach ($guru as $item)
                    <div class="staff-card group bg-white rounded-2xl border border-slate-200/80 p-5 text-center shadow-xs hover:border-blue-500">
                        @if ($item->foto_url)
                            <div class="w-16 h-16 rounded-full overflow-hidden mx-auto mb-4 ring-2 ring-white shadow-md group-hover:scale-105 transition-transform">
                                <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br {{ $item->warna ?: 'from-blue-500 to-blue-700' }} flex items-center justify-center mx-auto mb-4 ring-2 ring-white shadow-md group-hover:scale-105 transition-transform">
                                <span class="text-white font-bold text-lg">
                                    {{ $item->initials }}
                                </span>
                            </div>
                        @endif
                        <h3 class="text-sm font-extrabold text-[#023775] mb-1 leading-snug">{{ $item->nama }}</h3>
                        <p class="text-[11px] text-slate-400 font-semibold mb-2">{{ $item->jabatan }}</p>
                        @if ($item->mapel)
                            <span class="inline-block px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-100">
                                {{ $item->mapel }}
                            </span>
                        @endif
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

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($tendik as $item)
                    <div class="staff-card group bg-white rounded-2xl border border-slate-200/80 p-5 text-center shadow-xs hover:border-amber-500">
                        @if ($item->foto_url)
                            <div class="w-16 h-16 rounded-full overflow-hidden mx-auto mb-4 ring-2 ring-white shadow-md group-hover:scale-105 transition-transform">
                                <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br {{ $item->warna ?: 'from-slate-500 to-slate-700' }} flex items-center justify-center mx-auto mb-4 ring-2 ring-white shadow-md group-hover:scale-105 transition-transform">
                                <span class="text-white font-bold text-lg">
                                    {{ $item->initials }}
                                </span>
                            </div>
                        @endif
                        <h3 class="text-sm font-extrabold text-[#023775] mb-1 leading-snug">{{ $item->nama }}</h3>
                        <p class="text-[11px] text-slate-400 font-semibold mb-2">{{ $item->jabatan }}</p>
                        @if ($item->mapel)
                            <span class="inline-block px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-[11px] font-bold border border-amber-100">
                                {{ $item->mapel }}
                            </span>
                        @endif
                    </div>
                @endforeach
            </section>

        </div>
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')
</body>

</html>
