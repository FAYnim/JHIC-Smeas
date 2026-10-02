@extends('admin.layout')

@section('page-title', 'Artikel & Berita Sekolah')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Manajemen Artikel</h2>
                <p class="text-xs text-slate-500">Publikasikan kabar prestasi, kegiatan, dan panduan karir SMKN 1 Surabaya</p>
            </div>
            <a href="{{ route('admin.artikel.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-blue-700">
                <x-lucide-plus class="h-4 w-4" />
                Tulis Artikel Baru
            </a>
        </div>

        {{-- Filter & Search Card --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
            <form method="GET" action="{{ route('admin.artikel.index') }}" class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau isi artikel..."
                    class="rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden">

                <input type="text" name="kategori" value="{{ request('kategori') }}" placeholder="Filter kategori (Prestasi, Karir, dsb)..."
                    class="rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden">

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-slate-800 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-900 transition">
                        Filter
                    </button>
                    @if (request()->hasAny(['q', 'kategori']))
                        <a href="{{ route('admin.artikel.index') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table Card --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-slate-200 bg-slate-50 font-bold text-slate-700">
                    <tr>
                        <th class="px-4 py-3">Artikel</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Tanggal Terbit</th>
                        <th class="px-4 py-3">Estimasi Baca</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($artikels as $item)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($item->display_image)
                                        <img src="{{ $item->display_image }}" alt="{{ $item->title }}" class="h-10 w-14 rounded-md object-cover border border-slate-200">
                                    @else
                                        <div class="h-10 w-14 rounded-md bg-amber-100 flex items-center justify-center font-bold text-amber-700 text-xs">
                                            NEWS
                                        </div>
                                    @endif
                                    <div class="max-w-md min-w-0">
                                        <p class="font-extrabold text-slate-900 truncate" title="{{ $item->title }}">{{ $item->title }}</p>
                                        <p class="text-[11px] text-slate-400 font-mono truncate">/pusat-karir/artikel/{{ $item->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full bg-blue-50 px-2 py-0.5 text-[10px] font-bold text-blue-700 border border-blue-100">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-600 font-medium">
                                {{ $item->published_at ? $item->published_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $item->reading_time ?: '-' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('pusat-karir.detail-artikel', $item->slug) }}" target="_blank" class="rounded-sm p-1 text-slate-500 hover:text-slate-800 transition" title="Lihat di situs">
                                        <x-lucide-external-link class="h-4 w-4" />
                                    </a>
                                    <a href="{{ route('admin.artikel.edit', $item) }}" class="rounded-sm p-1 text-slate-600 hover:text-blue-600 transition" title="Edit">
                                        <x-lucide-pencil class="h-4 w-4" />
                                    </a>
                                    <form method="POST" action="{{ route('admin.artikel.destroy', $item) }}" onsubmit="return confirm('Hapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-sm p-1 text-slate-600 hover:text-red-600 transition" title="Hapus">
                                            <x-lucide-trash-2 class="h-4 w-4" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                                Belum ada artikel diterbitkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($artikels->hasPages())
                <div class="border-t border-slate-200 p-4">
                    {{ $artikels->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
