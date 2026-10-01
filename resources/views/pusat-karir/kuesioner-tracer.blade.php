<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kuesioner Tracer Study | Pusat Karir SMKN 1 Surabaya</title>

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

<body class="bg-slate-50 text-slate-800 antialiased">
    @include('partials.navbar', ['activePage' => 'pusat-karir'])

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <nav class="text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('beranda') }}" class="hover:text-blue-600 font-semibold">Beranda</a>
            <span class="mx-1">/</span>
            <a href="{{ route('pusat-karir.index') }}" class="hover:text-blue-600 font-semibold">Pusat Karir</a>
            <span class="mx-1">/</span>
            <a href="{{ route('pusat-karir.study-tracer') }}" class="hover:text-blue-600 font-semibold">Study Tracer</a>
            <span class="mx-1">/</span>
            <span class="font-bold text-slate-900">Form Kuesioner</span>
        </nav>

        @php
            $identity = $alumni ?? null;
            $sessionVerified = $verified ?? null;

            $namaValue = $identity->nama ?? ($sessionVerified['nama'] ?? '');
            $jurusanValue = $identity->jurusan ?? ($sessionVerified['jurusan'] ?? '');
            $nisnValue = $identity->nisn ?? ($sessionVerified['nisn'] ?? '');
            $tahunValue = $identity->tahun_lulus ?? ($sessionVerified['tahun_lulus'] ?? '');
        @endphp

        <div class="max-w-3xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 md:p-8">
                <h1 class="text-2xl font-extrabold text-slate-900 text-center">Kuisioner Tracer Study</h1>

                {{-- Stepper --}}
                <div class="mt-6 flex items-center justify-center gap-2 bg-slate-100 rounded-lg px-4 py-3">
                    <span class="text-xs font-bold text-slate-900">Data Alumni</span>
                    <span class="h-px w-8 sm:w-16 bg-slate-300"></span>
                    <span class="text-xs font-bold text-slate-900">Status Karir</span>
                    <span class="h-px w-8 sm:w-16 bg-slate-300"></span>
                    <span class="text-xs font-bold text-slate-900">Rincian Alumni</span>
                </div>

                {{-- Alumni identity --}}
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="rounded-lg bg-[#eff6ff] border border-blue-100 px-4 py-3">
                        <p class="text-[11px] font-semibold text-blue-800/70 uppercase tracking-wide">Nama Lengkap</p>
                        <p class="mt-0.5 text-sm font-bold text-slate-900">{{ $namaValue !== '' ? $namaValue : '—' }}</p>
                    </div>
                    <div class="rounded-lg bg-[#eff6ff] border border-blue-100 px-4 py-3">
                        <p class="text-[11px] font-semibold text-blue-800/70 uppercase tracking-wide">Jurusan</p>
                        <p class="mt-0.5 text-sm font-bold text-slate-900">{{ $jurusanValue !== '' ? $jurusanValue : '—' }}</p>
                    </div>
                    <div class="rounded-lg bg-[#eff6ff] border border-blue-100 px-4 py-3">
                        <p class="text-[11px] font-semibold text-blue-800/70 uppercase tracking-wide">NISN</p>
                        <p class="mt-0.5 text-sm font-bold text-slate-900">{{ $nisnValue !== '' ? $nisnValue : '—' }}</p>
                    </div>
                    <div class="rounded-lg bg-[#eff6ff] border border-blue-100 px-4 py-3">
                        <p class="text-[11px] font-semibold text-blue-800/70 uppercase tracking-wide">Lulusan</p>
                        <p class="mt-0.5 text-sm font-bold text-slate-900">{{ $tahunValue !== '' ? 'Lulusan '.$tahunValue : '—' }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('pusat-karir.study-tracer.store') }}" class="mt-8 space-y-6">
                    @csrf

                    <input type="hidden" name="alumnis_id" value="{{ $identity->id ?? ($sessionVerified['alumnis_id'] ?? '') }}">
                    <input type="hidden" name="nisn" value="{{ $nisnValue }}">
                    <input type="hidden" name="nama" value="{{ $namaValue }}">
                    <input type="hidden" name="jurusan" value="{{ $jurusanValue }}">
                    <input type="hidden" name="tahun_lulus" value="{{ $tahunValue }}">

                    {{-- Q1 --}}
                    <div>
                        <p class="text-sm font-bold text-slate-900 mb-2.5">Apakah status pekerjaan anda saat ini?</p>
                        <div class="flex flex-wrap gap-2.5" role="radiogroup" aria-label="Status pekerjaan">
                            @foreach (['Bekerja', 'Melanjutkan Kuliah', 'Wirausaha', 'Mencari kerja'] as $status)
                                <label class="cursor-pointer">
                                    <input type="radio" name="status_pekerjaan" value="{{ $status }}" class="peer sr-only" required>
                                    <span class="inline-block rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:border-slate-400 peer-checked:border-blue-600 peer-checked:bg-blue-100 peer-checked:text-blue-700">{{ $status }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('status_pekerjaan')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Q2 --}}
                    <div>
                        <label for="nama_perusahaan" class="block text-sm font-bold text-slate-900 mb-1.5">Nama Perusahaan / Instansi</label>
                        <input type="text" name="nama_perusahaan" id="nama_perusahaan" value="{{ old('nama_perusahaan') }}" placeholder="Nama perusahaan..."
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        @error('nama_perusahaan')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Q3 --}}
                    <div>
                        <label for="posisi" class="block text-sm font-bold text-slate-900 mb-1.5">Posisi Pekerjaan</label>
                        <input type="text" name="posisi" id="posisi" value="{{ old('posisi') }}" placeholder="Jabatan..."
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        @error('posisi')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Q4 --}}
                    <div>
                        <label for="masa_tunggu" class="block text-sm font-bold text-slate-900 mb-1.5">Berapa lama masa tunggu hingga bekerja?</label>
                        <select name="masa_tunggu" id="masa_tunggu"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="">Pilih masa tunggu</option>
                            @foreach (['Di bawah 1 Bulan', '1 - 3 Bulan', '4 - 6 Bulan', '7 - 12 Bulan', 'Lebih dari 12 Bulan'] as $option)
                                <option value="{{ $option }}" @selected(old('masa_tunggu') === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('masa_tunggu')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Q5 --}}
                    <div>
                        <label for="rentang_gaji" class="block text-sm font-bold text-slate-900 mb-1.5">Rentang Gaji Bulanan</label>
                        <select name="rentang_gaji" id="rentang_gaji"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="">Pilih rentang gaji</option>
                            @foreach (['Di bawah Rp 2.000.000', 'Rp 2.000.000 - Rp 4.500.000', 'Rp 4.500.000 - Rp 6.000.000', 'Rp 6.000.000 - Rp 10.000.000', 'Lebih dari Rp 10.000.000', 'Belum / Tidak Berpenghasilan'] as $option)
                                <option value="{{ $option }}" @selected(old('rentang_gaji') === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('rentang_gaji')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Q6 --}}
                    <div>
                        <p class="text-sm font-bold text-slate-900 mb-2.5">Seberapa relevan dengan bidang anda?</p>
                        <div class="flex flex-wrap gap-2.5" role="radiogroup" aria-label="Relevansi bidang">
                            @foreach (['Relevan', 'Cukup Relevan', 'Tidak Relevan'] as $relevan)
                                <label class="cursor-pointer">
                                    <input type="radio" name="relevansi" value="{{ $relevan }}" class="peer sr-only" required>
                                    <span class="inline-block rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:border-slate-400 peer-checked:border-blue-600 peer-checked:bg-blue-100 peer-checked:text-blue-700">{{ $relevan }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('relevansi')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Q7 --}}
                    <div>
                        <label for="saran" class="block text-sm font-bold text-slate-900 mb-1.5">Masukan atau sarana praktek kejuruan</label>
                        <textarea name="saran" id="saran" rows="4" placeholder="Saran..."
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('saran') }}</textarea>
                        @error('saran')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Checkbox --}}
                    <div>
                        <label class="flex items-start gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_konfirmasi" value="1" required
                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                            <span class="text-sm text-slate-700 leading-relaxed">Saya menyatakan bahwa data yang diisi adalah benar dan dapat digunakan untuk evaluasi mutu sekolah.</span>
                        </label>
                        @error('is_konfirmasi')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center justify-between gap-3 pt-2">
                        <a href="{{ route('pusat-karir.study-tracer') }}"
                            class="rounded-lg bg-slate-200 px-6 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-300 transition-colors">
                            Kembali
                        </a>
                        <button type="submit"
                            class="rounded-lg bg-blue-600 px-8 py-2.5 text-sm font-bold text-white hover:bg-blue-700 transition-colors">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="w-full bg-blue-700 text-white text-center py-4 text-sm font-semibold mt-10">
        Dibuat dengan <span class="text-red-500">❤️</span> oleh Chicken Noodles Team
    </footer>
</body>

</html>
