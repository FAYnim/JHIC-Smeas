@extends('admin.layout')

@section('page-title', 'Edit Guru / Tendik')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Edit Guru / Tendik</h2>
                <p class="text-xs text-slate-500">Perbarui informasi profil staf</p>
            </div>
            <a href="{{ route('admin.guru.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.guru.update', $guru) }}" enctype="multipart/form-data" class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap & Gelar *</label>
                    <input type="text" name="nama" value="{{ old('nama', $guru->nama) }}" required maxlength="255"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan *</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $guru->jabatan) }}" required maxlength="255"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('jabatan') border-red-500 @enderror">
                    @error('jabatan')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Mata Pelajaran / Unit Kerja</label>
                    <input type="text" name="mapel" value="{{ old('mapel', $guru->mapel) }}" maxlength="255"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('mapel') border-red-500 @enderror">
                    @error('mapel')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori *</label>
                    <select name="kategori" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('kategori') border-red-500 @enderror">
                        <option value="guru" @selected(old('kategori', $guru->kategori) === 'guru')>Guru</option>
                        <option value="tendik" @selected(old('kategori', $guru->kategori) === 'tendik')>Tenaga Kependidikan</option>
                    </select>
                    @error('kategori')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampilan</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $guru->urutan) }}" min="0"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('urutan') border-red-500 @enderror">
                    @error('urutan')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Foto Formal</label>
                    @if ($guru->foto_url)
                        <div class="mb-2 flex items-center gap-3">
                            <img src="{{ $guru->foto_url }}" alt="{{ $guru->nama }}" class="h-12 w-12 rounded-full object-cover border border-slate-200">
                            <span class="text-xs text-slate-500">Foto saat ini terpasang. Unggah baru untuk mengganti.</span>
                        </div>
                    @endif
                    <input type="file" name="foto" accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('foto') border-red-500 @enderror">
                    <p class="mt-1 text-[11px] text-slate-400">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                    @error('foto')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $guru->is_active)) class="rounded-sm border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-bold text-slate-700">Tampilkan di halaman publik sekolah</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.guru.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white hover:bg-blue-700 transition">
                    Perbarui Guru / Tendik
                </button>
            </div>
        </form>
    </div>
@endsection
