<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Tracer & Jejak Karir Alumni | Pusat Karir SMKN 1 Surabaya</title>

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
            <span class="font-bold text-slate-900">Study Tracer</span>
        </nav>

        @if (session('success'))
            <div class="mb-4 flex items-start justify-between gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800" id="flash-success">
                <p class="font-semibold">{{ session('success') }}</p>
                <button type="button" onclick="document.getElementById('flash-success').remove()" class="text-green-700 hover:text-green-900 font-bold shrink-0" aria-label="Tutup">&times;</button>
            </div>
        @endif

        @if (session('error') || $errors->any())
            <div class="mb-4 flex items-start justify-between gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" id="flash-error">
                <p class="font-semibold">{{ session('error') ?? $errors->first() }}</p>
                <button type="button" onclick="document.getElementById('flash-error').remove()" class="text-red-700 hover:text-red-900 font-bold shrink-0" aria-label="Tutup">&times;</button>
            </div>
        @endif

        {{-- Hero --}}
        <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#0a1628] to-[#023775] min-h-[240px] flex items-center">
            <div class="absolute inset-y-0 right-0 w-1/2 hidden md:block">
                <img src="https://placehold.co/800x600/023775/ffffff?text=SMKN+1+Surabaya" alt="Gedung SMKN 1 Surabaya" class="w-full h-full object-cover opacity-40">
                <div class="absolute inset-0 bg-gradient-to-r from-[#0a1628] via-[#0a1628]/70 to-transparent"></div>
            </div>
            <div class="relative z-10 px-6 py-10 md:px-10 max-w-2xl">
                <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">Study Tracer &amp; Jejak Karir Alumni</h1>
                <p class="mt-4 text-sm md:text-base text-slate-200 leading-relaxed">
                    Pantau keterhubungan lulusan SMKN 1 Surabaya di Dunia Usaha, Dunia Industri, serta Perguruan Tinggi. Bantu almamater dengan mengisi data karir terkini untuk sinkronisasi kurikulum industri.
                </p>
                <a href="{{ route('pusat-karir.study-tracer.kuesioner') }}"
                    class="mt-6 inline-flex items-center gap-2 rounded-lg bg-[#fbbf24] px-6 py-3 text-sm font-bold text-slate-900 hover:bg-amber-300 transition-colors">
                    ✍ Isi Kuesioner Karir
                </a>
            </div>
        </section>

        {{-- Stat cards --}}
        @php
            $trendColorMap = [
                'green' => 'text-green-600',
                'blue' => 'text-blue-600',
                'slate' => 'text-slate-500',
            ];

            $statColor = function (string $color) use ($trendColorMap): string {
                if (str_starts_with($color, '#')) {
                    return '';
                }

                return $trendColorMap[$color] ?? 'text-slate-500';
            };

            $statStyle = function (string $color): string {
                return str_starts_with($color, '#') ? 'style="color: ' . e($color) . '"' : '';
            };
        @endphp

        <section class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $stats = [
                    [
                        'value' => $setting->tingkat_keterserapan ?? '91,8%',
                        'label' => 'Tingkat Keterserapan Alumni',
                        'sub' => $setting->keterserapan_trend ?? '↑ 3,2% dari tahun lalu',
                        'color' => $setting->keterserapan_trend_warna ?? 'green',
                    ],
                    [
                        'value' => $setting->masa_tunggu ?? '1,8 Bln',
                        'label' => 'Rata-rata Masa Tunggu Kerja',
                        'sub' => $setting->masa_tunggu_sub ?? 'Lulusan langsung terserap DUDI',
                        'color' => $setting->masa_tunggu_sub_warna ?? 'blue',
                    ],
                    [
                        'value' => $setting->kesesuaian ?? '86,4%',
                        'label' => 'Kesesuaian Bidang Kejuruan',
                        'sub' => $setting->kesesuaian_sub ?? 'Linear dengan program keahlian',
                        'color' => $setting->kesesuaian_sub_warna ?? 'slate',
                    ],
                    [
                        'value' => $setting->total_alumni ?? '2.450+',
                        'label' => 'Total Alumni Terdata',
                        'sub' => $setting->total_alumni_sub ?? 'Database aktif BKK sekolah',
                        'color' => $setting->total_alumni_sub_warna ?? 'blue',
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <p class="text-3xl font-extrabold text-slate-900">{{ $stat['value'] }}</p>
                    <p class="mt-1 text-sm font-semibold text-slate-700">{{ $stat['label'] }}</p>
                    <p class="mt-2 text-xs font-bold {{ $statColor($stat['color']) }}" {!! $statStyle($stat['color']) !!}>{{ $stat['sub'] }}</p>
                </div>
            @endforeach
        </section>

        {{-- Two-column: BMW Index + form verifikasi --}}
        <section class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-extrabold text-slate-900">Distribusi Status Lulusan (BMW Index)</h2>
                <p class="mt-1 text-xs text-slate-500">Berdasarkan pendataan alumni angkatan 2023 - 2025.</p>

                <div class="mt-6 space-y-5">
                    @forelse ($statuses as $status)
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-sm font-semibold text-slate-700">{{ $status->nama }}</span>
                                <span class="text-sm font-bold text-slate-900">{{ rtrim(rtrim(number_format($status->persen, 2, ',', '.'), '0'), ',') }}%</span>
                            </div>
                            <div class="h-2.5 w-full rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full rounded-full" style="width: {{ $status->persen }}%; background-color: {{ $status->warna }}"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">Belum ada data distribusi status lulusan.</p>
                    @endforelse
                </div>

                <p class="mt-6 text-xs text-slate-500 leading-relaxed">
                    {{ $setting->catatan_bmw ?? '📌 Data diperbarui otomatis setiap semester melalui sinkronisasi sistem BKK & Kemendikbud.' }}
                </p>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-extrabold text-slate-900">Pembaruan Data Alumni</h2>
                <p class="mt-1 text-sm text-slate-600">Kamu lulusan SMKN 1 Surabaya? Masukkan data untuk mulai.</p>

                <form method="GET" action="{{ route('pusat-karir.study-tracer.kuesioner') }}" class="mt-5 space-y-4">
                    <div>
                        <label for="nisn" class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor Induk Siswa Nasional (NISN)</label>
                        <input type="text" name="nisn" id="nisn" maxlength="10" pattern="[0-9]{10}" inputmode="numeric" required
                            placeholder="Contoh: 0058291823"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label for="tahun_lulus" class="block text-sm font-semibold text-slate-700 mb-1.5">Tahun Kelulusan</label>
                        <select name="tahun_lulus" id="tahun_lulus" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="">Pilih tahun kelulusan</option>
                            @for ($year = 2025; $year >= 2015; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full rounded-lg bg-blue-600 px-4 py-3 text-sm font-bold text-white hover:bg-blue-700 transition-colors">
                        Verifikasi Data &amp; Lanjut Isi
                    </button>
                </form>

                <div class="mt-4 rounded-lg bg-blue-50 border border-blue-100 px-4 py-3 text-xs text-blue-800 leading-relaxed">
                    🔒 Kerahasiaan data pribadi dilindungi dan hanya digunakan untuk keperluan evaluasi serta akreditasi resmi SMKN 1 Surabaya.
                </div>
            </div>
        </section>

        {{-- Mitra Penerima Lulusan --}}
        <section class="mt-10">
            <h2 class="text-xl font-extrabold text-slate-900">Mitra Penerima Lulusan</h2>
            <p class="mt-1 text-sm text-slate-500">DUDI &amp; Instansi yang secara rutin merekrut alumni SMKN 1 Surabaya setiap tahun ajaran.</p>

            <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @forelse ($mitras as $mitra)
                    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm text-center">
                        <p class="text-sm font-extrabold leading-snug" style="color: {{ $mitra->warna }}">{{ $mitra->nama }}</p>
                        <p class="mt-2 text-xs font-semibold text-slate-600">
                            {{ $mitra->jumlah_alumni }}+ {{ $mitra->catatan ?? 'Alumni Aktif' }}
                        </p>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 col-span-full">Belum ada data mitra penerima lulusan.</p>
                @endforelse
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>

</html>
