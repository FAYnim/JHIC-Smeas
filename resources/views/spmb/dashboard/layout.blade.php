<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPMB') — SMKN 1 Surabaya</title>

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
        }

        /* ===== SPMB Dashboard Shell ===== */
        .dash-sidebar {
            width: 288px;
            background: #0a2e5c;
            position: fixed;
            inset-block: 0;
            inset-inline-start: 0;
            z-index: 40;
            display: flex;
            flex-direction: column;
        }

        .dash-sidebar__nav {
            padding: 1rem 1.25rem 1.5rem;
        }

        .dash-nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            border-radius: 0.5rem;
            color: #9db3cc;
            font-size: 0.95rem;
            font-weight: 600;
            transition: background 0.15s ease, color 0.15s ease;
        }

        .dash-nav-item svg {
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
        }

        .dash-nav-item:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .dash-nav-item--active {
            color: #ffffff;
            background: #1d5fa8;
        }

        .dash-nav-item--active:hover {
            background: #1d5fa8;
        }

        .dash-main {
            margin-inline-start: 288px;
            min-height: 100vh;
            background: #e8edf4;
            display: flex;
            flex-direction: column;
        }

        .dash-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.5rem;
        }

        .dash-topbar__title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #111827;
        }

        .dash-topbar__user {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #0a2e5c;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 0.4rem 0.9rem;
            border-radius: 0.5rem;
        }

        .dash-content {
            padding: 0.5rem 1.5rem 2.5rem;
        }

        .dash-card {
            background: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.12);
            padding: 1.5rem;
        }

        /* ===== Form primitives ===== */
        .field-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.375rem;
        }

        .field-input {
            width: 100%;
            border: 1px solid #9ca3af;
            border-radius: 0.375rem;
            background: #ffffff;
            padding: 0.625rem 0.75rem;
            font-size: 0.875rem;
            color: #111827;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .field-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .field-input.input-error {
            border-color: #dc2626;
        }

        .field-select {
            width: 100%;
            appearance: none;
            border: 1px solid #9ca3af;
            border-radius: 0.375rem;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%230f3d7a' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='m19.5 8.25-7.5 7.5-7.5-7.5' /%3E%3C/svg%3E") right 0.6rem center / 0.9rem no-repeat #ffffff;
            padding: 0.625rem 2.25rem 0.625rem 0.75rem;
            font-size: 0.875rem;
            color: #111827;
            outline: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
        }

        .field-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .field-select:required:not(:valid) {
            border-color: #dc2626;
        }

        .field-error-text {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            color: #dc2626;
            margin-top: 0.375rem;
        }

        .field-notice {
            margin-bottom: 1rem;
            padding: 0.625rem 0.875rem;
            background: #dcfce7;
            color: #166534;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }

        .field-warning {
            margin-bottom: 1rem;
            padding: 0.625rem 0.875rem;
            background: #fff7ed;
            color: #9a3412;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }

        /* Parent-status dot (Masih Hidup blue / Meninggal gray) */
        .status-dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 9999px;
            display: inline-block;
        }

        /* ===== Parent data tabs ===== */
        .pt-tabs {
            display: flex;
            gap: 4px;
            margin-bottom: 1.5rem;
            border: 2px solid #1d5fa8;
            border-radius: 0.625rem;
            overflow: hidden;
        }

        .pt-tab {
            flex: 1;
            text-align: center;
            padding: 0.875rem 0.5rem;
            font-size: 1rem;
            font-weight: 700;
            color: #1d5fa8;
            background: #ffffff;
            cursor: pointer;
            border: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: background 0.15s ease, color 0.15s ease;
        }

        .pt-tab--active {
            background: #1d5fa8;
            color: #ffffff;
        }

        .pt-panel {
            display: none;
        }

        .pt-panel--active {
            display: block;
        }

        /* ===== File input ===== */
        .file-input {
            width: 100%;
            border: 1.5px dashed #93c5fd;
            border-radius: 0.375rem;
            background: #f8fafc;
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #334155;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: border-color 0.15s ease, background 0.15s ease;
        }

        .file-input:hover {
            border-color: #2563eb;
            background: #eff6ff;
        }

        .file-input:focus {
            outline: none;
            border-color: #2563eb;
            background: #eff6ff;
        }

        .file-input::file-selector-button {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            color: #ffffff;
            background: #2563eb;
            border: none;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            margin-inline-end: 0.625rem;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .file-input::file-selector-button:hover {
            background: #1d4ed8;
        }

        /* ===== CTA ===== */
        .declaration-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.875rem 1rem;
        }

        .btn-blue {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            background: #2563eb;
            color: #ffffff;
            font-size: 0.875rem;
            font-weight: 700;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: background 0.15s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .btn-blue:hover {
            background: #1d4ed8;
        }

        .btn-blue svg {
            width: 1rem;
            height: 1rem;
        }

        .doc-row__hint {
            font-size: 0.7rem;
            font-weight: 600;
            color: #6b7280;
        }

        .doc-row__name {
            font-size: 0.875rem;
            font-weight: 700;
            color: #111827;
        }

        .doc-row__meta {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
        }

        .doc-row__meta .verified {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            color: #16a34a;
        }

        /* ===== Formulir ===== */
        .formulir-step {
            margin-bottom: 1.5rem;
        }

        .formulir-step h2 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.75rem;
        }

        .btn-green {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #4ade80;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 0.75rem 1.75rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: background 0.15s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .btn-green:hover {
            background: #22c55e;
        }

        .btn-navy {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: #1d5fa8;
            color: #ffffff;
            font-size: 0.875rem;
            font-weight: 700;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background 0.15s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .btn-navy:hover {
            background: #0f3d7a;
        }

        .btn-navy svg {
            width: 1.125rem;
            height: 1.125rem;
        }

        .checkbox-label {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #111827;
            line-height: 1.5;
            cursor: pointer;
        }

        .checkbox-label input {
            margin-top: 0.125rem;
            width: 0.875rem;
            height: 0.875rem;
            accent-color: #2563eb;
            flex-shrink: 0;
        }

        .select-placeholder-text {
            color: #6b7280;
        }

        /* ===== Mobile ===== */
        .dash-menu-toggle {
            display: none;
        }

        @media (max-width: 768px) {
            .dash-sidebar {
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }

            .dash-sidebar--open {
                transform: translateX(0);
            }

            .dash-main {
                margin-inline-start: 0;
            }

            .dash-menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 2.5rem;
                height: 2.5rem;
                background: #0a2e5c;
                color: #ffffff;
                border-radius: 0.5rem;
            }
        }
    </style>
</head>

<body class="antialiased">
    {{-- Sidebar --}}
    <aside id="dash-sidebar" class="dash-sidebar">
        <div class="px-5 pt-5 pb-3 flex items-center gap-3">
            <img src="{{ asset('images/smkn1-logo-white-transparent.png') }}" alt="Logo SMKN 1 Surabaya"
                class="h-14 w-auto object-contain">
        </div>

        <nav class="dash-sidebar__nav flex flex-col gap-1">
            <a href="{{ route('spmb.dashboard') }}" class="dash-nav-item {{ request()->routeIs('spmb.dashboard') ? 'dash-nav-item--active' : '' }}">
                <x-lucide-layout-grid />
                Dashboard
            </a>
            <a href="{{ route('spmb.biodata') }}" class="dash-nav-item {{ request()->routeIs('spmb.biodata') ? 'dash-nav-item--active' : '' }}">
                <x-lucide-user />
                Biodata
            </a>
            <a href="{{ route('spmb.orang-tua') }}" class="dash-nav-item {{ request()->routeIs('spmb.orang-tua') ? 'dash-nav-item--active' : '' }}">
                <x-lucide-users />
                Orang Tua
            </a>
            <a href="{{ route('spmb.dokumen') }}" class="dash-nav-item {{ request()->routeIs('spmb.dokumen') ? 'dash-nav-item--active' : '' }}">
                <x-lucide-book />
                Dokumen
            </a>
            <a href="{{ route('spmb.formulir') }}" class="dash-nav-item {{ request()->routeIs('spmb.formulir') ? 'dash-nav-item--active' : '' }}">
                <x-lucide-list />
                Formulir
            </a>
            <a href="{{ route('spmb.verifikasi') }}" class="dash-nav-item {{ request()->routeIs('spmb.verifikasi') ? 'dash-nav-item--active' : '' }}">
                <x-lucide-circle-check />
                Verifikasi
            </a>
            <a href="{{ route('spmb.pengumuman') }}" class="dash-nav-item {{ request()->routeIs('spmb.pengumuman') ? 'dash-nav-item--active' : '' }}">
                <x-lucide-megaphone />
                Pengumuman
            </a>
            <a href="{{ route('spmb.bantuan') }}" class="dash-nav-item {{ request()->routeIs('spmb.bantuan') ? 'dash-nav-item--active' : '' }}">
                <x-lucide-lightbulb />
                Bantuan
            </a>
            {{-- ponytail: beranda belum ada — arahkan ke pusat karir; swap href ke route beranda saat tersedia --}}
            <a href="{{ route('pusat-karir.index') }}" class="dash-nav-item">
                <x-lucide-log-out />
                Keluar
            </a>
        </nav>
    </aside>

    {{-- Main column --}}
    <div class="dash-main">
        <div class="dash-topbar">
            <div class="flex items-center gap-3">
                <button type="button" class="dash-menu-toggle" id="dash-menu-toggle" aria-label="Toggle menu">
                    <x-lucide-menu class="w-6 h-6" />
                </button>
                <h1 class="dash-topbar__title">@yield('page-title')</h1>
            </div>

            <div class="flex items-center gap-3">
                <span class="dash-topbar__user">
                    {{ $calonSiswa?->nama_lengkap ?? 'Calon Siswa' }}
                </span>
            </div>
        </div>

        <div class="dash-content">
            @if (session('spmb_notice'))
                <div class="field-notice">{{ session('spmb_notice') }}</div>
            @endif

            @if (session('spmb_warning'))
                <div class="field-warning">{{ session('spmb_warning') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        const dashMenuToggle = document.getElementById('dash-menu-toggle');
        const dashSidebar = document.getElementById('dash-sidebar');
        if (dashMenuToggle && dashSidebar) {
            dashMenuToggle.addEventListener('click', () => {
                dashSidebar.classList.toggle('dash-sidebar--open');
            });
        }
    </script>
    @yield('scripts')
</body>

</html>
