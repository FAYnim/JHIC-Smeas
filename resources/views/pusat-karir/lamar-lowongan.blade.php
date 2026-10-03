<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi & Ajuan Magang - {{ $lowongan->title }} | Pusat Karir SMKN 1 Surabaya</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Vite Styles & Scripts with Fallback -->
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

        /* Navbar hover underline effect */
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

        /* White Header Card */
        .header-card {
            background: #ffffff;
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .header-card .company-logo {
            width: 72px;
            height: 72px;
            background: #ffffff;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f5f9;
        }

        .header-card .company-logo .telkom-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #ffffff;
        }

        .header-card .company-logo .telkom-icon .telkom-text {
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .header-card .company-logo .telkom-icon .telkom-sub {
            font-size: 7px;
            letter-spacing: 0.5px;
            opacity: 0.85;
        }

        .badge-mitra-green {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #059669;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 999px;
        }

        .meta-tag--location {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .meta-tag--duration {
            background: #f0f9ff;
            color: #0284c7;
            border: 1px solid #bae6fd;
        }

        .meta-tag--jurusan {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .meta-tag--kuota {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        /* Form Card */
        .form-card {
            background: #ffffff;
            border-radius: 1rem;
            padding: 2rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-top: 1.5rem;
        }

        .form-section-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.75rem;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 0.65rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #1e293b;
            background: #ffffff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        /* File Upload / Prefilled Box */
        .file-preview-box {
            background: #eef6ff;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Verified Banner */
        .verified-banner {
            background: #a7f3d0;
            color: #064e3b;
            border-radius: 0.75rem;
            padding: 0.875rem 1.25rem;
            font-weight: 700;
            font-size: 0.9375rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .verified-icon {
            width: 26px;
            height: 26px;
            background: #10b981;
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .verified-icon svg {
            width: 16px;
            height: 16px;
        }

        /* Buttons */
        .btn-verifikasi {
            background: #094074;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 0.65rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .btn-verifikasi:hover {
            background: #05294e;
        }

        .btn-kirim {
            background: #094074;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 0.65rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-kirim:hover {
            background: #05294e;
        }

        .btn-batal {
            background: #ffffff;
            color: #334155;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 0.65rem 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid #cbd5e1;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-batal:hover {
            background: #f8fafc;
        }

        /* Footer */
        .site-footer {
            background: #1d4ed8;
            color: #ffffff;
            text-align: center;
            padding: 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 4rem;
        }
    </style>
</head>

<body>

    @include('partials.navbar', ['activePage' => 'pusat-karir'])

    <!-- Main Container -->
    <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-5">

        <!-- Breadcrumbs -->
        <nav class="flex items-center text-xs gap-1.5 mb-4 flex-wrap" aria-label="Breadcrumb">
            <a href="{{ route('beranda') }}" class="text-blue-600 hover:underline font-medium">Beranda</a>
            <span class="text-slate-400">/</span>
            <a href="{{ route('pusat-karir.index') }}" class="text-blue-600 hover:underline font-medium">Pusat Karir</a>
            <span class="text-slate-400">/</span>
            <a href="{{ route('pusat-karir.index') }}#peluang-unggulan" class="text-blue-600 hover:underline font-medium">Peluang Unggulan</a>
            <span class="text-slate-400">/</span>
            <span class="text-slate-500 font-medium">{{ $lowongan->company_short }} - {{ $lowongan->title }}</span>
        </nav>

        <!-- Top Header Card (White Card Design matching Mockup) -->
        <div class="header-card">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-5">
                <!-- Company Logo Placeholder -->
                <div class="company-logo">
                    <div class="telkom-icon">
                        <span
                            class="telkom-text">{{ strtoupper(Str::limit($lowongan->company_short ?? $lowongan->company_name, 10, '')) }}</span>
                    </div>
                </div>

                <!-- Job Main Details -->
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-0.5">
                        <span class="text-slate-500 font-semibold text-sm">{{ $lowongan->company_name }}</span>
                        @if ($lowongan->is_mitra_dudi)
                            <span class="badge-mitra-green">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Mitra Resmi DUDI
                            </span>
                        @endif
                    </div>

                    <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 my-1">{{ $lowongan->title }}</h1>

                    <!-- Metadata Tags -->
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <span
                            class="px-3 py-1 rounded-md text-xs font-semibold meta-tag--location">{{ $lowongan->location }}</span>
                        <span
                            class="px-3 py-1 rounded-md text-xs font-semibold meta-tag--duration">{{ $lowongan->duration }}</span>
                        <span
                            class="px-3 py-1 rounded-md text-xs font-semibold meta-tag--jurusan">{{ $lowongan->jurusan }}</span>
                        <span class="px-3 py-1 rounded-md text-xs font-semibold meta-tag--kuota">Sisa
                            {{ $lowongan->kuota }} Kuota</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification & Application Form Card -->
        <div class="form-card">
            <form action="{{ route('pusat-karir.store-lamar', $lowongan->slug) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <!-- Section 1: Verifikasi Data Siswa -->
                <section class="mb-8">
                    <h2 class="form-section-title">1. Verifikasi Data Siswa</h2>

                    <div class="mb-3">
                        <label for="nisn" class="form-label">Nomor Induk Siswa Nasional (NISN)</label>
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                            <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}"
                                placeholder="Masukkan NISN Anda..." class="form-input max-w-md font-mono" required
                                inputmode="numeric" pattern="[0-9]*" maxlength="10"
                                aria-describedby="nisn-error">
                            <button type="button" id="btn-verifikasi-nisn" class="btn-verifikasi">
                                Verifikasi
                            </button>
                        </div>
                        @error('nisn')
                            <p id="nisn-error" class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Verified Success Alert Box (Hidden initially until verified) -->
                    <div id="verified-box" class="verified-banner" style="display: none;">
                        <div class="verified-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span id="verified-name">Data Siswa Ditemukan (NISN Valid)</span>
                    </div>
                </section>

                <!-- Section 2: Berkas -->
                <section class="mb-8">
                    <h2 class="form-section-title">2. Berkas</h2>

                    <div class="space-y-5">
                        @if($lowongan->dokumen)
                            @foreach($lowongan->dokumen as $index => $doc)
                                @php
                                    $docType = $doc['type'] ?? 'pdf';
                                    $fieldName = 'doc_' . $index;
                                    $inputName = Str::slug($doc['name'], '_');
                                @endphp
                                <div>
                                    <label for="{{ $inputName }}" class="form-label">{{ str_replace(['_', '.pdf'], [' ', ''], $doc['name']) }} ({{ $doc['desc'] ?? '' }})</label>

                                    @if($docType === 'link')
                                        <input type="url" id="{{ $inputName }}" name="{{ $inputName }}"
                                            placeholder="https://..." value=""
                                            class="form-input">
                                    @else
                                        <div class="relative">
                                            <input type="file" id="{{ $inputName }}" name="{{ $inputName }}" class="hidden" accept=".pdf"
                                                onchange="updateFileName(this, 'filename-{{ $index }}')" required>
                                            <label for="{{ $inputName }}"
                                                class="file-preview-box cursor-pointer hover:bg-sky-100/80 transition-colors">
                                                <span id="filename-{{ $index }}" class="font-medium text-slate-500">Pilih atau unggah berkas (.pdf)...</span>
                                                <span
                                                    class="text-xs font-semibold text-blue-700 bg-blue-100 px-2.5 py-1 rounded">Pilih
                                                    Berkas</span>
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="text-sm text-slate-500 italic">Tidak ada dokumen khusus yang dipersyaratkan.</div>
                        @endif
                    </div>

                    <!-- Consent Checkbox -->
                    <div class="mt-6 flex items-start gap-3">
                        <input type="checkbox" id="consent" name="consent" required
                            class="mt-1 w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500 cursor-pointer">
                        <label for="consent"
                            class="text-sm font-medium text-slate-700 cursor-pointer leading-relaxed">
                            Saya bersedia mengikuti magang on-site selama {{ $lowongan->duration }} di
                            {{ explode(',', $lowongan->location)[0] }} dan mematuhi SOP industri dari
                            {{ $lowongan->company_name }}.
                        </label>
                    </div>
                </section>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ route('pusat-karir.detail', $lowongan->slug) }}" class="btn-batal">
                        Batal
                    </a>
                    <button type="submit" class="btn-kirim">
                        Kirim Lamaran
                    </button>
                </div>

            </form>
        </div>

    </main>

    <!-- Footer Bar -->
    <footer class="site-footer">
        Dibuat oleh Chicken Noodles Team
    </footer>

    <!-- Interactive JS for Verification Simulation -->
    <script>
        const nisnInput = document.getElementById('nisn');
        const verifiedBox = document.getElementById('verified-box');
        const verifiedName = document.getElementById('verified-name');

        nisnInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
            verifiedBox.style.display = 'none';
        });

        document.getElementById('btn-verifikasi-nisn').addEventListener('click', function() {
            const val = nisnInput.value.trim();

            if (!/^\d+$/.test(val) || val.length !== 10) {
                verifiedBox.style.display = 'none';
                alert('NISN harus diisi dengan angka, 10 digit tanpa huruf atau simbol.');
                nisnInput.focus();
                return;
            }

            verifiedBox.style.display = 'flex';
            verifiedName.textContent = `Data Siswa NISN ${val} (NISN Valid)`;
        });

        function updateFileName(input, targetId) {
            if (input.files && input.files[0]) {
                const filenameSpan = document.getElementById(targetId);
                filenameSpan.textContent = input.files[0].name;
                filenameSpan.classList.remove('text-slate-500');
                filenameSpan.classList.add('text-slate-800');
            }
        }
    </script>

</body>

</html>
