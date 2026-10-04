<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — SMK Negeri 1 Surabaya</title>

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
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased flex flex-col min-h-screen">

    {{-- Header / Navbar --}}
    @include('partials.navbar', [
        'activePage' => 'jurusan',
        'berandaUrl' => route('beranda')
    ])

    <main class="flex-grow">

        {{-- Breadcrumb --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <nav class="flex items-center gap-2 text-sm text-slate-500 font-medium" aria-label="Breadcrumb">
                <a href="{{ route('beranda') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('jurusan') }}" class="hover:text-blue-600 transition-colors">Jurusan</a>
                <span>/</span>
                <span class="text-slate-900 font-bold">@yield('nama')</span>
            </nav>
        </div>

        {{-- Hero Section: Logo + Jurusan Name --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                {{-- Jurusan Logo --}}
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl bg-[#023775] flex items-center justify-center shadow-lg shrink-0">
                    <span class="text-white font-black text-4xl sm:text-5xl tracking-tighter">@yield('kode')</span>
                </div>

                {{-- Jurusan Info --}}
                <div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-1">
                        @yield('nama')
                    </h1>
                    @hasSection('ketua')
                        <p class="text-sm sm:text-base text-slate-500">
                            Ketua Program Keahlian: <span class="font-bold text-slate-700">@yield('ketua')</span>
                        </p>
                    @endif
                </div>
            </div>
        </section>

        {{-- Main Content: 2 Column Layout --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
            @yield('content')
        </section>

    </main>

    {{-- Footer --}}
    @include('partials.footer')
</body>

</html>
