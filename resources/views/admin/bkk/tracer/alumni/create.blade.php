@extends('admin.layout')

@section('title', 'Tambah Data Alumni')
@section('page-title', 'Tambah Data Alumni')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.tracer.index', ['tab' => 'alumni']) }}"
            class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 mb-4 transition">
            <x-lucide-arrow-left class="w-4 h-4" />
            Kembali ke Tracer Study
        </a>

        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.tracer.alumni.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        NISN (10 Digit) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nisn" value="{{ old('nisn') }}" required maxlength="10"
                        placeholder="Contoh: 0012345678"
                        class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono">
                    @error('nisn')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required maxlength="255"
                        placeholder="Nama siswa alumni"
                        class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('nama')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Kompetensi Keahlian / Jurusan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="jurusan" value="{{ old('jurusan') }}" required maxlength="255"
                        placeholder="Contoh: Rekayasa Perangkat Lunak"
                        class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('jurusan')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Tahun Kelulusan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', date('Y')) }}" required min="2000" max="{{ date('Y') + 1 }}"
                            class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('tahun_lulus')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Tahun Angkatan Masuk <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="angkatan" value="{{ old('angkatan', date('Y') - 3) }}" required min="2000" max="{{ date('Y') + 1 }}"
                            class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('angkatan')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.tracer.index', ['tab' => 'alumni']) }}"
                        class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-800 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        Simpan Alumni
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
