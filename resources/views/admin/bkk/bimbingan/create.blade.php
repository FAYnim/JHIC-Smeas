@extends('admin.layout')

@section('title', 'Tambah Materi Bimbingan Karir')
@section('page-title', 'Tambah Materi Bimbingan Karir')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.bimbingan.index') }}"
            class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 mb-4 transition">
            <x-lucide-arrow-left class="w-4 h-4" />
            Kembali ke Daftar Materi
        </a>

        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.bimbingan.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Kategori Bimbingan <span class="text-red-500">*</span>
                    </label>
                    <select name="bimbingan_kategori_id" required
                        class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategoriList as $k)
                            <option value="{{ $k->id }}" {{ old('bimbingan_kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('bimbingan_kategori_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Judul Materi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        placeholder="Contoh: Cara Membuat CV Menarik untuk Fresh Graduate"
                        class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('title')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Deskripsi / Rangkuman Singkat
                    </label>
                    <textarea name="description" rows="4"
                        placeholder="Deskripsi singkat isi materi atau topik pembahasan..."
                        class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Tautan Eksternal (Opsional)
                    </label>
                    <input type="url" name="external_url" value="{{ old('external_url') }}"
                        placeholder="https://contoh.com/materi-pdf-atau-artikel"
                        class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('external_url')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', '1') == '1' ? 'checked' : '' }}
                            class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-semibold text-slate-700">Publikasikan Materi Segera</span>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.bimbingan.index') }}"
                        class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-800 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        Simpan Materi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
