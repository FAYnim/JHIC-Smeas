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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }

        .slide-up {
            animation: slideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .pulse-scanner {
            animation: pulseScanner 1.5s infinite;
        }

        @keyframes pulseScanner {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(2, 64, 137, 0.4); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 20px rgba(2, 64, 137, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(2, 64, 137, 0); }
        }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased flex flex-col min-h-screen">

    {{-- Header / Navbar --}}
    @include('partials.navbar', [
        'activePage' => 'jurusan',
        'berandaUrl' => route('beranda')
    ])

    <main class="flex-grow py-8 md:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb Navigation --}}
            <nav class="flex items-center gap-2 text-xs md:text-sm text-slate-500 mb-6 font-medium">
                <a href="{{ route('beranda') }}" class="hover:text-blue-900 transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('jurusan') }}" class="hover:text-blue-900 transition-colors">Jurusan</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">AI Major Finder</span>
            </nav>

            {{-- ==================== STATE 1: INTRO CARD ==================== --}}
            <div id="state-intro" class="bg-white rounded-3xl p-6 md:p-10 shadow-xl border border-slate-100 slide-up">
                <div class="flex items-center gap-3 mb-6">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-800 border border-blue-100">
                        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                        </svg>
                        Smeas AI Major Finder
                    </span>
                    <span class="text-xs text-slate-400 font-medium">15 Pertanyaan • ±3 Menit</span>
                </div>

                <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-4">
                    Temukan Jurusan Impianmu di SMKN 1 Surabaya
                </h1>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed mb-8">
                    Setiap orang memiliki bakat unik dan gaya berpikir yang berbeda. Jawab 15 pernyataan kuesioner probabilitas ini dengan jujur sesuai dirimu untuk memetakan kecocokanmu terhadap <strong>9 bidang keahlian vokasi</strong> kami yang dilengkapi rekomendasi personal oleh AI.
                </p>

                {{-- Panduan Skala Pilihan --}}
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-5 mb-8">
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Panduan Skala Jawaban:</div>
                    <div class="grid grid-cols-5 gap-2 text-center text-xs font-semibold">
                        <div class="p-2.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700">
                            <div class="font-bold text-sm">STS</div>
                            <div class="text-[10px] mt-0.5">Sangat Tidak Setuju</div>
                        </div>
                        <div class="p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-700">
                            <div class="font-bold text-sm">TS</div>
                            <div class="text-[10px] mt-0.5">Tidak Setuju</div>
                        </div>
                        <div class="p-2.5 rounded-xl bg-slate-100 border border-slate-200 text-slate-700">
                            <div class="font-bold text-sm">N</div>
                            <div class="text-[10px] mt-0.5">Netral</div>
                        </div>
                        <div class="p-2.5 rounded-xl bg-teal-50 border border-teal-200 text-teal-700">
                            <div class="font-bold text-sm">S</div>
                            <div class="text-[10px] mt-0.5">Setuju</div>
                        </div>
                        <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700">
                            <div class="font-bold text-sm">SS</div>
                            <div class="text-[10px] mt-0.5">Sangat Setuju</div>
                        </div>
                    </div>
                </div>

                {{-- Personalisasi Nama (Opsional) --}}
                <div class="mb-8">
                    <label for="student-name" class="block text-sm font-bold text-slate-700 mb-2">
                        Siapa nama panggilanmu? <span class="text-slate-400 font-normal text-xs">(Opsional untuk personalisasi hasil AI)</span>
                    </label>
                    <input type="text" id="student-name" placeholder="Contoh: Rizky / Alya (Boleh dikosongkan)"
                        class="w-full md:w-80 px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-blue-900 focus:ring-4 focus:ring-blue-100 transition-all">
                </div>

                <button type="button" onclick="startQuiz()"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-[#024089] to-[#012f66] text-white font-bold text-base rounded-xl shadow-lg shadow-blue-950/20 hover:from-[#002f66] hover:to-[#001f44] hover:shadow-xl hover:translate-y-[-2px] transition-all">
                    <span>Mulai Kuesioner (15 Soal)</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>

            {{-- ==================== STATE 2: STEPPER WIZARD ==================== --}}
            <div id="state-quiz" class="hidden bg-white rounded-3xl p-6 md:p-10 shadow-xl border border-slate-100 slide-up">
                {{-- Progress Indicator --}}
                <div class="mb-8">
                    <div class="flex items-center justify-between text-xs md:text-sm font-bold text-slate-500 mb-2.5">
                        <div class="flex items-center gap-2">
                            <button type="button" id="btn-back" onclick="prevQuestion()"
                                class="inline-flex items-center gap-1 text-slate-400 hover:text-blue-900 font-semibold transition-colors disabled:opacity-30 disabled:pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span>Sebelumnya</span>
                            </button>
                            <span class="text-slate-300">|</span>
                            <span id="question-counter" class="text-blue-900 font-extrabold">Pertanyaan 1 dari 15</span>
                        </div>
                        <span id="progress-percent" class="text-blue-900 font-black">7%</span>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden p-0.5">
                        <div id="progress-bar" class="h-full bg-gradient-to-r from-blue-900 to-amber-500 rounded-full transition-all duration-300 ease-out" style="width: 7%;"></div>
                    </div>
                </div>

                {{-- Question Card --}}
                <div class="min-h-[120px] flex items-center mb-8">
                    <h2 id="question-text" class="text-xl md:text-2xl font-bold text-slate-900 leading-snug">
                        Memuat pertanyaan...
                    </h2>
                </div>

                {{-- 5 Likert Buttons --}}
                <div class="grid grid-cols-1 sm:grid-cols-5 gap-3">
                    <button type="button" onclick="selectAnswer(1)"
                        class="btn-option group flex sm:flex-col items-center justify-between sm:justify-center gap-2 p-4 rounded-2xl border-2 border-slate-200 hover:border-rose-400 hover:bg-rose-50/50 transition-all text-left sm:text-center focus:outline-none">
                        <span class="w-8 h-8 rounded-full bg-rose-100 text-rose-700 font-black text-sm flex items-center justify-center group-hover:scale-110 transition-transform">1</span>
                        <div>
                            <div class="text-xs font-extrabold text-slate-700 group-hover:text-rose-900">STS</div>
                            <div class="text-[11px] text-slate-500">Sangat Tidak Setuju</div>
                        </div>
                    </button>

                    <button type="button" onclick="selectAnswer(2)"
                        class="btn-option group flex sm:flex-col items-center justify-between sm:justify-center gap-2 p-4 rounded-2xl border-2 border-slate-200 hover:border-amber-400 hover:bg-amber-50/50 transition-all text-left sm:text-center focus:outline-none">
                        <span class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 font-black text-sm flex items-center justify-center group-hover:scale-110 transition-transform">2</span>
                        <div>
                            <div class="text-xs font-extrabold text-slate-700 group-hover:text-amber-900">TS</div>
                            <div class="text-[11px] text-slate-500">Tidak Setuju</div>
                        </div>
                    </button>

                    <button type="button" onclick="selectAnswer(3)"
                        class="btn-option group flex sm:flex-col items-center justify-between sm:justify-center gap-2 p-4 rounded-2xl border-2 border-slate-200 hover:border-slate-400 hover:bg-slate-50 transition-all text-left sm:text-center focus:outline-none">
                        <span class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 font-black text-sm flex items-center justify-center group-hover:scale-110 transition-transform">3</span>
                        <div>
                            <div class="text-xs font-extrabold text-slate-700 group-hover:text-slate-900">N</div>
                            <div class="text-[11px] text-slate-500">Netral</div>
                        </div>
                    </button>

                    <button type="button" onclick="selectAnswer(4)"
                        class="btn-option group flex sm:flex-col items-center justify-between sm:justify-center gap-2 p-4 rounded-2xl border-2 border-slate-200 hover:border-teal-400 hover:bg-teal-50/50 transition-all text-left sm:text-center focus:outline-none">
                        <span class="w-8 h-8 rounded-full bg-teal-100 text-teal-700 font-black text-sm flex items-center justify-center group-hover:scale-110 transition-transform">4</span>
                        <div>
                            <div class="text-xs font-extrabold text-slate-700 group-hover:text-teal-900">S</div>
                            <div class="text-[11px] text-slate-500">Setuju</div>
                        </div>
                    </button>

                    <button type="button" onclick="selectAnswer(5)"
                        class="btn-option group flex sm:flex-col items-center justify-between sm:justify-center gap-2 p-4 rounded-2xl border-2 border-slate-200 hover:border-emerald-400 hover:bg-emerald-50/50 transition-all text-left sm:text-center focus:outline-none">
                        <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-black text-sm flex items-center justify-center group-hover:scale-110 transition-transform">5</span>
                        <div>
                            <div class="text-xs font-extrabold text-slate-700 group-hover:text-emerald-900">SS</div>
                            <div class="text-[11px] text-slate-500">Sangat Setuju</div>
                        </div>
                    </button>
                </div>
            </div>

            {{-- ==================== STATE 3: CALCULATING TRANSITION ==================== --}}
            <div id="state-evaluating" class="hidden bg-white rounded-3xl p-12 text-center shadow-xl border border-slate-100 slide-up">
                <div class="w-20 h-20 mx-auto rounded-full bg-blue-900 text-amber-400 flex items-center justify-center text-3xl pulse-scanner mb-6 shadow-xl">
                    🤖
                </div>
                <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Menganalisis Pola Minatmu...</h3>
                <p class="text-slate-500 text-sm max-w-md mx-auto">
                    Kecerdasan probabilitas sedang mengalkulasi kecocokan jawabanmu dengan 9 jurusan vokasi SMKN 1 Surabaya.
                </p>
            </div>

            {{-- ==================== STATE 4: RICH CAREER DASHBOARD ==================== --}}
            <div id="state-result" class="hidden space-y-6 slide-up">
                
                {{-- Greeting Header --}}
                <div class="text-center mb-6">
                    <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-200 mb-2">
                        🎉 Analisis Minat & Bakat Selesai
                    </span>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                        Hai <span id="res-greeting-name" class="text-blue-900">Sobat SMEAS</span>, Ini Rekomendasi Jurusanmu!
                    </h2>
                </div>

                {{-- Hero Top Match Card --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-[#024089] via-[#002f66] to-[#001938] rounded-3xl p-6 md:p-8 text-white shadow-2xl">
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
                            <span id="res-top-code" class="inline-block px-2.5 py-1 bg-amber-400 text-blue-950 font-black rounded-md text-xs tracking-wider mb-2">RPL</span>
                            <h3 id="res-top-name" class="text-2xl md:text-3xl font-black tracking-tight text-white mb-2">
                                Rekayasa Perangkat Lunak
                            </h3>
                            <p id="res-top-career" class="text-blue-200 text-xs md:text-sm font-medium">
                                Software Developer, Web Engineer, Mobile App Creator
                            </p>
                        </div>

                        <div class="pt-4 border-t border-white/10 flex flex-wrap items-center gap-4">
                            <a id="res-top-link" href="{{ route('jurusan.detail', 'rekayasa-perangkat-lunak') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-amber-400 text-blue-950 font-bold text-sm rounded-xl hover:bg-amber-300 transition-all shadow-lg shadow-amber-950/20">
                                <span>Pelajari Profil Jurusan Ini</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                            <a href="{{ route('spmb.index') }}"
                                class="inline-flex items-center gap-2 px-5 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold text-sm rounded-xl border border-white/20 transition-all">
                                <span>Daftar Sekarang (SPMB)</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- AI Personal Insight Card --}}
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-xl border border-slate-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-lg">
                            🤖
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-base md:text-lg">Analisis Personal Smeas.Ai</h4>
                            <p class="text-xs text-slate-400 font-medium">Konsultan Bimbingan Karir Resmi SMKN 1 Surabaya</p>
                        </div>
                    </div>

                    {{-- Skeleton Loader saat AJAX memuat --}}
                    <div id="ai-skeleton" class="space-y-2.5 animate-pulse py-2">
                        <div class="h-3.5 bg-slate-200 rounded w-full"></div>
                        <div class="h-3.5 bg-slate-200 rounded w-5/6"></div>
                        <div class="h-3.5 bg-slate-200 rounded w-4/6"></div>
                    </div>

                    {{-- AI Insight Text --}}
                    <div id="ai-text" class="hidden text-slate-700 text-sm md:text-base leading-relaxed font-normal whitespace-pre-line border-l-4 border-amber-400 pl-4 py-1">
                    </div>
                </div>

                {{-- Ranked Breakdown: 9 Majors --}}
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-xl border border-slate-100">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="font-extrabold text-slate-900 text-base md:text-lg">
                            Ranking Probabilitas 9 Kejuruan SMKN 1 Surabaya
                        </h4>
                        <span class="text-xs font-semibold text-slate-400">Diurutkan berdasarkan skor</span>
                    </div>

                    <div id="ranked-majors-list" class="space-y-4">
                        {{-- Injected dynamically --}}
                    </div>
                </div>

                {{-- Action & Sharing Toolbar --}}
                <div class="bg-slate-900 rounded-3xl p-6 md:p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h4 class="text-lg font-bold text-white mb-1">Bagikan Hasil Rekomendasimu</h4>
                        <p class="text-slate-400 text-xs md:text-sm">
                            Konsultasikan dengan orang tua atau bagikan ke teman-temanmu agar bisa memilih bersama.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        <button type="button" onclick="shareWhatsApp()"
                            class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm shadow-lg shadow-emerald-950/20 transition-all">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>WhatsApp</span>
                        </button>

                        <button type="button" onclick="copyResultLink()"
                            class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm border border-white/10 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                            </svg>
                            <span id="btn-copy-text">Salin Tautan</span>
                        </button>

                        <button type="button" onclick="resetQuiz()"
                            class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-transparent hover:bg-white/5 text-slate-400 hover:text-white font-semibold text-sm border border-slate-700 transition-all">
                            <span>Ulangi Tes</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-[#024089] text-white pt-12 pb-8 border-t border-blue-900 mt-12">
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
        }

        function renderQuestion() {
            const q = questions[currentQuestionIndex];
            if (!q) return;

            const qCounter = document.getElementById('question-counter');
            const qText = document.getElementById('question-text');
            const pPercent = document.getElementById('progress-percent');
            const pBar = document.getElementById('progress-bar');
            const btnBack = document.getElementById('btn-back');

            const currentNum = currentQuestionIndex + 1;
            const total = questions.length;
            const percentage = Math.round((currentNum / total) * 100);

            qCounter.textContent = `Pertanyaan ${currentNum} dari ${total}`;
            pPercent.textContent = `${percentage}%`;
            pBar.style.width = `${percentage}%`;
            qText.textContent = q.text;

            btnBack.disabled = (currentQuestionIndex === 0);

            // Reset option highlights
            const optionBtns = document.querySelectorAll('.btn-option');
            optionBtns.forEach(btn => {
                btn.classList.remove('ring-4', 'ring-blue-500', 'bg-blue-50');
            });

            // If previously answered, highlight it
            if (userAnswers[q.id]) {
                const prevVal = userAnswers[q.id];
                if (optionBtns[prevVal - 1]) {
                    optionBtns[prevVal - 1].classList.add('ring-4', 'ring-blue-500', 'bg-blue-50');
                }
            }
        }

        function selectAnswer(val) {
            const q = questions[currentQuestionIndex];
            if (!q) return;

            userAnswers[q.id] = val;

            // Highlight chosen button
            const optionBtns = document.querySelectorAll('.btn-option');
            if (optionBtns[val - 1]) {
                optionBtns[val - 1].classList.add('ring-4', 'ring-blue-500', 'bg-blue-50');
            }

            // Micro delay for smoothness
            setTimeout(() => {
                if (currentQuestionIndex < questions.length - 1) {
                    currentQuestionIndex++;
                    renderQuestion();
                } else {
                    finishQuiz();
                }
            }, 200);
        }

        function prevQuestion() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                renderQuestion();
            }
        }

        function calculateProbabilities() {
            // Scores accumulation per major
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

            const results = calculateProbabilities();
            lastRankedResults = results;

            // Wait 600ms for realistic AI calculation animation
            setTimeout(() => {
                renderResults(results);
            }, 600);
        }

        function renderResults(results) {
            document.getElementById('state-evaluating').classList.add('hidden');
            document.getElementById('state-result').classList.remove('hidden');

            const displayName = studentName || 'Sobat SMEAS';
            document.getElementById('res-greeting-name').textContent = displayName;

            // Top #1
            const top = results[0];
            document.getElementById('res-top-score').textContent = `${top.score}%`;
            document.getElementById('res-top-code').textContent = top.code;
            document.getElementById('res-top-name').textContent = top.name;
            document.getElementById('res-top-career').textContent = top.career;
            document.getElementById('res-top-link').href = `/jurusan/${top.slug}`;

            // Render all 9 majors breakdown
            const listEl = document.getElementById('ranked-majors-list');
            listEl.innerHTML = '';

            results.forEach((item, idx) => {
                const rankNum = idx + 1;
                let barColor = 'bg-slate-400';
                let badgeBg = 'bg-slate-100 text-slate-600';
                
                if (rankNum === 1) {
                    barColor = 'bg-amber-400';
                    badgeBg = 'bg-amber-100 text-amber-900 border border-amber-300 font-black';
                } else if (rankNum === 2) {
                    barColor = 'bg-blue-600';
                    badgeBg = 'bg-blue-100 text-blue-900 border border-blue-200 font-bold';
                } else if (rankNum === 3) {
                    barColor = 'bg-teal-500';
                    badgeBg = 'bg-teal-100 text-teal-900 border border-teal-200 font-bold';
                }

                const itemRow = document.createElement('div');
                itemRow.className = 'p-3.5 rounded-2xl border border-slate-100 hover:border-slate-300 bg-slate-50/50 transition-all';
                itemRow.innerHTML = `
                    <div class="flex items-center justify-between gap-3 mb-2">
                        <div class="flex items-center gap-2.5">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs ${badgeBg}">
                                ${rankNum}
                            </span>
                            <span class="font-bold text-slate-800 text-sm md:text-base">${item.name}</span>
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-200 text-slate-700">${item.code}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm md:text-base font-extrabold text-slate-900">${item.score}%</span>
                            <a href="/jurusan/${item.slug}" class="text-xs font-semibold text-blue-900 hover:underline hidden sm:inline">
                                Detail &rarr;
                            </a>
                        </div>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200/80 rounded-full overflow-hidden">
                        <div class="h-full ${barColor} rounded-full transition-all duration-700" style="width: ${item.score}%"></div>
                    </div>
                `;
                listEl.appendChild(itemRow);
            });

            // Scroll to top of results
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
                    highlights: ['analisis minat', 'daya pikir logis']
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
                aiText.textContent = `Halo ${name}! Kamu memiliki potensi luar biasa pada bidang ${top.name} dengan tingkat kecocokan mencapai ${top.score}%. Bakat dan antusiasmemu sangat sejalan dengan kurikulum vokasi unggulan di SMKN 1 Surabaya.`;
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
                `🏆 Hasil Jurusan Paling Cocok:\n` +
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
