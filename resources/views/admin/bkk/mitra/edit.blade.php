@extends('admin.layout')

@section('title', 'Edit Mitra DUDI')
@section('page-title', 'Edit Mitra DUDI')

@section('content')
    <form method="POST" action="{{ route('admin.mitra.update', $mitra) }}" enctype="multipart/form-data"
        class="mx-auto max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500">Informasi Mitra</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Nama Perusahaan *</label>
                    <input type="text" name="name" value="{{ old('name', $mitra->name) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Nama Singkat *</label>
                    <input type="text" name="short_name" value="{{ old('short_name', $mitra->short_name) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Sektor *</label>
                    <input type="text" name="sector" value="{{ old('sector', $mitra->sector) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Kota *</label>
                    <input type="text" name="city" value="{{ old('city', $mitra->city) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-bold text-slate-600">Website</label>
                    <input type="url" name="website" value="{{ old('website', $mitra->website) }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-bold text-slate-600">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ old('description', $mitra->description) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-bold text-slate-600">Alamat</label>
                    <textarea name="address" rows="2"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ old('address', $mitra->address) }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <label class="mb-1 block text-xs font-bold text-slate-600">Logo Mitra (maks. 2MB)</label>
                @if ($mitra->logo_path)
                    <div class="mb-2 flex items-center gap-3">
                        <img src="{{ $mitra->logo_url }}" alt="Logo" class="h-12 w-12 rounded-lg border border-slate-200 object-contain">
                        <span class="text-xs text-slate-500">Logo saat ini</span>
                    </div>
                @endif
                <input type="file" name="logo" accept="image/png,image/jpeg,image/webp"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-1 file:text-xs file:font-bold file:text-blue-600">
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500">MoU & Kemitraan</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Status MoU</label>
                    <select name="is_mou_active" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="1" {{ old('is_mou_active', $mitra->is_mou_active) ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_mou_active', $mitra->is_mou_active) === false ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Berlaku Hingga</label>
                    <input type="date" name="mou_until" value="{{ old('mou_until', $mitra->mou_until?->format('Y-m-d')) }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Kemitraan Sejak</label>
                    <input type="number" name="kemitraan_sejak" value="{{ old('kemitraan_sejak', $mitra->kemitraan_sejak) }}" min="1950"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Program (per baris)</label>
                    <textarea name="programs" rows="3"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ old('programs', is_array($mitra->programs) ? implode("\n", $mitra->programs) : $mitra->programs) }}</textarea>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500">Narahubung</h2>
            <div class="grid gap-4 sm:grid-cols-3">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Nama</label>
                    <input type="text" name="narahubung_nama" value="{{ old('narahubung_nama', $mitra->narahubung_nama) }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Jabatan</label>
                    <input type="text" name="narahubung_jabatan" value="{{ old('narahubung_jabatan', $mitra->narahubung_jabatan) }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">WhatsApp</label>
                    <input type="text" name="narahubung_wa" value="{{ old('narahubung_wa', $mitra->narahubung_wa) }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.mitra.index') }}"
                class="rounded-lg border border-slate-200 px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50">
                Batal
            </a>
            <button type="submit"
                class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-blue-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
@endsection
