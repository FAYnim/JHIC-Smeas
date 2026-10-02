@extends('admin.layout')

@section('page-title', 'Sarana & Prasarana')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Manajemen Sarana & Prasarana</h2>
                <p class="text-xs text-slate-500">Kelola fasilitas pembelajaran dan sarana pendukung operasional sekolah</p>
            </div>
            <a href="{{ route('admin.fasilitas.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-blue-700">
                <x-lucide-plus class="h-4 w-4" />
                Tambah Fasilitas
            </a>
        </div>

        {{-- Filter & Search Card --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
            <form method="GET" action="{{ route('admin.fasilitas.index') }}" class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari fasilitas atau deskripsi..."
                    class="rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden">

                <select name="kategori" class="rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden">
                    <option value="">Semua Kategori</option>
                    <option value="pembelajaran" @selected(request('kategori') === 'pembelajaran')>Fasilitas Pembelajaran</option>
                    <option value="pendukung" @selected(request('kategori') === 'pendukung')>Fasilitas Pendukung</option>
                </select>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-slate-800 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-900 transition">
                        Filter
                    </button>
                    @if (request()->hasAny(['q', 'kategori']))
                        <a href="{{ route('admin.fasilitas.index') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
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
                        <th class="px-4 py-3">Fasilitas</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Jumlah / Kapasitas</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3 text-center">Urutan</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($fasilitas as $item)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($item->image_url)
                                        <img src="{{ $item->image_url }}" alt="{{ $item->nama }}" class="h-10 w-10 rounded-lg object-cover border border-slate-200">
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-mono text-xs border border-blue-100">
                                            {{ substr($item->icon ?: 'fas', 0, 3) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-extrabold text-slate-900">{{ $item->nama }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $item->kategori === 'pembelajaran' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold text-slate-700">
                                {{ $item->jumlah ?: '-' }}
                            </td>
                            <td class="px-4 py-3 text-slate-500 max-w-sm">
                                <p class="truncate" title="{{ $item->deskripsi }}">{{ $item->deskripsi }}</p>
                            </td>
                            <td class="px-4 py-3 text-center font-bold text-slate-600">
                                {{ $item->urutan }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.fasilitas.edit', $item) }}" class="rounded-sm p-1 text-slate-600 hover:text-blue-600 transition" title="Edit">
                                        <x-lucide-pencil class="h-4 w-4" />
                                    </a>
                                    <form method="POST" action="{{ route('admin.fasilitas.destroy', $item) }}" onsubmit="return confirm('Hapus fasilitas ini?')">
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
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                Belum ada sarana prasarana yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($fasilitas->hasPages())
                <div class="border-t border-slate-200 p-4">
                    {{ $fasilitas->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
