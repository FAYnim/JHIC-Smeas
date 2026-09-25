<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Karir SMKN 1 Surabaya</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Vite Styles & Scripts with Fallback -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Navbar hover underline effect */
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
            /* amber-400 */
            border-radius: 9999px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .nav-hover-link:hover::after {
            transform: scaleX(1);
        }

        /* ===== Hero Section Styles ===== */
        .hero-wrapper {
            padding: 1.25rem 1.25rem 0;
        }

        .hero-section {
            position: relative;
            overflow: hidden;
            border-radius: 1.25rem;
            min-height: calc(80vh - 80px - 1.25rem);
            display: flex;
            align-items: center;
        }

        /* Background image layer */
        .hero-section__bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .hero-section__bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Dark overlay on top of the image */
        .hero-section__overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(135deg, rgba(15, 23, 52, 0.92) 0%, rgba(20, 40, 80, 0.82) 100%);
        }

        /* Content sits above overlay */
        .hero-section__content {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 2.75rem 2.5rem 2.5rem;
        }

        .hero-section__title {
            font-size: 2rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 0.625rem;
        }

        .hero-section__subtitle {
            font-size: 0.95rem;
            font-weight: 400;
            color: rgba(203, 213, 225, 0.9);
            max-width: 480px;
            line-height: 1.6;
            margin-bottom: 1.75rem;
        }

        /* Search bar */
        .hero-search-bar {
            display: flex;
            align-items: center;
            background: #ffffff;
            border-radius: 0.625rem;
            overflow: hidden;
            max-width: 560px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            margin-bottom: 1.25rem;
        }

        .hero-search-bar input {
            flex: 1;
            border: none;
            outline: none;
            padding: 0.875rem 1.125rem;
            font-size: 0.9rem;
            color: #334155;
            background: transparent;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .hero-search-bar input::placeholder {
            color: #94a3b8;
        }

        .hero-search-bar button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            margin: 4px;
            border: none;
            border-radius: 0.5rem;
            background: #2563eb;
            color: #ffffff;
            cursor: pointer;
            transition: background 0.2s ease;
            flex-shrink: 0;
        }

        .hero-search-bar button:hover {
            background: #1d4ed8;
        }

        .hero-search-bar button svg {
            width: 20px;
            height: 20px;
        }

        /* Filter buttons */
        .hero-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.625rem;
        }

        .hero-filter-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1.375rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
            border: 1.5px solid rgba(255, 255, 255, 0.35);
            background: transparent;
            color: #ffffff;
        }

        .hero-filter-btn:hover {
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.08);
        }

        .hero-filter-btn--active {
            background: #eab308;
            color: #1c1917;
            border-color: #eab308;
        }

        .hero-filter-btn--active:hover {
            background: #facc15;
            border-color: #facc15;
        }

        /* Responsive */
        @media (min-width: 768px) {
            .hero-section__title {
                font-size: 2.5rem;
            }

            .hero-section__content {
                padding: 3.5rem 3rem 3rem;
            }
        }

        @media (max-width: 480px) {
            .hero-section__title {
                font-size: 1.5rem;
            }

            .hero-section__content {
                padding: 2rem 1.25rem 1.75rem;
            }

            .hero-search-bar {
                max-width: 100%;
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
    <!-- Navbar Header -->
    <header class="sticky top-0 z-50 bg-white shadow-xs border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo & Branding (Image Asset) -->
                <a href="#" class="flex items-center group">
                    <img src="{{ asset('images/logo-smkn1.png') }}" alt="Logo SMKN 1 Surabaya"
                        class="h-11 sm:h-12 w-auto object-contain transition-transform duration-200 group-hover:scale-105">
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-7">
                    <a href="#"
                        class="nav-hover-link text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Beranda
                    </a>
                    <a href="#"
                        class="nav-hover-link text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Profil
                    </a>
                    <a href="#"
                        class="nav-hover-link text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Jurusan
                    </a>
                    <a href="#"
                        class="nav-hover-link text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Informasi
                    </a>

                    <a href="#"
                        class="nav-hover-link text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Pusat Karir
                    </a>

                    <a href="#"
                        class="nav-hover-link text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        BLUD
                    </a>

                    <!-- SPMB Button -->
                    <a href="#"
                        class="ml-2 inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg shadow-sm hover:shadow transition-all duration-200">
                        SPMB
                    </a>
                </nav>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden items-center">
                    <button type="button" id="mobile-menu-btn" aria-label="Toggle Navigation"
                        class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                        <svg id="menu-icon-open" class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="menu-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white px-4 pt-3 pb-6 shadow-lg">
            <div class="flex flex-col space-y-3">
                <a href="#"
                    class="px-3 py-2 rounded-md text-base font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors">
                    Beranda
                </a>
                <a href="#"
                    class="px-3 py-2 rounded-md text-base font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors">
                    Profil
                </a>
                <a href="#"
                    class="px-3 py-2 rounded-md text-base font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors">
                    Jurusan
                </a>
                <a href="#"
                    class="px-3 py-2 rounded-md text-base font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors">
                    Informasi
                </a>
                <a href="#"
                    class="px-3 py-2 rounded-md text-base font-bold text-slate-900 bg-amber-50 text-amber-900 border-l-4 border-amber-400 transition-colors">
                    Pusat Karir
                </a>
                <a href="#"
                    class="px-3 py-2 rounded-md text-base font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors">
                    BLUD
                </a>
                <div class="pt-2">
                    <a href="#"
                        class="w-full inline-flex items-center justify-center px-5 py-2.5 text-base font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-all duration-200">
                        SPMB
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ===== Hero Section ===== -->
    <main class="hero-wrapper">
        <section class="hero-section" id="hero-pusat-karir">
            <!-- Background Image (placeholder, ganti src saat asset tersedia) -->
            <div class="hero-section__bg">
                <!-- background sementara -->
                <img src="{{ asset('images/logo-smkn1.png') }}" alt="Background Pusat Karir">
            </div>

            <!-- Dark Overlay -->
            <div class="hero-section__overlay"></div>

            <!-- Hero Content -->
            <div class="hero-section__content">
                <h1 class="hero-section__title">Pusat Karir SMKN 1 Surabaya</h1>
                <p class="hero-section__subtitle">
                    Temukan lowongan kerja, magang, dan peluang karier terbaik
                    untuk alumni dan siswa SMKN 1 Surabaya.
                </p>

                <!-- Search Bar -->
                <form class="hero-search-bar" action="#" method="GET" id="hero-search-form">
                    <input type="text" name="q" placeholder="Cari perusahaan, posisi, atau tempat magang..."
                        autocomplete="off">
                    <button type="submit" aria-label="Cari">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </form>

                <!-- Filter Buttons -->
                <div class="hero-filters" id="hero-filters">
                    <button type="button" class="hero-filter-btn hero-filter-btn--active"
                        data-filter="semua">Semua</button>
                    <button type="button" class="hero-filter-btn" data-filter="magang">Magang</button>
                    <button type="button" class="hero-filter-btn" data-filter="full-time">Full-time</button>
                    <button type="button" class="hero-filter-btn" data-filter="part-time">Part time</button>
                </div>
            </div>
        </section>

        <!-- ===== section peluang unggulan ===== -->
        @php
            // Data dummy — diset kosong [] sampai backend & dashboard admin selesai
            $peluangUnggulan = $peluangUnggulan ?? [];
        @endphp

        <section class="w-full px-5 mt-12 mb-16" id="peluang-unggulan">
            <h2 class="text-3xl font-bold text-slate-800 mb-6">Peluang Unggulan</h2>

            @if (!empty($peluangUnggulan) && count($peluangUnggulan) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($peluangUnggulan as $item)
                        <div
                            class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-slate-100 flex flex-col">
                            <div class="p-5 flex justify-between items-start">
                                <div class="flex gap-4">
                                    <div
                                        class="w-12 h-12 bg-slate-200 rounded-lg flex items-center justify-center text-slate-400 shrink-0">
                                        @if (!empty($item['logo']))
                                            <img src="{{ asset($item['logo']) }}" alt="{{ $item['company'] }}"
                                                class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-sm">
                                            {{ $item['company'] ?? 'Perusahaan' }}</h3>
                                        <p class="text-xs text-slate-600 mt-1">
                                            {{ $item['title'] ?? 'Posisi Pekerjaan' }}</p>
                                        <p class="text-[11px] text-slate-500 mt-1">{{ $item['location'] ?? 'Lokasi' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end justify-between h-full gap-4">
                                    <button class="text-slate-400 hover:text-blue-600 transition-colors"
                                        aria-label="Simpan lowongan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                    </button>
                                    <span
                                        class="inline-block px-2.5 py-1 bg-blue-100 text-blue-600 text-[10px] font-bold rounded">{{ $item['type'] ?? 'Magang' }}</span>
                                </div>
                            </div>
                            <div class="border-t border-slate-100 px-5 py-3 mt-auto">
                                <a href="{{ $item['url'] ?? '#' }}"
                                    class="block text-center text-xs font-semibold text-slate-600 hover:text-blue-600 transition-colors">Selengkapnya</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div
                    class="bg-white rounded-xl border border-slate-100 shadow-sm p-8 text-center flex flex-col items-center justify-center min-h-[180px]">
                    <div
                        class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-3 text-slate-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-600 mb-1">Belum ada peluang unggulan</p>
                    <p class="text-xs text-slate-400">Peluang unggulan akan ditampilkan di sini setelah dicantumkan
                        melalui dashboard.</p>
                </div>
            @endif
        </section>

        <!-- ===== Jelajahi Berdasarkan Kategori Section ===== -->
        @php
            // Data dummy — diset kosong [] sampai backend & dashboard admin selesai
            $categories = $categories ?? [];
        @endphp

        <section class="w-full px-5 mt-10 mb-16" id="jelajahi-kategori">
            <h2 class="text-3xl font-bold text-slate-800 mb-8">Jelajahi berdasarkan kategori</h2>

            @if (!empty($categories) && count($categories) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach ($categories as $category)
                        <a href="{{ url('pusat-karir/kategori/' . ($category['slug'] ?? '')) }}"
                            class="kategori-card group bg-white rounded-xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-200 p-5 flex flex-col items-center text-center"
                            data-category-slug="{{ $category['slug'] ?? '' }}">

                            {{-- Icon --}}
                            <div
                                class="w-14 h-14 rounded-xl bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center mb-3.5 transition-colors duration-200">
                                @switch($category['icon'] ?? '')
                                    @case('briefcase')
                                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor"
                                            stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    @break

                                    @case('document-text')
                                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor"
                                            stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    @break

                                    @case('building-office')
                                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor"
                                            stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                        </svg>
                                    @break

                                    @case('academic-cap')
                                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor"
                                            stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15v-3.75m0 0l5.25 2.625L17.25 11.25" />
                                        </svg>
                                    @break

                                    @case('chart-bar')
                                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor"
                                            stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                        </svg>
                                    @break

                                    @default
                                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor"
                                            stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                        </svg>
                                @endswitch
                            </div>

                            {{-- Name --}}
                            <h3
                                class="text-sm font-bold text-slate-800 group-hover:text-blue-600 transition-colors leading-tight mb-1">
                                {{ $category['name'] ?? '' }}
                            </h3>

                            {{-- Count --}}
                            <p class="text-xs text-slate-500">
                                {{ number_format($category['count'] ?? 0) }} {{ $category['unit'] ?? 'program' }}
                            </p>
                        </a>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div
                    class="bg-white rounded-xl border border-slate-100 shadow-sm p-8 text-center flex flex-col items-center justify-center min-h-[160px]">
                    <div
                        class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-3 text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-600 mb-1">Belum ada kategori</p>
                    <p class="text-xs text-slate-400">Kategori akan ditampilkan di sini setelah dicantumkan melalui
                        dashboard.</p>
                </div>
            @endif

            <!-- ===== Lowongan / Magang / Artikel Terbaru ===== -->
            @php
                // Data dummy — diset kosong [] sampai backend & dashboard admin selesai
                $lowonganTerbaru = $lowonganTerbaru ?? [];
                $magangTerbaru = $magangTerbaru ?? [];
                $artikelTerbaru = $artikelTerbaru ?? [];
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-10">

                <!-- Lowongan Terbaru -->
                <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col min-h-[220px]"
                    id="lowongan-terbaru">
                    <div class="flex items-center justify-between px-5 pt-5 pb-3">
                        <h3 class="text-lg font-bold text-slate-800">Lowongan Terbaru</h3>
                        <a href="#"
                            class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">Lihat
                            semua</a>
                    </div>
                    @if (!empty($lowonganTerbaru) && count($lowonganTerbaru) > 0)
                        <div class="divide-y divide-slate-100">
                            @foreach ($lowonganTerbaru as $lowongan)
                                <div class="px-5 py-4 flex items-start gap-3.5 hover:bg-slate-50 transition-colors"
                                    data-lowongan-item>
                                    <div
                                        class="w-10 h-10 bg-slate-200 rounded-lg flex items-center justify-center text-slate-400 shrink-0 mt-0.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-bold text-slate-900 truncate">{{ $lowongan['title'] }}
                                        </h4>
                                        <p class="text-xs text-slate-600 mt-0.5">{{ $lowongan['company'] }}</p>
                                        <p class="text-[11px] text-slate-500">{{ $lowongan['location'] }}</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span
                                                class="text-[10px] text-slate-400">{{ $lowongan['posted_ago'] }}</span>
                                            <span
                                                class="inline-block px-2 py-0.5 text-[10px] font-bold rounded
                                                {{ ($lowongan['type_color'] ?? '') === 'blue' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }}">
                                                {{ $lowongan['type'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <button class="text-slate-300 hover:text-blue-600 transition-colors mt-1 shrink-0"
                                        aria-label="Simpan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 text-center flex flex-col items-center justify-center flex-1 my-auto">
                            <div
                                class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mb-2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 14.15" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-slate-600 mb-0.5">Belum ada lowongan terbaru</p>
                            <p class="text-[11px] text-slate-400">Data akan muncul setelah ditambahkan.</p>
                        </div>
                    @endif
                </div>

                <!-- Magang Terbaru -->
                <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col min-h-[220px]"
                    id="magang-terbaru">
                    <div class="flex items-center justify-between px-5 pt-5 pb-3">
                        <h3 class="text-lg font-bold text-slate-800">Magang Terbaru</h3>
                        <a href="#"
                            class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">Lihat
                            semua</a>
                    </div>
                    @if (!empty($magangTerbaru) && count($magangTerbaru) > 0)
                        <div class="divide-y divide-slate-100">
                            @foreach ($magangTerbaru as $magang)
                                <div class="px-5 py-4 flex items-start gap-3.5 hover:bg-slate-50 transition-colors"
                                    data-magang-item>
                                    <div
                                        class="w-10 h-10 bg-slate-200 rounded-lg flex items-center justify-center text-slate-400 shrink-0 mt-0.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-bold text-slate-900 truncate">{{ $magang['title'] }}
                                        </h4>
                                        <p class="text-xs text-slate-600 mt-0.5">{{ $magang['company'] }}</p>
                                        <p class="text-[11px] text-slate-500">{{ $magang['location'] }}</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span
                                                class="text-[10px] text-slate-400">{{ $magang['posted_ago'] }}</span>
                                            <span
                                                class="inline-block px-2 py-0.5 text-[10px] font-bold rounded
                                                {{ ($magang['type_color'] ?? '') === 'blue' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }}">
                                                {{ $magang['type'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <button class="text-slate-300 hover:text-blue-600 transition-colors mt-1 shrink-0"
                                        aria-label="Simpan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 text-center flex flex-col items-center justify-center flex-1 my-auto">
                            <div
                                class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mb-2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 14.15" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-slate-600 mb-0.5">Belum ada magang terbaru</p>
                            <p class="text-[11px] text-slate-400">Data akan muncul setelah ditambahkan.</p>
                        </div>
                    @endif
                </div>

                <!-- Artikel Terbaru -->
                <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col min-h-[220px]"
                    id="artikel-terbaru">
                    <div class="flex items-center justify-between px-5 pt-5 pb-3">
                        <h3 class="text-lg font-bold text-slate-800">Artikel Terbaru</h3>
                        <a href="#"
                            class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">Lihat
                            semua</a>
                    </div>
                    @if (!empty($artikelTerbaru) && count($artikelTerbaru) > 0)
                        <div class="divide-y divide-slate-100 flex flex-col flex-1">
                            @foreach ($artikelTerbaru as $artikel)
                                <a href="{{ url('pusat-karir/artikel/' . ($artikel['slug'] ?? '')) }}"
                                    class="px-5 py-5 flex items-center gap-4 hover:bg-slate-50 transition-colors flex-1"
                                    data-artikel-item>
                                    <div
                                        class="w-20 h-14 bg-slate-200 rounded-lg flex items-center justify-center text-slate-400 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4
                                        class="text-sm font-bold text-slate-800 leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors">
                                        {{ $artikel['title'] }}
                                    </h4>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 text-center flex flex-col items-center justify-center flex-1 my-auto">
                            <div
                                class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mb-2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-slate-600 mb-0.5">Belum ada artikel terbaru</p>
                            <p class="text-[11px] text-slate-400">Data akan muncul setelah ditambahkan.</p>
                        </div>
                    @endif
                </div>

            </div>
        </section>

        <!-- ===== Bimbingan Karir Section ===== -->
        @php
            // Data dummy — nantinya diganti dari controller
            $bimbinganFilters = $bimbinganFilters ?? [
                ['label' => 'Semua', 'slug' => 'semua', 'icon' => 'squares'],
                ['label' => 'Tips CV', 'slug' => 'tips-cv', 'icon' => 'document'],
                ['label' => 'Tips Interview', 'slug' => 'tips-interview', 'icon' => 'chat'],
                ['label' => 'Roadmap Karir', 'slug' => 'roadmap-karir', 'icon' => 'map'],
                ['label' => 'Webinar', 'slug' => 'webinar', 'icon' => 'video'],
                ['label' => 'Sertifikasi', 'slug' => 'sertifikasi', 'icon' => 'badge'],
            ];

            // null = belum ada webinar dari dashboard
            $upcomingWebinar = $upcomingWebinar ?? null;
        @endphp

        <section class="w-full px-5 mt-4 mb-16" id="bimbingan-karir">
            <h2 class="text-3xl font-bold text-slate-800 mb-6">Bimbingan Karir</h2>

            <!-- Filter Tabs -->
            <div class="flex flex-wrap gap-2.5 mb-8" id="bimbingan-filters">
                @foreach ($bimbinganFilters as $index => $filter)
                    <button type="button"
                        class="bimbingan-filter-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200
                            {{ $index === 0 ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-blue-300 hover:text-blue-600' }}"
                        data-filter="{{ $filter['slug'] }}">

                        {{-- Filter Icon --}}
                        @switch($filter['icon'])
                            @case('squares')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                </svg>
                            @break

                            @case('document')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            @break

                            @case('chat')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                </svg>
                            @break

                            @case('map')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 6.75V15m0-8.25L3.75 3.75v11.25L9 18m0-11.25l6-3m0 0v11.25m0-11.25l5.25 3v11.25L15 18m0-11.25L9 9.75" />
                                </svg>
                            @break

                            @case('video')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            @break

                            @case('badge')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.745 3.745 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                </svg>
                            @break
                        @endswitch

                        {{ $filter['label'] }}
                    </button>
                @endforeach
            </div>

            <!-- Feature Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- CTA Card — Persiapkan Karir -->
                <div
                    class="relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 p-7 flex items-center min-h-[180px]">
                    {{-- Decorative chart icon --}}
                    <div class="absolute right-4 bottom-4 opacity-10">
                        <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-xl font-bold text-white leading-tight mb-1.5">
                            Persiapkan Karir,<br>Raih Masa Depan
                        </h3>
                        <a href="#"
                            class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-white text-sm font-bold rounded-lg shadow transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15v-3.75m0 0 5.25 2.625L17.25 11.25" />
                            </svg>
                            Mulai Belajar
                        </a>
                    </div>
                </div>

                <!-- Upcoming Webinar Card -->
                <div
                    class="bg-white rounded-xl border border-slate-100 shadow-sm p-7 flex flex-col justify-center min-h-[180px]">
                    @if ($upcomingWebinar)
                        <span
                            class="inline-block text-[10px] font-bold tracking-widest text-slate-400 uppercase mb-2">Upcoming
                            Webinar</span>
                        <h3 class="text-lg font-bold text-slate-900 mb-2.5">
                            {{ $upcomingWebinar['title'] }}
                        </h3>
                        <p class="text-sm text-slate-500 mb-5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            {{ $upcomingWebinar['date'] }} · {{ $upcomingWebinar['time'] }}
                        </p>
                        <a href="{{ url('pusat-karir/webinar/' . $upcomingWebinar['slug']) }}"
                            class="inline-flex items-center justify-center w-full px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-sm transition-all duration-200">
                            Register Now
                        </a>
                    @else
                        {{-- Empty State --}}
                        <div class="flex flex-col items-center justify-center text-center py-4">
                            <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor"
                                    stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-600 mb-1">Belum ada webinar</p>
                            <p class="text-xs text-slate-400">Webinar akan ditampilkan di sini setelah dicantumkan
                                melalui dashboard.</p>
                        </div>
                    @endif
                </div>

            </div>
        </section>

        <!-- ===== Sumber Rekomendasi Section ===== -->
        @php
            // Data dummy — diset kosong [] sampai backend & dashboard admin selesai
            $sumberRekomendasi = $sumberRekomendasi ?? [];
        @endphp

        <section class="w-full px-5 mt-4 mb-16" id="sumber-rekomendasi">
            <h2 class="text-3xl font-bold text-slate-800 mb-6">Sumber Rekomendasi</h2>

            @if (!empty($sumberRekomendasi) && count($sumberRekomendasi) > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($sumberRekomendasi as $sumber)
                        <a href="{{ $sumber['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer"
                            class="bg-white rounded-xl border border-slate-200/90 hover:border-blue-400 p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-lg group">

                            <div>
                                @if (!empty($sumber['has_image']))
                                    {{-- Thumbnail Container --}}
                                    <div
                                        class="w-full h-48 rounded-lg bg-slate-100 overflow-hidden mb-5 flex items-center justify-center relative border border-slate-100/80 group-hover:border-blue-100 transition-colors">
                                        @if (!empty($sumber['image']))
                                            <img src="{{ asset($sumber['image']) }}" alt="{{ $sumber['title'] }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            {{-- Visual Placeholder Gradient with School/Career Vibe --}}
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-slate-100 via-blue-50/50 to-indigo-50/80 flex flex-col items-center justify-center text-slate-400 gap-2 p-4 text-center">
                                                <div
                                                    class="w-12 h-12 rounded-xl bg-white shadow-sm border border-slate-200/60 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-300">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                        stroke-width="1.8" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.949 8.949 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                </div>
                                                <span
                                                    class="text-xs font-semibold text-slate-400 group-hover:text-blue-600 transition-colors">Asset
                                                    Image Placeholder</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Category Tag & Title --}}
                                    <span
                                        class="text-xs font-semibold text-red-600 uppercase tracking-wider block mb-2">
                                        {{ $sumber['category'] ?? 'Rekomendasi' }}
                                    </span>
                                    <h3
                                        class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors leading-snug flex items-start justify-between gap-2 mb-4">
                                        <span>{{ $sumber['title'] ?? '' }}</span>
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all shrink-0 mt-1"
                                            fill="none" stroke="currentColor" stroke-width="2.5"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </h3>
                                @else
                                    {{-- Card Without Image (Text & Editorial Focus) --}}
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-xs font-semibold text-red-600 uppercase tracking-wider">
                                            {{ $sumber['category'] ?? 'Rekomendasi' }}
                                        </span>
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all shrink-0"
                                            fill="none" stroke="currentColor" stroke-width="2.5"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </div>
                                    <h3
                                        class="text-xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors leading-snug mb-6">
                                        {{ $sumber['title'] ?? '' }}
                                    </h3>
                                @endif
                            </div>

                            {{-- Card Footer Date / Metadata --}}
                            <div class="pt-4 border-t border-slate-100 mt-auto">
                                <span class="text-xs font-medium text-slate-400 block">
                                    {{ $sumber['date'] ?? '' }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div
                    class="bg-white rounded-xl border border-slate-100 shadow-sm p-8 text-center flex flex-col items-center justify-center min-h-[180px]">
                    <div
                        class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-3 text-slate-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-600 mb-1">Belum ada sumber rekomendasi</p>
                    <p class="text-xs text-slate-400">Sumber rekomendasi akan ditampilkan di sini setelah dicantumkan
                        melalui dashboard.</p>
                </div>
            @endif
        </section>
    </main>

    <!-- Footer Banner -->
    <footer class="w-full bg-blue-700 text-white text-center py-4 text-sm font-semibold">
        Dibuat dengan <span class="text-red-500">❤️</span> oleh Chicken Noodles Team
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');

        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                const isHidden = mobileMenu.classList.contains('hidden');
                if (isHidden) {
                    mobileMenu.classList.remove('hidden');
                    iconOpen.classList.add('hidden');
                    iconClose.classList.remove('hidden');
                } else {
                    mobileMenu.classList.add('hidden');
                    iconOpen.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                }
            });
        }

        // Hero Filter Buttons Toggle
        const filterContainer = document.getElementById('hero-filters');
        if (filterContainer) {
            filterContainer.addEventListener('click', (e) => {
                const btn = e.target.closest('.hero-filter-btn');
                if (!btn) return;

                filterContainer.querySelectorAll('.hero-filter-btn').forEach(b => {
                    b.classList.remove('hero-filter-btn--active');
                });
                btn.classList.add('hero-filter-btn--active');
            });
        }

        // Bimbingan Karir Filter Toggle
        const bimbinganContainer = document.getElementById('bimbingan-filters');
        if (bimbinganContainer) {
            bimbinganContainer.addEventListener('click', (e) => {
                const btn = e.target.closest('.bimbingan-filter-btn');
                if (!btn) return;

                bimbinganContainer.querySelectorAll('.bimbingan-filter-btn').forEach(b => {
                    b.classList.remove('bg-blue-600', 'text-white', 'shadow-sm');
                    b.classList.add('bg-white', 'text-slate-600', 'border', 'border-slate-200');
                });
                btn.classList.remove('bg-white', 'text-slate-600', 'border', 'border-slate-200');
                btn.classList.add('bg-blue-600', 'text-white', 'shadow-sm');
            });
        }
    </script>
</body>

</html>
