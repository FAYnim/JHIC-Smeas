@extends('spmb.dashboard.layout')

@section('page-title', 'Dokumen')

@section('content')
    <div class="dash-card max-w-3xl">
        <form method="POST" action="{{ route('spmb.save-dokumen') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col gap-6">
                <div>
                    <div class="flex flex-wrap items-baseline gap-x-3 gap-y-1">
                        <h3 class="doc-row__name">AKTA KELAHIRAN</h3>
                        <span class="doc-row__hint">SCAN AKTA KELAHIRAN</span>
                        <span class="doc-row__meta">pdf, jpg, png · maks 2MB</span>
                    </div>
                    @if (($dokumenStatus['akta']['uploaded'] ?? false))
                        <p class="mt-2 text-xs font-semibold text-emerald-700">Sudah diunggah: {{ $dokumenStatus['akta']['name'] }}</p>
                    @endif
                    <input type="file" name="docs[akta]" accept=".pdf,.jpg,.jpeg,.png"
                        class="file-input mt-2.5" required>
                    @error('docs.akta')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <div class="flex flex-wrap items-baseline gap-x-3 gap-y-1">
                        <h3 class="doc-row__name">KARTU KELUARGA</h3>
                        <span class="doc-row__hint">SCAN KARTU KELUARGA</span>
                        <span class="doc-row__meta">pdf, jpg, png · maks 2MB</span>
                    </div>
                    @if (($dokumenStatus['kartu_keluarga']['uploaded'] ?? false))
                        <p class="mt-2 text-xs font-semibold text-emerald-700">Sudah diunggah: {{ $dokumenStatus['kartu_keluarga']['name'] }}</p>
                    @endif
                    <input type="file" name="docs[kartu_keluarga]" accept=".pdf,.jpg,.jpeg,.png"
                        class="file-input mt-2.5" required>
                    @error('docs.kartu_keluarga')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <div class="flex flex-wrap items-baseline gap-x-3 gap-y-1">
                        <h3 class="doc-row__name">IJAZAH SMP</h3>
                        <span class="doc-row__hint">SCAN IJAZAH SMP</span>
                        <span class="doc-row__meta">pdf, jpg, png · maks 2MB</span>
                    </div>
                    @if (($dokumenStatus['ijazah_smp']['uploaded'] ?? false))
                        <p class="mt-2 text-xs font-semibold text-emerald-700">Sudah diunggah: {{ $dokumenStatus['ijazah_smp']['name'] }}</p>
                    @endif
                    <input type="file" name="docs[ijazah_smp]" accept=".pdf,.jpg,.jpeg,.png"
                        class="file-input mt-2.5" required>
                    @error('docs.ijazah_smp')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-8 mt-10">
                <a href="{{ route('spmb.formulir') }}"
                    class="text-sm font-bold text-slate-500 hover:text-slate-700">Simpan & Lanjut</a>
                <button type="submit" class="btn-blue">
                    Simpan Dokumen
                    <x-lucide-arrow-right />
                </button>
            </div>
        </form>
    </div>
@endsection
