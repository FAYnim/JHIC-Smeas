@extends('admin.layout')

@section('title', 'Kelola FAQ SPMB')
@section('page-title', 'FAQ SPMB')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.faq.index') }}" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pertanyaan atau jawaban..."
                class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-bold text-white hover:bg-slate-900">
                Cari
            </button>
        </form>
        <a href="{{ route('admin.faq.create') }}"
            class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">
            <x-lucide-plus class="w-4 h-4" />
            Tambah Pertanyaan FAQ
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
                    <th class="px-4 py-3 w-16">Urutan</th>
                    <th class="px-4 py-3">Pertanyaan & Jawaban</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($faqs as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-bold text-slate-400">
                            #{{ $item->urutan }}
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-bold text-slate-900">{{ $item->pertanyaan }}</p>
                            <p class="text-xs text-slate-500 line-clamp-2 mt-0.5">{{ $item->jawaban }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700">
                                {{ $item->kategori ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold {{ $item->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $item->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.faq.edit', $item) }}"
                                    class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-blue-600">
                                    <x-lucide-pencil class="w-4 h-4" />
                                </a>
                                <form action="{{ route('admin.faq.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan FAQ ini?');">
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
                        <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                            Belum ada daftar FAQ yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $faqs->links() }}
    </div>
@endsection
