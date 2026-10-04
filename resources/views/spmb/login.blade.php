<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPMB SMKN 1 Surabaya</title>

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
            /* amber-400 */
            border-radius: 9999px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .nav-hover-link:hover::after {
            transform: scaleX(1);
        }

        /* ===== SPMB Login ===== */
        .spmb-stage {
            position: relative;
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            overflow: hidden;
        }

        .spmb-stage__bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .spmb-stage__bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .spmb-stage__overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            background: rgba(11, 47, 102, 0.55);
        }

        .spmb-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 40rem;
            background: #ffffff;
            border-radius: 1.25rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            padding: 2.25rem 2rem;
            text-align: center;
        }

        .spmb-card__title {
            font-size: 1.125rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .spmb-card form input {
            width: 100%;
            background: #e5eaf5;
            border: none;
            outline: none;
            border-radius: 0.5rem;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            color: #1f2937;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: box-shadow 0.2s ease, background 0.2s ease;
        }

        .spmb-card form input::placeholder {
            color: #94a3b8;
        }

        .spmb-card form input:focus {
            background: #dde5f5;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3);
        }

        .spmb-card form input.input-error {
            background: #fee2e2;
        }

        .spmb-card form input.input-error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.3);
        }

        .spmb-card__submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 1.25rem;
            min-width: 8.5rem;
            padding: 0.75rem 2.25rem;
            border: none;
            border-radius: 0.625rem;
            background: #1e3a8a;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: background 0.2s ease;
        }

        .spmb-card__submit:hover {
            background: #172554;
        }

        .spmb-error {
            margin-top: 0.875rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #dc2626;
        }

        .spmb-notice {
            margin-top: 0.875rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #16a34a;
        }

        @media (max-width: 480px) {
            .spmb-card {
                padding: 1.75rem 1.25rem;
            }

            .spmb-card__title {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body class="antialiased flex flex-col min-h-screen">
    @include('partials.navbar', [
        'activePage'    => '',
        'spmbClickable' => false,
        'logoUrl'       => route('beranda'),
        'berandaUrl'    => route('beranda'),
    ])

    <!-- ===== SPMB Login Section ===== -->
    <main class="spmb-stage">
        <!-- Background image + dark blue overlay -->
        <div class="spmb-stage__bg">
            <img src="{{ asset('images/smkn1.png') }}" alt="Gedung SMKN 1 Surabaya">
        </div>
        <div class="spmb-stage__overlay"></div>

        <!-- NISN Login Card -->
        <section class="spmb-card">
            <h1 class="spmb-card__title">Silahkan masukkan NISN untuk melanjutkan proses pendaftaran</h1>

            <form method="POST" action="{{ route('spmb.login') }}" class="spmb-card__form">
                @csrf
                <input type="text" name="nisn" id="nisn-input" inputmode="numeric" autocomplete="off"
                    maxlength="10" placeholder="Contoh: 1234567890" value="{{ old('nisn') }}"
                    @error('nisn') class="input-error" @enderror>
                @error('nisn')
                    <p class="spmb-error">{{ $message }}</p>
                @enderror
                @if (session('spmb_success'))
                    <p class="spmb-notice">{{ session('spmb_success') }}</p>
                @endif
                <button type="submit" class="spmb-card__submit">Masuk</button>
            </form>
        </section>
    </main>

    @include('partials.footer')

    <script>
        // NISN: digits only, max 10
        const nisnInput = document.getElementById('nisn-input');
        if (nisnInput) {
            nisnInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/\D/g, '').slice(0, 10);
                e.target.classList.remove('input-error');
                const errEl = e.target.parentElement.querySelector('.spmb-error');
                if (errEl) errEl.remove();
            });
        }
    </script>
</body>

</html>
