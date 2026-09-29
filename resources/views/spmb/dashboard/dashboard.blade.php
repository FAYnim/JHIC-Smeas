@extends('spmb.dashboard.layout')

@section('page-title', 'Dashboard')

@section('content')
    <div class="dash-card max-w-2xl mx-auto py-10">
        <p class="text-sm text-slate-600 font-semibold text-center mb-8">
            Lengkapi semua tahap di bawah ini untuk memproses pendaftaran Anda.
        </p>

        <div class="flex flex-col gap-8 items-center">
            <!-- Step 1: Biodata (completed, blue) -->
            <div class="flex items-center gap-6">
                <div
                    class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center text-xl font-extrabold shrink-0">
                    1
                </div>
                <div class="text-left">
                    <p class="text-base font-bold text-slate-900">Biodata</p>
                    <p class="text-xs font-semibold text-blue-600">Sudah terisi</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div
                    class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center text-xl font-extrabold shrink-0">
                    2
                </div>
                <div class="text-left">
                    <p class="text-base font-bold text-slate-900">Orang Tua</p>
                    <p class="text-xs font-semibold text-blue-600">Sudah terisi</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div
                    class="w-12 h-12 rounded-full border-2 border-blue-600 bg-white text-blue-600 flex items-center justify-center text-xl font-extrabold shrink-0">
                    3
                </div>
                <div class="text-left">
                    <p class="text-base font-bold text-slate-900">Dokumen</p>
                    <p class="text-xs font-semibold text-slate-400">Belum terisi</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div
                    class="w-12 h-12 rounded-full border-2 border-blue-600 bg-white text-blue-600 flex items-center justify-center text-xl font-extrabold shrink-0">
                    4
                </div>
                <div class="text-left">
                    <p class="text-base font-bold text-slate-900">Formulir</p>
                    <p class="text-xs font-semibold text-slate-400">Belum terisi</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div
                    class="w-12 h-12 rounded-full border-2 border-blue-600 bg-white text-blue-600 flex items-center justify-center text-xl font-extrabold shrink-0">
                    5
                </div>
                <div class="text-left">
                    <p class="text-base font-bold text-slate-900">Verifikasi</p>
                    <p class="text-xs font-semibold text-slate-400">Belum terisi</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div
                    class="w-12 h-12 rounded-full border-2 border-blue-600 bg-white text-blue-600 flex items-center justify-center text-xl font-extrabold shrink-0">
                    6
                </div>
                <div class="text-left">
                    <p class="text-base font-bold text-slate-900">Pengumuman</p>
                    <p class="text-xs font-semibold text-slate-400">Belum terisi</p>
                </div>
            </div>
        </div>
    </div>
@endsection
