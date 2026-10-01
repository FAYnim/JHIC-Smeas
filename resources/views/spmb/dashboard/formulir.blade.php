@extends('spmb.dashboard.layout')

@section('page-title', 'Formulir')

@section('content')
    <div class="dash-card max-w-4xl">
        <form method="POST" action="{{ route('spmb.save-formulir') }}">
            @csrf
            <div class="formulir-step">
                <h2>1. Pilih jalur seleksi</h2>
                <select name="jalur" required
                    class="field-select w-full @error('jalur') input-error @endif">
                    <option value="" disabled @selected(!old('jalur', $calonSiswa->jalur_pendaftaran ?? ''))>Pilih jalur...</option>
                    <option @selected(old('jalur', $calonSiswa->jalur_pendaftaran ?? '') === 'Prestasi Akademik')>Prestasi Akademik</option>
                    <option @selected(old('jalur', $calonSiswa->jalur_pendaftaran ?? '') === 'Prestasi Non-Akademik')>Prestasi Non-Akademik</option>
                    <option @selected(old('jalur', $calonSiswa->jalur_pendaftaran ?? '') === 'Domisili')>Domisili</option>
                    <option @selected(old('jalur', $calonSiswa->jalur_pendaftaran ?? '') === 'Afirmasi')>Afirmasi</option>
                    <option @selected(old('jalur', $calonSiswa->jalur_pendaftaran ?? '') === 'Inklusi')>Inklusi</option>
                </select>
                @error('jalur')
                    <span class="field-error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="formulir-step">
                <h2>2. Pilih Jurusan</h2>
                <select name="jurusan" required
                    class="field-select w-full @error('jurusan') input-error @endif">
                    <option value="" disabled @selected(!old('jurusan', $calonSiswa->jurusan_pilihan ?? ''))>Pilih jurusan...</option>
                    <option @selected(old('jurusan', $calonSiswa->jurusan_pilihan ?? '') === 'Rekayasa Perangkat Lunak')>Rekayasa Perangkat Lunak</option>
                    <option @selected(old('jurusan', $calonSiswa->jurusan_pilihan ?? '') === 'Teknik Komputer Jaringan')>Teknik Komputer Jaringan</option>
                    <option @selected(old('jurusan', $calonSiswa->jurusan_pilihan ?? '') === 'Bisnis Digital')>Bisnis Digital</option>
                    <option @selected(old('jurusan', $calonSiswa->jurusan_pilihan ?? '') === 'Manajemen Perkantoran')>Manajemen Perkantoran</option>
                    <option @selected(old('jurusan', $calonSiswa->jurusan_pilihan ?? '') === 'Manajemen Logistik')>Manajemen Logistik</option>
                    <option @selected(old('jurusan', $calonSiswa->jurusan_pilihan ?? '') === 'Desain Komunikasi Visual')>Desain Komunikasi Visual</option>
                    <option @selected(old('jurusan', $calonSiswa->jurusan_pilihan ?? '') === 'Perhotelan')>Perhotelan</option>
                    <option @selected(old('jurusan', $calonSiswa->jurusan_pilihan ?? '') === 'Akuntansi')>Akuntansi</option>
                    <option @selected(old('jurusan', $calonSiswa->jurusan_pilihan ?? '') === 'Produksi dan Siaran Program Televisi')>Produksi dan Siaran Program Televisi</option>
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

            <div class="flex items-center gap-4 mt-10">
                <button type="submit" class="btn-green">Simpan Formulir</button>
                @if($calonSiswa && $calonSiswa->jalur_pendaftaran)
                    <a href="{{ route('spmb.unduh-formulir') }}" class="btn-blue">Unduh PDF</a>
                @endif
            </div>
        </form>
    </div>
@endsection
