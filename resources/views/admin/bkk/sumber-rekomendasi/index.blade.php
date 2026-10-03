@extends('admin.layout')

@section('title', 'Sumber Rekomendasi')
@section('page-title', 'Sumber Rekomendasi')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Katalog Sumber Rekomendasi</h2>
            <p class="text-xs text-slate-500">Kelola tautan rekomendasi karir untuk siswa/alumni.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-4 mb-6">
        <form method="POST" action="{{ route('admin.sumber-rekomendasi.store') }}" enctype="multipart/form-data"
            class="flex flex-wrap items-end gap-3">
            @csrf
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-slate-600 mb-1">Judul</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Nama sumber..."
                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-slate-600 mb-1">URL</label>
                <input type="url" name="url" value="{{ old('url') }}" required placeholder="https://..."
                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="min-w-[160px]">
                <label class="block text-xs font-bold text-slate-600 mb-1">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori') }}" placeholder="Opsional..."
                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Gambar</label>
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                    class="text-sm text-slate-600 file:mr-3 file:px-3 file:py-2 file:bg-slate-800 file:text-white file:text-xs file:font-semibold file:rounded-lg file:border-0 hover:file:bg-slate-900 transition">
            </div>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
                Tambah Sumber
            </button>
        </form>
        @if ($errors->any())
            <p class="mt-2 text-xs font-semibold text-red-600">{{ $errors->first() }}</p>
        @endif
    </div>

    @if ($sumbers->isEmpty())
        <div class="bg-white rounded-xl border border-slate-200 p-8 text-center">
            <p class="text-sm font-semibold text-slate-600 mb-1">Belum ada sumber rekomendasi</p>
            <p class="text-xs text-slate-400">Tambahkan tautan lewat form di atas.</p>
        </div>
    @else
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead
                        class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-3">#</th>
                            <th class="px-5 py-3">Judul</th>
                            <th class="px-5 py-3">URL</th>
                            <th class="px-5 py-3">Kategori</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($sumbers as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4 font-bold text-slate-900">{{ $item->urutan }}</td>
                                <td class="px-5 py-4">
                                    <p class="font-bold text-slate-900">{{ $item->title }}</p>
                                    @if ($item->image_path)
                                        <p class="text-xs text-slate-500 mt-0.5">Ada gambar</p>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-xs font-medium">
                                    <a href="{{ $item->url }}" target="_blank"
                                        class="text-blue-600 hover:underline inline-flex items-center gap-1">
                                        {{ Str::limit($item->url, 40) }}
                                        <x-lucide-external-link class="w-3 h-3" />
                                    </a>
                                </td>
                                <td class="px-5 py-4">
                                    <span
                                        class="inline-block px-2.5 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded">
                                        {{ $item->kategori ?? 'Rekomendasi' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    @if ($item->is_active)
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <form method="POST"
                                        action="{{ route('admin.sumber-rekomendasi.destroy', $item) }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus sumber rekomendasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded transition"
                                            title="Hapus">
                                            <x-lucide-trash-2 class="w-4 h-4" />
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
