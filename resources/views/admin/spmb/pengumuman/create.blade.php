@extends('admin.layout')

@section('title', 'Buat Pengumuman SPMB')
@section('page-title', 'Buat Pengumuman Baru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.pengumuman.index') }}"
            class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800">
            <x-lucide-arrow-left class="w-4 h-4" />
            Kembali ke Daftar Pengumuman
        </a>
    </div>

    <div class="max-w-3xl rounded-xl border border-slate-200 bg-white p-6">
        <form action="{{ route('admin.pengumuman.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Judul Pengumuman <span class="text-red-500">*</span>
                </label>
                <input type="text" name="judul" value="{{ old('judul') }}" required maxlength="255"
                    placeholder="Contoh: Jadwal Tes Wawancara & Daftar Ulang Jalur Prestasi"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                @error('judul')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Isi Pengumuman <span class="text-red-500">*</span>
                </label>
                <textarea name="konten" rows="8" required maxlength="5000"
                    placeholder="Tuliskan isi pengumuman lengkap, jadwal pelaksanaan, lokasi, atau persyaratan yang harus dipersiapkan siswa..."
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ old('konten') }}</textarea>
                @error('konten')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                    class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <label for="is_published" class="text-sm font-semibold text-slate-700">
                    Publikasikan sekarang ke halaman dashboard calon siswa
                </label>
            </div>

            <div class="pt-4 border-t flex justify-end gap-3">
                <a href="{{ route('admin.pengumuman.index') }}"
                    class="rounded-lg px-4 py-2 text-sm font-bold text-slate-600 hover:bg-slate-100">
                    Batal
                </a>
                <button type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-bold text-white hover:bg-blue-700 transition">
                    Simpan Pengumuman
                </button>
            </div>
        </form>
    </div>
@endsection
