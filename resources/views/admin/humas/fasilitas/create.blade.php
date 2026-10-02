@extends('admin.layout')

@section('page-title', 'Tambah Fasilitas')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Tambah Fasilitas</h2>
                <p class="text-xs text-slate-500">Tambahkan sarana prasarana baru ke profil sekolah</p>
            </div>
            <a href="{{ route('admin.fasilitas.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.fasilitas.store') }}" enctype="multipart/form-data" class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
            @csrf

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Sarana / Ruangan *</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Lab Komputer / Masjid Al-Ikhlas"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Fasilitas *</label>
                    <select name="kategori" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('kategori') border-red-500 @enderror">
                        <option value="pembelajaran" @selected(old('kategori') === 'pembelajaran')>Fasilitas Pembelajaran</option>
                        <option value="pendukung" @selected(old('kategori') === 'pendukung')>Fasilitas Pendukung</option>
                    </select>
                    @error('kategori')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah / Kapasitas</label>
                    <input type="text" name="jumlah" value="{{ old('jumlah') }}" placeholder="Contoh: 6 Lab / 72 Ruang / 1 Gedung"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('jumlah') border-red-500 @enderror">
                    @error('jumlah')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Icon Identitas</label>
                    <input type="text" name="icon" value="{{ old('icon') }}" placeholder="Contoh: building, computer, book, sport"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('icon') border-red-500 @enderror">
                    @error('icon')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampilan</label>
                    <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('urutan') border-red-500 @enderror">
                    @error('urutan')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Fasilitas *</label>
                    <textarea name="deskripsi" rows="3" required placeholder="Jelaskan spesifikasi dan kegunaan sarana ini..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Foto Sarana Prasarana (Opsional)</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('image') border-red-500 @enderror">
                    <p class="mt-1 text-[11px] text-slate-400">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                    @error('image')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.fasilitas.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white hover:bg-blue-700 transition">
                    Simpan Fasilitas
                </button>
            </div>
        </form>
    </div>
@endsection
