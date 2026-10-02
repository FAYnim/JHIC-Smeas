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

            @php
                $bulan = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                ];
                $tanggalPembuatan = null;
                if ($produk->tanggal_pembuatan) {
                    $tanggalPembuatan = (int) $produk->tanggal_pembuatan->format('d')
                        . ' ' . $bulan[(int) $produk->tanggal_pembuatan->format('n')]
                        . ' ' . $produk->tanggal_pembuatan->format('Y');
                }
            @endphp

            {{-- Top card --}}
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

                        @if ($produk->subtitle)
                            <p class="text-blue-700 font-bold mt-1">{{ $produk->subtitle }}</p>
                        @endif

                        @if ($tanggalPembuatan)
                            <p class="text-sm text-slate-600 mt-3">
                                Tanggal pembuatan: {{ $tanggalPembuatan }}
                            </p>
                        @endif

                        @if ($produk->angkatan !== null)
                            <p class="text-sm text-slate-600 mt-1">Angkatan: {{ $produk->angkatan }}</p>
                        @endif

                        <div class="detail-team-box mt-4">
                            @if ($produk->didukung_oleh)
                                <p class="text-sm text-slate-700">
                                    <span class="font-bold">Didukung oleh:</span> {{ $produk->didukung_oleh }}
                                </p>
                                <hr class="my-2 border-slate-300">
                            @endif
                            @if ($produk->ketua_tim)
                                <p class="text-sm text-slate-700">
                                    <span class="font-bold">Ketua tim:</span> {{ $produk->ketua_tim }}
                                </p>
                            @endif
                            @if (!empty($produk->anggota_tim) && count($produk->anggota_tim) > 0)
                                <p class="text-sm text-slate-700 mt-2 font-bold">Anggota tim:</p>
                                <ul class="text-sm text-slate-700">
                                    @foreach ($produk->anggota_tim as $anggota)
                                        <li>{{ $anggota }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Jurusan strip --}}
                <div class="mt-6 pt-5 border-t border-slate-200">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="detail-jurusan-avatar"
                                style="background: linear-gradient(135deg, {{ $produk->jurusan_logo_color ?? '#fbbf24' }}, {{ $produk->jurusan_logo_color ?? '#fbbf24' }}cc);">
                                {{ strtoupper(substr($produk->jurusan_nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-900 text-sm sm:text-base">{{ $produk->jurusan_nama }}</p>
                                <a href="https://wa.me/" target="_blank" rel="noopener noreferrer"
                                    class="detail-btn-sm detail-btn-blue-sm mt-2">Tanya seputar karya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Main + sidebar --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <div class="lg:col-span-2 space-y-6">
                    {{-- Tentang Karya --}}
                    <section class="detail-card p-4 sm:p-5">
                        <h2 class="detail-section-header">Tentang Karya</h2>
                        <p class="mt-3 text-sm leading-relaxed text-slate-700 whitespace-pre-line">
                            {{ $produk->deskripsi }}
                        </p>
                    </section>

                    {{-- Galeri --}}
                    <section class="detail-card p-4 sm:p-5">
                        <h2 class="detail-section-header">Galeri Proses dan Demo</h2>
                        <div class="detail-galeri-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mt-4">
                            @forelse ($produk->galeri as $gambar)
                                <figure>
                                    <img src="{{ $gambar->image_url }}" alt="{{ $gambar->caption ?? $produk->title }}"
                                        loading="lazy">
                                    @if ($gambar->caption)
                                        <figcaption class="text-xs text-slate-500 mt-1 text-center">
                                            {{ $gambar->caption }}
                                        </figcaption>
                                    @endif
                                </figure>
                            @empty
                                <p class="text-sm text-slate-500">Belum ada foto galeri.</p>
                            @endforelse
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
</body>

</html>
