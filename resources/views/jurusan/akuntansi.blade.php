@extends('jurusan.layout')

@section('title', 'Akuntansi')
@section('kode', 'AK')
@section('nama', 'Akuntansi')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 shadow-xs">
                <h2 class="text-xl font-extrabold text-[#023775] mb-4">Tentang Jurusan</h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6">
                    Jurusan yang mempelajari pengolahan data keuangan, pencatatan transaksi bisnis, pembukuan keuangan perusahaan, hingga pelaporan pajak sesuai standar akuntansi di Indonesia.
                </p>

                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Kompetensi Yang Dipelajari</h3>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Akuntansi Keuangan
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Praktikum Akuntansi Perusahaan Jasa/Dagang/Manufaktur
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Akuntansi Lembaga/Instansi Pemerintah
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Perpajakan
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Spreadsheet/Pengolahan Angka
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
                        Accounting Officer
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Tax Consultant/Staf Pajak
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Auditor Junior
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Payroll Staff
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Financial Analyst
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Bank Teller
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
