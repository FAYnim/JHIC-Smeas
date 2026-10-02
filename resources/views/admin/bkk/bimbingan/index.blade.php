@extends('admin.layout')

@section('title', 'Bimbingan Karir')
@section('page-title', 'Bimbingan Karir')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Katalog Materi Bimbingan Karir</h2>
            <p class="text-xs text-slate-500">Kelola artikel, modul, dan materi bimbingan karir siswa/alumni.</p>
        </div>
        <a href="{{ route('admin.bimbingan.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition">
            <x-lucide-plus class="w-4 h-4" />
            Tambah Materi
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.bimbingan.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari materi atau deskripsi..."
                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <select name="kategori" onchange="this.form.submit()"
                    class="px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-700 font-medium">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList as $k)
                        <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-sm font-semibold rounded-lg hover:bg-slate-900 transition">
                Cari
            </button>
            @if (request()->hasAny(['q', 'kategori']))
                <a href="{{ route('admin.bimbingan.index') }}" class="px-3 py-2 text-sm font-semibold text-slate-500 hover:text-slate-800">
                    Reset
                </a>
            @endif
        </form>
    </div>

    @if ($bimbingans->isEmpty())
        <div class="bg-white rounded-xl border border-slate-200 p-8 text-center">
            <p class="text-sm font-semibold text-slate-600 mb-1">Belum ada materi bimbingan</p>
            <p class="text-xs text-slate-400">Silakan tambahkan materi bimbingan karir baru.</p>
        </div>
    @else
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Materi</th>
                            <th class="px-5 py-3">Kategori</th>
                            <th class="px-5 py-3">Tautan Eksternal</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($bimbingans as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4">
                                    <p class="font-bold text-slate-900">{{ $item->title }}</p>
                                    @if ($item->description)
                                        <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">{{ $item->description }}</p>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-block px-2.5 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded">
                                        {{ $item->kategori->nama ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-xs font-medium">
                                    @if ($item->external_url && $item->external_url !== '#')
                                        <a href="{{ $item->external_url }}" target="_blank" class="text-blue-600 hover:underline inline-flex items-center gap-1">
                                            {{ Str::limit($item->external_url, 30) }}
                                            <x-lucide-external-link class="w-3 h-3" />
                                        </a>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    @if ($item->is_published)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded">
                                            Publik
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded">
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('admin.bimbingan.edit', $item) }}"
                                            class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded transition"
                                            title="Ubah">
                                            <x-lucide-pencil class="w-4 h-4" />
                                        </a>
                                        <form method="POST" action="{{ route('admin.bimbingan.destroy', $item) }}"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi bimbingan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded transition"
                                                title="Hapus">
                                                <x-lucide-trash-2 class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($bimbingans->hasPages())
                <div class="p-4 border-t border-slate-200">
                    {{ $bimbingans->links() }}
                </div>
            @endif
        </div>
    @endif
@endsection