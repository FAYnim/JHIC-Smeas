@extends('spmb.dashboard.layout')

@section('page-title', 'Dashboard')

@php
    // ponytail: static step status until DB-backed progress exists.
    $steps = [
        ['no' => 1, 'name' => 'Biodata', 'desc' => 'Identitas dan data diri peserta', 'done' => true, 'route' => 'spmb.biodata'],
        ['no' => 2, 'name' => 'Orang Tua', 'desc' => 'Data ayah dan ibu / wali', 'done' => true, 'route' => 'spmb.orang-tua'],
        ['no' => 3, 'name' => 'Dokumen', 'desc' => 'Unggah berkas persyaratan', 'done' => false, 'route' => 'spmb.dokumen'],
        ['no' => 4, 'name' => 'Formulir', 'desc' => 'Isi formulir pendaftaran', 'done' => false, 'route' => 'spmb.formulir'],
        ['no' => 5, 'name' => 'Verifikasi', 'desc' => 'Periksa ulang data Anda', 'done' => false, 'route' => 'spmb.verifikasi'],
        ['no' => 6, 'name' => 'Pengumuman', 'desc' => 'Pantau hasil seleksi', 'done' => false, 'route' => 'spmb.pengumuman'],
    ];
    $doneCount = count(array_filter($steps, fn ($s) => $s['done']));
    $percent = (int) round($doneCount / count($steps) * 100);
    $circumference = 2 * M_PI * 52;
@endphp

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 max-w-6xl">
        {{-- Left card: percent completed --}}
        <div class="dash-card lg:col-span-2">
            <h2 class="text-xl font-extrabold text-slate-900">Progres Data</h2>
            <p class="text-xs font-semibold text-slate-500 mt-1.5">
                Lengkapi semua tahap untuk memproses pendaftaran Anda.
            </p>

            <div class="relative w-44 h-44 mx-auto my-6">
                <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="52" fill="none" stroke="#e2e8f0" stroke-width="10" />
                    <circle cx="60" cy="60" r="52" fill="none" stroke="#1d5fa8" stroke-width="10"
                        stroke-linecap="round"
                        stroke-dasharray="{{ $circumference }}"
                        stroke-dashoffset="{{ $circumference * (1 - $percent / 100) }}" />
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-4xl font-extrabold text-slate-900">{{ $percent }}%</span>
                    <span class="text-xs font-bold text-slate-500">Terisi</span>
                </div>
            </div>

            <p class="text-xs font-semibold text-slate-500 text-center">
                {{ $doneCount }} dari {{ count($steps) }} tahap selesai
            </p>
        </div>

        {{-- Right card: step tracker --}}
        <div class="dash-card lg:col-span-3">
            <p class="text-xs font-bold tracking-wide text-slate-500 uppercase mb-6">Tahap Pendaftaran</p>

            <div class="relative">
                {{-- connector line --}}
                <div
                    class="absolute left-[0.9375rem] top-4 bottom-4 w-0.5 bg-[#1d5fa8]/25 hidden sm:block"></div>

                <div class="flex flex-col gap-5 sm:gap-6">
                    @foreach ($steps as $step)
                        <a href="{{ route($step['route']) }}"
                            class="relative flex items-start gap-4 no-underline hover:bg-slate-50 rounded-lg -mx-2 px-2 py-1 transition-colors">
                            @if ($step['done'])
                                <div
                                    class="w-[1.875rem] h-[1.875rem] rounded-lg bg-[#1d5fa8] text-white flex items-center justify-center shrink-0 z-10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                            @else
                                <div
                                    class="w-[1.875rem] h-[1.875rem] rounded-lg border-2 border-[#1d5fa8] bg-white text-[#1d5fa8] flex items-center justify-center text-xs font-extrabold shrink-0 z-10">
                                    {{ $step['no'] }}
                                </div>
                            @endif
                            <div class="flex-1 pt-0.5">
                                <p class="text-sm font-bold text-slate-900">{{ $step['name'] }}</p>
                                <p class="text-xs font-medium text-slate-500 mt-0.5">{{ $step['desc'] }}</p>
                            </div>
                            <span
                                class="text-xs font-bold {{ $step['done'] ? 'text-[#1d5fa8]' : 'text-slate-400' }} shrink-0">
                                {{ $step['done'] ? 'Sudah terisi' : 'Belum terisi' }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Bottom action bar --}}
        <div class="dash-card lg:col-span-5">
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 py-1">
                <a href="{{ route('spmb.biodata') }}" class="btn-navy">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-4.5 4.5m4.5 0v2.25m-6.75 4.5308-1.0261-.3413m11.026 3.7397a.75.75 0 11-.7286 1.2883m4.6873-3.4712a.75.75 0 11.7286-1.2883M6.75 18.75h4.5l-.72-3.27m8.7 2.545-1.305 1.305M6.75 18.75H4.5A2.25 2.25 0 012.25 16.5V15m10.5 1.5H13.5m-7.5-3V9.75a2.25 2.25 0 012.25-2.25h3a2.25 2.25 0 012.25 2.25v1.5m-6-4.5V6a.75.75 0 01.75-.75h.5a.75.75 0 01.75.75v3.75h4.5V12" />
                    </svg>
                    Lengkapi Biodata
                </a>
                <a href="{{ route('spmb.dokumen') }}" class="btn-navy">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Upload Dokumen
                </a>
                <a href="{{ route('spmb.bantuan') }}" class="btn-navy">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.903.055-1.073.468l-.97 2.257c-.163.384-.563.614-.983.58L4.99 18.723a.75.75 0 01-.747-.615L2.25 6.75z" />
                    </svg>
                    Hubungi Panitia
                </a>
            </div>
        </div>
    </div>
@endsection
