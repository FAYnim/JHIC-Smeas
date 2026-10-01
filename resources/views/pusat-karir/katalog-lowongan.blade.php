<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bursa Kerja Khusus (BKK) Alumni | Pusat Karir SMKN 1 Surabaya</title>

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
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
    @include('partials.navbar', ['activePage' => 'pusat-karir'])

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <nav class="text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('beranda') }}" class="hover:text-blue-600 font-semibold">Beranda</a>
            <span class="mx-1">/</span>
            <a href="{{ route('pusat-karir.index') }}" class="hover:text-blue-600 font-semibold">Pusat Karir</a>
            <span class="mx-1">/</span>
            <span class="font-bold text-slate-900">Lowongan Kerja</span>
        </nav>

        <h1 class="text-3xl font-extrabold text-slate-900">Bursa Kerja Khusus (BKK) Alumni</h1>
        <p class="text-sm text-slate-500 mt-2">Peluang kerja purnawaktu, paruhwaktu, dan kontrak industri terpercaya bagi lulusan serta alumni SMKN 1 Surabaya.</p>

        <form action="{{ route('pusat-karir.katalog-lowongan') }}" method="GET" class="mt-6 flex items-center bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <svg class="w-5 h-5 text-slate-400 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input type="text" name="q" value="{{ $selected['q'] ?? '' }}" placeholder="Cari nama posisi karir, keahlian, atau nama perusahaan mitra..."
                class="flex-1 border-0 outline-none px-3 py-4 text-sm text-slate-700 placeholder:text-slate-400">
            <button type="submit" class="m-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors shrink-0">
                Cari Lowongan
            </button>
        </form>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-8">
            <aside class="lg:col-span-3">
                <form action="{{ route('pusat-karir.katalog-lowongan') }}" method="GET" class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 sticky top-24">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-bold text-slate-900">Filter Lowongan</h2>
                        <a href="{{ route('pusat-karir.katalog-lowongan') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Reset</a>
                    </div>

                    @if ($selected['q'] ?? null)
                        <input type="hidden" name="q" value="{{ $selected['q'] }}">
                    @endif
                    @if (($selected['urut'] ?? null))
                        <input type="hidden" name="urut" value="{{ $selected['urut'] }}">
                    @endif

                    <div class="mb-5 pb-5 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-800 mb-3">Tipe Pekerjaan</p>
                        <div class="space-y-2.5">
                            @foreach ($tipeOptions as $opt)
                                <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                                    <input type="checkbox" name="tipe[]" value="{{ $opt }}" {{ in_array($opt, $selected['tipe'], true) ? 'checked' : '' }} class="filter-check w-4 h-4 rounded">
                                    <span class="{{ in_array($opt, $selected['tipe'], true) ? 'font-semibold text-blue-700' : '' }}">{{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-5 pb-5 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-800 mb-3">Pengalaman</p>
                        <div class="space-y-2.5">
                            @foreach ($pengalamanOptions as $opt)
                                <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                                    <input type="checkbox" name="pengalaman[]" value="{{ $opt }}" {{ in_array($opt, $selected['pengalaman'], true) ? 'checked' : '' }} class="filter-check w-4 h-4 rounded">
                                    <span class="{{ in_array($opt, $selected['pengalaman'], true) ? 'font-semibold text-blue-700' : '' }}">{{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-5 pb-5 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-800 mb-3">Bidang Industri</p>
                        <div class="space-y-2.5">
                            @foreach ($bidangOptions as $opt)
                                <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                                    <input type="checkbox" name="bidang[]" value="{{ $opt }}" {{ in_array($opt, $selected['bidang'], true) ? 'checked' : '' }} class="filter-check w-4 h-4 rounded">
                                    <span class="{{ in_array($opt, $selected['bidang'], true) ? 'font-semibold text-blue-700' : '' }}">{{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-5 pb-5 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-800 mb-3">Estimasi Rentang Gaji</p>
                        <div class="space-y-2.5">
                            @foreach ($gajiOptions as $key => $opt)
                                <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                                    <input type="radio" name="gaji" value="{{ $key }}" {{ ($selected['gaji'] ?? 'semua') === $key ? 'checked' : '' }} class="filter-check w-4 h-4">
                                    <span class="{{ ($selected['gaji'] ?? 'semua') === $key ? 'font-semibold text-blue-700' : '' }}">{{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-5">
                        <p class="text-xs font-bold text-slate-800 mb-3">Kualifikasi Lulusan</p>
                        <div class="space-y-2.5">
                            @foreach ($jenjangOptions as $opt)
                                <label class="flex items-center gap-2.5 text-sm text-slate-600 cursor-pointer">
                                    <input type="checkbox" name="jenjang[]" value="{{ $opt }}" {{ in_array($opt, $selected['jenjang'], true) ? 'checked' : '' }} class="filter-check w-4 h-4 rounded">
                                    <span class="{{ in_array($opt, $selected['jenjang'], true) ? 'font-semibold text-blue-700' : '' }}">{{ $opt }}</span>
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
                        {{ $lowongans->total() }} lowongan kerja aktif khusus alumni
                    </p>
                    <form action="{{ route('pusat-karir.katalog-lowongan') }}" method="GET" class="flex items-center gap-2">
                        @foreach ($selected as $k => $v)
                            @if ($k !== 'urut' && !empty($v))
                                @if (is_array($v))
                                    @foreach ($v as $item)
                                        <input type="hidden" name="{{ $k }}[]" value="{{ $item }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                @endif
                            @endif
                        @endforeach
                        <label class="text-xs font-semibold text-slate-500">Urutan:</label>
                        <select name="urut" onchange="this.form.submit()"
                            class="border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="terbaru" {{ ($selected['urut'] ?? '') !== 'gaji_desc' ? 'selected' : '' }}>Terbaru</option>
                            <option value="gaji_desc" {{ ($selected['urut'] ?? '') === 'gaji_desc' ? 'selected' : '' }}>Gaji Tertinggi</option>
                        </select>
                    </form>
                </div>

                @if ($lowongans->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach ($lowongans as $i => $l)
                            @php
                                $isFeatured = $i === 0;
                                $logoColor = $l->logo_color ?: '#2563eb';
                                $logoShort = $l->company_short ? \Illuminate\Support\Str::limit($l->company_short, 6, '') : \Illuminate\Support\Str::limit($l->company_name, 6, '');
                                $jenisLabel = $l->tipe_pekerjaan ? \Illuminate\Support\Str::before($l->tipe_pekerjaan, ' (') : 'Lowongan';
                                $gajiText = null;
                                if ($l->gaji_min && $l->gaji_max) {
                                    $gajiText = $l->gaji_min === $l->gaji_max
                                        ? 'Rp ' . number_format($l->gaji_min, 0, ',', '.') . ' (Standar UMK)'
                                        : 'Rp ' . number_format($l->gaji_min, 0, ',', '.') . ' – ' . number_format($l->gaji_max, 0, ',', '.');
                                } elseif ($l->gaji_min) {
                                    $gajiText = 'Rp ' . number_format($l->gaji_min, 0, ',', '.') . ' – ' . number_format($l->gaji_max ?: $l->gaji_min, 0, ',', '.');
                                }
                            @endphp
                            <div class="group bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col hover:border-blue-500 hover:ring-1 hover:ring-blue-500 transition-colors">
                                <div class="p-5 flex items-start justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white text-[10px] font-black tracking-wide shrink-0" style="background-color: {{ $logoColor }}">
                                            {{ $logoShort }}
                                        </div>
                                        <div>
                                            <span class="inline-block px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded mb-1">{{ $jenisLabel }}</span>
                                            <p class="text-xs text-slate-500">{{ $l->company_name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-5 pb-4">
                                    <h3 class="font-bold text-slate-900 text-lg leading-snug">{{ $l->title }}</h3>
                                    <div class="flex flex-wrap gap-2 mt-2.5">
                                        @if ($l->fresh_graduate_ok)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                                                Fresh Graduate Ok
                                            </span>
                                        @endif
                                        @if ($l->is_mitra_dudi)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-slate-100 text-slate-600 text-[11px] font-bold rounded">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.745 3.745 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                                                Mitra DUDI
                                            </span>
                                        @endif
                                        @if ($l->pengalaman && !str_contains(strtolower($l->pengalaman), 'fresh'))
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-amber-50 text-amber-700 text-[11px] font-bold rounded">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                Pengalaman {{ $l->pengalaman }}
                                            </span>
                                        @endif
                                    </div>
                                    @if ($gajiText)
                                        <p class="mt-3 text-sm font-bold text-emerald-600 inline-flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33" /></svg>
                                            {{ $gajiText }}
                                        </p>
                                    @endif
                                    <div class="flex flex-col sm:flex-row sm:justify-between gap-2 mt-2.5 text-xs text-slate-500">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                            {{ $l->location }}
                                        </span>
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" /></svg>
                                            Min. {{ $l->jenjang_pendidikan ?: 'SMK / MAK Sederajat' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-auto border-t border-slate-100 px-5 py-4">
                                    <p class="text-xs text-slate-500 mb-3">
                                        Batas Lamaran: <span class="font-bold text-red-600">{{ $l->batas_pendaftaran->translatedFormat('d M Y') }}</span>
                                    </p>
                                    <a href="{{ route('pusat-karir.detail', $l->slug) }}"
                                        class="block text-center text-sm font-bold py-2.5 rounded-lg transition-colors bg-slate-100 text-slate-700 hover:bg-slate-200 group-hover:bg-blue-700 group-hover:text-white">
                                        Lihat Detail &amp; Lamar →
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
                        <p class="text-sm font-bold text-slate-700 mb-1">Tidak ada lowongan yang cocok</p>
                        <p class="text-xs text-slate-400">Coba ubah kata kunci atau reset filter Anda.</p>
                    </div>
                @endif
            </section>
        </div>
    </main>

    <footer class="w-full bg-blue-700 text-white text-center py-4 text-sm font-semibold">
        Dibuat dengan <span class="text-red-500">❤️</span> oleh Chicken Noodles Team
    </footer>
</body>

</html>
