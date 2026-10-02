@extends('admin.layout')

@section('title', 'Edit FAQ SPMB')
@section('page-title', 'Edit Pertanyaan FAQ')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.faq.index') }}"
            class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800">
            <x-lucide-arrow-left class="w-4 h-4" />
            Kembali ke Daftar FAQ
        </a>
    </div>

    <div class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6">
        <form action="{{ route('admin.faq.update', $faq) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Kategori <span class="text-xs font-normal text-slate-400">(Opsional)</span>
                </label>
                <input type="text" name="kategori" value="{{ old('kategori', $faq->kategori) }}" maxlength="100"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                @error('kategori')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Pertanyaan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="pertanyaan" value="{{ old('pertanyaan', $faq->pertanyaan) }}" required maxlength="255"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                @error('pertanyaan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Jawaban <span class="text-red-500">*</span>
                </label>
                <textarea name="jawaban" rows="5" required maxlength="5000"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ old('jawaban', $faq->jawaban) }}</textarea>
                @error('jawaban')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Urutan Tampil
                    </label>
                    <input type="number" name="urutan" value="{{ old('urutan', $faq->urutan) }}" min="0"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div class="flex items-center pt-5">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-semibold text-slate-700">Aktifkan pertanyaan</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t flex justify-end gap-3">
                <a href="{{ route('admin.faq.index') }}"
                    class="rounded-lg px-4 py-2 text-sm font-bold text-slate-600 hover:bg-slate-100">
                    Batal
                </a>
                <button type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-bold text-white hover:bg-blue-700 transition">
                    Perbarui FAQ
                </button>
            </div>
        </form>
    </div>
@endsection
