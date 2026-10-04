<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artikel->title }} | Pusat Karir SMKN 1 Surabaya</title>

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

        .artikel-body p {
            margin-bottom: 1rem;
            line-height: 1.8;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">
    @include('partials.navbar', ['activePage' => 'pusat-karir'])

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <nav class="text-xs text-slate-500 mb-4" aria-label="Breadcrumb">
            <a href="{{ route('beranda') }}" class="hover:text-blue-600 font-semibold">Beranda</a>
            <span class="mx-1">/</span>
            <a href="{{ route('pusat-karir.index') }}" class="hover:text-blue-600 font-semibold">Pusat Karir</a>
            <span class="mx-1">/</span>
            <a href="{{ route('pusat-karir.artikel') }}" class="hover:text-blue-600 font-semibold">Artikel</a>
            <span class="mx-1">/</span>
            <span class="font-bold text-slate-900">{{ $artikel->kategori }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <article class="lg:col-span-8">
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-snug">{{ $artikel->title }}</h1>
                <p class="text-xs text-slate-500 mt-2">Dipublikasi {{ $artikel->published_at->translatedFormat('l, d F Y') }}</p>

                @if ($artikel->display_image)
                    <div class="mt-5 rounded-xl overflow-hidden">
                        <img src="{{ $artikel->display_image }}" alt="{{ $artikel->title }}" class="w-full h-auto max-h-[420px] object-cover">
                    </div>
                @else
                    <div class="artikel-thumb mt-5 rounded-xl h-64 md:h-80"></div>
                @endif

                <div class="artikel-body mt-6 text-slate-700 text-sm md:text-base">
                    {!! nl2br(e($artikel->content)) !!}
                </div>
            </article>

            <aside class="lg:col-span-4">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Artikel Lainnya</h2>
                <div class="space-y-4">
                    @forelse ($other as $o)
                        <a href="{{ route('pusat-karir.detail-artikel', $o->slug) }}"
                            class="block bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
                            @if ($o->display_image)
                                <div class="h-36 overflow-hidden">
                                    <img src="{{ $o->display_image }}" alt="{{ $o->title }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="artikel-thumb h-36"></div>
                            @endif
                            <div class="p-3">
                                <h3 class="text-sm font-bold text-slate-900 leading-snug group-hover:text-blue-600 transition-colors">{{ $o->title }}</h3>
                            </div>
                        </a>
                    @empty
                        <div class="bg-white rounded-xl border border-slate-200 p-5 text-center">
                            <p class="text-xs text-slate-400">Belum ada artikel lain.</p>
                        </div>
                    @endforelse
                </div>
            </aside>
        </div>
    </main>

    @include('partials.footer')
</body>

</html>
