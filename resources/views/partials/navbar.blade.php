@php
    $activePage   = $activePage   ?? '';
    $spmbClickable = $spmbClickable ?? true;
    $logoUrl      = $logoUrl      ?? route('pusat-karir.index');
    $berandaUrl   = $berandaUrl   ?? route('beranda');

    $navLinks = [
        ['label' => 'Beranda',     'url' => $berandaUrl,                'key' => 'beranda'],
        ['label' => 'Profil',      'url' => route('visi-misi'),         'key' => 'profil'],
        ['label' => 'Jurusan',     'url' => route('jurusan'),           'key' => 'jurusan'],
        ['label' => 'Informasi',   'url' => route('informasi'),           'key' => 'informasi'],
        ['label' => 'Pusat Karir', 'url' => route('pusat-karir.index'), 'key' => 'pusat-karir'],
        ['label' => 'BLUD',        'url' => '#',                        'key' => 'blud'],
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
                    <a href="{{ $link['url'] }}"
                        class="nav-hover-link text-sm {{ $isActive($link['key']) ? 'font-bold text-slate-900 border-b-2 border-amber-400' : 'font-semibold text-slate-600 hover:text-slate-900' }} transition-colors py-2">
                        {{ $link['label'] }}
                    </a>
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
                <a href="{{ $link['url'] }}"
                    class="px-3 py-2 rounded-md text-base {{ $isActive($link['key']) ? 'font-bold text-slate-900 bg-amber-50 border-l-4 border-amber-400' : 'font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} transition-colors">
                    {{ $link['label'] }}
                </a>
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

{{-- Mobile menu toggle script --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn    = document.getElementById('mobile-menu-btn');
        const menu   = document.getElementById('mobile-menu');
        const iconOn = document.getElementById('menu-icon-open');
        const iconOf = document.getElementById('menu-icon-close');
        if (!btn || !menu) return;

        btn.addEventListener('click', () => {
            const open = menu.classList.toggle('hidden');
            if (iconOn) iconOn.classList.toggle('hidden', !open);
            if (iconOf) iconOf.classList.toggle('hidden', open);
        });
    });
</script>
