@extends('spmb.dashboard.layout')

@section('page-title', 'Pengumuman')

@section('content')
    <div class="max-w-2xl mx-auto">
        {{-- ponytail: state 1 only — swap in diterima/ditolak cards when the result table exists --}}
        <div class="dash-card text-center py-12">
            <div
                class="w-16 h-16 rounded-full bg-[#1d5fa8]/10 text-[#1d5fa8] flex items-center justify-center mx-auto">
                <x-lucide-clock class="w-8 h-8" />
            </div>

            <h2 class="text-xl font-extrabold text-slate-900 mt-5">Pengumuman Belum Diterbitkan</h2>
            <p class="text-sm font-medium text-slate-500 mt-2 leading-relaxed max-w-md mx-auto">
                Hasil seleksi masih dalam proses verifikasi administrasi. Pantau halaman ini secara berkala.
            </p>

            <div class="flex items-center justify-center gap-6 mt-8">
                <div class="text-center">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Status</p>
                    <p class="text-lg font-extrabold text-slate-900 mt-1">Verifikasi berjalan</p>
                </div>
                <div class="w-px h-10 bg-slate-200"></div>
                <div class="text-center">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Saluran</p>
                    <p class="text-lg font-extrabold text-slate-900 mt-1">Menu Pengumuman</p>
                </div>
            </div>
        </div>

        <div class="flex justify-center mt-6">
            <a href="{{ route('spmb.dashboard') }}" class="btn-navy">Kembali ke Dashboard</a>
        </div>
    </div>
@endsection
