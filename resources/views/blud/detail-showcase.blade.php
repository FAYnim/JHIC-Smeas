<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->title }} — BLUD SMKN 1 Surabaya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    @include('blud.partials.detail-css')
</head>

<body class="bg-[#f4f6f8] text-slate-800 antialiased flex flex-col min-h-screen">

    @include('partials.navbar', [
        'activePage' => 'blud',
        'berandaUrl' => route('beranda'),
    ])

    <main class="flex-grow">
        <div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pt-6 sm:pt-8 pb-10">
            <nav class="detail-breadcrumb text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
                <a href="{{ route('beranda') }}" class="hover:text-blue-800">Beranda</a>
                <span class="mx-1">/</span>
                <a href="{{ route('blud.index') }}" class="hover:text-blue-800">BLUD</a>
                <span class="mx-1">/</span>
                <span class="text-slate-700 font-semibold">{{ $produk->title }}</span>
            </nav>

            @if (session('success'))
                <div class="detail-success-banner mb-4" role="status">{{ session('success') }}</div>
            @endif

            {{-- Top card: gallery + info --}}
            <section class="detail-card p-4 sm:p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                    <div>
                        @include('blud.partials.gallery', ['produk' => $produk])
                    </div>

                    <div class="relative">
                        <button type="button"
                            class="detail-laporkan absolute top-0 right-0"
                            data-open-modal="modal-laporkan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3v1.5M3 21v-6m0 0l3.77-3.77L12 15m9-9v6m0 0l3.77-3.77M21 9l-3.77 3.77M12 15l-3.77-3.77L12 7.5" />
                            </svg>
                            Laporkan
                        </button>

                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight pr-16">
                            {{ $produk->title }}
                        </h1>

                        @if ($produk->rating !== null)
                            <div class="flex flex-wrap items-center gap-2 mt-3 text-sm text-slate-600">
                                <span class="detail-stars" aria-label="Rating {{ $produk->rating }}">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= (int) floor((float) $produk->rating))
                                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"
                                                aria-hidden="true">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.077 10.1c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-slate-300" fill="currentColor" viewBox="0 0 20 20"
                                                aria-hidden="true">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.077 10.1c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </span>
                                <span class="font-semibold text-slate-700">{{ number_format((float) $produk->rating, 1) }}</span>
                                <span>({{ $produk->rating_count ?? 0 }} rating)</span>
                                <span class="text-slate-400">|</span>
                                <span>Terjual {{ $produk->terjual ?? '0' }}</span>
                            </div>
                        @endif

                        @if ($produk->harga_min !== null || $produk->harga_max !== null)
                            <p class="detail-price mt-3">
                                @if ($produk->harga_min !== null && $produk->harga_max !== null)
                                    Rp {{ number_format($produk->harga_min) }} - Rp {{ number_format($produk->harga_max) }}
                                @elseif ($produk->harga_min !== null)
                                    Rp {{ number_format($produk->harga_min) }}
                                @else
                                    Rp {{ number_format($produk->harga_max) }}
                                @endif
                            </p>
                        @endif

                        @if ($produk->pengiriman)
                            <div class="flex items-center justify-between gap-4 mt-4 py-3 border-y border-slate-200">
                                <span class="font-semibold text-slate-700 text-sm">Pengiriman</span>
                                <span class="text-sm text-slate-600 text-right">{{ $produk->pengiriman }}</span>
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-5">
                            <button type="button" class="detail-btn-primary"
                                data-open-modal="modal-penawaran">
                                Minta Penawaran
                            </button>
                            <a href="https://wa.me/" target="_blank" rel="noopener noreferrer"
                                class="detail-btn-amber">
                                Konsultasi WA
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Jurusan strip --}}
                <div class="mt-6 pt-5 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center gap-4 justify-between">
                    <div class="flex items-center gap-3">
                        <div class="detail-jurusan-avatar"
                            style="background: linear-gradient(135deg, {{ $produk->jurusan_logo_color ?? '#fbbf24' }}, {{ $produk->jurusan_logo_color ?? '#fbbf24' }}cc);">
                            {{ strtoupper(substr($produk->jurusan_nama, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm sm:text-base">{{ $produk->jurusan_nama }}</p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <a href="https://wa.me/" target="_blank" rel="noopener noreferrer"
                                    class="detail-btn-sm detail-btn-blue-sm">Chat Sekarang</a>
                                <a href="{{ route('jurusan.detail', ['slug' => $produk->jurusan_slug]) }}"
                                    class="detail-btn-sm detail-btn-amber-sm">Kunjungi Jurusan</a>
                            </div>
                        </div>
                    </div>

                    <div class="detail-stats-grid sm:max-w-sm w-full sm:w-auto">
                        <div>
                            <p class="detail-stats-label">Penilaian</p>
                            <p class="detail-stats-value">{{ $produk->penilaian_count ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="detail-stats-label">Produk</p>
                            <p class="detail-stats-value">{{ $produk->produk_count ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="detail-stats-label">Presentase Chat Dibalas</p>
                            <p class="detail-stats-value">{{ $produk->presentase_chat ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="detail-stats-label">Waktu Chat Dibalas</p>
                            <p class="detail-stats-value">{{ $produk->waktu_chat ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Main + sidebar --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <div class="lg:col-span-2 space-y-6">
                    {{-- Spesifikasi --}}
                    <section class="detail-card p-4 sm:p-5">
                        <h2 class="detail-section-header">Spesifikasi Produk</h2>
                        <div class="mt-1 px-1">
                            <div class="detail-spec-row">
                                <span class="detail-spec-label">Kategori</span>
                                <span class="detail-spec-value">{{ $produk->kategori ?? '—' }}</span>
                            </div>
                            <div class="detail-spec-row">
                                <span class="detail-spec-label">Stok</span>
                                <span class="detail-spec-value">{{ $produk->stok ?? '—' }}</span>
                            </div>
                            <div class="detail-spec-row">
                                <span class="detail-spec-label">Produk Custom</span>
                                <span class="detail-spec-value">{{ $produk->opsi_custom ?? '—' }}</span>
                            </div>
                            <div class="detail-spec-row">
                                <span class="detail-spec-label">Quantity per Pack</span>
                                <span class="detail-spec-value">{{ $produk->quantity_per_pack ?? '—' }}</span>
                            </div>
                        </div>
                    </section>

                    {{-- Deskripsi --}}
                    <section class="detail-card p-4 sm:p-5">
                        <h2 class="detail-section-header">Deskripsi Produk</h2>
                        <p class="mt-3 text-sm leading-relaxed text-slate-700 whitespace-pre-line">
                            {{ $produk->deskripsi }}
                        </p>
                    </section>

                    {{-- Penilaian --}}
                    <section class="detail-card p-4 sm:p-5">
                        <h2 class="detail-section-header">Penilaian Produk</h2>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 mt-4">
                            <p class="text-3xl font-extrabold text-slate-900">
                                {{ $produk->rating !== null ? number_format((float) $produk->rating, 1) : '—' }} dari 5
                            </p>
                            <span class="detail-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($produk->rating !== null && $i <= (int) floor((float) $produk->rating))
                                        <svg class="w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 20 20"
                                            aria-hidden="true">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.077 10.1c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-slate-300" fill="currentColor" viewBox="0 0 20 20"
                                            aria-hidden="true">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.077 10.1c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    @endif
                                @endfor
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-4" id="detail-rating-filters">
                            <button type="button" class="detail-chip is-active" data-rating-filter="all">Semua</button>
                            <button type="button" class="detail-chip" data-rating-filter="5">5 bintang</button>
                            <button type="button" class="detail-chip" data-rating-filter="4">4 bintang</button>
                            <button type="button" class="detail-chip" data-rating-filter="3">3 bintang</button>
                            <button type="button" class="detail-chip" data-rating-filter="2">2 bintang</button>
                            <button type="button" class="detail-chip" data-rating-filter="1">1 bintang</button>
                        </div>
                    </section>

                    {{-- Komentar --}}
                    @include('blud.partials.komentar', ['produk' => $produk])
                </div>

                {{-- Sidebar --}}
                <aside>
                    <div class="detail-card">
                        <div class="detail-yellow-bar">
                            Produk Lain dari {{ $produk->jurusan_nama }} :
                        </div>
                        <div class="p-4">
                            @forelse ($related as $item)
                                <a href="{{ route('blud.detail', $item->slug) }}" class="detail-related-link">
                                    <img class="detail-related-thumb"
                                        src="{{ $item->galeri->first()?->image_url ?? 'https://placehold.co/200x200/e2e8f0/64748b?text=' . urlencode($item->title) }}"
                                        alt="{{ $item->title }}" loading="lazy">
                                    <span class="detail-related-title">{{ $item->title }}</span>
                                </a>
                            @empty
                                <p class="text-sm text-slate-500 py-2">Belum ada produk lain dari jurusan ini.</p>
                            @endforelse
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <footer class="w-full bg-blue-700 text-white text-center py-4 text-sm font-semibold mt-auto">
        Dibuat dengan <span class="text-red-500">❤️</span> oleh Chicken Noodles Team
    </footer>

    @include('blud.partials.modal-penawaran-laporkan', ['produk' => $produk])

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterChips = document.querySelectorAll('[data-rating-filter]');
            const commentItems = document.querySelectorAll('#detail-comments-list [data-rating]');
            filterChips.forEach((chip) => {
                chip.addEventListener('click', () => {
                    const filter = chip.getAttribute('data-rating-filter');
                    filterChips.forEach((c) => c.classList.remove('is-active'));
                    chip.classList.add('is-active');
                    commentItems.forEach((item) => {
                        const rating = item.getAttribute('data-rating');
                        const match = filter === 'all' || rating === filter;
                        item.style.display = match ? '' : 'none';
                    });
                });
            });
        });
    </script>
</body>

</html>
