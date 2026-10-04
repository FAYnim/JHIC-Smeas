<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — SMKN 1 Surabaya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="min-h-screen flex items-center justify-center bg-slate-100 antialiased">
    <div class="w-full max-w-md px-4">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-smkn1.webp') }}" alt="Logo SMKN 1 Surabaya"
                class="h-20 mx-auto object-contain">
            <h1 class="mt-4 text-2xl font-extrabold text-slate-900">Panel Admin</h1>
            <p class="text-sm font-medium text-slate-500 mt-1">SMKN 1 Surabaya — Pusat Karir</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-600 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        autocomplete="username" autofocus
                        class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/15 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="block text-xs font-bold text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-600 mb-1.5">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                        class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/15 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="block text-xs font-bold text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold text-sm py-3 rounded-lg hover:bg-blue-700 transition">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-xs font-medium text-slate-500 mt-6">
            <a href="{{ route('beranda') }}" class="text-blue-700 hover:underline">← Kembali ke situs</a>
        </p>
    </div>
</body>

</html>
