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
        <form method="POST" action="{{ route('spmb.save-dokumen') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col gap-6">
                @foreach ($docs as $doc)
                    <div>
                        <div class="flex flex-wrap items-baseline gap-x-3 gap-y-1">
                            <h3 class="doc-row__name">{{ $doc['name'] }}</h3>
                            <span class="doc-row__hint">{{ $doc['desc'] }}</span>
                            <span class="doc-row__meta">{{ $doc['exts'] }} · maks 2MB</span>
                        </div>
                        <input type="file" name="docs[{{ $doc['id'] }}]" accept=".pdf,.jpg,.jpeg,.png"
                            class="file-input mt-2.5">
                    </div>
                @endforeach
            </div>

            {{-- Submit row --}}
            <div class="flex items-center justify-end gap-8 mt-10">
                <a href="{{ route('spmb.formulir') }}"
                    class="text-sm font-bold text-slate-500 hover:text-slate-700">Simpan & Lanjut</a>
                <button type="submit" class="btn-blue">
                    Lanjut
                    <x-lucide-arrow-right />
                </button>
            </div>
        </form>
    </div>
@endsection
