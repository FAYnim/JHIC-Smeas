<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLUD SMKN 1 Surabaya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
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

        .blud-hero {
            position: relative;
            width: 100%;
            height: clamp(280px, 42vw, 460px);
            overflow: hidden;
        }

        .blud-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .blud-hero__overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(2, 20, 48, 0.15) 0%,
                    rgba(2, 20, 48, 0.45) 55%,
                    rgba(2, 20, 48, 0.78) 100%);
        }

        .blud-hero__content {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 1.5rem 1.25rem 1.75rem;
            color: #fff;
            max-width: 90rem;
            margin-inline: auto;
            z-index: 1;
        }

        .blud-hero__title {
            font-weight: 800;
            font-size: clamp(1.75rem, 4.2vw, 2.75rem);
            line-height: 1.15;
            letter-spacing: -0.02em;
        }

        .blud-hero__subtitle {
            margin-top: 0.5rem;
            font-size: clamp(0.95rem, 1.6vw, 1.125rem);
            color: rgba(255, 255, 255, 0.85);
            max-width: 48rem;
        }

        .blud-hero__cta {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.65rem 1.4rem;
            border-radius: 9999px;
            background: #fff;
            color: #0f172a;
            font-weight: 700;
            font-size: 0.95rem;
            transition: background 0.15s ease;
        }

        .blud-hero__cta:hover {
            background: #e2e8f0;
        }

        @media (min-width: 768px) {
            .blud-hero__content {
                padding: 2rem 2rem 2.25rem;
            }
        }

        .blud-search {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
        }

        .blud-search__field {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.85rem 1.1rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .blud-search__field:focus-within {
            border-color: #93c5fd;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
        }

        .blud-search__field input {
            flex: 1;
            border: 0;
            outline: 0;
            background: transparent;
            font-size: 0.95rem;
            color: #0f172a;
            font-family: inherit;
        }

        .blud-search__field input::placeholder {
            color: #94a3b8;
        }

        .blud-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 0.85rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .blud-card:hover {
            transform: translateY(-3px);
            border-color: #cbd5e1;
            box-shadow: 0 12px 28px -12px rgba(2, 55, 117, 0.18);
        }

        .blud-card__media {
            position: relative;
            aspect-ratio: 1 / 0.92;
            background: #e2e8f0;
            overflow: hidden;
            flex: none;
            min-height: 0;
        }

        .blud-card__media img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .blud-badge-major {
            position: absolute;
            top: 0.65rem;
            right: 0.65rem;
            background: #fbbf24;
            color: #1c1917;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            padding: 0.28rem 0.55rem;
            border-radius: 0.35rem;
            box-shadow: 0 1px 2px rgba(28, 25, 23, 0.12);
        }

        .blud-badge-rank {
            position: absolute;
            top: 0.55rem;
            right: 0.55rem;
            background: #023775;
            color: #fbbf24;
            font-size: 0.78rem;
            font-weight: 800;
            min-width: 1.75rem;
            height: 1.75rem;
            padding-inline: 0.35rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.35rem;
            box-shadow: 0 2px 6px rgba(2, 55, 117, 0.28);
        }

        .blud-card__body {
            padding: 0.9rem 0.95rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
            flex: 1;
        }

        .blud-card__title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .blud-card__desc {
            font-size: 0.75rem;
            color: #64748b;
            line-height: 1.45;
            flex: 1;
        }

        .blud-btn-detail {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-top: auto;
            padding: 0.55rem 0.75rem;
            border-radius: 0.4rem;
            background: #fbbf24;
            color: #1c1917;
            font-size: 0.78rem;
            font-weight: 700;
            border: 1px solid #f59e0b;
            transition: background 0.2s ease, transform 0.15s ease;
        }

        .blud-btn-detail:hover {
            background: #fcd34d;
        }

        .blud-btn-detail:active {
            transform: scale(0.98);
        }

        .blud-section-title {
            font-size: clamp(1.35rem, 2.4vw, 1.75rem);
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }

        .blud-empty {
            display: none;
            text-align: center;
            padding: 2.5rem 1rem;
            color: #64748b;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .blud-empty.is-visible {
            display: block;
        }
    </style>
</head>

<body class="bg-[#f4f6f8] text-slate-800 antialiased flex flex-col min-h-screen">

    @include('partials.navbar', [
        'activePage' => 'blud',
        'berandaUrl' => route('beranda'),
    ])

    <main class="flex-grow">
        {{-- Hero banner --}}
        @include('blud.partials.hero')

        {{-- Search --}}
        <section class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-10">
            <div class="blud-search">
                <form action="{{ route('blud.index') }}" method="GET" class="blud-search__field">
                    <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor"
                        stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                    </svg>
                    <input id="blud-search-input" type="search" name="q" value="{{ request('q') }}"
                        placeholder="Cari produk atau layanan..." autocomplete="off"
                        aria-label="Cari produk atau layanan">
                </form>
            </div>
        </section>

        @php
            $perJurusan = $produkBluds->groupBy('jurusan_nama');
        @endphp

        {{-- Produk Terlaris --}}
        <section class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pt-10 sm:pt-12 pb-4"
            data-blud-section>
            <h2 class="blud-section-title">Produk Terlaris</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                @forelse ($produkBluds->where('tipe', \App\Models\ProdukBlud::TIPE_SHOWCASE)->sortByDesc('rating') as $p)
                    @include('blud.partials.card', ['p' => $p])
                @empty
                    <p class="text-sm text-slate-500 col-span-full">Belum ada produk showcase.</p>
                @endforelse
            </div>
        </section>

        {{-- Semua Produk --}}
        <section class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-10 pb-4"
            data-blud-section>
            <h2 class="blud-section-title">Semua Produk</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                @forelse ($produkBluds as $p)
                    @include('blud.partials.card', ['p' => $p])
                @empty
                    <p class="text-sm text-slate-500 col-span-full">Belum ada produk terdaftar.</p>
                @endforelse
            </div>
        </section>

        {{-- Bagian per jurusan --}}
        @foreach ($perJurusan as $jurusanNama => $produkList)
            <section class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-10 pb-4"
                data-blud-section>
                <h2 class="blud-section-title">{{ $jurusanNama }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                    @foreach ($produkList as $p)
                        @include('blud.partials.card', ['p' => $p, 'showBadge' => false, 'showRating' => false])
                    @endforeach
                </div>
            </section>
        @endforeach

        @if ($produkBluds->isEmpty())
            <div class="blud-empty is-visible" id="blud-empty">
                Produk atau layanan tidak ditemukan.
            </div>
        @else
            <div class="blud-empty" id="blud-empty">
                Produk atau layanan tidak ditemukan.
            </div>
        @endif
    </main>

    @include('partials.footer')
<script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('blud-search-input');
            const emptyState = document.getElementById('blud-empty');
            const cards = Array.from(document.querySelectorAll('[data-blud-card]'));
            const sections = Array.from(document.querySelectorAll('[data-blud-section]'));

            const filterCards = (query) => {
                const q = query.trim().toLowerCase();
                let visibleCount = 0;

                cards.forEach((card) => {
                    const haystack = card.getAttribute('data-search') || '';
                    const match = !q || haystack.includes(q);
                    card.style.display = match ? '' : 'none';
                    if (match) visibleCount += 1;
                });

                sections.forEach((section) => {
                    const sectionCards = section.querySelectorAll('[data-blud-card]');
                    const hasVisible = Array.from(sectionCards).some(
                        (card) => card.style.display !== 'none'
                    );
                    section.style.display = hasVisible ? '' : 'none';
                });

                if (emptyState) {
                    emptyState.classList.toggle('is-visible', visibleCount === 0);
                }
            };

            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    filterCards(e.target.value);
                });
            }
        });
    </script>
</body>

</html>
