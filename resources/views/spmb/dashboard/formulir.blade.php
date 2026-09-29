@extends('spmb.dashboard.layout')

@section('page-title', 'Formulir')

@php
    // ponytail: static options until jalur/jurusan data comes from DB.
    $jalurOptions = [
        'Pengembangan',
        'Kelas Berbasis Kompetensi',
        'PPDB Jalur Umum',
        'Jalur Prestasi',
    ];
    $jurusanOptions = [
        'Administrasi Perkantoran',
        'Akuntansi & Keuangan Lembaga',
        'Bisnis Daring & Pemasaran',
        'Fotografi',
        'Teknik Komputer & Jaringan',
        'Rekayasa Perangkat Lunak',
        'Tata Busana',
        'Produksi Audio & Video',
    ];
@endphp

@section('content')
    <div class="dash-card max-w-4xl">
        <form method="POST" action="{{ route('spmb.save-formulir') }}">
            @csrf
            <div class="formulir-step">
                <h2>1. Pilih jalur seleksi</h2>
                <select name="jalur" required
                    class="field-select w-full @error('jalur') input-error @enderror">
                    <option value="" disabled @selected(!old('jalur'))>Pilih jalur...</option>
                    @foreach ($jalurOptions as $jalur)
                        <option @selected(old('jalur') === $jalur)>{{ $jalur }}</option>
                    @endforeach
                </select>
                @error('jalur')
                    <span class="field-error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="formulir-step">
                <h2>2. Pilih Jurusan</h2>
                <select name="jurusan" required
                    class="field-select w-full @error('jurusan') input-error @enderror">
                    <option value="" disabled @selected(!old('jurusan'))>Pilih jurusan...</option>
                    @foreach ($jurusanOptions as $jurusan)
                        <option @selected(old('jurusan') === $jurusan)>{{ $jurusan }}</option>
                    @endforeach
                </select>
                @error('jurusan')
                    <span class="field-error-text">{{ $message }}</span>
                @enderror
            </div>

            <label class="checkbox-label">
                <input type="checkbox" name="deklarasi" value="1" @checked(old('deklarasi'))>
                <span>Saya menyatakan bahwa seluruh data dan berkas yang dimasukkan adalah BENAR dan SAH. Jika di
                    kemudian hari ditemukan pemalsuan data, saya siap mendapatkan konsekuensi</span>
            </label>
            @error('deklarasi')
                <span class="field-error-text">{{ $message }}</span>
            @enderror

            <button type="submit" class="btn-green mt-10">Unduh formulir</button>
        </form>
    </div>
@endsection
