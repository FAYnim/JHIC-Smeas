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
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
    <!-- Navbar Header -->
    <header class="sticky top-0 z-50 bg-white shadow-xs border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo & Branding (Image Asset) -->
                <a href="#" class="flex items-center group">
                    <img src="{{ asset('images/logo-smkn1.png') }}" alt="Logo SMKN 1 Surabaya" class="h-11 sm:h-12 w-auto object-contain transition-transform duration-200 group-hover:scale-105">
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-7">
                    <a href="#"
                        class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Beranda
                    </a>
                    <a href="#"
                        class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Profil
                    </a>
                    <a href="#"
                        class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Jurusan
                    </a>
                    <a href="#"
                        class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Informasi
                    </a>

                    <!-- Active Menu Item: Pusat Karir -->
                    <a href="#" class="relative text-sm font-bold text-slate-900 py-2 group">
                        Pusat Karir
                        <!-- Yellow indicator underline matching design -->
                        <span class="absolute bottom-0 left-0 w-full h-1 bg-amber-400 rounded-full shadow-xs"></span>
                    </a>

                    <a href="#"
                        class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
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

    <!-- Content Area Placeholder -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Hero & main content will be placed here -->
    </main>

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
    </script>
</body>

</html>
