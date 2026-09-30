@extends('jurusan.layout')

@section('title', 'Bisnis Daring dan Pemasaran')
@section('kode', 'BDP')
@section('nama', 'Bisnis Daring dan Pemasaran')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 shadow-xs">
                <h2 class="text-xl font-extrabold text-[#023775] mb-4">Tentang Jurusan</h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6">
                    Program keahlian berbasis SKKNI yang membekali siswa dalam keterampilan riset pasar, strategi penjualan digital, pengelolaan ritel modern, dan pemasaran berbasis teknologi digital.
                </p>

                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Kompetensi Yang Dipelajari</h3>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Pemasaran Digital
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Perencanaan Bisnis
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Penataan Produk (Display)
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Bisnis Ritel
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Administrasi Transaksi
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
                        Digital Marketer
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Social Media Specialist
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        E-Commerce Admin
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Content Creator
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Sales Executive
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Store Manager Ritel
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
