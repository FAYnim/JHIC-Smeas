@extends('admin.layout')

@section('page-title', 'Tulis Artikel')

@section('content')
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Tulis Artikel Baru</h2>
                <p class="text-xs text-slate-500">Buat publikasi berita atau panduan karir sekolah</p>
            </div>
            <a href="{{ route('admin.artikel.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.artikel.store') }}" enctype="multipart/form-data" class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Artikel *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required maxlength="255" placeholder="Contoh: Siswa SMKN 1 Surabaya Lolos Seleksi Magang Industri Jepang"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kategori *</label>
                        <input type="text" name="kategori" value="{{ old('kategori', 'Prestasi') }}" required maxlength="100" placeholder="Contoh: Prestasi / Karir / Informasi"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('kategori') border-red-500 @enderror">
                        @error('kategori')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Slug URL (Opsional)</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" placeholder="Dibiarkan kosong untuk auto-generate"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Ringkasan Singkat (Excerpt) *</label>
                    <textarea name="excerpt" rows="2" required maxlength="500" placeholder="Ringkasan 1-2 kalimat pengantar artikel..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('excerpt') border-red-500 @enderror">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Konten Lengkap *</label>
                    <textarea name="content" rows="10" required maxlength="50000" placeholder="Tuliskan isi artikel selengkapnya di sini..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Cover Gambar</label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('image') border-red-500 @enderror">
                        <p class="mt-1 text-[11px] text-slate-400">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                        @error('image')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Atau Gunakan Image URL</label>
                        <input type="url" name="image_url" value="{{ old('image_url') }}" maxlength="500" placeholder="https://example.com/banner.jpg"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('image_url') border-red-500 @enderror">
                        @error('image_url')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Waktu Publikasi</label>
                        <input type="datetime-local" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('published_at') border-red-500 @enderror">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Estimasi Waktu Baca (Opsional)</label>
                        <input type="text" name="reading_time" value="{{ old('reading_time') }}" maxlength="50" placeholder="Contoh: 3 menit baca (auto jika kosong)"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('reading_time') border-red-500 @enderror">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.artikel.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white hover:bg-blue-700 transition">
                    Terbitkan Artikel
                </button>
            </div>
        </form>
    </div>
@endsection
