@php
    $input = 'w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-hidden';
    $galeriValue = old('galeri', '');
    $fields = [
        ['title', 'Nama Produk / Jasa *', 'text'],
        ['subtitle', 'Subjudul', 'text'],
        ['jurusan_nama', 'Nama Jurusan *', 'text'],
        ['harga_min', 'Harga Minimum (Rp)', 'number'],
        ['harga_max', 'Harga Maksimum (Rp)', 'number'],
        ['stok', 'Stok', 'text'],
        ['pengiriman', 'Pengiriman', 'text'],
        ['opsi_custom', 'Opsi Custom (kustom)', 'text'],
        ['quantity_per_pack', 'Jumlah per Pack', 'text'],
        ['wa_number', 'Nomor WhatsApp', 'text'],
    ];
@endphp

@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="mb-1 block text-xs font-bold text-slate-600">Tipe *</label>
        <select name="tipe" class="{{ $input }}">
            <option value="showcase" @selected(old('tipe', $produk->tipe) === 'showcase')>Showcase (Langsung)</option>
            <option value="kustom" @selected(old('tipe', $produk->tipe) === 'kustom')>Kustom (Pre-Order)</option>
        </select>
    </div>

    <div>
        <label class="mb-1 block text-xs font-bold text-slate-600">Kategori</label>
        <select name="kategori" class="{{ $input }}">
            <option value="">- Pilih kategori -</option>
            @foreach (\App\Models\ProdukBlud::KATEGORI as $kategori)
                <option value="{{ $kategori }}" @selected(old('kategori', $produk->kategori) === $kategori)>{{ $kategori }}</option>
            @endforeach
        </select>
    </div>

    @foreach ($fields as [$name, $label, $type])
        <div>
            <label class="mb-1 block text-xs font-bold text-slate-600">{{ $label }}</label>
            <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $produk->$name) }}" class="{{ $input }}">
        </div>
    @endforeach

    <div class="md:col-span-2">
        <label class="mb-1 block text-xs font-bold text-slate-600">Deskripsi *</label>
        <textarea name="deskripsi" rows="5" class="{{ $input }}">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-xs font-bold text-slate-600">Gambar Produk (maks. 10 file, JPG/PNG/WEBP, 2 MB per file)</label>

        @if ($produk->exists && $produk->galeri->isNotEmpty())
            <div class="mb-3 grid grid-cols-3 gap-3 md:grid-cols-5">
                @foreach ($produk->galeri as $item)
                    <label class="block rounded-lg border border-slate-200 p-1 text-center text-xs">
                        <img src="{{ $item->image_url }}" alt="Gambar {{ $loop->iteration }}" class="h-20 w-full rounded object-cover">
                        <span class="mt-1 flex items-center justify-center gap-1">
                            <input type="checkbox" name="keep[]" value="{{ $item->id }}" checked> Simpan
                        </span>
                    </label>
                @endforeach
            </div>
            <p class="mb-2 text-xs text-slate-500">Hapus centang untuk menghapus gambar saat disimpan.</p>
        @endif

        <input type="file" name="gambar[]" multiple accept="image/jpeg,image/png,image/webp" class="{{ $input }}">
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-xs font-bold text-slate-600">Atau tambah lewat URL gambar (opsional, satu per baris)</label>
        <textarea name="galeri" rows="3" placeholder="https://example.com/foto1.jpg" class="{{ $input }}">{{ $galeriValue }}</textarea>
    </div>

    <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $produk->is_published))>
        Publikasikan
    </label>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-bold text-white hover:bg-blue-700">Simpan</button>
    <a href="{{ route('admin.produk-blud.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700">Batal</a>
</div>
