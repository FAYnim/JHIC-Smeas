@extends('admin.layout')

@section('page-title', 'Tambah Webinar')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Tambah Webinar Baru</h2>
                <p class="text-xs text-slate-500">Jadwalkan sesi webinar atau lokakarya untuk siswa & alumni</p>
            </div>
            <a href="{{ route('admin.webinar.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.webinar.store') }}" class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Topik / Judul Webinar *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Menyiapkan Portofolio Desain Berstandar Industri"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pemateri / Pembicara *</label>
                        <input type="text" name="speaker" value="{{ old('speaker') }}" required placeholder="Contoh: Hendra Gunawan (Senior UI/UX Designer)"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('speaker') border-red-500 @enderror">
                        @error('speaker')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Platform *</label>
                        <input type="text" name="platform" value="{{ old('platform', 'Zoom Meeting') }}" required placeholder="Contoh: Zoom Meeting / Google Meet / Aula Sekolah"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('platform') border-red-500 @enderror">
                        @error('platform')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Pelaksanaan *</label>
                        <input type="date" name="start_date" value="{{ old('start_date', now()->addDays(7)->format('Y-m-d')) }}" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Waktu Pelaksanaan *</label>
                        <input type="time" name="start_time" value="{{ old('start_time', '09:00') }}" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('start_time') border-red-500 @enderror">
                        <p class="mt-1 text-[11px] text-slate-400">Jam mulai webinar (WIB).</p>
                        @error('start_time')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tautan Registrasi Pendaftaran *</label>
                    <input type="url" name="registration_url" value="{{ old('registration_url') }}" required placeholder="https://..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('registration_url') border-red-500 @enderror">
                    @error('registration_url')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi Detail (Opsional)</label>
                    <input type="text" name="location" value="{{ old('location', 'Online via Zoom Meeting') }}" placeholder="Contoh: Online via Zoom / Gedung Aula Lt. 2"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('location') border-red-500 @enderror">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi & Agenda Acara *</label>
                    <textarea name="description" rows="5" required placeholder="Jelaskan gambaran webinar dan materi yang akan dipelajari peserta..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', true)) class="rounded-sm border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-bold text-slate-700">Publikasikan webinar ke halaman publik</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.webinar.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white hover:bg-blue-700 transition">
                    Simpan Webinar
                </button>
            </div>
        </form>
    </div>
@endsection
