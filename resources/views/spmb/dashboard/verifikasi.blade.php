@extends('spmb.dashboard.layout')

@section('page-title', 'Verifikasi')

@php
    // ponytail: static data pending DB hookup — display old() so the
    // review reflects what the applicant just submitted.
    $biodata = [
        'NISN' => old('nisn', '—'),
        'Nama Lengkap' => old('nama', '—'),
        'Jenis Kelamin' => old('jenis_kelamin', '—'),
        'Tempat Lahir' => old('tempat_lahir', '—'),
        'Tanggal Lahir' => old('tanggal_lahir', '—'),
        'Status' => old('status', '—'),
        'Alamat' => old('alamat', '—'),
        'No. WhatsApp' => old('wa', '—'),
        'Email' => old('email', '—'),
        'Nama Sekolah' => old('sekolah', '—'),
    ];
    $orangTua = [
        'Nama Ayah' => old('nama_ayah', '—'),
        'Pekerjaan Ayah' => old('pekerjaan_ayah', '—'),
        'Nama Ibu' => old('nama_ibu', '—'),
        'Pekerjaan Ibu' => old('pekerjaan_ibu', '—'),
    ];
    $docs = [
        'pilih' => 'Pilih 2 dokumen',
        'akta' => 'FOTO AKTA KELAHIRAN',
        'ktp-ayah' => 'FOTO KTP AYAH',
        'ktp-ibu' => 'FOTO KTP IBU',
        'jjk' => 'KARTU JAJAN PANGAN (JJ)',
        'kartu-keluarga' => 'FOTO KARTU KELUARGA',
        'ijazah-smp' => 'IJAZAH / KARTU PELAJAR SMP',
        'rapor-smt-1' => 'Rapor semester 1',
        'rapor-smt-2' => 'Rapor semester 2',
        'rapor-smt-3' => 'Rapor semester 3',
        'rapor-smt-4' => 'Rapor semester 4',
        'rapor-smt-5' => 'Rapor semester 5',
    ];
    $formulir = [
        'Jalur Seleksi' => old('jalur', '—'),
        'Jurusan' => old('jurusan', '—'),
        'Pernyataan' => old('deklarasi') ? 'Sudah dinyatakan' : 'Belum dinyatakan',
    ];
@endphp

@section('content')
    <div class="max-w-4xl flex flex-col gap-6">
        {{-- Biodata summary --}}
        <div class="dash-card">
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-bold tracking-wide text-slate-500 uppercase">Data Biodata</p>
                <a href="{{ route('spmb.biodata') }}"
                    class="text-xs font-bold text-[#1d5fa8] hover:underline">Perbaiki</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-4">
                @foreach ($biodata as $label => $value)
                    <div>
                        <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">{{ $label }}</p>
                        <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Orang tua summary --}}
        <div class="dash-card">
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-bold tracking-wide text-slate-500 uppercase">Data Orang Tua</p>
                <a href="{{ route('spmb.orang-tua') }}"
                    class="text-xs font-bold text-[#1d5fa8] hover:underline">Perbaiki</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-4">
                @foreach ($orangTua as $label => $value)
                    <div>
                        <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">{{ $label }}</p>
                        <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Dokumen checklist --}}
        <div class="dash-card">
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-bold tracking-wide text-slate-500 uppercase">Dokumen</p>
                <a href="{{ route('spmb.dokumen') }}"
                    class="text-xs font-bold text-[#1d5fa8] hover:underline">Kelola</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach ($docs as $id => $name)
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-50 border border-slate-100">
                        <div class="w-8 h-8 rounded-md bg-[#1d5fa8]/10 text-[#1d5fa8] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-900 truncate">{{ $name }}</p>
                            <p class="text-[0.65rem] font-semibold text-slate-400">Belum diunggah</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Formulir summary --}}
        <div class="dash-card">
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-bold tracking-wide text-slate-500 uppercase">Formulir</p>
                <a href="{{ route('spmb.formulir') }}"
                    class="text-xs font-bold text-[#1d5fa8] hover:underline">Perbaiki</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-10 gap-y-4">
                @foreach ($formulir as $label => $value)
                    <div>
                        <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">{{ $label }}</p>
                        <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Submit row --}}
        <div class="flex items-center justify-end gap-6">
            <a href="{{ route('spmb.dashboard') }}"
                class="text-sm font-bold text-slate-500 hover:text-slate-700">Kembali ke Dashboard</a>
            <a href="{{ route('spmb.pengumuman') }}" class="btn-blue">
                Selesai, Lihat Pengumuman
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
    </div>
@endsection
