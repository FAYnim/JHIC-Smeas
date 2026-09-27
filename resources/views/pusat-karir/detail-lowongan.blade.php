<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lowongan - Telkom Indonesia | Pusat Karir SMKN 1 Surabaya</title>

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

        /* === Detail Header Banner === */
        .detail-header-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #1e40af 100%);
            border-radius: 1rem;
            padding: 1.75rem 2rem;
            margin-top: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .detail-header-banner .company-logo {
            width: 72px;
            height: 72px;
            background: #fff;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .detail-header-banner .company-logo .telkom-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .detail-header-banner .company-logo .telkom-icon .telkom-text {
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .detail-header-banner .company-logo .telkom-icon .telkom-sub {
            font-size: 7px;
            letter-spacing: 0.5px;
            opacity: 0.85;
        }

        .detail-header-banner .badge-mitra {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 999px;
        }

        .detail-header-banner .badge-mitra svg {
            width: 13px;
            height: 13px;
        }

        .detail-header-banner .job-title {
            font-size: 1.625rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.25;
            margin: 0.5rem 0 1rem;
        }

        .detail-header-banner .meta-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .meta-tag--location { background: rgba(239, 68, 68, 0.12); color: #fca5a5; }
        .meta-tag--duration { background: rgba(56, 189, 248, 0.12); color: #7dd3fc; }
        .meta-tag--jurusan  { background: rgba(251, 191, 36, 0.12); color: #fde68a; }
        .meta-tag--kuota    { background: rgba(52, 211, 153, 0.12); color: #6ee7b7; }

        /* === Content Sections === */
        .content-card {
            background: #ffffff;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            padding: 2rem;
        }

        .content-card .section-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .content-card .section-desc {
            font-size: 0.875rem;
            color: #475569;
            line-height: 1.75;
        }

        .content-card .bullet-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .content-card .bullet-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 6px 0;
            font-size: 0.875rem;
            color: #475569;
            line-height: 1.65;
        }

        .content-card .bullet-list li::before {
            content: '';
            display: block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #2563eb;
            margin-top: 7px;
            flex-shrink: 0;
        }

        /* Document Items */
        .doc-item {
            display: flex;
            align-items: center;
            gap: 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
        }

        .doc-item .doc-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .doc-item .doc-icon svg { width: 20px; height: 20px; }

        .doc-item .doc-icon--pdf  { background: #fee2e2; color: #dc2626; }
        .doc-item .doc-icon--link { background: #e0f2fe; color: #0284c7; }

        .doc-item .doc-name {
            font-size: 0.875rem;
            font-weight: 700;
            color: #1e293b;
        }

        .doc-item .doc-desc {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 2px;
        }

        /* Benefit Tags */
        .benefit-tag {
            display: inline-flex;
            align-items: center;
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 999px;
        }

        /* === Sidebar === */
        .sidebar-card {
            background: #ffffff;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            padding: 1.5rem;
            position: sticky;
            top: 6.5rem;
        }

        .btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px 16px;
            background: #1d4ed8;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9375rem;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-primary:hover { background: #1e40af; }

        .btn-secondary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 10px 8px;
            background: transparent;
            color: #1d4ed8;
            font-weight: 700;
            font-size: 0.75rem;
            border-radius: 10px;
            border: 1.5px solid #bfdbfe;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-secondary:hover { background: #eff6ff; }

        .info-label {
            font-size: 0.7rem;
            color: #94a3b8;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 0.875rem;
            font-weight: 700;
            color: #1e293b;
        }

        .info-value--green { color: #059669; }

        /* Pokja Card */
        .pokja-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
        }

        .pokja-card .pokja-avatar {
            width: 36px;
            height: 36px;
            background: #dbeafe;
            color: #1d4ed8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pokja-card .pokja-avatar svg {
            width: 18px;
            height: 18px;
        }

        .btn-wa {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px 12px;
            background: transparent;
            color: #059669;
            font-weight: 700;
            font-size: 0.75rem;
            border-radius: 10px;
            border: 1.5px solid #059669;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-wa:hover { background: #ecfdf5; }

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

        /* Two-column layout */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .detail-header-banner {
                padding: 1.25rem 1rem;
            }
            .detail-header-banner .job-title {
                font-size: 1.25rem;
            }
            .content-card {
                padding: 1.25rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar Header -->
    <header class="sticky top-0 z-50 bg-white shadow-xs border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo & Branding -->
                <a href="{{ route('pusat-karir.index') }}" class="flex items-center group">
                    <img src="{{ asset('images/logo-smkn1.png') }}" alt="Logo SMKN 1 Surabaya"
                        class="h-11 sm:h-12 w-auto object-contain transition-transform duration-200 group-hover:scale-105">
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-7">
                    <a href="#"
                        class="nav-hover-link text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Beranda
                    </a>
                    <a href="#"
                        class="nav-hover-link text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Profil
                    </a>
                    <a href="#"
                        class="nav-hover-link text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Jurusan
                    </a>
                    <a href="#"
                        class="nav-hover-link text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        Informasi
                    </a>
                    <a href="{{ route('pusat-karir.index') }}"
                        class="nav-hover-link text-sm font-bold text-slate-900 border-b-2 border-amber-400 transition-colors py-2">
                        Pusat Karir
                    </a>
                    <a href="#"
                        class="nav-hover-link text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors py-2">
                        BLUD
                    </a>
                </nav>

                <!-- Action Button -->
                <div class="hidden md:flex items-center">
                    <a href="#"
                        class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-all duration-200 hover:shadow">
                        SPMB
                    </a>
                </div>

                <!-- Mobile Hamburger -->
                <button class="md:hidden p-2 text-slate-600 hover:text-slate-900" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-5">

        <!-- Breadcrumbs -->
        <nav class="flex items-center text-xs gap-1.5 mb-4 flex-wrap">
            <a href="#" class="text-blue-600 hover:underline font-medium">Beranda</a>
            <span class="text-slate-400">/</span>
            <a href="{{ route('pusat-karir.index') }}" class="text-blue-600 hover:underline font-medium">Pusat Karir</a>
            <span class="text-slate-400">/</span>
            <a href="#" class="text-blue-600 hover:underline font-medium">Peluang Unggulan</a>
            <span class="text-slate-400">/</span>
            <span class="text-slate-500 font-medium">{{ $lowongan->company_short }} - {{ $lowongan->title }}</span>
        </nav>

        <!-- Top Header Job Banner Card (Dark Blue) -->
        <div class="detail-header-banner">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-5">
                <!-- Company Logo Placeholder -->
                <div class="company-logo">
                    <div class="telkom-icon">
                        <span class="telkom-text">{{ strtoupper(Str::limit($lowongan->company_short ?? $lowongan->company_name, 10, '')) }}</span>
                    </div>
                </div>

                <!-- Job Main Details -->
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-0.5">
                        <span class="text-slate-300 font-semibold text-sm">{{ $lowongan->company_name }}</span>
                        @if($lowongan->is_mitra_dudi)
                        <span class="badge-mitra">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mitra Resmi DUDI
                        </span>
                        @endif
                    </div>

                    <h1 class="job-title">{{ $lowongan->title }}</h1>

                    <!-- Metadata Tags -->
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="meta-tag meta-tag--location">{{ $lowongan->location }}</span>
                        <span class="meta-tag meta-tag--duration">{{ $lowongan->duration }}</span>
                        <span class="meta-tag meta-tag--jurusan">{{ $lowongan->jurusan }}</span>
                        <span class="meta-tag meta-tag--kuota">Sisa {{ $lowongan->kuota }} Kuota</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content 2-Column Grid -->
        <div class="detail-grid">

            <!-- Left Column: Detailed Job Description -->
            <div>
                <div class="content-card" style="display:flex;flex-direction:column;gap:2rem;">

                    <!-- Section: Deskripsi Program Magang -->
                    <section>
                        <h2 class="section-title">Deskripsi Program Magang</h2>
                        <p class="section-desc">{{ $lowongan->deskripsi }}</p>
                    </section>

                    <!-- Section: Tanggung Jawab & Jobdesk Siswa -->
                    @if($lowongan->tanggung_jawab)
                    <section>
                        <h2 class="section-title">Tanggung Jawab &amp; Jobdesk Siswa</h2>
                        <ul class="bullet-list">
                            @foreach($lowongan->tanggung_jawab as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </section>
                    @endif

                    <!-- Section: Kualifikasi Siswa -->
                    @if($lowongan->kualifikasi)
                    <section>
                        <h2 class="section-title">Kualifikasi Siswa</h2>
                        <ul class="bullet-list">
                            @foreach($lowongan->kualifikasi as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </section>
                    @endif

                    <!-- Section: Dokumen yang Wajib Diunggah -->
                    @if($lowongan->dokumen)
                    <section>
                        <h2 class="section-title">Dokumen yang Wajib Diunggah</h2>
                        <div style="display:flex;flex-direction:column;gap:12px;">
                            @foreach($lowongan->dokumen as $doc)
                            <div class="doc-item">
                                <div class="doc-icon {{ ($doc['type'] ?? 'pdf') === 'link' ? 'doc-icon--link' : 'doc-icon--pdf' }}">
                                    @if(($doc['type'] ?? 'pdf') === 'link')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                    </svg>
                                    @else
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="doc-name">{{ $doc['name'] }}</div>
                                    <div class="doc-desc">{{ $doc['desc'] }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    <!-- Section: Fasilitas & Benefit Siswa -->
                    @if($lowongan->benefits)
                    <section>
                        <h2 class="section-title">Fasilitas &amp; Benefit Siswa</h2>
                        <div style="display:flex;flex-wrap:wrap;gap:10px;">
                            @foreach($lowongan->benefits as $benefit)
                            <span class="benefit-tag">{{ $benefit }}</span>
                            @endforeach
                        </div>
                    </section>
                    @endif

                </div>
            </div>

            <!-- Right Column Sidebar: Actions & Registration Info -->
            <div>
                <div class="sidebar-card">

                    <!-- Primary Action Button -->
                    <button class="btn-primary">
                        Ajukan Magang Sekarang
                    </button>

                    <!-- Secondary Action Buttons -->
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:16px;">
                        <button class="btn-secondary">Simpan Lowongan</button>
                        <button class="btn-secondary">Bagikan Link</button>
                    </div>

                    <hr style="border:0;border-top:1px solid #f1f5f9;margin:20px 0;">

                    <!-- Information Registration Section -->
                    <div>
                        <h3 style="font-size:0.9375rem;font-weight:700;color:#0f172a;margin-bottom:16px;">
                            Informasi Pendaftaran
                        </h3>
                        <div style="display:flex;flex-direction:column;gap:14px;">
                            <div>
                                <p class="info-label">Batas Akhir Pendaftaran:</p>
                                <p class="info-value">{{ $lowongan->batas_pendaftaran->format('d F Y') }}</p>
                            </div>
                            <div>
                                <p class="info-label">Metode Kerja:</p>
                                <p class="info-value">{{ $lowongan->metode_kerja }}</p>
                            </div>
                            <div>
                                <p class="info-label">Durasi Pelaksanaan:</p>
                                <p class="info-value">{{ $lowongan->durasi_pelaksanaan }}</p>
                            </div>
                            <div>
                                <p class="info-label">Status Kuota:</p>
                                <p class="info-value info-value--green">{{ $lowongan->status_kuota }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Inner Pokja Contact Card -->
                    @if($lowongan->pokja_nama)
                    <div class="pokja-card" style="margin-top:20px;">
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                            <div class="pokja-avatar">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                            </div>
                            <div>
                                <div style="font-size:0.8rem;font-weight:700;color:#0f172a;">{{ $lowongan->pokja_nama }}</div>
                                <div style="font-size:0.7rem;color:#94a3b8;">Koordinator: {{ $lowongan->pokja_koordinator }}</div>
                            </div>
                        </div>
                        <a href="https://wa.me/{{ $lowongan->pokja_wa }}" target="_blank" class="btn-wa">
                            Konsultasi via WhatsApp Pokja
                        </a>
                    </div>
                    @endif

                </div>
            </div>

        </div>

    </main>

    <!-- Footer Bar -->
    <footer class="site-footer">
        Dibuat oleh Chicken Noodles Team
    </footer>

</body>

</html>
