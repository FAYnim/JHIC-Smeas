@extends('admin.layout')

@section('title', 'Kelola Mitra DUDI')
@section('page-title', 'Kelola Mitra DUDI')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.mitra.index') }}" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari mitra..."
                class="rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-bold text-white hover:bg-slate-900">
                Cari
            </button>
        </form>
        <div class="flex items-center gap-3">
            <a href="{{ route('pusat-karir.katalog-mitra') }}" target="_blank" class="text-sm text-blue-600 hover:underline">Lihat di Situs →</a>
            <a href="{{ route('admin.mitra.create') }}"
                class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">
                <x-lucide-plus class="w-4 h-4" />
                Tambah Mitra
            </a>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3">Mitra</th>
                    <th class="px-4 py-3">Sektor</th>
                    <th class="px-4 py-3">Kota</th>
                    <th class="px-4 py-3">MoU</th>
                    <th class="px-4 py-3">Lowongan Aktif</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($mitras as $mitra)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($mitra->logo_path)
                                    <img src="{{ $mitra->logo_url }}" alt="{{ $mitra->name }}"
                                        class="h-9 w-9 rounded-lg object-contain">
                                @else
                                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 text-xs font-bold text-blue-600">
                                        {{ Str::limit($mitra->short_name, 2, '') }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $mitra->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $mitra->short_name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $mitra->sector }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $mitra->city }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $mitra->is_mou_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $mitra->is_mou_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $mitra->lowongans->count() }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.mitra.edit', $mitra) }}"
                                    class="rounded-lg bg-slate-100 p-2 text-slate-600 hover:bg-slate-200">
                                    <x-lucide-pencil class="w-4 h-4" />
                                </a>
                                <form method="POST" action="{{ route('admin.mitra.destroy', $mitra) }}"
                                    onsubmit="return confirm('Yakin ingin menghapus mitra ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg bg-red-50 p-2 text-red-600 hover:bg-red-100">
                                        <x-lucide-trash-2 class="w-4 h-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada mitra DUDI.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $mitras->links() }}
    </div>
@endsection
