@extends('admin.layout')

@section('title', 'Detail Pesanan BLUD')
@section('page-title', 'Detail Pesanan BLUD')

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-6">
        <dl class="grid gap-4 text-sm sm:grid-cols-2">
            <div>
                <dt class="text-xs font-bold uppercase text-slate-500">Produk</dt>
                <dd class="mt-1 font-semibold text-slate-900">{{ $pesanan->produk?->title ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-bold uppercase text-slate-500">Klien</dt>
                <dd class="mt-1 font-semibold text-slate-900">{{ $pesanan->nama }}</dd>
            </div>
            <div>
                <dt class="text-xs font-bold uppercase text-slate-500">Kontak</dt>
                <dd class="mt-1 font-mono text-xs text-blue-600">{{ $pesanan->kontak }}</dd>
            </div>
            <div>
                <dt class="text-xs font-bold uppercase text-slate-500">Waktu</dt>
                <dd class="mt-1 text-slate-600">{{ $pesanan->created_at?->format('d M Y, H:i') }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-xs font-bold uppercase text-slate-500">Pesan</dt>
                <dd class="mt-1 text-slate-700">{{ $pesanan->pesan }}</dd>
            </div>
            <div>
                <dt class="text-xs font-bold uppercase text-slate-500">Ditangani oleh</dt>
                <dd class="mt-1 text-slate-700">{{ $pesanan->penangan?->name ?? '—' }}</dd>
            </div>
        </dl>

        @if ($waUrl)
            <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                class="mt-4 inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700">
                <x-lucide-message-square class="w-4 h-4" />
                Hubungi via WhatsApp
            </a>
        @endif
    </div>

    <form method="POST" action="{{ route('admin.pesanan-blud.update', $pesanan) }}"
        class="mb-6 rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label for="status" class="mb-1 block text-xs font-bold uppercase text-slate-500">Status</label>
            <select id="status" name="status"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-hidden @error('status') border-red-500 @enderror">
                @foreach ($statuses as $key => $label)
                    <option value="{{ $key }}" @selected(old('status', $pesanan->status) === $key)>{{ $label }}</option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="catatan_internal" class="mb-1 block text-xs font-bold uppercase text-slate-500">Catatan Internal</label>
            <textarea id="catatan_internal" name="catatan_internal" rows="3"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-hidden @error('catatan_internal') border-red-500 @enderror">{{ old('catatan_internal', $pesanan->catatan_internal) }}</textarea>
            @error('catatan_internal')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">
            Simpan Perubahan
        </button>
    </form>

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.pesanan-blud.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700">
            ← Kembali ke daftar
        </a>
        <form action="{{ route('admin.pesanan-blud.destroy', $pesanan) }}" method="POST"
            onsubmit="return confirm('Hapus pesanan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-lg px-3 py-2 text-sm font-bold text-red-600 hover:bg-red-50">
                Hapus Pesanan
            </button>
        </form>
    </div>
@endsection
