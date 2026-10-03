@extends('admin.layout')

@section('title', 'Lamaran Magang')
@section('page-title', 'Lamaran Magang')

@section('content')
    <div class="mb-6 grid gap-4 sm:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-xs font-bold uppercase text-slate-400">Total Pelamar</p>
            <p class="mt-1 text-2xl font-extrabold text-slate-800">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-xl border border-yellow-200 bg-yellow-50 p-4">
            <p class="text-xs font-bold uppercase text-yellow-600">Menunggu</p>
            <p class="mt-1 text-2xl font-extrabold text-yellow-700">{{ $stats['pending'] }}</p>
        </div>
        <div class="rounded-xl border border-green-200 bg-green-50 p-4">
            <p class="text-xs font-bold uppercase text-green-600">Diterima</p>
            <p class="mt-1 text-2xl font-extrabold text-green-700">{{ $stats['accepted'] }}</p>
        </div>
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <p class="text-xs font-bold uppercase text-red-600">Ditolak</p>
            <p class="mt-1 text-2xl font-extrabold text-red-700">{{ $stats['rejected'] }}</p>
        </div>
    </div>

    <div class="mb-4 flex flex-wrap items-center gap-3">
        <form method="GET" action="{{ route('admin.lamaran.index') }}" class="flex flex-wrap items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari NISN atau kode registrasi..."
                class="rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
            <select name="status" class="rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                    <th class="px-4 py-3">Kode Registrasi</th>
                    <th class="px-4 py-3">NISN</th>
                    <th class="px-4 py-3">Posisi Lowongan</th>
                    <th class="px-4 py-3">Perusahaan</th>
                    <th class="px-4 py-3">Berkas</th>
                    <th class="px-4 py-3">Tanggal Daftar</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($lamarans as $lamaran)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-mono text-xs font-semibold text-slate-700">{{ $lamaran->registration_code }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $lamaran->nisn }}</td>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-slate-800">{{ $lamaran->lowongan?->title ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $lamaran->lowongan?->company_name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col gap-1">
                                @forelse (($lamaran->documents ?? []) as $doc)
                                    <a href="{{ $doc['type'] === 'link' ? $doc['value'] : asset('storage/'.$doc['value']) }}"
                                        target="_blank" rel="noopener"
                                        class="text-xs font-semibold text-blue-600 hover:underline">{{ $doc['label'] }}</a>
                                @empty
                                    <span class="text-xs text-slate-400">-</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $lamaran->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $lamaran->status === 'accepted' ? 'bg-green-100 text-green-700' : ($lamaran->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($lamaran->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end">
                                <form method="POST" action="{{ route('admin.lamaran.update-status', $lamaran) }}"
                                    class="flex items-center gap-1.5">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="rounded-lg border border-slate-200 px-2 py-1.5 text-xs focus:border-blue-500 focus:outline-none">
                                        <option value="pending" {{ $lamaran->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="accepted" {{ $lamaran->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                        <option value="rejected" {{ $lamaran->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    <button type="submit" class="rounded-lg bg-blue-600 px-2.5 py-1.5 text-xs font-bold text-white hover:bg-blue-700">
                                        Update
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-slate-500">Belum ada lamaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $lamarans->links() }}
    </div>
@endsection
