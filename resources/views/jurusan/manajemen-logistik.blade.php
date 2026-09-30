@extends('jurusan.layout')

@section('title', 'Manajemen Logistik')
@section('kode', 'ML')
@section('nama', 'Manajemen Logistik')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 shadow-xs">
                <h2 class="text-xl font-extrabold text-[#023775] mb-4">Tentang Jurusan</h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6">
                    Jurusan yang mempelajari perencanaan, pelaksanaan, serta pengendalian arus barang, informasi, dan pasokan dari titik asal (origin) hingga titik konsumsi (end-user) secara efisien.
                </p>

                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Kompetensi Yang Dipelajari</h3>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Perencanaan Rantai Pasok
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Manajemen Pergudangan
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Manajemen Transportasi &amp; Distribusi
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Pengadaan Barang (Procurement)
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Sistem Informasi Logistik
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
                        Warehouse Staff/Supervisor
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Supply Chain Coordinator
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Logistics Specialist
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Procurement Staff
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Inventory Control Admin
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Freight Forwarding Officer
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
