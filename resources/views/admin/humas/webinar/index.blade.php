@extends('admin.layout')

@section('page-title', 'Webinar & Workshop')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Manajemen Webinar & Workshop</h2>
                <p class="text-xs text-slate-500">Kelola jadwal webinar karir, pelatihan siswa, dan temu industri</p>
            </div>
            <a href="{{ route('admin.webinar.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-blue-700">
                <x-lucide-plus class="h-4 w-4" />
                Tambah Webinar Baru
            </a>
        </div>

        {{-- Filter & Search Card --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
            <form method="GET" action="{{ route('admin.webinar.index') }}" class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul webinar atau pembicara..."
                    class="rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden">

                <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden">
                    <option value="">Semua Status</option>
                    <option value="published" @selected(request('status') === 'published')>Terpublikasi</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                </select>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-slate-800 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-900 transition">
                        Filter
                    </button>
                    @if (request()->hasAny(['q', 'status']))
                        <a href="{{ route('admin.webinar.index') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
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
                        <th class="px-4 py-3">Topik Webinar</th>
                        <th class="px-4 py-3">Pemateri</th>
                        <th class="px-4 py-3">Waktu & Platform</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($webinars as $item)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-4 py-3">
                                <p class="font-extrabold text-slate-900">{{ $item->title }}</p>
                                <p class="text-[11px] text-slate-400 font-mono">/pusat-karir/webinar/{{ $item->slug }}</p>
                            </td>
                            <td class="px-4 py-3 font-semibold text-slate-800">
                                {{ $item->speaker }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                <p class="font-medium text-slate-800">{{ $item->start_date ? $item->start_date->format('d M Y') : '-' }} • {{ $item->start_time }}</p>
                                <span class="inline-flex rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-700">
                                    {{ $item->platform }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <form method="POST" action="{{ route('admin.webinar.toggle-publish', $item) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex rounded-full px-2.5 py-0.5 text-[10px] font-bold transition {{ $item->is_published ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200' }}">
                                        {{ $item->is_published ? 'Published' : 'Draft' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    @if ($item->registration_url)
                                        <a href="{{ $item->registration_url }}" target="_blank" class="rounded-sm p-1 text-slate-500 hover:text-slate-800 transition" title="Link Registrasi">
                                            <x-lucide-external-link class="h-4 w-4" />
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.webinar.edit', $item) }}" class="rounded-sm p-1 text-slate-600 hover:text-blue-600 transition" title="Edit">
                                        <x-lucide-pencil class="h-4 w-4" />
                                    </a>
                                    <form method="POST" action="{{ route('admin.webinar.destroy', $item) }}" onsubmit="return confirm('Hapus webinar ini?')">
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
                                Belum ada webinar yang dijadwalkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($webinars->hasPages())
                <div class="border-t border-slate-200 p-4">
                    {{ $webinars->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
