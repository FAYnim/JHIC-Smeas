<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mitra->name }} | Pusat Karir SMKN 1 Surabaya</title>

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
            background-color: #f1f5f9;
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

        .company-header {
            background: linear-gradient(135deg, #0a1628 0%, #0f2847 50%, #162e52 100%);
            border-radius: 1rem;
            padding: 1.75rem 2rem;
            margin-top: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.06);
            position: relative;
            overflow: hidden;
        }

        .company-header::before {
            content: '';
            position: absolute;
            top: -2px;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2563eb, #3b82f6, #60a5fa);
            border-radius: 4px 4px 0 0;
        }

        .section-tabs {
            display: flex;
            gap: 0;
            border-bottom: 2px solid #e2e8f0;
            margin-top: 1.75rem;
        }

        .section-tab {
            border: none;
            background: transparent;
            padding: 0.9rem 1.25rem;
            font-weight: 600;
            font-size: 0.88rem;
            color: #64748b;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .section-tab.active {
            color: #0f172a;
            font-weight: 700;
            border-bottom-color: #2563eb;
        }

        .filter-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn.active {
            background: #0f172a;
            color: #ffffff;
            border-color: #0f172a;
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
            <a href="{{ route('pusat-karir.katalog-mitra') }}" class="hover:text-blue-600 font-semibold">Mitra Industri (DUDI)</a>
            <span class="mx-1">/</span>
            <span class="font-bold text-slate-900">{{ $mitra->name }}</span>
        </nav>

        @php
            $stats = $mitra->stats ?? [];
            $lowonganMagang = $mitra->lowongans->where('jenis', 'magang');
            $lowonganLoker = $mitra->lowongans->where('jenis', 'lowongan');
            $totalPeluang = $mitra->lowongans->count();
            $waLink = $mitra->narahubung_wa ? 'https://wa.me/' . $mitra->narahubung_wa : '#';
        @endphp

        <div class="company-header">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                <div class="flex items-start gap-4 flex-1 min-w-0">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-white text-xs font-black tracking-widest shrink-0 shadow-lg"
                        style="background-color: {{ $mitra->logo_color ?: '#dc2626' }}">
                        {{ $mitra->logo_text ?: \Illuminate\Support\Str::limit($mitra->name, 7, '') }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <h1 class="text-2xl font-extrabold text-white leading-snug">{{ $mitra->name }}</h1>
                            @if ($mitra->is_mou_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/15 border border-emerald-400/30 text-emerald-300 text-[10px] font-bold rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    MoU Aktif s.d. {{ optional($mitra->mou_until)->format('Y') }}
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-400 mb-3">{{ $mitra->sector }} • {{ $mitra->city }}</p>
                        <div class="flex flex-wrap gap-2 items-center">
                            @foreach (($mitra->programs ?? []) as $prog)
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-500/20 text-blue-200">{{ $prog }}</span>
                            @endforeach
                            @if ($mitra->website)
                                <a href="{{ $mitra->website }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-500/20 text-slate-200 hover:text-white">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0 0a8.949 8.949 0 004.951-1.488A3.987 3.987 0 0013 16h-2a3.987 3.987 0 00-3.951 3.512A8.949 8.949 0 0012 21zm3-11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    {{ preg_replace('#^https?://(www\.)?#', '', $mitra->website) }}
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex border border-white/10 rounded-xl overflow-hidden bg-white/5 min-w-[240px]">
                    <div class="flex-1 text-center py-3 px-2 border-r border-white/10">
                        <span class="block text-2xl font-extrabold text-white">{{ $stats['siswa_pkl'] ?? 0 }}</span>
                        <span class="block text-[11px] text-slate-400 font-semibold">Siswa PKL</span>
                    </div>
                    <div class="flex-1 text-center py-3 px-2 border-r border-white/10">
                        <span class="block text-2xl font-extrabold text-white">{{ $stats['kelas_industri'] ?? 0 }}</span>
                        <span class="block text-[11px] text-slate-400 font-semibold">Kelas Industri</span>
                    </div>
                    <div class="flex-1 text-center py-3 px-2">
                        <span class="block text-2xl font-extrabold text-white">{{ $stats['peluang_aktif'] ?? $totalPeluang }}</span>
                        <span class="block text-[11px] text-slate-400 font-semibold">Peluang Aktif</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-4 pt-4 border-t border-white/10 text-xs text-slate-400">
                <span class="inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                    {{ $mitra->address }}
                </span>
                @if ($mitra->distance_note)
                    <span class="inline-flex items-center gap-1.5 font-semibold text-amber-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H18.75m-7.5-3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        Jarak: {{ $mitra->distance_note }}
                    </span>
                @endif
                @if ($mitra->kemitraan_sejak)
                    <span class="ml-auto">Kemitraan Sejak: <strong class="text-white">{{ $mitra->kemitraan_sejak }}</strong></span>
                @endif
            </div>
        </div>

        <div class="section-tabs">
            <button type="button" class="section-tab active" data-mitra-tab="peluang">Peluang &amp; Lowongan Aktif ({{ $totalPeluang }})</button>
            <button type="button" class="section-tab" data-mitra-tab="kemitraan">Informasi Kemitraan &amp; Dokumen</button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mt-6">
            <div class="lg:col-span-8">
                <div data-mitra-panel="peluang">
                    <div class="flex flex-wrap gap-2 mb-5" id="mitra-filter-row">
                        <button type="button" class="filter-btn active" data-mitra-filter="semua">Semua ({{ $totalPeluang }})</button>
                        <button type="button" class="filter-btn" data-mitra-filter="magang">Magang PKL Siswa ({{ $lowonganMagang->count() }})</button>
                        <button type="button" class="filter-btn" data-mitra-filter="lowongan">Loker BKK Alumni ({{ $lowonganLoker->count() }})</button>
                    </div>

                    @if ($totalPeluang > 0)
                        <div class="space-y-5" id="mitra-lowongan-list">
                            @foreach ($mitra->lowongans as $l)
                                @php
                                    $isMagang = $l->jenis === 'magang';
                                    $ctaUrl = $isMagang ? route('pusat-karir.lamar', $l->slug) : route('pusat-karir.detail', $l->slug);
                                    $ctaText = $isMagang ? 'Lihat & Ajukan Magang →' : 'Lihat Detail Loker →';
                                    $gajiText = null;
                                    if ($l->gaji_min && $l->gaji_max) {
                                        $gajiText = 'Rp ' . number_format($l->gaji_min, 0, ',', '.') . ' – Rp ' . number_format($l->gaji_max, 0, ',', '.') . ' / bln';
                                    }
                                    $benefitText = implode(' & ', array_slice($l->benefits ?? [], 0, 2));
                                @endphp
                                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5" data-mitra-item data-jenis="{{ $l->jenis }}">
                                    <div class="flex items-start justify-between gap-3 mb-3">
                                        <div class="flex flex-wrap gap-2">
                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded {{ $isMagang ? 'bg-blue-50 text-blue-700' : 'bg-emerald-50 text-emerald-700' }}">
                                                {{ $isMagang ? 'MAGANG PKL' : 'LOKER BKK ALUMNI' }}
                                            </span>
                                            @if ($l->kuota > 0 && $isMagang)
                                                <span class="px-2 py-0.5 bg-amber-50 text-amber-700 text-[10px] font-bold rounded">Sisa {{ $l->kuota }} Kuota</span>
                                            @endif
                                            @if ($l->fresh_graduate_ok)
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded">Fresh Graduate Welcome</span>
                                            @endif
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded">Verifikasi NISN</span>
                                        </div>
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-lg leading-snug">{{ $l->title }}</h3>
                                    <p class="text-sm text-slate-500 mt-1">
                                        {{ $l->company_name }} • Rekomendasi Jurusan: <span class="font-bold text-blue-700">{{ $l->jurusan }}</span>
                                    </p>
                                    <div class="flex flex-wrap gap-x-5 gap-y-1.5 mt-3 text-sm text-slate-600">
                                        <span class="inline-flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Durasi: {{ $l->duration }}
                                        </span>
                                        <span class="inline-flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                            Skema: {{ $l->metode_kerja }}
                                        </span>
                                    </div>
                                    @if ($gajiText)
                                        <p class="mt-2.5 text-sm font-bold text-emerald-600 inline-flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33" /></svg>
                                            {{ $gajiText }}
                                        </p>
                                    @elseif ($benefitText)
                                        <p class="mt-2.5 text-sm font-bold text-emerald-600">💰 {{ $benefitText }}</p>
                                    @endif
                                    <div class="mt-auto pt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        <p class="text-xs text-slate-500">
                                            {{ $isMagang ? 'Batas Pengajuan Berkas' : 'Tenggat Lamaran' }}:
                                            <span class="font-bold text-red-600">{{ $l->batas_pendaftaran->translatedFormat('d M Y') }}</span>
                                        </p>
                                        <a href="{{ $ctaUrl }}"
                                            class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold rounded-lg transition-colors {{ $isMagang ? 'bg-blue-700 text-white hover:bg-blue-800' : 'border border-blue-600 text-blue-700 hover:bg-blue-50' }}">
                                            {{ $ctaText }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-xl border border-slate-200 p-8 text-center">
                            <p class="text-sm font-bold text-slate-700 mb-1">Belum ada peluang aktif</p>
                            <p class="text-xs text-slate-400">Peluang dari mitra ini akan ditampilkan di sini.</p>
                        </div>
                    @endif

                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mt-6">
                        <h3 class="font-bold text-slate-900 text-lg">Keunggulan Program Kemitraan Bersama {{ $mitra->short_name ?: \Illuminate\Support\Str::before($mitra->name, ' PT') }}</h3>
                        <p class="text-sm text-slate-500 mt-1">Manfaat terakreditasi khusus untuk siswa aktif dan lulusan terdaftar SMKN 1 Surabaya.</p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                            @php
                                $kelas = $mitra->kelas_industri ?? [];
                                $keunggulan = [
                                    ['title' => 'Kelas Industri ' . ($mitra->short_name ?: 'Mitra'), 'desc' => 'Sinkronisasi kurikulum dengan mentor ahli industri.', 'icon' => 'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15v-3.75m0 0l5.25 2.625L17.25 11.25'],
                                    ['title' => $kelas['output_sertifikasi'] ?? 'Sertifikasi Resmi', 'desc' => 'Pengakuan kompetensi nasional setelah menyelesaikan program.', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.745 3.745 0 011.043 3.296A3.745 3.745 0 0121 12z'],
                                    ['title' => 'Jalur Prioritas BKK', 'desc' => 'Rekomendasi berkinerja tinggi untuk penempatan kerja setelah lulus.', 'icon' => 'M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5'],
                                ];
                            @endphp
                            @foreach ($keunggulan as $k)
                                <div class="bg-slate-50 rounded-xl p-4">
                                    <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-blue-600 mb-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $k['icon'] }}" /></svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-900">{{ $k['title'] }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $k['desc'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div data-mitra-panel="kemitraan" class="hidden">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                        <h3 class="font-bold text-slate-900 text-lg">Kelas Industri</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                            <div class="bg-blue-50 rounded-xl p-4">
                                <p class="text-sm font-bold text-slate-900 mb-2">Jurusan Sasaran</p>
                                <ul class="text-sm text-slate-600 list-disc list-inside space-y-0.5">
                                    @foreach (($kelas['jurusan_sasaran'] ?? []) as $j)
                                        <li>{{ $j }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4">
                                <p class="text-sm font-bold text-slate-900 mb-2">Instruktur Industri</p>
                                <p class="text-sm text-slate-600">{{ $kelas['instruktur'] ?? '-' }}</p>
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4">
                                <p class="text-sm font-bold text-slate-900 mb-2">Output Sertifikasi</p>
                                <p class="text-sm text-slate-600">{{ $kelas['output_sertifikasi'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mt-5">
                        <h3 class="font-bold text-slate-900 text-lg">Dokumen Pembelajaran &amp; Persyaratan Kemitraan</h3>
                        <p class="text-sm text-slate-500 mt-1">Berkas resmi yang dapat diunduh oleh siswa, wali murid, dan bapak/ibu guru pengampu.</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                            @foreach (($mitra->documents ?? []) as $doc)
                                <a href="{{ $doc['url'] ?? '#' }}"
                                    class="flex items-center justify-between gap-3 bg-slate-50 hover:bg-slate-100 rounded-lg px-4 py-3 transition-colors">
                                    <span class="text-sm font-bold text-slate-800 truncate">{{ $doc['name'] }}</span>
                                    <svg class="w-4 h-4 text-slate-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <aside class="lg:col-span-4 space-y-5">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                    <h3 class="font-bold text-slate-900 mb-1">Narahubung Kemitraan Sekolah</h3>
                    <p class="text-xs text-slate-500 mb-4">Guru pengampu kerja sama {{ $mitra->name }}</p>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-xs font-bold shrink-0">
                            {{ \Illuminate\Support\Str::limit($mitra->narahubung_nama ?? 'AS', 2, '') }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $mitra->narahubung_nama ?: '-' }}</p>
                            <p class="text-xs text-slate-500">{{ $mitra->narahubung_jabatan }}</p>
                        </div>
                    </div>
                    <a href="{{ $waLink }}"
                        class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-emerald-500 hover:bg-emerald-400 text-white text-sm font-bold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" /></svg>
                        Hubungi via WhatsApp Pokja
                    </a>
                    <p class="text-xs text-slate-400 mt-3">Konsultasi ketersediaan kuota rombel dan surat izin Pokja.</p>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                    <h3 class="font-bold text-slate-900 mb-3">Lokasi Penempatan Industri</h3>
                    <div class="bg-slate-100 rounded-lg h-40 flex items-center justify-center relative overflow-hidden">
                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                        <span class="absolute bottom-2 left-2 text-[10px] text-slate-500 bg-white/80 px-2 py-0.5 rounded">{{ \Illuminate\Support\Str::limit($mitra->address ?? '', 40) }}</span>
                    </div>
                    <p class="text-sm font-bold text-slate-900 mt-3">{{ \Illuminate\Support\Str::before($mitra->address ?? '-', ', Jl.') ?: 'Lokasi Industri' }}</p>
                    <p class="text-xs text-slate-500">{{ $mitra->address }}</p>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($mitra->address ?? $mitra->name) }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-1 text-sm font-bold text-blue-600 hover:text-blue-700 mt-2">
                        Buka Petunjuk Arah di Google Maps
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                    </a>
                </div>

                <div class="rounded-xl bg-slate-900 p-5">
                    <h3 class="font-bold text-white mb-1">Dokumen &amp; Silabus Kemitraan</h3>
                    <p class="text-xs text-slate-400 mb-4">Unduh materi acuan resmi sebelum mendaftar.</p>
                    <div class="space-y-3">
                        @foreach (array_slice($mitra->documents ?? [], 0, 2) as $doc)
                            <a href="{{ $doc['url'] ?? '#' }}" class="flex items-center justify-between gap-3 bg-slate-800 rounded-lg px-4 py-3">
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-white truncate">{{ $doc['name'] }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $doc['desc'] }}</p>
                                </div>
                                <span class="text-xs font-bold text-blue-400 shrink-0 inline-flex items-center gap-1">
                                    Unduh
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>

        <div class="mt-12 rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <span class="inline-block px-3 py-1 bg-blue-600 text-white text-[10px] font-bold tracking-widest uppercase rounded mb-3">Kemitraan Industri</span>
                <h2 class="text-2xl font-extrabold text-white leading-snug">Tertarik Menjadi Bagian Mitra Resmi SMKN 1 Surabaya?</h2>
                <p class="text-sm text-slate-300 mt-2 max-w-xl">Buka akses ke ribuan talenta vokasi siap kerja, sinkronisasi kurikulum industri, atau penyelenggaraan kelas industri bersama.</p>
            </div>
            <div class="flex flex-col gap-3 shrink-0">
                <a href="#"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-white text-sm font-bold rounded-lg transition-colors">
                    Hubungi Pokja Hubungan Industri
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                </a>
                <a href="#"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-slate-600 text-slate-200 hover:text-white hover:border-slate-400 text-sm font-bold rounded-lg transition-colors">
                    Unduh Draf Panduan MoU (.PDF)
                </a>
            </div>
        </div>
    </main>

    <footer class="w-full bg-blue-700 text-white text-center py-4 text-sm font-semibold">
        Dibuat dengan <span class="text-red-500">❤️</span> oleh Chicken Noodles Team
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('[data-mitra-tab]');
            const panels = document.querySelectorAll('[data-mitra-panel]');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    panels.forEach(p => {
                        p.classList.toggle('hidden', p.getAttribute('data-mitra-panel') !== tab.getAttribute('data-mitra-tab'));
                    });
                });
            });

            const filterRow = document.getElementById('mitra-filter-row');
            const items = document.querySelectorAll('[data-mitra-item]');
            if (filterRow && items.length) {
                filterRow.addEventListener('click', (e) => {
                    const btn = e.target.closest('.filter-btn');
                    if (!btn) return;
                    filterRow.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    const filter = btn.getAttribute('data-mitra-filter');
                    items.forEach(item => {
                        const show = filter === 'semua' || item.getAttribute('data-jenis') === filter;
                        item.classList.toggle('hidden', !show);
                    });
                });
            }
        });
    </script>
</body>

</html>
