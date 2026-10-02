@extends('admin.layout')

@section('title', 'Katalog Produk BLUD')
@section('page-title', 'Produk & Jasa BLUD')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.produk-blud.index') }}" class="flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk, jurusan..."
                class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">

            <select name="tipe" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Semua Tipe</option>
                <option value="showcase" {{ request('tipe') === 'showcase' ? 'selected' : '' }}>Showcase (Langsung)</option>
                <option value="kustom" {{ request('tipe') === 'kustom' ? 'selected' : '' }}>Kustom (Pre-Order)</option>
            </select>

            <select name="status" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft / Non-aktif</option>
            </select>

            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-bold text-white hover:bg-slate-900">
                Filter
            </button>
            @if (request()->hasAny(['search', 'tipe', 'status']))
                <a href="{{ route('admin.produk-blud.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700">Reset</a>
            @endif
        </form>
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
                    <th class="px-4 py-3">Produk / Jasa</th>
                    <th class="px-4 py-3">Jurusan</th>
                    <th class="px-4 py-3">Tipe</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Status Publikasi</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($produkBluds as $produk)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <p class="font-bold text-slate-900">{{ $produk->title }}</p>
                            <p class="text-xs text-slate-500 line-clamp-1">{{ Str::limit($produk->deskripsi, 80) }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-700">
                                {{ $produk->jurusan_nama }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded px-2 py-0.5 text-xs font-semibold {{ $produk->tipe === 'kustom' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($produk->tipe) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs font-mono font-semibold text-slate-700">
                            @if ($produk->harga_min && $produk->harga_max)
                                Rp{{ number_format($produk->harga_min, 0, ',', '.') }} - Rp{{ number_format($produk->harga_max, 0, ',', '.') }}
                            @elseif ($produk->harga_min)
                                Rp{{ number_format($produk->harga_min, 0, ',', '.') }}
                            @else
                                Sesuai Penawaran
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.produk-blud.toggle-publish', $produk) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="inline-flex items-center gap-1 rounded-full border px-2.5 py-0.5 text-xs font-bold transition {{ $produk->is_published ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border-slate-200 hover:bg-slate-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $produk->is_published ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $produk->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('blud.detail', $produk->slug) }}" target="_blank"
                                class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:underline">
                                Lihat
                                <x-lucide-external-link class="w-3.5 h-3.5" />
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                            Belum ada produk BLUD yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $produkBluds->links() }}
    </div>
@endsection
