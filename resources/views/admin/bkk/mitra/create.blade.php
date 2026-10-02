@extends('admin.layout')

@section('title', 'Tambah Mitra DUDI')
@section('page-title', 'Tambah Mitra DUDI')

@section('content')
    <form method="POST" action="{{ route('admin.mitra.store') }}" enctype="multipart/form-data"
        class="mx-auto max-w-3xl space-y-6">
        @csrf

        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500">Informasi Mitra</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Nama Perusahaan *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Nama Singkat *</label>
                    <input type="text" name="short_name" value="{{ old('short_name') }}" required maxlength="50"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('short_name') border-red-500 @enderror">
                    @error('short_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Sektor *</label>
                    <input type="text" name="sector" value="{{ old('sector') }}" required maxlength="100"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('sector') border-red-500 @enderror">
                    @error('sector')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @endforeach
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Kota *</label>
                    <input type="text" name="city" value="{{ old('city') }}" required maxlength="100"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('city') border-red-500 @enderror">
                    @error('city')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @endforeach
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-bold text-slate-600">Website</label>
                    <input type="url" name="website" value="{{ old('website') }}" maxlength="255"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('website') border-red-500 @enderror">
                    @error('website')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @endforeach
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-bold text-slate-600">Deskripsi</label>
                    <textarea name="description" rows="3" maxlength="5000"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @endforeach
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-bold text-slate-600">Alamat</label>
                    <textarea name="address" rows="2" maxlength="1000"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @endforeach
                </div>
            </div>
            <div class="mt-4">
                <label class="mb-1 block text-xs font-bold text-slate-600">Logo Mitra (maks. 2MB)</label>
                <input type="file" name="logo" accept="image/png,image/jpeg,image/webp"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-1 file:text-xs file:font-bold file:text-blue-600 @error('logo') border-red-500 @enderror">
                @error('logo')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500">MoU & Kemitraan</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Status MoU</label>
                    <select name="is_mou_active" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('is_mou_active') border-red-500 @enderror">
                        <option value="1" {{ old('is_mou_active') ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_mou_active') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('is_mou_active')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Berlaku Hingga</label>
                    <input type="date" name="mou_until" value="{{ old('mou_until') }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('mou_until') border-red-500 @enderror">
                    @error('mou_until')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @endforeach
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Kemitraan Sejak</label>
                    <input type="number" name="kemitraan_sejak" value="{{ old('kemitraan_sejak') }}" min="1950"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('kemitraan_sejak') border-red-500 @enderror">
                    @error('kemitraan_sejak')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @endforeach
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Program (per baris)</label>
                    <textarea name="programs" rows="3" maxlength="2000"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('programs') border-red-500 @enderror">{{ old('programs') }}</textarea>
                    @error('programs')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500">Narahubung</h2>
            <div class="grid gap-4 sm:grid-cols-3">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Nama</label>
                    <input type="text" name="narahubung_nama" value="{{ old('narahubung_nama') }}" maxlength="255"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('narahubung_nama') border-red-500 @enderror">
                    @error('narahubung_nama')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @endforeach
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Jabatan</label>
                    <input type="text" name="narahubung_jabatan" value="{{ old('narahubung_jabatan') }}" maxlength="100"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('narahubung_jabatan') border-red-500 @enderror">
                    @error('narahubung_jabatan')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @endforeach
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">WhatsApp</label>
                    <input type="text" name="narahubung_wa" value="{{ old('narahubung_wa') }}" maxlength="30"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('narahubung_wa') border-red-500 @enderror">
                    @error('narahubung_wa')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @endforeach
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
                Simpan Mitra
            </button>
        </div>
    </form>
@endsection
