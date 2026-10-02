@extends('admin.layout')

@section('page-title', 'Struktur Organisasi')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Manajemen Struktur Organisasi</h2>
                <p class="text-xs text-slate-500">Kelola jajaran wakil kepala sekolah serta unit/bagian pendukung</p>
            </div>
            <a href="{{ route('admin.struktur-organisasi.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-blue-700">
                <x-lucide-plus class="h-4 w-4" />
                Tambah Jabatan / Unit
            </a>
        </div>

        {{-- Jajaran Wakil Kepala Sekolah --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs">
            <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
                <h3 class="text-sm font-extrabold text-slate-800">Pimpinan & Wakil Kepala Sekolah</h3>
            </div>
            <table class="w-full text-left text-xs">
                <thead class="border-b border-slate-200 bg-slate-50/50 font-bold text-slate-700">
                    <tr>
                        <th class="px-4 py-3">Pimpinan</th>
                        <th class="px-4 py-3">Bidang & NIP</th>
                        <th class="px-4 py-3 text-center">Urutan</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($wakil as $item)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($item->foto_url)
                                        <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}" class="h-10 w-10 rounded-full object-cover border border-slate-200">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-700 text-xs">
                                            WKS
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-extrabold text-slate-900">{{ $item->nama }}</p>
                                        <p class="text-[11px] text-slate-500">{{ $item->jabatan ?: 'Wakil Kepala Sekolah' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full bg-blue-50 px-2 py-0.5 text-[10px] font-bold text-blue-700 border border-blue-100">
                                    {{ $item->bidang ?: '-' }}
                                </span>
                                @if ($item->nip)
                                    <p class="mt-0.5 text-[11px] text-slate-400">NIP. {{ $item->nip }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center font-bold text-slate-600">
                                {{ $item->urutan }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.struktur-organisasi.edit', $item) }}" class="rounded-sm p-1 text-slate-600 hover:text-blue-600 transition" title="Edit">
                                        <x-lucide-pencil class="h-4 w-4" />
                                    </a>
                                    <form method="POST" action="{{ route('admin.struktur-organisasi.destroy', $item) }}" onsubmit="return confirm('Hapus entri struktur ini?')">
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
                            <td colspan="4" class="px-4 py-6 text-center text-slate-400">
                                Belum ada data wakil kepala sekolah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Unit Kerja & Bagian Pendukung --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs">
            <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
                <h3 class="text-sm font-extrabold text-slate-800">Unit Kerja & Bagian</h3>
            </div>
            <table class="w-full text-left text-xs">
                <thead class="border-b border-slate-200 bg-slate-50/50 font-bold text-slate-700">
                    <tr>
                        <th class="px-4 py-3">Unit / Bagian</th>
                        <th class="px-4 py-3">Deskripsi Singkat</th>
                        <th class="px-4 py-3">Icon</th>
                        <th class="px-4 py-3 text-center">Urutan</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($bagian as $item)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-4 py-3 font-extrabold text-slate-900">
                                {{ $item->nama }}
                            </td>
                            <td class="px-4 py-3 text-slate-600 max-w-md">
                                {{ $item->deskripsi ?: '-' }}
                            </td>
                            <td class="px-4 py-3 text-slate-500 font-mono text-[11px]">
                                {{ $item->icon ?: 'default' }}
                            </td>
                            <td class="px-4 py-3 text-center font-bold text-slate-600">
                                {{ $item->urutan }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.struktur-organisasi.edit', $item) }}" class="rounded-sm p-1 text-slate-600 hover:text-blue-600 transition" title="Edit">
                                        <x-lucide-pencil class="h-4 w-4" />
                                    </a>
                                    <form method="POST" action="{{ route('admin.struktur-organisasi.destroy', $item) }}" onsubmit="return confirm('Hapus entri unit ini?')">
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
                            <td colspan="5" class="px-4 py-6 text-center text-slate-400">
                                Belum ada unit kerja terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
