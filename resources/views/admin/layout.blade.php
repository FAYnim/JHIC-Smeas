<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin') — SMKN 1 Surabaya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        /* ponytail: token warna inline. Pindahkan ke resources/css/app.css
           @theme bila panel admin tumbuh modul baru yang butuh warna sama. */
        .adm-body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .adm-sidebar {
            width: 264px;
            background: #1e3a5f;
            position: fixed;
            inset-block: 0;
            inset-inline-start: 0;
            z-index: 40;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .adm-nav-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .625rem .875rem;
            border-radius: .5rem;
            color: #cbd5e1;
            font-size: .875rem;
            font-weight: 600;
            transition: background .15s ease, color .15s ease;
        }

        .adm-nav-item svg {
            width: 1.125rem;
            height: 1.125rem;
            flex-shrink: 0;
        }

        .adm-nav-item:hover {
            color: #fff;
            background: rgba(255, 255, 255, .08);
        }

        .adm-nav-item--active {
            color: #fff;
            background: #2563eb;
        }

        .adm-main {
            margin-inline-start: 264px;
            min-height: 100vh;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
        }

        .adm-topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: .875rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .adm-content {
            padding: 1.5rem;
            flex: 1;
        }

        .adm-userchip {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: #1e3a5f;
            color: #fff;
            font-size: .8rem;
            font-weight: 700;
            padding: .4rem .875rem;
            border-radius: .5rem;
        }

        .adm-menu-toggle {
            display: none;
        }

        @media (max-width: 1023px) {
            .adm-sidebar {
                transform: translateX(-100%);
                transition: transform .25s ease;
            }

            .adm-sidebar--open {
                transform: translateX(0);
            }

            .adm-main {
                margin-inline-start: 0;
            }

            .adm-menu-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2.5rem;
                height: 2.5rem;
                background: #1e3a5f;
                color: #fff;
                border-radius: .5rem;
                cursor: pointer;
            }
        }
    </style>
</head>

<body class="adm-body antialiased">
    @php
        $menuItems = \App\Support\AdminMenu::availableItemsFor(auth()->user());
        $menuGroups = [];
        foreach ($menuItems as $item) {
            $menuGroups[$item['group']][] = $item;
        }
    @endphp

    <aside id="adm-sidebar" class="adm-sidebar">
        <div class="flex items-center gap-3 px-5 pt-5 pb-4">
            <img src="{{ asset('images/smkn1-logo-white-transparent.png') }}" alt="Logo SMKN 1 Surabaya"
                class="h-11 w-auto object-contain">
            <span class="text-white font-extrabold text-lg leading-tight">Panel Admin</span>
        </div>

        <nav class="flex flex-col gap-4 px-5 pb-6">
            @foreach ($menuGroups as $group => $items)
                <div>
                    @if ($group !== 'Umum')
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-2.5 mb-1.5">
                            {{ $group }}
                        </p>
                    @endif

                    @foreach ($items as $item)
                        <a href="{{ route($item['route']) }}"
                            class="adm-nav-item {{ request()->routeIs($item['route']) ? 'adm-nav-item--active' : '' }}">
                            @switch($item['icon'])
                                @case('layout-grid')
                                    <x-lucide-layout-grid />
                                @break
                                @case('newspaper')
                                    <x-lucide-newspaper />
                                @break
                                @case('briefcase')
                                    <x-lucide-briefcase />
                                @break
                                @case('inbox')
                                    <x-lucide-inbox />
                                @break
                                @case('building-2')
                                    <x-lucide-building-2 />
                                @break
                                @case('users')
                                    <x-lucide-users />
                                @break
                                @case('graduation-cap')
                                    <x-lucide-graduation-cap />
                                @break
                                @case('shield')
                                    <x-lucide-shield />
                                @break
                                @case('settings')
                                    <x-lucide-settings />
                                @break
                                @case('academic-cap')
                                    <x-lucide-book-open />
                                @break
                                @case('chart-bar')
                                    <x-lucide-bar-chart-3 />
                                @break
                                @case('network')
                                    <x-lucide-network />
                                @break
                                @case('building')
                                    <x-lucide-building />
                                @break
                                @case('video')
                                    <x-lucide-video />
                                @break
                                @case('megaphone')
                                    <x-lucide-megaphone />
                                @break
                                @case('help-circle')
                                    <x-lucide-help-circle />
                                @break
                                @case('shopping-bag')
                                    <x-lucide-shopping-bag />
                                @break
                                @case('flag')
                                    <x-lucide-flag />
                                @break
                                @default
                                    <x-lucide-circle />
                            @endswitch
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            @endforeach
        </nav>
    </aside>

    <div class="adm-main">
        <header class="adm-topbar">
            <div class="flex items-center gap-3">
                <button type="button" class="adm-menu-toggle" id="adm-menu-toggle" aria-label="Toggle menu">
                    <x-lucide-menu class="w-6 h-6" />
                </button>
                <h1 class="text-xl font-extrabold text-slate-900">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="flex items-center gap-3 min-w-0">
                <span class="adm-userchip min-w-0">
                    <span class="max-w-[10rem] truncate">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] font-semibold text-blue-200 shrink-0">
                        ({{ auth()->user()->roleLabel() }})
                    </span>
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-red-600 transition shrink-0">
                        <x-lucide-log-out class="w-4 h-4" />
                        Keluar
                    </button>
                </form>
            </div>
        </header>

        <main class="adm-content">
            @if (session('success'))
                <div
                    class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        const admMenuToggle = document.getElementById('adm-menu-toggle');
        const admSidebar = document.getElementById('adm-sidebar');
        if (admMenuToggle && admSidebar) {
            admMenuToggle.addEventListener('click', () => {
                admSidebar.classList.toggle('adm-sidebar--open');
            });
        }
    </script>
    @yield('scripts')
</body>

</html>
