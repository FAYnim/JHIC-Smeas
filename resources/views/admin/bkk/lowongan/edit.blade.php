@extends('admin.layout')

@section('title', 'Edit Lowongan')
@section('page-title', 'Edit Lowongan')

@section('content')
    <form method="POST" action="{{ route('admin.lowongan.update', $lowongan) }}" enctype="multipart/form-data"
        class="mx-auto max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500">Informasi Perusahaan</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Nama Perusahaan *</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $lowongan->company_name) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    @error('company_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Singkatan</label>
                    <input type="text" name="company_short" value="{{ old('company_short', $lowongan->company_short) }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
            </div>
            <div class="mt-4">
                <label class="mb-1 block text-xs font-bold text-slate-600">Mitra DUDI</label>
                <select name="mitra_id" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    <option value="">— Bukan Mitra DUDI —</option>
                    @foreach ($mitras as $mitra)
                        <option value="{{ $mitra->id }}" {{ old('mitra_id', $lowongan->mitra_id) == $mitra->id ? 'selected' : '' }}>
                            {{ $mitra->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mt-4">
                <label class="mb-1 block text-xs font-bold text-slate-600">Logo Perusahaan (maks. 2MB)</label>
                @if ($lowongan->logo_path)
                    <div class="mb-2 flex items-center gap-3">
                        <img src="{{ $lowongan->logo_url }}" alt="Logo" class="h-12 w-12 rounded-lg border border-slate-200 object-contain">
                        <span class="text-xs text-slate-500">Logo saat ini</span>
                    </div>
                @endif
                <input type="file" name="logo" accept="image/png,image/jpeg,image/webp"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-1 file:text-xs file:font-bold file:text-blue-600">
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500">Posisi & Spesifikasi</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-bold text-slate-600">Judul Posisi *</label>
                    <input type="text" name="title" value="{{ old('title', $lowongan->title) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Jenis *</label>
                    <select name="jenis" required class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="magang" {{ old('jenis', $lowongan->jenis) === 'magang' ? 'selected' : '' }}>Magang</option>
                        <option value="lowongan" {{ old('jenis', $lowongan->jenis) === 'lowongan' ? 'selected' : '' }}>Lowongan Kerja</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Metode Kerja *</label>
                    <input type="text" name="metode_kerja" value="{{ old('metode_kerja', $lowongan->metode_kerja) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Lokasi *</label>
                    <input type="text" name="location" value="{{ old('location', $lowongan->location) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Jurusan *</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan', $lowongan->jurusan) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Kuota *</label>
                    <input type="number" name="kuota" value="{{ old('kuota', $lowongan->kuota) }}" min="0" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Durasi *</label>
                    <input type="text" name="duration" value="{{ old('duration', $lowongan->duration) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Batas Pendaftaran *</label>
                    <input type="date" name="batas_pendaftaran" value="{{ old('batas_pendaftaran', $lowongan->batas_pendaftaran->format('Y-m-d')) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Durasi Pelaksanaan *</label>
                    <input type="text" name="durasi_pelaksanaan" value="{{ old('durasi_pelaksanaan', $lowongan->durasi_pelaksanaan) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500">Kualifikasi & Tanggung Jawab</h2>
            <div class="space-y-4">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Deskripsi *</label>
                    <textarea name="deskripsi" rows="4" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Tanggung Jawab (per baris)</label>
                    <textarea name="tanggung_jawab" rows="4"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ old('tanggung_jawab', is_array($lowongan->tanggung_jawab) ? implode("\n", $lowongan->tanggung_jawab) : $lowongan->tanggung_jawab) }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Kualifikasi (per baris)</label>
                    <textarea name="kualifikasi" rows="4"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ old('kualifikasi', is_array($lowongan->kualifikasi) ? implode("\n", $lowongan->kualifikasi) : $lowongan->kualifikasi) }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Benefits (per baris)</label>
                    <textarea name="benefits" rows="3"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ old('benefits', is_array($lowongan->benefits) ? implode("\n", $lowongan->benefits) : $lowongan->benefits) }}</textarea>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500">Publikasi</h2>
            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $lowongan->is_published) ? 'checked' : '' }}
                    class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                Publikasikan
            </label>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.lowongan.index') }}"
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
