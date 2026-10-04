<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smeas AI Major Finder — Rekomendasi Jurusan SMKN 1 Surabaya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        :root {
            --color-smeas-primary: #024089;
            --color-smeas-dark: #001e47;
            --color-smeas-gold: #f59e0b;
            --color-smeas-gold-hover: #d97706;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(2, 64, 137, 0.06) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(245, 158, 11, 0.07) 0px, transparent 50%),
                radial-gradient(at 50% 30%, rgba(2, 64, 137, 0.03) 0px, transparent 60%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* Container Shell */
        .major-finder-shell {
            max-width: 860px;
            margin: 0 auto;
            padding: 0 16px;
        }

        /* Glass Card Base */
        .smeas-glass-card {
            background: #ffffff;
            border-radius: 28px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 
                0 20px 45px -15px rgba(2, 64, 137, 0.08),
                0 2px 6px -1px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Question Statement Card */
        .question-statement-box {
            background: linear-gradient(135deg, rgba(2, 64, 137, 0.03) 0%, rgba(248, 250, 252, 0.95) 100%);
            border: 1.5px solid rgba(2, 64, 137, 0.12);
            border-left: 6px solid var(--color-smeas-primary);
            border-radius: 22px;
            padding: 32px 28px;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .question-statement-box::after {
            content: "“";
            position: absolute;
            right: 20px;
            bottom: -25px;
            font-size: 130px;
            font-family: Georgia, serif;
            color: rgba(2, 64, 137, 0.05);
            line-height: 1;
            pointer-events: none;
            user-select: none;
        }

        .question-text-title {
            font-size: clamp(1.2rem, 3vw, 1.45rem);
            font-weight: 800;
            color: #0f172a;
            line-height: 1.55;
            margin: 0;
            letter-spacing: -0.015em;
            position: relative;
            z-index: 1;
        }

        .statement-anim {
            animation: statementFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes statementFadeIn {
            from {
                opacity: 0;
                transform: translateX(12px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Spectrum Bar Indicator */
        .spectrum-bar-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding: 0 4px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .spectrum-left {
            color: #e11d48;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .spectrum-right {
            color: #059669;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .spectrum-mid-hint {
            color: #94a3b8;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            text-transform: none;
            display: none;
        }

        @media (min-width: 640px) {
            .spectrum-mid-hint {
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }
        }

        /* Likert Grid Layout */
        .likert-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        @media (max-width: 640px) {
            .likert-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }

        /* Likert Button Card */
        .likert-card {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            padding: 20px 10px 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: pointer;
            outline: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            user-select: none;
        }

        @media (max-width: 640px) {
            .likert-card {
                flex-direction: row;
                justify-content: space-between;
                padding: 16px 20px;
                text-align: left;
            }
        }

        .likert-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.08);
        }

        @media (max-width: 640px) {
            .likert-card:hover {
                transform: translateX(4px);
            }
        }

        /* Keyboard Shortcut Keycap */
        .likert-kbd {
            position: absolute;
            top: 8px;
            right: 8px;
            font-size: 0.65rem;
            font-weight: 800;
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 1px 6px;
            line-height: 1.2;
            box-shadow: 0 1px 2px rgba(0,0,0,0.06);
            transition: all 0.2s ease;
        }

        @media (max-width: 640px) {
            .likert-kbd {
                display: none;
            }
        }

        .likert-num-badge {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 800;
            margin-bottom: 10px;
            transition: all 0.25s ease;
        }

        @media (max-width: 640px) {
            .likert-num-badge {
                margin-bottom: 0;
                width: 34px;
                height: 34px;
                font-size: 0.9rem;
                flex-shrink: 0;
            }
        }

        .likert-label-code {
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            margin-bottom: 4px;
            transition: color 0.2s ease;
        }

        .likert-label-desc {
            font-size: 0.72rem;
            font-weight: 600;
            line-height: 1.25;
            color: #64748b;
            transition: color 0.2s ease;
        }

        /* Radio Check Indicator for Mobile */
        .likert-mobile-check {
            display: none;
        }

        @media (max-width: 640px) {
            .likert-mobile-check {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 24px;
                height: 24px;
                border-radius: 50%;
                border: 2px solid #cbd5e1;
                flex-shrink: 0;
                transition: all 0.2s ease;
            }

            .likert-mobile-check svg {
                width: 14px;
                height: 14px;
                opacity: 0;
                transform: scale(0.5);
                transition: all 0.2s ease;
            }
        }

        /* Specific Colors: 1 (STS) to 5 (SS) */
        .likert-card[data-val="1"] .likert-num-badge { background: #ffe4e6; color: #e11d48; }
        .likert-card[data-val="1"]:hover { border-color: #f43f5e; background: #fff1f2; }
        .likert-card[data-val="1"]:hover .likert-label-code { color: #e11d48; }

        .likert-card[data-val="2"] .likert-num-badge { background: #ffedd5; color: #ea580c; }
        .likert-card[data-val="2"]:hover { border-color: #f97316; background: #fff7ed; }
        .likert-card[data-val="2"]:hover .likert-label-code { color: #ea580c; }

        .likert-card[data-val="3"] .likert-num-badge { background: #f1f5f9; color: #475569; }
        .likert-card[data-val="3"]:hover { border-color: #94a3b8; background: #f8fafc; }
        .likert-card[data-val="3"]:hover .likert-label-code { color: #334155; }

        .likert-card[data-val="4"] .likert-num-badge { background: #e0f2fe; color: #0284c7; }
        .likert-card[data-val="4"]:hover { border-color: #38bdf8; background: #f0f9ff; }
        .likert-card[data-val="4"]:hover .likert-label-code { color: #0284c7; }

        .likert-card[data-val="5"] .likert-num-badge { background: #d1fae5; color: #059669; }
        .likert-card[data-val="5"]:hover { border-color: #10b981; background: #ecfdf5; }
        .likert-card[data-val="5"]:hover .likert-label-code { color: #059669; }

        /* Selected State */
        .likert-card.active-selected {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 14px 28px -4px rgba(2, 64, 137, 0.18);
        }

        .likert-card.active-selected .likert-kbd {
            background: #ffffff;
            color: #0f172a;
            border-color: rgba(0,0,0,0.15);
        }

        .likert-card.active-selected[data-val="1"] { border-color: #e11d48; background: #fff1f2; }
        .likert-card.active-selected[data-val="1"] .likert-num-badge { background: #e11d48; color: #fff; }
        .likert-card.active-selected[data-val="1"] .likert-mobile-check { border-color: #e11d48; background: #e11d48; color: #fff; }
        .likert-card.active-selected[data-val="1"] .likert-mobile-check svg { opacity: 1; transform: scale(1); }

        .likert-card.active-selected[data-val="2"] { border-color: #ea580c; background: #fff7ed; }
        .likert-card.active-selected[data-val="2"] .likert-num-badge { background: #ea580c; color: #fff; }
        .likert-card.active-selected[data-val="2"] .likert-mobile-check { border-color: #ea580c; background: #ea580c; color: #fff; }
        .likert-card.active-selected[data-val="2"] .likert-mobile-check svg { opacity: 1; transform: scale(1); }

        .likert-card.active-selected[data-val="3"] { border-color: #475569; background: #f1f5f9; }
        .likert-card.active-selected[data-val="3"] .likert-num-badge { background: #475569; color: #fff; }
        .likert-card.active-selected[data-val="3"] .likert-mobile-check { border-color: #475569; background: #475569; color: #fff; }
        .likert-card.active-selected[data-val="3"] .likert-mobile-check svg { opacity: 1; transform: scale(1); }

        .likert-card.active-selected[data-val="4"] { border-color: #0284c7; background: #f0f9ff; }
        .likert-card.active-selected[data-val="4"] .likert-num-badge { background: #0284c7; color: #fff; }
        .likert-card.active-selected[data-val="4"] .likert-mobile-check { border-color: #0284c7; background: #0284c7; color: #fff; }
        .likert-card.active-selected[data-val="4"] .likert-mobile-check svg { opacity: 1; transform: scale(1); }

        .likert-card.active-selected[data-val="5"] { border-color: #059669; background: #ecfdf5; }
        .likert-card.active-selected[data-val="5"] .likert-num-badge { background: #059669; color: #fff; }
        .likert-card.active-selected[data-val="5"] .likert-mobile-check { border-color: #059669; background: #059669; color: #fff; }
        .likert-card.active-selected[data-val="5"] .likert-mobile-check svg { opacity: 1; transform: scale(1); }

        /* Pulse Scanner animation for evaluating state */
        .pulse-scanner {
            animation: pulseRing 1.6s cubic-bezier(0.24, 0, 0.38, 1) infinite;
        }

        @keyframes pulseRing {
            0% { transform: scale(0.92); box-shadow: 0 0 0 0 rgba(2, 64, 137, 0.5); }
            70% { transform: scale(1.06); box-shadow: 0 0 0 24px rgba(2, 64, 137, 0); }
            100% { transform: scale(0.92); box-shadow: 0 0 0 0 rgba(2, 64, 137, 0); }
        }

        .fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Print Media Style for Official Report */
        @media print {
            body {
                background: #ffffff !important;
            }
            header, footer, nav, #state-intro, #state-quiz, #state-evaluating, .no-print {
                display: none !important;
            }
            .major-finder-shell {
                max-width: 100% !important;
                padding: 0 !important;
            }
            .smeas-glass-card {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
            }
        }
    </style>
</head>

<body class="antialiased flex flex-col min-h-screen">

    {{-- Header / Navbar --}}
    @include('partials.navbar', [
        'activePage' => 'jurusan',
        'berandaUrl' => route('beranda')
    ])

    <main class="flex-grow py-8 md:py-14">
        <div class="major-finder-shell">

            {{-- Breadcrumb Navigation --}}
            <nav class="flex items-center gap-2 text-xs md:text-sm text-slate-500 mb-6 font-medium">
                <a href="{{ route('beranda') }}" class="hover:text-blue-900 transition-colors">Beranda</a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('jurusan') }}" class="hover:text-blue-900 transition-colors">Jurusan</a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-900 font-bold">AI Major Finder</span>
            </nav>

            {{-- ==================== STATE 1: INTRO CARD ==================== --}}
            <div id="state-intro" class="smeas-glass-card p-6 md:p-12 fade-in">
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-900 border border-blue-200">
                        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                        </svg>
                        Smeas AI Major Finder
                    </span>
                    <span class="text-xs text-slate-500 font-semibold bg-slate-100 px-3 py-1.5 rounded-full">
                        ⏱️ 15 Pertanyaan • ±3 Menit
                    </span>
                </div>

                <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-4 tracking-tight">
                    Temukan Jurusan Impianmu di SMKN 1 Surabaya
                </h1>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed mb-8 max-w-2xl">
                    Bingung memilih satu dari 9 kompetensi keahlian favorit di SMEAS? Kuesioner probabilitas cerdas ini mengukur minat, kecenderungan logika, serta gaya kerjamu untuk memberikan rekomendasi jurusan paling akurat yang didukung analisis personal dari AI.
                </p>

                {{-- 3 Value Points --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80">
                        <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold text-sm mb-3">1</div>
                        <h4 class="font-bold text-slate-900 text-sm mb-1">15 Pernyataan Cepat</h4>
                        <p class="text-slate-500 text-xs leading-relaxed">Cukup pilih skala Sangat Tidak Setuju (STS) hingga Sangat Setuju (SS).</p>
                    </div>
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80">
                        <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-900 flex items-center justify-center font-bold text-sm mb-3">2</div>
                        <h4 class="font-bold text-slate-900 text-sm mb-1">Matriks 9 Kejuruan</h4>
                        <p class="text-slate-500 text-xs leading-relaxed">Algoritma probabilitas memetakan responmu ke seluruh jurusan vokasi.</p>
                    </div>
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-900 flex items-center justify-center font-bold text-sm mb-3">3</div>
                        <h4 class="font-bold text-slate-900 text-sm mb-1">Analisis Personal AI</h4>
                        <p class="text-slate-500 text-xs leading-relaxed">Dapatkan narasi bimbingan karir masa depan eksklusif dari Smeas.Ai.</p>
                    </div>
                </div>

                {{-- Name Input (Optional) --}}
                <div class="mb-8 p-5 bg-blue-50/50 border border-blue-100 rounded-2xl">
                    <label for="student-name" class="block text-sm font-bold text-slate-900 mb-1.5">
                        Siapa nama panggilanmu?
                    </label>
                    <p class="text-xs text-slate-500 mb-3">
                        Digunakan oleh AI Career Counselor untuk menyapa dan menyusun laporan hasil rekomendasi secara personal.
                    </p>
                    <input type="text" id="student-name" placeholder="Ketik namamu di sini (contoh: Dimas / Nabila)"
                        class="w-full sm:w-80 px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-slate-800 text-sm font-semibold focus:outline-none focus:border-blue-900 focus:ring-4 focus:ring-blue-100 transition-all">
                </div>

                <button type="button" onclick="startQuiz()"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-[#024089] to-[#002f66] text-white font-bold text-base rounded-xl shadow-lg shadow-blue-950/20 hover:from-[#002f66] hover:to-[#001f44] hover:shadow-xl hover:translate-y-[-2px] transition-all cursor-pointer">
                    <span>Mulai Kuesioner Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>

            {{-- ==================== STATE 2: STEPPER WIZARD ==================== --}}
            <div id="state-quiz" class="hidden smeas-glass-card p-6 md:p-10 fade-in">
                
                {{-- Header Nav & Progress --}}
                <div class="mb-6 pb-6 border-b border-slate-100">
                    <div class="flex items-center justify-between gap-4 mb-3">
                        <button type="button" id="btn-back" onclick="prevQuestion()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-slate-500 hover:text-blue-900 hover:bg-slate-100 transition-all disabled:opacity-30 disabled:pointer-events-none cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <span>Soal Sebelumnya</span>
                        </button>

                        <div class="flex items-center gap-2">
                            <span id="question-category-pill" class="hidden sm:inline-flex items-center gap-1 px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-bold">
                                📊 Analisis Finansial
                            </span>
                            <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-900 border border-blue-100 rounded-full text-xs font-extrabold">
                                <span id="question-counter">Pertanyaan 1 dari 15</span>
                            </div>
                        </div>

                        <span id="progress-percent" class="text-xs md:text-sm font-black text-amber-600">7%</span>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div id="progress-bar" class="h-full bg-gradient-to-r from-[#024089] to-[#f59e0b] rounded-full transition-all duration-300 ease-out" style="width: 7%;"></div>
                    </div>
                </div>

                {{-- Question Statement Card --}}
                <div class="question-statement-box">
                    <div class="inline-flex items-center gap-2 text-xs font-extrabold text-blue-900 uppercase tracking-wider mb-2.5">
                        <span id="question-icon-badge" class="text-base">📊</span>
                        <span id="question-category-label">Pernyataan Kuesioner:</span>
                    </div>
                    <h2 id="question-text" class="question-text-title statement-anim">
                        Saya sangat menikmati aktivitas yang melibatkan analisis angka, pencatatan data keuangan, atau audit laporan secara teliti.
                    </h2>
                </div>

                {{-- Spectrum Guide Bar --}}
                <div class="spectrum-bar-wrap">
                    <div class="spectrum-left">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block shadow-sm"></span>
                        <span>Sangat Tidak Setuju</span>
                    </div>
                    <div class="spectrum-mid-hint">
                        <span>💡 Tekan angka <strong>1 - 5</strong> di keyboard atau klik di bawah:</span>
                    </div>
                    <div class="spectrum-right">
                        <span>Sangat Setuju</span>
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block shadow-sm"></span>
                    </div>
                </div>

                {{-- 5 Likert Buttons --}}
                <div class="likert-grid" id="likert-container">
                    <button type="button" onclick="selectAnswer(1)" data-val="1" class="likert-card" title="Pilih Sangat Tidak Setuju (Tekan 1)">
                        <span class="likert-kbd">1</span>
                        <div class="likert-num-badge">1</div>
                        <div class="flex-grow">
                            <div class="likert-label-code">STS</div>
                            <div class="likert-label-desc">Sangat Tidak Setuju</div>
                        </div>
                        <div class="likert-mobile-check">
                            <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                    </button>

                    <button type="button" onclick="selectAnswer(2)" data-val="2" class="likert-card" title="Pilih Tidak Setuju (Tekan 2)">
                        <span class="likert-kbd">2</span>
                        <div class="likert-num-badge">2</div>
                        <div class="flex-grow">
                            <div class="likert-label-code">TS</div>
                            <div class="likert-label-desc">Tidak Setuju</div>
                        </div>
                        <div class="likert-mobile-check">
                            <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                    </button>

                    <button type="button" onclick="selectAnswer(3)" data-val="3" class="likert-card" title="Pilih Netral (Tekan 3)">
                        <span class="likert-kbd">3</span>
                        <div class="likert-num-badge">3</div>
                        <div class="flex-grow">
                            <div class="likert-label-code">N</div>
                            <div class="likert-label-desc">Netral</div>
                        </div>
                        <div class="likert-mobile-check">
                            <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                    </button>

                    <button type="button" onclick="selectAnswer(4)" data-val="4" class="likert-card" title="Pilih Setuju (Tekan 4)">
                        <span class="likert-kbd">4</span>
                        <div class="likert-num-badge">4</div>
                        <div class="flex-grow">
                            <div class="likert-label-code">S</div>
                            <div class="likert-label-desc">Setuju</div>
                        </div>
                        <div class="likert-mobile-check">
                            <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                    </button>

                    <button type="button" onclick="selectAnswer(5)" data-val="5" class="likert-card" title="Pilih Sangat Setuju (Tekan 5)">
                        <span class="likert-kbd">5</span>
                        <div class="likert-num-badge">5</div>
                        <div class="flex-grow">
                            <div class="likert-label-code">SS</div>
                            <div class="likert-label-desc">Sangat Setuju</div>
                        </div>
                        <div class="likert-mobile-check">
                            <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                    </button>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400 font-medium px-1">
                    <span class="flex items-center gap-1.5">
                        <kbd class="px-1.5 py-0.5 bg-slate-100 border border-slate-200 rounded text-[10px] font-bold text-slate-600">←</kbd>
                        <span>Panah Kiri untuk kembali</span>
                    </span>
                    <span>
                        ✨ <em>Pilihanmu otomatis lanjut ke nomor berikutnya</em>
                    </span>
                </div>
            </div>

            {{-- ==================== STATE 3: CALCULATING TRANSITION ==================== --}}
            <div id="state-evaluating" class="hidden smeas-glass-card p-12 text-center fade-in">
                <div class="w-20 h-20 mx-auto rounded-full bg-[#024089] text-amber-400 flex items-center justify-center text-3xl pulse-scanner mb-6 shadow-xl">
                    🤖
                </div>
                <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Menganalisis Pola Minat & Bakatmu...</h3>
                <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed mb-6">
                    Sistem probabilitas cerdas sedang mengolah 15 respon jawabanmu untuk mencocokkan matriks kompetensi 9 kejuruan vokasi SMKN 1 Surabaya.
                </p>

                <div class="max-w-xs mx-auto space-y-2 text-xs font-semibold text-slate-400 text-left">
                    <div class="flex items-center gap-2 text-blue-900 font-bold">
                        <span class="w-2 h-2 rounded-full bg-blue-600 animate-ping"></span>
                        <span>Menghitung normalisasi bobot kejuruan...</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-500">
                        <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                        <span>Menghubungkan ke Smeas.Ai Career Engine...</span>
                    </div>
                </div>
            </div>

            {{-- ==================== STATE 4: RICH CAREER DASHBOARD ==================== --}}
            <div id="state-result" class="hidden space-y-6 fade-in">
                
                {{-- Greeting Header --}}
                <div class="text-center mb-6">
                    <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-200 mb-2">
                        🎉 Analisis Minat & Bakat Selesai
                    </span>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Hai <span id="res-greeting-name" class="text-blue-900">Sobat SMEAS</span>, Ini Rekomendasi Jurusanmu!
                    </h2>
                    <p class="text-slate-500 text-xs md:text-sm mt-1">
                        Berikut adalah peta kecocokan potensi dirimu dengan 9 program keahlian di SMKN 1 Surabaya.
                    </p>
                </div>

                {{-- Hero Top Match Card --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-[#024089] via-[#002f66] to-[#001938] rounded-3xl p-6 md:p-8 text-white shadow-2xl border border-blue-900">
                    {{-- Decorative Glow Circles --}}
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-amber-400/15 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-white/15 backdrop-blur border border-white/20 text-yellow-300">
                                🏆 Rekomendasi Juara #1
                            </span>
                            <div class="text-right">
                                <span id="res-top-score" class="text-4xl md:text-5xl font-black text-amber-400">95%</span>
                                <span class="block text-[11px] font-semibold text-blue-200 uppercase tracking-wider">Kecocokan</span>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center gap-2.5 mb-2">
                                <span id="res-top-code" class="inline-block px-2.5 py-1 bg-amber-400 text-blue-950 font-black rounded-md text-xs tracking-wider">RPL</span>
                                <span class="text-xs text-blue-200 font-semibold">Kompetensi Keahlian Unggulan</span>
                            </div>
                            <h3 id="res-top-name" class="text-2xl md:text-4xl font-black tracking-tight text-white mb-2.5">
                                Rekayasa Perangkat Lunak
                            </h3>
                            <p id="res-top-career" class="text-blue-100 text-xs md:text-sm font-medium leading-relaxed max-w-2xl">
                                Software Developer, Web Engineer, Mobile App Creator
                            </p>
                        </div>

                        <div class="pt-5 border-t border-white/10 flex flex-wrap items-center gap-3.5 no-print">
                            <a id="res-top-link" href="{{ route('jurusan.detail', 'rekayasa-perangkat-lunak') }}"
                                class="inline-flex items-center gap-2 px-6 py-3.5 bg-amber-400 text-blue-950 font-bold text-sm rounded-xl hover:bg-amber-300 transition-all shadow-lg shadow-amber-950/20 cursor-pointer">
                                <span>Pelajari Profil Jurusan Ini</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                            <a href="{{ route('spmb.index') }}"
                                class="inline-flex items-center gap-2 px-5 py-3.5 bg-white/10 hover:bg-white/20 text-white font-semibold text-sm rounded-xl border border-white/25 transition-all">
                                <span>Daftar Sekarang (SPMB)</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- AI Personal Insight Card --}}
                <div class="smeas-glass-card p-6 md:p-8">
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-xl shadow-sm">
                                🤖
                            </div>
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-base md:text-lg">Analisis Personal Smeas.Ai</h4>
                                <p class="text-xs text-slate-400 font-medium">Konsultan Bimbingan Karir Resmi SMKN 1 Surabaya</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            AI Online
                        </span>
                    </div>

                    {{-- Skeleton Loader saat AJAX memuat --}}
                    <div id="ai-skeleton" class="space-y-2.5 animate-pulse py-2">
                        <div class="h-3.5 bg-slate-200 rounded w-full"></div>
                        <div class="h-3.5 bg-slate-200 rounded w-5/6"></div>
                        <div class="h-3.5 bg-slate-200 rounded w-4/6"></div>
                    </div>

                    {{-- AI Insight Text --}}
                    <div id="ai-text" class="hidden text-slate-700 text-sm md:text-base leading-relaxed font-normal whitespace-pre-line border-l-4 border-amber-400 pl-4 py-1.5 bg-amber-50/40 rounded-r-xl">
                    </div>
                </div>

                {{-- Ranked Breakdown: 9 Majors --}}
                <div class="smeas-glass-card p-6 md:p-8">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-base md:text-lg">
                                Ranking Probabilitas 9 Kejuruan SMKN 1 Surabaya
                            </h4>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">Pemetaan menyeluruh berdasarkan skor kecocokan minatmu</p>
                        </div>
                        <span class="text-xs font-bold text-blue-900 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                            9 Kompetensi Keahlian
                        </span>
                    </div>

                    <div id="ranked-majors-list" class="space-y-3.5">
                        {{-- Injected dynamically --}}
                    </div>
                </div>

                {{-- Action & Sharing Toolbar --}}
                <div class="bg-slate-900 rounded-3xl p-6 md:p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 no-print">
                    <div>
                        <h4 class="text-lg font-bold text-white mb-1">Bagikan Hasil Rekomendasimu</h4>
                        <p class="text-slate-400 text-xs md:text-sm">
                            Konsultasikan dengan orang tua atau bagikan ke teman-temanmu agar bisa memilih bersama.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        <button type="button" onclick="shareWhatsApp()"
                            class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm shadow-lg shadow-emerald-950/20 transition-all cursor-pointer">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>WhatsApp</span>
                        </button>

                        <button type="button" onclick="copyResultLink()"
                            class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm border border-white/10 transition-all cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                            </svg>
                            <span id="btn-copy-text">Salin Tautan</span>
                        </button>

                        <button type="button" onclick="window.print()"
                            class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-4 py-3.5 rounded-xl bg-white/5 hover:bg-white/15 text-slate-300 hover:text-white font-semibold text-sm border border-slate-700 transition-all cursor-pointer" title="Cetak atau Simpan PDF">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            <span>Cetak</span>
                        </button>

                        <button type="button" onclick="resetQuiz()"
                            class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-4 py-3.5 rounded-xl bg-transparent hover:bg-white/5 text-slate-400 hover:text-white font-semibold text-sm border border-slate-800 transition-all cursor-pointer">
                            <span>Ulangi Tes</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-[#024089] text-white pt-12 pb-8 border-t border-blue-900 mt-12 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo SMKN 1 Surabaya" class="h-10 w-auto">
                        <div>
                            <span class="font-extrabold text-base tracking-wide block">SMK NEGERI 1 SURABAYA</span>
                            <span class="text-xs text-blue-200">Pusat Keunggulan Vokasi & Karir Masa Depan</span>
                        </div>
                    </div>
                    <p class="text-xs text-blue-200/90 leading-relaxed max-w-sm mb-4">
                        Membentuk lulusan berakhlak mulia, kompeten, berdaya saing global, dan siap kerja di dunia usaha serta industri.
                    </p>
                </div>
                <div>
                    <h5 class="font-bold text-sm mb-3 text-amber-400">Navigasi Utama</h5>
                    <ul class="space-y-2 text-xs text-blue-100">
                        <li><a href="{{ route('beranda') }}" class="hover:text-amber-400 transition-colors">&bull; Beranda</a></li>
                        <li><a href="{{ route('jurusan') }}" class="hover:text-amber-400 transition-colors">&bull; 9 Bidang Kejuruan</a></li>
                        <li><a href="{{ route('pusat-karir.index') }}" class="hover:text-amber-400 transition-colors">&bull; Pusat Karir & Lowongan</a></li>
                        <li><a href="{{ route('spmb.index') }}" class="hover:text-amber-400 transition-colors">&bull; Pendaftaran Siswa Baru (SPMB)</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-sm mb-3 text-amber-400">Kontak Sekolah</h5>
                    <p class="text-xs text-blue-100/90 leading-relaxed">
                        Jl. Smea No. 4, Wonokromo, Surabaya, Jawa Timur 60243<br>
                        Telepon: (031) 8292038<br>
                        Email: info@smkn1surabaya.sch.id
                    </p>
                </div>
            </div>
            <div class="pt-6 border-t border-white/10 text-center text-xs text-blue-200/70 font-medium">
                &copy; {{ date('Y') }} SMK Negeri 1 Surabaya. All rights reserved.
            </div>
        </div>
    </footer>

    {{-- Script Engine --}}
    <script>
        const questions = @json($questions);
        const majorsData = @json($majors);
        const analysisUrl = "{{ route('temukan-jurusan.analisis') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let currentQuestionIndex = 0;
        let userAnswers = {}; // { questionId: 1..5 }
        let studentName = '';
        let lastRankedResults = [];

        function startQuiz() {
            const nameInput = document.getElementById('student-name');
            studentName = nameInput ? nameInput.value.trim() : '';

            document.getElementById('state-intro').classList.add('hidden');
            document.getElementById('state-quiz').classList.remove('hidden');
            
            currentQuestionIndex = 0;
            userAnswers = {};
            renderQuestion();
            window.scrollTo({ top: 120, behavior: 'smooth' });
        }

        function renderQuestion() {
            const q = questions[currentQuestionIndex];
            if (!q) return;

            const qCounter = document.getElementById('question-counter');
            const qText = document.getElementById('question-text');
            const pPercent = document.getElementById('progress-percent');
            const pBar = document.getElementById('progress-bar');
            const btnBack = document.getElementById('btn-back');
            const catPill = document.getElementById('question-category-pill');
            const iconBadge = document.getElementById('question-icon-badge');
            const catLabel = document.getElementById('question-category-label');

            const currentNum = currentQuestionIndex + 1;
            const total = questions.length;
            const percentage = Math.round((currentNum / total) * 100);

            qCounter.textContent = `Pertanyaan ${currentNum} dari ${total}`;
            pPercent.textContent = `${percentage}%`;
            pBar.style.width = `${percentage}%`;

            // Animate statement text change
            qText.classList.remove('statement-anim');
            void qText.offsetWidth; // trigger reflow
            qText.textContent = q.text;
            qText.classList.add('statement-anim');

            if (q.category) {
                if (catPill) {
                    catPill.textContent = `${q.icon || '📌'} ${q.category}`;
                }
                if (iconBadge) {
                    iconBadge.textContent = q.icon || '💬';
                }
                if (catLabel) {
                    catLabel.textContent = q.category;
                }
            }

            btnBack.disabled = (currentQuestionIndex === 0);

            // Reset active states on likert cards
            const cards = document.querySelectorAll('.likert-card');
            cards.forEach(card => card.classList.remove('active-selected'));

            // If previously answered, highlight it
            if (userAnswers[q.id]) {
                const prevVal = userAnswers[q.id];
                const activeCard = document.querySelector(`.likert-card[data-val="${prevVal}"]`);
                if (activeCard) {
                    activeCard.classList.add('active-selected');
                }
            }
        }

        function selectAnswer(val) {
            const q = questions[currentQuestionIndex];
            if (!q) return;

            userAnswers[q.id] = val;

            // Highlight chosen button immediately
            const cards = document.querySelectorAll('.likert-card');
            cards.forEach(card => card.classList.remove('active-selected'));
            
            const activeCard = document.querySelector(`.likert-card[data-val="${val}"]`);
            if (activeCard) {
                activeCard.classList.add('active-selected');
            }

            // Smooth micro delay before advancing
            setTimeout(() => {
                if (currentQuestionIndex < questions.length - 1) {
                    currentQuestionIndex++;
                    renderQuestion();
                } else {
                    finishQuiz();
                }
            }, 220);
        }

        function prevQuestion() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                renderQuestion();
            }
        }

        // Global Keyboard Shortcuts (1-5 for options, ArrowLeft/Backspace for prev)
        window.addEventListener('keydown', (e) => {
            const quizState = document.getElementById('state-quiz');
            if (!quizState || quizState.classList.contains('hidden')) return;

            // Ignore if active element is an input
            if (['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) return;

            if (['1', '2', '3', '4', '5'].includes(e.key)) {
                e.preventDefault();
                selectAnswer(parseInt(e.key, 10));
            } else if (e.key === 'ArrowLeft' || e.key === 'Backspace') {
                if (currentQuestionIndex > 0) {
                    e.preventDefault();
                    prevQuestion();
                }
            }
        });

        function calculateProbabilities() {
            const majorScores = {};
            const majorMin = {};
            const majorMax = {};

            // Initialize all majors
            Object.keys(majorsData).forEach(slug => {
                majorScores[slug] = 0;
                majorMin[slug] = 0;
                majorMax[slug] = 0;
            });

            // Iterate 15 questions
            questions.forEach(q => {
                const answer = userAnswers[q.id] || 3; // default neutral 3 if missing

                // Primary (weight: 3)
                if (q.primary && majorScores[q.primary] !== undefined) {
                    majorScores[q.primary] += (answer * 3);
                    majorMin[q.primary] += (1 * 3);
                    majorMax[q.primary] += (5 * 3);
                }

                // Secondary (weight: 1)
                if (q.secondary && majorScores[q.secondary] !== undefined) {
                    majorScores[q.secondary] += (answer * 1);
                    majorMin[q.secondary] += (1 * 1);
                    majorMax[q.secondary] += (5 * 1);
                }
            });

            // Normalize to 25% - 98%
            const results = Object.keys(majorsData).map(slug => {
                const raw = majorScores[slug];
                const min = majorMin[slug] || 1;
                const max = majorMax[slug] || 5;

                const ratio = Math.max(0, Math.min(1, (raw - min) / (max - min)));
                const scorePercent = Math.round(25 + (ratio * 73));
                const cappedScore = Math.min(98, Math.max(25, scorePercent));

                return {
                    slug: slug,
                    name: majorsData[slug].name,
                    code: majorsData[slug].code,
                    career: majorsData[slug].career,
                    score: cappedScore
                };
            });

            // Sort descending by score
            results.sort((a, b) => b.score - a.score);
            return results;
        }

        function finishQuiz() {
            document.getElementById('state-quiz').classList.add('hidden');
            document.getElementById('state-evaluating').classList.remove('hidden');
            window.scrollTo({ top: 120, behavior: 'smooth' });

            const results = calculateProbabilities();
            lastRankedResults = results;

            // Wait 650ms for realistic calculation transition
            setTimeout(() => {
                renderResults(results);
            }, 650);
        }

        function renderResults(results) {
            document.getElementById('state-evaluating').classList.add('hidden');
            document.getElementById('state-result').classList.remove('hidden');

            const displayName = studentName || 'Sobat SMEAS';
            document.getElementById('res-greeting-name').textContent = displayName;

            // Top #1 Match
            const top = results[0];
            document.getElementById('res-top-score').textContent = `${top.score}%`;
            document.getElementById('res-top-code').textContent = top.code;
            document.getElementById('res-top-name').textContent = top.name;
            document.getElementById('res-top-career').textContent = top.career;
            document.getElementById('res-top-link').href = `/jurusan/${top.slug}`;

            // Render all 9 majors breakdown with podium styling
            const listEl = document.getElementById('ranked-majors-list');
            listEl.innerHTML = '';

            results.forEach((item, idx) => {
                const rankNum = idx + 1;
                let barColor = 'bg-slate-400';
                let badgeBg = 'bg-slate-100 text-slate-700 border border-slate-200';
                let podiumTag = '';
                let borderHighlight = 'border-slate-100 bg-slate-50/60 hover:border-slate-300';
                
                if (rankNum === 1) {
                    barColor = 'bg-amber-400';
                    badgeBg = 'bg-amber-400 text-blue-950 font-black';
                    podiumTag = '<span class="text-[11px] font-extrabold text-amber-600 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">🥇 Juara 1</span>';
                    borderHighlight = 'border-amber-200 bg-amber-50/30 hover:border-amber-300 shadow-sm';
                } else if (rankNum === 2) {
                    barColor = 'bg-blue-600';
                    badgeBg = 'bg-blue-600 text-white font-bold';
                    podiumTag = '<span class="text-[11px] font-extrabold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full">🥈 Peringkat 2</span>';
                    borderHighlight = 'border-blue-100 bg-blue-50/20 hover:border-blue-200';
                } else if (rankNum === 3) {
                    barColor = 'bg-teal-500';
                    badgeBg = 'bg-teal-500 text-white font-bold';
                    podiumTag = '<span class="text-[11px] font-extrabold text-teal-700 bg-teal-50 border border-teal-200 px-2 py-0.5 rounded-full">🥉 Peringkat 3</span>';
                    borderHighlight = 'border-teal-100 bg-teal-50/20 hover:border-teal-200';
                }

                const itemRow = document.createElement('div');
                itemRow.className = `p-4 rounded-2xl border ${borderHighlight} transition-all`;
                itemRow.innerHTML = `
                    <div class="flex items-center justify-between gap-3 mb-2.5">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs ${badgeBg}">
                                ${rankNum}
                            </span>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-bold text-slate-900 text-sm md:text-base">${item.name}</span>
                                    <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded bg-slate-200 text-slate-700">${item.code}</span>
                                    ${podiumTag}
                                </div>
                                <div class="text-[11px] text-slate-400 font-medium hidden sm:block">${item.career}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <span class="text-base md:text-lg font-black text-slate-900">${item.score}%</span>
                            <a href="/jurusan/${item.slug}" class="text-xs font-bold text-blue-900 hover:text-amber-600 transition-colors hidden sm:inline">
                                Detail &rarr;
                            </a>
                        </div>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200/80 rounded-full overflow-hidden">
                        <div class="h-full ${barColor} rounded-full transition-all duration-700 ease-out" style="width: ${item.score}%"></div>
                    </div>
                `;
                listEl.appendChild(itemRow);
            });

            // Scroll to top of results smoothly
            window.scrollTo({ top: 120, behavior: 'smooth' });

            // Request AI Analysis from Gemini Endpoint
            fetchAIAnalysis(displayName, results);
        }

        function fetchAIAnalysis(name, results) {
            const skeleton = document.getElementById('ai-skeleton');
            const aiText = document.getElementById('ai-text');

            skeleton.classList.remove('hidden');
            aiText.classList.add('hidden');

            const top = results[0];
            const alternatives = results.slice(1, 3);

            fetch(analysisUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    nama: name,
                    top_major: { name: top.name, score: top.score },
                    alternatives: alternatives.map(a => ({ name: a.name, score: a.score })),
                    highlights: ['analisis minat', 'daya pikir logis', 'kompetensi vokasi']
                })
            })
            .then(res => res.json())
            .then(data => {
                skeleton.classList.add('hidden');
                if (data.success && data.analysis) {
                    aiText.textContent = data.analysis;
                    aiText.classList.remove('hidden');
                    aiText.classList.add('fade-in');
                }
            })
            .catch(() => {
                skeleton.classList.add('hidden');
                aiText.textContent = `Halo ${name}! Berdasarkan hasil kuesioner, kamu menunjukkan potensi luar biasa pada kompetensi keahlian ${top.name} dengan tingkat kecocokan mencapai ${top.score}%. Karakteristik berpikirmu yang analitis dan tekun sangat sejalan dengan kurikulum vokasi unggulan di SMKN 1 Surabaya.`;
                aiText.classList.remove('hidden');
            });
        }

        function shareWhatsApp() {
            if (!lastRankedResults || lastRankedResults.length < 3) return;
            const name = studentName || 'Sobat SMEAS';
            const top1 = lastRankedResults[0];
            const top2 = lastRankedResults[1];
            const top3 = lastRankedResults[2];

            const message = `Halo! Saya (${name}) baru saja mengikuti tes minat & bakat di Smeas AI Major Finder SMKN 1 Surabaya.\n\n` +
                `🏆 Hasil Rekomendasi Jurusan Terbaik Saya:\n` +
                `1. ${top1.name} (${top1.score}% Cocok)\n` +
                `2. ${top2.name} (${top2.score}% Cocok)\n` +
                `3. ${top3.name} (${top3.score}% Cocok)\n\n` +
                `Yuk coba tes rekomendasi jurusanmu di SMKN 1 Surabaya juga:\n${window.location.href}`;

            const waUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}`;
            window.open(waUrl, '_blank');
        }

        function copyResultLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                const btnText = document.getElementById('btn-copy-text');
                const orig = btnText.textContent;
                btnText.textContent = '✓ Tautan Disalin!';
                setTimeout(() => {
                    btnText.textContent = orig;
                }, 2000);
            });
        }

        function resetQuiz() {
            document.getElementById('state-result').classList.add('hidden');
            document.getElementById('state-intro').classList.remove('hidden');
            window.scrollTo({ top: 120, behavior: 'smooth' });
        }
    </script>

</body>

</html>
