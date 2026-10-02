@extends('admin.layout')

@section('page-title', 'Guru & Tenaga Kependidikan')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Manajemen Guru & Tendik</h2>
                <p class="text-xs text-slate-500">Kelola direktori pendidik dan tenaga kependidikan SMKN 1 Surabaya</p>
            </div>
            <a href="{{ route('admin.guru.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-blue-700">
                <x-lucide-plus class="h-4 w-4" />
                Tambah Guru / Tendik
            </a>
        </div>

        {{-- Filter & Search Card --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
            <form method="GET" action="{{ route('admin.guru.index') }}" class="grid grid-cols-1 gap-3 sm:grid-cols-4">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, jabatan, atau mapel..."
                    class="rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden">

                <select name="kategori" class="rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden">
                    <option value="">Semua Kategori</option>
                    <option value="guru" @selected(request('kategori') === 'guru')>Guru</option>
                    <option value="tendik" @selected(request('kategori') === 'tendik')>Tenaga Kependidikan</option>
                </select>

                <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden">
                    <option value="">Semua Status</option>
                    <option value="active" @selected(request('status') === 'active')>Aktif</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Non-Aktif</option>
                </select>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-slate-800 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-900 transition">
                        Filter
                    </button>
                    @if (request()->hasAny(['q', 'kategori', 'status']))
                        <a href="{{ route('admin.guru.index') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
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
                        <th class="px-4 py-3">Staf</th>
                        <th class="px-4 py-3">Jabatan & Mapel</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3 text-center">Urutan</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($gurus as $item)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($item->foto_url)
                                        <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}" class="h-10 w-10 rounded-full object-cover border border-slate-200">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br {{ $item->warna ?: 'from-blue-500 to-blue-700' }} flex items-center justify-center font-bold text-white text-xs">
                                            {{ $item->initials }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-extrabold text-slate-900">{{ $item->nama }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-slate-900">{{ $item->jabatan }}</p>
                                @if ($item->mapel)
                                    <p class="text-[11px] text-slate-500">{{ $item->mapel }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $item->kategori === 'guru' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center font-bold text-slate-600">
                                {{ $item->urutan }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <form method="POST" action="{{ route('admin.guru.toggle-active', $item) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex rounded-full px-2.5 py-0.5 text-[10px] font-bold transition {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200' }}">
                                        {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.guru.edit', $item) }}" class="rounded-sm p-1 text-slate-600 hover:text-blue-600 transition" title="Edit">
                                        <x-lucide-pencil class="h-4 w-4" />
                                    </a>
                                    <form method="POST" action="{{ route('admin.guru.destroy', $item) }}" onsubmit="return confirm('Hapus data staf ini?')">
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
                                Belum ada data guru atau tendik.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($gurus->hasPages())
                <div class="border-t border-slate-200 p-4">
                    {{ $gurus->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
