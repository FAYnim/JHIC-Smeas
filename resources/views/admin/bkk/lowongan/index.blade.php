@extends('admin.layout')

@section('title', 'Kelola Lowongan')
@section('page-title', 'Kelola Lowongan')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.lowongan.index', ['jenis' => '']) }}"
                class="rounded-lg px-3 py-1.5 text-xs font-bold {{ request('jenis') ? 'bg-white text-slate-600 border border-slate-200' : 'bg-blue-600 text-white' }}">
                Semua
            </a>
            <a href="{{ route('admin.lowongan.index', ['jenis' => 'magang']) }}"
                class="rounded-lg px-3 py-1.5 text-xs font-bold {{ request('jenis') === 'magang' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                Magang
            </a>
            <a href="{{ route('admin.lowongan.index', ['jenis' => 'lowongan']) }}"
                class="rounded-lg px-3 py-1.5 text-xs font-bold {{ request('jenis') === 'lowongan' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                Lowongan Kerja
            </a>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('pusat-karir.katalog-lowongan') }}" target="_blank" class="text-sm text-blue-600 hover:underline">Lihat di Situs →</a>
            <a href="{{ route('admin.lowongan.create') }}"
                class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">
                <x-lucide-plus class="w-4 h-4" />
                Tambah Lowongan
            </a>
        </div>
    </div>

    <div class="mb-4 flex flex-wrap items-center gap-3">
        <form method="GET" action="{{ route('admin.lowongan.index') }}" class="flex flex-wrap items-center gap-2">
            @if (request('jenis'))
                <input type="hidden" name="jenis" value="{{ request('jenis') }}">
            @endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari posisi atau perusahaan..."
                class="rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
            <select name="status" class="rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-bold text-white hover:bg-slate-900">
                Filter
            </button>
        </form>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3">Perusahaan / Posisi</th>
                    <th class="px-4 py-3">Jenis</th>
                    <th class="px-4 py-3">Kuota</th>
                    <th class="px-4 py-3">Batas Daftar</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($lowongans as $lowongan)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($lowongan->logo_path)
                                    <img src="{{ $lowongan->logo_url }}" alt="{{ $lowongan->company_name }}"
                                        class="h-9 w-9 rounded-lg object-contain">
                                @else
                                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 text-xs font-bold text-blue-600">
                                        {{ Str::limit($lowongan->company_short ?? $lowongan->company_name, 2, '') }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $lowongan->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $lowongan->company_name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $lowongan->jenis === 'magang' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($lowongan->jenis) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $lowongan->kuota }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $lowongan->batas_pendaftaran->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('admin.lowongan.toggle-publish', $lowongan) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold {{ $lowongan->is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $lowongan->is_published ? 'bg-green-500' : 'bg-slate-400' }}"></span>
                                    {{ $lowongan->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.lowongan.edit', $lowongan) }}"
                                    class="rounded-lg bg-slate-100 p-2 text-slate-600 hover:bg-slate-200">
                                    <x-lucide-pencil class="w-4 h-4" />
                                </a>
                                <form method="POST" action="{{ route('admin.lowongan.destroy', $lowongan) }}"
                                    onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
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
                        <td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada lowongan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $lowongans->links() }}
    </div>
@endsection
