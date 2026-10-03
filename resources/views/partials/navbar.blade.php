@php
    $activePage   = $activePage   ?? '';
    $spmbClickable = $spmbClickable ?? true;
    $logoUrl      = $logoUrl      ?? route('beranda');
    $berandaUrl   = $berandaUrl   ?? route('beranda');

    $profilDropdown = [
        ['label' => 'Visi & Misi',                 'url' => route('visi-misi'),                    'key' => 'profil'],
        ['label' => 'Struktur Organisasi',         'url' => route('struktur-organisasi'),          'key' => 'profil'],
        ['label' => 'Guru & Tenaga Kependidikan',  'url' => route('guru-dan-tenaga-kependidikan'),  'key' => 'profil'],
        ['label' => 'Sarana & Prasarana',          'url' => route('sarana-dan-prasarana'),         'key' => 'profil'],
    ];

    $navLinks = [
        ['label' => 'Beranda',     'url' => $berandaUrl,                'key' => 'beranda'],
        ['label' => 'Profil',      'url' => route('visi-misi'),         'key' => 'profil'],
        ['label' => 'Jurusan',     'url' => route('jurusan'),           'key' => 'jurusan'],
        ['label' => 'Informasi',   'url' => route('informasi'),           'key' => 'informasi'],
        ['label' => 'Pusat Karir', 'url' => route('pusat-karir.index'), 'key' => 'pusat-karir'],
        ['label' => 'BLUD',        'url' => route('blud.index'),        'key' => 'blud'],
    ];

    $isActive = fn(string $key) => $activePage === $key;
@endphp

{{-- ========== Desktop + Mobile Navbar ========== --}}
<header class="sticky top-0 z-50 bg-white shadow-xs border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            {{-- Logo --}}
            <a href="{{ $logoUrl }}" class="flex items-center group">
                <img src="{{ asset('images/logo-smkn1.png') }}" alt="Logo SMKN 1 Surabaya"
                    class="h-11 sm:h-12 w-auto object-contain transition-transform duration-200 group-hover:scale-105">
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden md:flex items-center gap-7">
                @foreach ($navLinks as $link)
                    @if ($link['key'] === 'profil')
                        {{-- Dropdown Profil --}}
                        <div class="relative" id="desktop-profil-dropdown">
                            <button type="button" id="desktop-profil-btn"
                                class="nav-hover-link text-sm {{ $isActive($link['key']) ? 'font-bold text-slate-900 border-b-2 border-amber-400' : 'font-semibold text-slate-600 hover:text-slate-900' }} transition-colors py-2 inline-flex items-center gap-1 cursor-pointer">
                                {{ $link['label'] }}
                                <svg class="w-3.5 h-3.5 transition-transform duration-200" id="desktop-profil-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="desktop-profil-menu"
                                class="absolute left-0 top-full mt-0 w-64 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50 hidden opacity-0 -translate-y-1 transition-all duration-150">
                                @foreach ($profilDropdown as $item)
                                    <a href="{{ $item['url'] }}"
                                        class="block px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $link['url'] }}"
                            class="nav-hover-link text-sm {{ $isActive($link['key']) ? 'font-bold text-slate-900 border-b-2 border-amber-400' : 'font-semibold text-slate-600 hover:text-slate-900' }} transition-colors py-2">
                            {{ $link['label'] }}
                        </a>
                    @endif
                @endforeach

                {{-- SPMB Button --}}
                @if ($spmbClickable)
                    <a href="{{ route('spmb.index') }}"
                        class="ml-2 inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg shadow-sm hover:shadow transition-all duration-200">
                        SPMB
                    </a>
                @else
                    <span
                        class="ml-2 inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-blue-800 rounded-lg shadow-sm cursor-default">
                        SPMB
                    </span>
                @endif
            </nav>

            {{-- Mobile Menu Button --}}
            <div class="flex md:hidden items-center">
                <button type="button" id="mobile-menu-btn" aria-label="Toggle Navigation"
                    class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                    <x-lucide-menu id="menu-icon-open" class="w-6 h-6" />
                    <x-lucide-x id="menu-icon-close" class="w-6 h-6 hidden" />
                </button>
            </div>

        </div>
    </div>

    {{-- Mobile Navigation Menu --}}
    <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white px-4 pt-3 pb-6 shadow-lg">
        <div class="flex flex-col space-y-3">
            @foreach ($navLinks as $link)
                @if ($link['key'] === 'profil')
                    {{-- Mobile Dropdown Profil --}}
                    <div>
                        <button type="button" data-mobile-profil-toggle
                            class="w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors">
                            {{ $link['label'] }}
                            <svg class="w-4 h-4 transition-transform duration-200" data-mobile-profil-chevron fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div data-mobile-profil-menu class="hidden pl-4 mt-1 space-y-1">
                            @foreach ($profilDropdown as $item)
                                <a href="{{ $item['url'] }}"
                                    class="block px-3 py-2 rounded-md text-sm font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-50 transition-colors">
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $link['url'] }}"
                        class="px-3 py-2 rounded-md text-base {{ $isActive($link['key']) ? 'font-bold text-slate-900 bg-amber-50 border-l-4 border-amber-400' : 'font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} transition-colors">
                        {{ $link['label'] }}
                    </a>
                @endif
            @endforeach

            <div class="pt-2">
                @if ($spmbClickable)
                    <a href="{{ route('spmb.index') }}"
                        class="w-full inline-flex items-center justify-center px-5 py-2.5 text-base font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-all duration-200">
                        SPMB
                    </a>
                @else
                    <span
                        class="w-full inline-flex items-center justify-center px-5 py-2.5 text-base font-bold text-white bg-blue-800 rounded-lg">
                        SPMB
                    </span>
                @endif
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Mobile menu toggle
        const btn    = document.getElementById('mobile-menu-btn');
        const menu   = document.getElementById('mobile-menu');
        const iconOn = document.getElementById('menu-icon-open');
        const iconOf = document.getElementById('menu-icon-close');
        if (btn && menu) {
            btn.addEventListener('click', () => {
                const open = menu.classList.toggle('hidden');
                if (iconOn) iconOn.classList.toggle('hidden', !open);
                if (iconOf) iconOf.classList.toggle('hidden', open);
            });
        }

        // Desktop Profil dropdown (hover)
        const ddWrap  = document.getElementById('desktop-profil-dropdown');
        const ddMenu  = document.getElementById('desktop-profil-menu');
        const ddChev  = document.getElementById('desktop-profil-chevron');
        if (ddWrap && ddMenu) {
            let hideTimer;
            ddWrap.addEventListener('mouseenter', () => {
                clearTimeout(hideTimer);
                ddMenu.classList.remove('hidden', 'opacity-0', '-translate-y-1');
                ddMenu.classList.add('opacity-100', 'translate-y-0');
                if (ddChev) ddChev.classList.add('rotate-180');
            });
            ddWrap.addEventListener('mouseleave', () => {
                hideTimer = setTimeout(() => {
                    ddMenu.classList.add('hidden', 'opacity-0', '-translate-y-1');
                    ddMenu.classList.remove('opacity-100', 'translate-y-0');
                    if (ddChev) ddChev.classList.remove('rotate-180');
                }, 120);
            });
        }

        // Mobile Profil dropdown (tap)
        const mToggle = document.querySelector('[data-mobile-profil-toggle]');
        const mMenu   = document.querySelector('[data-mobile-profil-menu]');
        const mChev   = document.querySelector('[data-mobile-profil-chevron]');
        if (mToggle && mMenu) {
            mToggle.addEventListener('click', () => {
                mMenu.classList.toggle('hidden');
                if (mChev) mChev.classList.toggle('rotate-180');
            });
        }
    });
</script>
