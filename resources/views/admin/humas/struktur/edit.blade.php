@extends('admin.layout')

@section('page-title', 'Edit Jabatan / Unit')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Edit Jabatan / Unit</h2>
                <p class="text-xs text-slate-500">Perbarui informasi struktur organisasi sekolah</p>
            </div>
            <a href="{{ route('admin.struktur-organisasi.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.struktur-organisasi.update', $strukturOrganisasi) }}" enctype="multipart/form-data" class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori *</label>
                    <select name="kategori" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('kategori') border-red-500 @enderror">
                        <option value="wakil" @selected(old('kategori', $strukturOrganisasi->kategori) === 'wakil')>Wakil Kepala Sekolah</option>
                        <option value="bagian" @selected(old('kategori', $strukturOrganisasi->kategori) === 'bagian')>Unit Kerja / Bagian</option>
                    </select>
                    @error('kategori')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Jabatan / Unit *</label>
                    <input type="text" name="nama" value="{{ old('nama', $strukturOrganisasi->nama) }}" required maxlength="255"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Bidang (Khusus Wakil)</label>
                    <input type="text" name="bidang" value="{{ old('bidang', $strukturOrganisasi->bidang) }}" maxlength="255"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('bidang') border-red-500 @enderror">
                    @error('bidang')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">NIP (Khusus Wakil)</label>
                    <input type="text" name="nip" value="{{ old('nip', $strukturOrganisasi->nip) }}" maxlength="100"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('nip') border-red-500 @enderror">
                    @error('nip')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Icon Identitas (Khusus Unit Bagian)</label>
                    <input type="text" name="icon" value="{{ old('icon', $strukturOrganisasi->icon) }}"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('icon') border-red-500 @enderror">
                    @error('icon')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampilan</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $strukturOrganisasi->urutan) }}" min="0"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('urutan') border-red-500 @enderror">
                    @error('urutan')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Tugas / Fungsi (Unit Bagian)</label>
                    <textarea name="deskripsi" rows="3" maxlength="2000"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $strukturOrganisasi->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Foto Formal (Pimpinan Wakil)</label>
                    @if ($strukturOrganisasi->foto_url)
                        <div class="mb-2 flex items-center gap-3">
                            <img src="{{ $strukturOrganisasi->foto_url }}" alt="{{ $strukturOrganisasi->nama }}" class="h-12 w-12 rounded-full object-cover border border-slate-200">
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
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.struktur-organisasi.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white hover:bg-blue-700 transition">
                    Perbarui Entri
                </button>
            </div>
        </form>
    </div>
@endsection
