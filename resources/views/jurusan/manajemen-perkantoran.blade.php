@extends('jurusan.layout')

@section('title', 'Manajemen Perkantoran')
@section('kode', 'MP')
@section('nama', 'Manajemen Perkantoran')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-7 sm:p-8 shadow-xs">
                <h2 class="text-xl font-extrabold text-[#023775] mb-4">Tentang Jurusan</h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6">
                    Jurusan yang fokus pada tata kelola administrasi bisnis, efisiensi operasional perkantoran, manajemen kearsipan digital, serta layanan komunikasi profesional di lingkungan kerja.
                </p>

                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Kompetensi Yang Dipelajari</h3>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Otomatisasi Tata Kelola Perkantoran
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Kearsipan Digital
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Humas &amp; Keprotokolan
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Manajemen Keuangan Perkantoran
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Sarana Prasarana Perkantoran
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
                        Administrative Assistant
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Executive Secretary
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Front Office Officer
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Personal Assistant
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        HR Generalist Junior
                    </li>
                    <li class="flex items-start gap-2 text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        Document Control Officer
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
