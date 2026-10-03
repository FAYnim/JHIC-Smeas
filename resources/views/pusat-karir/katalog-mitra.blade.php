<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jaringan Kemitraan DUDI | Pusat Karir SMKN 1 Surabaya</title>

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

        .sector-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.55rem 1.1rem;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 700;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
        }

        .sector-pill:hover {
            border-color: #93c5fd;
            color: #1d4ed8;
        }

        .sector-pill.active {
            background: #1d4ed8;
            color: #fff;
            border-color: #1d4ed8;
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
            <span class="font-bold text-slate-900">Mitra Industri (DUDI)</span>
        </nav>

        <h1 class="text-3xl font-extrabold text-slate-900">Jaringan Kemitraan DUDI SMKN 1 Surabaya</h1>
        <p class="text-sm text-slate-500 mt-2">Eksplorasi ekosistem Dunia Usaha dan Dunia Industri yang terikat kerja sama resmi, kelas industri, dan penyaluran kerja.</p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3">
                <div class="w-11 h-11 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" /></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-slate-900">{{ $totalMitra }}+ Mitra</p>
                    <p class="text-xs text-slate-500">Terikat MoU Resmi Aktif</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3">
                <div class="w-11 h-11 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" /></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-slate-900">{{ number_format($totalSiswa) }}+ Siswa/Tahun</p>
                    <p class="text-xs text-slate-500">Tersalurkan Magang &amp; Kerja</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3">
                <div class="w-11 h-11 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" /></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-slate-900">{{ $totalKelas }} Kelas Industri</p>
                    <p class="text-xs text-slate-500">Kurikulum Sinkronisasi Industri</p>
                </div>
            </div>
        </div>

        <form action="{{ route('pusat-karir.katalog-mitra') }}" method="GET" class="mt-5 flex items-center bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <svg class="w-5 h-5 text-slate-400 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama perusahaan rekanan atau kota operasional..."
                class="flex-1 border-0 outline-none px-3 py-4 text-sm text-slate-700 placeholder:text-slate-400">
            @if (request('sector'))
                <input type="hidden" name="sector" value="{{ request('sector') }}">
            @endif
            @if (request('program'))
                <input type="hidden" name="program" value="{{ request('program') }}">
            @endif
            <button type="submit" class="m-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors shrink-0">
                Cari Mitra
            </button>
        </form>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mt-5">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('pusat-karir.katalog-mitra') }}" class="sector-pill {{ !request('sector') ? 'active' : '' }}">Semua Sektor</a>
                @foreach (['Teknologi Informasi', 'Kreatif & Media', 'Manufaktur & Logistik', 'Perbankan & Jasa'] as $sec)
                    <a href="{{ route('pusat-karir.katalog-mitra', array_filter(['sector' => $sec, 'q' => request('q'), 'program' => request('program')])) }}"
                        class="sector-pill {{ request('sector') === $sec ? 'active' : '' }}">{{ $sec }}</a>
                @endforeach
            </div>
            <form action="{{ route('pusat-karir.katalog-mitra') }}" method="GET" class="flex items-center gap-2">
                @if (request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                @if (request('sector'))
                    <input type="hidden" name="sector" value="{{ request('sector') }}">
                @endif
                <label class="text-xs font-semibold text-slate-500">Program:</label>
                <select name="program" onchange="this.form.submit()"
                    class="border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kerja Sama</option>
                    <option value="Tempat PKL Resmi" {{ request('program') === 'Tempat PKL Resmi' ? 'selected' : '' }}>Tempat PKL Resmi</option>
                    <option value="Kelas Industri" {{ request('program') === 'Kelas Industri' ? 'selected' : '' }}>Kelas Industri</option>
                    <option value="Guru Tamu" {{ request('program') === 'Guru Tamu' ? 'selected' : '' }}>Guru Tamu</option>
                    <option value="Sponsor JHIC" {{ request('program') === 'Sponsor JHIC' ? 'selected' : '' }}>Sponsor JHIC</option>
                    <option value="Rekrutmen BKK" {{ request('program') === 'Rekrutmen BKK' ? 'selected' : '' }}>Rekrutmen BKK</option>
                    <option value="Penyalur Alumni" {{ request('program') === 'Penyalur Alumni' ? 'selected' : '' }}>Penyalur Alumni</option>
                    <option value="Mitra DKV" {{ request('program') === 'Mitra DKV' ? 'selected' : '' }}>Mitra DKV</option>
                </select>
            </form>
        </div>

        @if ($mitras->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mt-6">
                @foreach ($mitras as $i => $m)
                    @php
                        $peluang = $m->lowongans()->count();
                        $magang = $m->lowongans()->where('jenis', 'magang')->count();
                        $loker = $m->lowongans()->where('jenis', 'lowongan')->count();
                        $peluangText = match (true) {
                            $magang > 0 && $loker > 0 => "{$magang} Magang + {$loker} Loker",
                            $magang > 0 => "{$magang} Posisi Magang",
                            $loker > 0 => "{$loker} Loker Aktif",
                            default => 'Segera hadir',
                        };
                        $peluangNote = $peluang > 0 ? 'tersedia' : 'sedang dibuka';
                        $sectorLine = "{$m->sector} • {$m->city}";
                    @endphp
                    <div class="bg-white rounded-xl border {{ $i === 0 ? 'border-blue-500 ring-1 ring-blue-500' : 'border-slate-200' }} shadow-sm p-5 flex flex-col">
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white text-[10px] font-black tracking-wide shrink-0" style="background-color: {{ $m->logo_color ?: '#2563eb' }}">
                                {{ $m->logo_text ?: \Illuminate\Support\Str::limit($m->name, 6, '') }}
                            </div>
                            @if ($m->is_mou_active)
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h18v2H3V3zm0 4h18v14H3V7zm2 2v10h14V9H5z" /></svg>
                                    MoU Aktif
                                </span>
                            @endif
                        </div>
                        <h3 class="font-bold text-slate-900 text-lg leading-snug">{{ $m->name }}</h3>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $sectorLine }}</p>
                        <div class="flex flex-wrap gap-2 mt-3">
                            @foreach (($m->programs ?? []) as $prog)
                                <span class="px-2 py-0.5 bg-amber-50 text-amber-700 text-[10px] font-bold rounded">{{ $prog }}</span>
                            @endforeach
                        </div>
                        <p class="text-sm text-slate-600 mt-3 line-clamp-2">{{ $m->description }}</p>
                        <div class="mt-3 text-xs text-slate-500 border border-slate-100 rounded-lg px-3 py-2">
                            <span class="font-bold text-slate-700">🔥 {{ $peluangText }}</span>
                            <span class="ml-1">{{ $peluangNote }}</span>
                        </div>
                        <a href="{{ route('pusat-karir.detail-mitra', $m->slug) }}"
                            class="mt-4 inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold rounded-lg transition-colors {{ $i === 0 ? 'bg-blue-700 text-white hover:bg-blue-800' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            Lihat Profil &amp; Lowongan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $mitras->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-10 text-center mt-6">
                <p class="text-sm font-bold text-slate-700 mb-1">Tidak ada mitra yang cocok</p>
                <p class="text-xs text-slate-400">Coba ubah kata kunci atau reset filter sektor.</p>
            </div>
        @endif

        <div class="mt-12 rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <span class="inline-block px-3 py-1 bg-blue-600 text-white text-[10px] font-bold tracking-widest uppercase rounded mb-3">Kemitraan Industri</span>
                <h2 class="text-2xl font-extrabold text-white leading-snug">Tertarik Menjadi Bagian Mitra Resmi SMKN 1 Surabaya?</h2>
                <p class="text-sm text-slate-300 mt-2 max-w-xl">Buka akses ke ribuan talenta vokasi siap kerja, sinkronisasi kurikulum industri, atau penyelenggaraan kelas industri bersama.</p>
            </div>
            <div class="flex flex-col gap-3 shrink-0">
                <a href="{{ route('pusat-karir.index') }}#kontak"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-white text-sm font-bold rounded-lg transition-colors">
                    Hubungi Pokja Hubungan Industri
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                </a>
                <a href="{{ asset('storage/dokumen/panduan-mou.pdf') }}" download
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-slate-600 text-slate-200 hover:text-white hover:border-slate-400 text-sm font-bold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    Unduh Draf Panduan MoU (.PDF)
                </a>
            </div>
        </div>
    </main>

    <footer class="w-full bg-blue-700 text-white text-center py-4 text-sm font-semibold">
        Dibuat dengan <span class="text-red-500">❤️</span> oleh Chicken Noodles Team
    </footer>
</body>

</html>
