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

        .dash-topbar__user img {
            width: 2rem;
            height: 2rem;
            border-radius: 9999px;
            object-fit: cover;
            background: #ffffff;
        }

        .dash-topbar__settings {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            background: #0a2e5c;
            color: #ffffff;
            border-radius: 0.5rem;
        }

        .dash-topbar__settings svg {
            width: 1.25rem;
            height: 1.25rem;
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

        /* ===== Biodata progress + CTA ===== */
        .progress-track {
            height: 6px;
            background: #e2e8f0;
            border-radius: 9999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #2563eb;
        }

        .progress-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
        }

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
            <img src="{{ asset('images/logo-smkn1.png') }}" alt="Logo SMKN 1 Surabaya"
                class="h-10 w-auto object-contain">
            <div>
                <p class="text-white text-base font-extrabold tracking-wide leading-none">SMKN</p>
                <p class="text-[0.6rem] font-bold tracking-[0.3em] text-blue-100 mt-1">SURABAYA</p>
            </div>
        </div>

        <nav class="dash-sidebar__nav flex flex-col gap-1">
            <a href="{{ route('spmb.dashboard') }}" class="dash-nav-item {{ request()->routeIs('spmb.dashboard') ? 'dash-nav-item--active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('spmb.biodata') }}" class="dash-nav-item {{ request()->routeIs('spmb.biodata') ? 'dash-nav-item--active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-4.5 4.5m4.5 0v2.25m-6.75 4.5308-1.0261-.3413m11.026 3.7397a.75.75 0 11-.7286 1.2883m4.6873-3.4712a.75.75 0 11.7286-1.2883M6.75 18.75h4.5l-.72-3.27m8.7 2.545-1.305 1.305M6.75 18.75H4.5A2.25 2.25 0 012.25 16.5V15m10.5 1.5H13.5m-7.5-3V9.75a2.25 2.25 0 012.25-2.25h3a2.25 2.25 0 012.25 2.25v1.5m-6-4.5V6a.75.75 0 01.75-.75h.5a.75.75 0 01.75.75v3.75h4.5V12" />
                </svg>
                Biodata
            </a>
            <a href="{{ route('spmb.orang-tua') }}" class="dash-nav-item {{ request()->routeIs('spmb.orang-tua') ? 'dash-nav-item--active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 002.625.75 3.001 3.001 0 002.995-2.543 3.005 3.005 0 00.008-.413c-.397-3.17-2.538-5.159-5.252-5.784a.753.753 0 01-.524-.487l-.485-1.929A3 3 0 0011.25 8.25H8.25m0 0a3 3 0 010 6H11.25" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 19.5H7.5" />
                </svg>
                Orang Tua
            </a>
            <a href="{{ route('spmb.dokumen') }}" class="dash-nav-item {{ request()->routeIs('spmb.dokumen') ? 'dash-nav-item--active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Dokumen
            </a>
            <a href="{{ route('spmb.formulir') }}" class="dash-nav-item {{ request()->routeIs('spmb.formulir') ? 'dash-nav-item--active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 9.75h15.75m-15.75 4.5h15.75m-13.5 0a.75.75 0 01.75-.75h6a.75.75 0 01.75.75m3.75 0a.75.75 0 01.75-.75h.008a.75.75 0 01.742.642l.008.05a.75.75 0 01-.75.858h-.008" />
                </svg>
                Formulir
            </a>
            <a href="{{ route('spmb.verifikasi') }}" class="dash-nav-item {{ request()->routeIs('spmb.verifikasi') ? 'dash-nav-item--active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Verifikasi
            </a>
            <a href="{{ route('spmb.pengumuman') }}" class="dash-nav-item {{ request()->routeIs('spmb.pengumuman') ? 'dash-nav-item--active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.34 15.84c-.688-.06-1.386-.06-2.09.015-2.18.228-4.758 1.88-5.16 2.308-.494.51-.484.444-.496.452-1.112.785.927 1.012.927 1.012 2.327.23 5.346-1.032 5.346-1.032 1.114.298 2.37.326 3.03.275M18.5 3l-5 2.437L10.75 3M15.25 6.437L10.75 8.637M13.5 12.25l-2.5-1.375L5.5 10.5M5.5 10.5L13.5 12.25M5.5 10.5L4.5 17.5" />
                </svg>
                Pengumuman
            </a>
            <a href="{{ route('spmb.bantuan') }}" class="dash-nav-item {{ request()->routeIs('spmb.bantuan') ? 'dash-nav-item--active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.879 7.519c1.171-1.505 3.175-2.01 4.59-1.132a3.0001 3.0001 0 011.132 4.59L10.5 21M15.5 3L14 5.25M14.25 9.75L12 14.25" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                Bantuan
            </a>
        </nav>
    </aside>

    {{-- Main column --}}
    <div class="dash-main">
        <div class="dash-topbar">
            <div class="flex items-center gap-3">
                <button type="button" class="dash-menu-toggle" id="dash-menu-toggle" aria-label="Toggle menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="dash-topbar__title">@yield('page-title')</h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="#" class="dash-topbar__settings" aria-label="Pengaturan">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87a8.229 8.229 0 011.52.941l.781.6c.344.264.461.744.287 1.14l-.391.868c-.184.417-.097.904.22 1.22l.63.631c.316.315.404.802.22 1.22l-.39.867c-.184.416-.097.903.22 1.219l.629.631c.317.316.405.803.22 1.22l-.54.868c-.174.416-.644.698-1.109.698h-2.094c-.55 0-1.019.398-1.109.94l-.213 1.281c-.09.542-.56.94-1.11.94h-2.593c-.55 0-1.02-.398-1.11-.94l-.213-1.28c-.09-.543-.56-.941-1.11-.941h-2.094c-.55 0-1.019.398-1.109.94l-.213 1.281c-.09.542-.56.94-1.11.94h-2.593c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.09-.543-.56-.941-1.109-.941h-2.094c-.55 0-1.019.398-1.109.94l-.54.868c-.174.416-.262.903-.078 1.22" />
                    </svg>
                </a>
                <span class="dash-topbar__user">
                    Olivia
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c99b326f1?w=96&h=96&fit=crop&crop=faces"
                        alt="Foto Olivia">
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
