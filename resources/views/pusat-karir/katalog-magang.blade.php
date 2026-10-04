<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Tempat Magang PKL Siswa | Pusat Karir SMKN 1 Surabaya</title>

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

        .filter-check {
            accent-color: #2563eb;
        }

        .filter-check:hover,
        .filter-check:active {
            box-shadow: 0 0 0 2px #2563eb;
            border-color: #2563eb;
        }

        .toggle-track {
            width: 40px;
            height: 22px;
            border-radius: 999px;
            background: #cbd5e1;
            position: relative;
            transition: background 0.2s;
        }

        .toggle-track.on {
            background: #16a34a;
        }

        .toggle-track::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: #fff;
            transition: transform 0.2s;
        }

        .toggle-track.on::after {
            transform: translateX(18px);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">
    @include('partials.navbar', ['activePage' => 'pusat-karir'])

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <nav class="text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('beranda') }}" class="hover:text-blue-600 font-semibold">Beranda</a>
            <span class="mx-1">/</span>
            <a href="{{ route('pusat-karir.index') }}" class="hover:text-blue-600 font-semibold">Pusat Karir</a>
            <span class="mx-1">/</span>
            <span class="font-bold text-slate-900">Magang PKL</span>
        </nav>

        <h1 class="text-3xl font-extrabold text-slate-900">Katalog Tempat Magang PKL Siswa</h1>
        <p class="text-sm text-slate-500 mt-2">Temukan peluang Praktek Kerja Lapangan resmi dari mitra DUDI SMKN 1 Surabaya sesuai kompetensi keahlianmu.</p>

        <form action="{{ route('pusat-karir.katalog-magang') }}" method="GET" class="mt-6 flex items-center bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <svg class="w-5 h-5 text-slate-400 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input type="text" name="q" value="{{ $selected['q'] ?? '' }}" placeholder="Cari nama posisi, keahlian, atau nama perusahaan..."
                class="flex-1 border-0 outline-none px-3 py-4 text-sm text-slate-700 placeholder:text-slate-400">
            <button type="submit" class="m-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors shrink-0">
                Cari Posisi
            </button>
        </form>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-8">
            <aside class="lg:col-span-3">
                <form action="{{ route('pusat-karir.katalog-magang') }}" method="GET" class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 sticky top-24">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-bold text-slate-900">Filter Pencarian</h2>
                        <a href="{{ route('pusat-karir.katalog-magang') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Reset</a>
                    </div>

                    @if ($selected['q'] ?? null)
                        <input type="hidden" name="q" value="{{ $selected['q'] }}">
                    @endif

                    <div class="mb-5 pb-5 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-800 mb-3">Ketersediaan Kuota</p>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="hidden" name="kuota" value="0">
                            <input type="checkbox" name="kuota" value="1" {{ $selected['kuota'] ? 'checked' : '' }} class="sr-only" onchange="this.closest('label').querySelector('.toggle-track').classList.toggle('on', this.checked)">
                            <span class="toggle-track {{ $selected['kuota'] ? 'on' : '' }}"></span>
                            <span class="text-sm {{ $selected['kuota'] ? 'font-semibold text-slate-900' : 'text-slate-600' }}">Hanya kuota tersedia</span>
                        </label>
                    </div>

                    <div class="mb-5 pb-5 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-800 mb-3">Jurusan (Keahlian)</p>
                        <div class="space-y-2.5">
                            @foreach ($jurusanOptions as $opt)
                                <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                                    <input type="checkbox" name="jurusan[]" value="{{ $opt }}" {{ in_array($opt, $selected['jurusan'], true) ? 'checked' : '' }} class="filter-check w-4 h-4 rounded">
                                    <span class="{{ in_array($opt, $selected['jurusan'], true) ? 'font-semibold text-blue-700' : '' }}">{{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-5 pb-5 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-800 mb-3">Skema Kerja</p>
                        <div class="space-y-2.5">
                            <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                                <input type="radio" name="skema" value="" {{ empty($selected['skema']) ? 'checked' : '' }} class="filter-check w-4 h-4">
                                <span class="{{ empty($selected['skema']) ? 'font-semibold text-blue-700' : '' }}">Semua Skema</span>
                            </label>
                            @foreach ($skemaOptions as $opt)
                                <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                                    <input type="radio" name="skema" value="{{ $opt }}" {{ ($selected['skema'] ?? '') === $opt ? 'checked' : '' }} class="filter-check w-4 h-4">
                                    <span class="{{ ($selected['skema'] ?? '') === $opt ? 'font-semibold text-blue-700' : '' }}">{{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-5 pb-5 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-800 mb-3">Durasi Pelaksanaan</p>
                        <div class="space-y-2.5">
                            @foreach ($durasiOptions as $opt)
                                <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                                    <input type="checkbox" name="durasi" value="{{ $opt }}" data-durasi {{ ($selected['durasi'] ?? '') === $opt ? 'checked' : '' }} class="filter-check w-4 h-4 rounded">
                                    <span class="{{ ($selected['durasi'] ?? '') === $opt ? 'font-semibold text-blue-700' : '' }}">{{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-5">
                        <p class="text-xs font-bold text-slate-800 mb-3">Fasilitas &amp; Benefit</p>
                        <div class="space-y-2.5">
                            @foreach ($fasilitasOptions as $opt)
                                <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                                    <input type="checkbox" name="fasilitas[]" value="{{ $opt }}" {{ in_array($opt, $selected['fasilitas'], true) ? 'checked' : '' }} class="filter-check w-4 h-4 rounded">
                                    <span class="{{ in_array($opt, $selected['fasilitas'], true) ? 'font-semibold text-blue-700' : '' }}">{{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white text-sm font-bold py-3 rounded-lg transition-colors">
                        Terapkan Filter
                    </button>
                </form>
            </aside>

            <section class="lg:col-span-9">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                    <p class="text-sm font-bold text-slate-900">
                        {{ $lowongans->total() }} lowongan ditemukan untuk jurusanmu
                    </p>
                    <span class="text-xs font-semibold text-slate-500 border border-slate-200 rounded-lg px-3 py-2 bg-white">
                        Urutan: Paling Baru
                    </span>
                </div>

                @if ($lowongans->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach ($lowongans as $i => $l)
                            @php
                                $isFeatured = $i === 0;
                                $logoColor = $l->logo_color ?: '#dc2626';
                                $logoShort = $l->company_short ? \Illuminate\Support\Str::limit($l->company_short, 7, '') : \Illuminate\Support\Str::limit($l->company_name, 7, '');
                                $benefitMain = $l->benefits[0] ?? 'Sertifikat Resmi Industri';
                            @endphp
                            <div class="group bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col hover:border-blue-500 hover:ring-1 hover:ring-blue-500 transition-colors">
                                <div class="p-5">
                                    <div class="flex items-start justify-between gap-3 mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white text-[10px] font-black tracking-wide shrink-0" style="background-color: {{ $logoColor }}">
                                                {{ $logoShort }}
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded mb-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.745 3.745 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                                                    Mitra Resmi
                                                </span>
                                                <p class="text-xs text-slate-500">{{ $l->company_name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-lg leading-snug">{{ $l->title }}</h3>
                                    <div class="flex flex-wrap gap-2 mt-2.5">
                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-700 text-[11px] font-bold rounded">{{ $l->jurusan }}</span>
                                        @if ($l->kuota > 0)
                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded">Sisa {{ $l->kuota }} Kuota</span>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 mt-3 text-xs text-slate-500">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                            {{ $l->location }}
                                        </span>
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ $l->duration }}
                                        </span>
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                            {{ $l->metode_kerja }}
                                        </span>
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z" /></svg>
                                            {{ $benefitMain }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-auto border-t border-slate-100 px-5 py-4">
                                    <p class="text-xs text-slate-500 mb-3">
                                        Batas Akhir: <span class="font-bold text-red-600">{{ $l->batas_pendaftaran->translatedFormat('d M Y') }}</span>
                                    </p>
                                    <a href="{{ $l->jenis === 'magang' ? route('pusat-karir.lamar', $l->slug) : route('pusat-karir.detail', $l->slug) }}"
                                        class="block text-center text-sm font-bold py-2.5 rounded-lg transition-colors bg-slate-100 text-slate-700 hover:bg-slate-200 group-hover:bg-blue-700 group-hover:text-white">
                                        Lihat Detail &amp; Ajukan →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $lowongans->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-10 text-center">
                        <p class="text-sm font-bold text-slate-700 mb-1">Belum ada magang yang cocok</p>
                        <p class="text-xs text-slate-400">Coba ubah filter atau reset pencarian Anda.</p>
                    </div>
                @endif
            </section>
        </div>
    </main>

    @include('partials.footer')
</body>

</html>
