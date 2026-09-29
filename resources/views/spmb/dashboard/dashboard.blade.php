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
                                    <x-lucide-check class="w-4 h-4" stroke-width="3" />
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
                    <x-lucide-user-plus />
                    Lengkapi Biodata
                </a>
                <a href="{{ route('spmb.dokumen') }}" class="btn-navy">
                    <x-lucide-upload />
                    Upload Dokumen
                </a>
                <a href="{{ route('spmb.bantuan') }}" class="btn-navy">
                    <x-lucide-message-circle />
                    Hubungi Panitia
                </a>
            </div>
        </div>
    </div>
@endsection
