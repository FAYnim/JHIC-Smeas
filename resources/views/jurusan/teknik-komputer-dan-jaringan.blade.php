@extends('jurusan.layout')

@section('title', 'Teknik Komputer dan Jaringan')
@section('kode', 'TKJ')
@section('nama', 'Teknik Komputer dan Jaringan')
@section('ketua', 'Wiyono, S.Pd., S.ST, MM.')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 shadow-xs">
                <h2 class="text-xl font-extrabold text-[#023775] mb-4">Tentang Jurusan</h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6">
                    Jurusan yang mempelajari perakitan perangkat keras komputer, instalasi sistem operasi, konfigurasi infrastruktur jaringan Local Area Network (LAN) / Wide Area Network (WAN), serta keamanan jaringan.
                </p>

                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Kompetensi Yang Dipelajari</h3>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Administrasi Infrastruktur Jaringan
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Administrasi Sistem Jaringan
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Teknologi Jaringan Berbasis Luas (WAN)
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Teknologi Layanan Jaringan
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Perakitan &amp; Perbaikan Komputer
                    </li>
                </ul>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 shadow-xs">
                <h2 class="text-xl font-extrabold text-[#023775] mb-4">Prospek Karier</h2>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Network Engineer
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        System Administrator
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        IT Support Technician
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Cybersecurity Junior Analyst
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Cloud Engineer
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Network Security Specialist
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
