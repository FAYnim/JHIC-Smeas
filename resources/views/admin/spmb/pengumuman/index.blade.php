@extends('admin.layout')

@section('title', 'Kelola Pengumuman SPMB')
@section('page-title', 'Pengumuman SPMB')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.pengumuman.index') }}" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul pengumuman..."
                class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-bold text-white hover:bg-slate-900">
                Cari
            </button>
        </form>
        <a href="{{ route('admin.pengumuman.create') }}"
            class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">
            <x-lucide-plus class="w-4 h-4" />
            Buat Pengumuman Baru
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3">Judul Pengumuman</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Waktu Publikasi</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($pengumumans as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 max-w-sm">
                            <p class="font-bold text-slate-900 truncate" title="{{ $item->judul }}">{{ $item->judul }}</p>
                            <p class="text-xs text-slate-500 line-clamp-1">{{ Str::limit($item->konten, 90) }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.pengumuman.toggle-publish', $item) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="inline-flex items-center gap-1 rounded-full border px-2.5 py-0.5 text-xs font-bold transition {{ $item->is_published ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border-slate-200 hover:bg-slate-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $item->is_published ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $item->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-xs text-slate-500">
                            {{ $item->published_at ? $item->published_at->format('d M Y, H:i') : '—' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.pengumuman.edit', $item) }}"
                                    class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-blue-600">
                                    <x-lucide-pencil class="w-4 h-4" />
                                </a>
                                <form action="{{ route('admin.pengumuman.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-red-600">
                                        <x-lucide-trash-2 class="w-4 h-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-slate-400">
                            Belum ada pengumuman yang dibuat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pengumumans->links() }}
    </div>
@endsection
