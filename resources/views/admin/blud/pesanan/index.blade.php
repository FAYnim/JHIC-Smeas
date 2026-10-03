@extends('admin.layout')

@section('title', 'Pesanan BLUD')
@section('page-title', 'Pesanan BLUD')

@php
    $badge = [
        'baru' => 'bg-blue-50 text-blue-700 border-blue-200',
        'dihubungi' => 'bg-amber-50 text-amber-700 border-amber-200',
        'diproses' => 'bg-violet-50 text-violet-700 border-violet-200',
        'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'batal' => 'bg-slate-100 text-slate-600 border-slate-200',
    ];
@endphp

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.pesanan-blud.index') }}" class="mb-4 flex flex-wrap items-center gap-3">
        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, kontak, pesan..."
            class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-hidden">
        <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-hidden">
            <option value="">Semua</option>
            @foreach ($statuses as $key => $label)
                <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">
            Filter
        </button>
    </form>

    <div class="mb-6 flex flex-wrap gap-2">
        @foreach ($statuses as $key => $label)
            <a href="{{ route('admin.pesanan-blud.index', ['status' => $key, 'q' => $search]) }}"
                class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-bold transition {{ $status === $key ? 'border-blue-600 bg-blue-600 text-white' : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300' }}">
                {{ $label }}
                <span class="rounded-full bg-slate-100 px-1.5 text-xs {{ $status === $key ? 'text-slate-700' : 'text-slate-500' }}">{{ $counts[$key] ?? 0 }}</span>
            </a>
        @endforeach
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3">Produk</th>
                    <th class="px-4 py-3">Klien</th>
                    <th class="px-4 py-3">Kontak</th>
                    <th class="px-4 py-3">Pesan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Waktu</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($pesanans as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-semibold text-slate-900">
                            {{ $item->produk?->title ?? '—' }}
                        </td>
                        <td class="px-4 py-3 font-bold text-slate-800">
                            {{ $item->nama }}
                        </td>
                        <td class="px-4 py-3 font-mono text-xs text-blue-600">
                            {{ $item->kontak }}
                        </td>
                        <td class="px-4 py-3 text-slate-600 max-w-xs">
                            {{ \Illuminate\Support\Str::limit($item->pesan, 80) }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full border px-2.5 py-0.5 text-xs font-bold {{ $badge[$item->status] ?? 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                {{ $statuses[$item->status] ?? $item->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-slate-500">
                            {{ $item->created_at?->format('d M Y, H:i') }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.pesanan-blud.show', $item) }}"
                                class="inline-flex rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700 hover:bg-blue-100">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-slate-400">
                            Belum ada pesanan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $pesanans->links() }}</div>
@endsection
