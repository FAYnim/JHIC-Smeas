@extends('spmb.dashboard.layout')

@section('page-title', 'Dokumen')

@php
    // ponytail: static list of required docs until the requirement table exists.
    $docs = [
        ['id' => 'pilih', 'name' => 'Pilih 2 dokumen', 'desc' => 'FOTO 1 (100px) &amp; FINGERPRINT 10x10CM', 'exts' => 'pdf, jpg, png'],
        ['id' => 'akta', 'name' => 'FOTO AKTA KELAHIRAN', 'desc' => 'SCAN AKTA KELAHIRAN', 'exts' => 'pdf, jpg, png'],
        ['id' => 'ktp-ayah', 'name' => 'FOTO KTP AYAH', 'desc' => 'SCAN KTP AYAH', 'exts' => 'pdf, jpg, png'],
        ['id' => 'ktp-ibu', 'name' => 'FOTO KTP IBU', 'desc' => 'SCAN KTP IBU', 'exts' => 'pdf, jpg, png'],
        ['id' => 'jjk', 'name' => 'KARTU JAJAN PANGAN (JJ)', 'desc' => 'SCAN KARTU JAJAN', 'exts' => 'pdf, jpg, png'],
        ['id' => 'kartu-keluarga', 'name' => 'FOTO KARTU KELUARGA', 'desc' => 'SCAN KARTU KELUARGA', 'exts' => 'pdf, jpg, png'],
        ['id' => 'ijazah-smp', 'name' => 'IJAZAH / KARTU PELAJAR SMP', 'desc' => 'SCAN IJAZAH / KARTU PELAJAR', 'exts' => 'pdf, jpg, png'],
        ['id' => 'rapor-smt-1', 'name' => 'Rapor semester 1', 'desc' => 'SCAN Rapor semester 1', 'exts' => 'pdf, jpg, png'],
        ['id' => 'rapor-smt-2', 'name' => 'Rapor semester 2', 'desc' => 'SCAN Rapor semester 2', 'exts' => 'pdf, jpg, png'],
        ['id' => 'rapor-smt-3', 'name' => 'Rapor semester 3', 'desc' => 'SCAN Rapor semester 3', 'exts' => 'pdf, jpg, png'],
        ['id' => 'rapor-smt-4', 'name' => 'Rapor semester 4', 'desc' => 'SCAN Rapor semester 4', 'exts' => 'pdf, jpg, png'],
        ['id' => 'rapor-smt-5', 'name' => 'Rapor semester 5', 'desc' => 'SCAN Rapor semester 5', 'exts' => 'pdf, jpg, png'],
    ];
@endphp

@section('content')
    <div class="dash-card max-w-3xl">
        {{-- Upload progress strip --}}
        <div class="relative mb-6">
            <span class="doc-progress__label">0 Berkas terverifikasi</span>
            <div class="doc-progress">
                <div class="h-full w-0 bg-[#0f3d7a]"></div>
            </div>
        </div>

        <form method="POST" action="{{ route('spmb.save-dokumen') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col gap-6">
                @foreach ($docs as $doc)
                    <div class="flex items-start gap-4">
                        <label class="upload-box shrink-0" title="Klik untuk unggah">
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3m6-1.25V15.75a3.375 3.375 0 01-3.375 3.375h-5.25A3.375 3.375 0 014.5 15.75v-1.875" />
                            </svg>
                            <input type="file" name="docs[{{ $doc['id'] }}]"
                                accept=".pdf,.jpg,.jpeg,.png"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </label>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="doc-row__name">{{ $doc['name'] }}</h3>
                            </div>
                            <p class="doc-row__hint">{{ $doc['desc'] }}</p>
                            <p class="doc-row__meta mt-1.5">{{ $doc['exts'] }} · &lt; 2MB</p>
                            <div class="flex items-center gap-2 mt-2.5">
                                <span class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Nama
                                    file</span>
                                <input type="text" name="doc_names[{{ $doc['id'] }}]"
                                    class="field-input !w-72 !text-xs" placeholder="berkas.pdf">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Submit row --}}
            <div class="flex items-center justify-end gap-8 mt-10">
                <a href="{{ route('spmb.formulir') }}"
                    class="text-sm font-bold text-slate-500 hover:text-slate-700">Simpan & Lanjut</a>
                <button type="submit" class="btn-blue">
                    Lanjut
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
@endsection
