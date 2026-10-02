<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel &amp; Tutorial | Pusat Karir SMKN 1 Surabaya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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

        .artikel-thumb {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 55%, #eab308 100%);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
    @include('partials.navbar', ['activePage' => 'pusat-karir'])

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <nav class="text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('beranda') }}" class="hover:text-blue-600 font-semibold">Beranda</a>
            <span class="mx-1">/</span>
            <a href="{{ route('pusat-karir.index') }}" class="hover:text-blue-600 font-semibold">Pusat Karir</a>
            <span class="mx-1">/</span>
            <span class="font-bold text-slate-900">Artikel</span>
        </nav>

        @if ($featured)
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mt-2">
                <h2 class="text-xl font-bold text-slate-900 leading-snug">{{ $featured->title }}</h2>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">{{ $featured->excerpt }}</p>
                <a href="{{ route('pusat-karir.detail-artikel', $featured->slug) }}"
                    class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-bold rounded-lg transition-colors">
                    Baca Panduan Lengkap
                </a>
            </div>
        @endif

        <section class="mt-10">
            <h2 class="text-lg font-bold text-slate-900">Template Berkas Karir Siap Pakai</h2>
            <p class="text-sm text-slate-500 mt-1">Unduh berkas resmi yang disesuaikan dengan format seleksi mitra industri SMKN 1 Surabaya</p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                @foreach (['Format CV ATS', 'Format CV ATS', 'Format CV ATS'] as $tpl)
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $tpl }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">Standard HRD • Format .DOCX (148 KB)</p>
                        </div>
                        <a href="#"
                            class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-bold rounded-lg transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                            Unduh
                        </a>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mt-10">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Daftar Artikel &amp; Tutorial Terbaru</h2>

            @if ($artikels->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($artikels as $a)
                        <a href="{{ route('pusat-karir.detail-artikel', $a->slug) }}"
                            class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow flex flex-col group">
                            @if ($a->display_image)
                                <div class="h-40 overflow-hidden">
                                    <img src="{{ $a->display_image }}" alt="{{ $a->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            @else
                                <div class="artikel-thumb h-40"></div>
                            @endif
                            <div class="p-4 flex flex-col flex-1">
                                <h3 class="text-sm font-bold text-slate-900 leading-snug group-hover:text-blue-600 transition-colors">{{ $a->title }}</h3>
                                <p class="text-xs text-slate-500 mt-1.5 line-clamp-2 flex-1">{{ $a->excerpt }}</p>
                                <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100">
                                    <span class="text-[11px] text-slate-400">{{ $a->reading_time ?: '4 menit baca' }}</span>
                                    <span class="text-xs font-bold text-slate-700 group-hover:text-blue-600 transition-colors">Baca Selengkapnya</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $artikels->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-10 text-center">
                    <p class="text-sm font-bold text-slate-700 mb-1">Belum ada artikel</p>
                    <p class="text-xs text-slate-400">Artikel karir akan ditampilkan di sini.</p>
                </div>
            @endif
        </section>
    </main>

    <footer class="w-full bg-blue-700 text-white text-center py-4 text-sm font-semibold">
        Dibuat dengan <span class="text-red-500">❤️</span> oleh Chicken Noodles Team
    </footer>
</body>

</html>
