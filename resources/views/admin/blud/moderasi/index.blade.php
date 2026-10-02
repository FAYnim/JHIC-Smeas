@extends('admin.layout')

@section('title', 'Moderasi BLUD')
@section('page-title', 'Moderasi Interaksi BLUD')

@section('content')
    {{-- Tab Navigation --}}
    <div class="mb-6 flex border-b border-slate-200 gap-2">
        <a href="{{ route('admin.moderasi-blud.index', ['tab' => 'komentar']) }}"
            class="inline-flex items-center gap-2 border-b-2 px-4 py-2.5 text-sm font-bold transition {{ $tab === 'komentar' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            <x-lucide-message-square class="w-4 h-4" />
            Komentar & Ulasan
            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600 font-semibold">{{ $counts['komentar'] }}</span>
        </a>
        <a href="{{ route('admin.moderasi-blud.index', ['tab' => 'penawaran']) }}"
            class="inline-flex items-center gap-2 border-b-2 px-4 py-2.5 text-sm font-bold transition {{ $tab === 'penawaran' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            <x-lucide-shopping-cart class="w-4 h-4" />
            Penawaran & Pesanan
            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600 font-semibold">{{ $counts['penawaran'] }}</span>
        </a>
        <a href="{{ route('admin.moderasi-blud.index', ['tab' => 'laporan']) }}"
            class="inline-flex items-center gap-2 border-b-2 px-4 py-2.5 text-sm font-bold transition {{ $tab === 'laporan' ? 'border-red-600 text-red-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            <x-lucide-flag class="w-4 h-4" />
            Laporan Pelanggaran
            <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs text-red-600 font-semibold">{{ $counts['laporan'] }}</span>
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Content Table per Tab --}}
    @if ($tab === 'komentar')
        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Pengirim</th>
                        <th class="px-4 py-3">Komentar</th>
                        <th class="px-4 py-3">Rating</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($komentars as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-900">
                                {{ $item->produk?->title ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-slate-700 font-medium">
                                {{ $item->nama ?? 'Anonim' }}
                            </td>
                            <td class="px-4 py-3 text-slate-600 max-w-xs">
                                {{ $item->komentar }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($item->rating)
                                    <span class="inline-flex items-center gap-1 font-bold text-amber-500">
                                        ★ {{ $item->rating }}/5
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-500">
                                {{ $item->created_at?->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <form action="{{ route('admin.moderasi-blud.destroy-komentar', $item) }}" method="POST"
                                    onsubmit="return confirm('Hapus komentar ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-red-600">
                                        <x-lucide-trash-2 class="w-4 h-4" />
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                Belum ada komentar yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $komentars->links() }}</div>

    @elseif ($tab === 'penawaran')
        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Produk Diminati</th>
                        <th class="px-4 py-3">Klien</th>
                        <th class="px-4 py-3">Kontak</th>
                        <th class="px-4 py-3">Pesan / Permintaan</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($penawarans as $item)
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
                            <td class="px-4 py-3 text-slate-600 max-w-sm">
                                {{ $item->pesan }}
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-500">
                                {{ $item->created_at?->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <form action="{{ route('admin.moderasi-blud.destroy-penawaran', $item) }}" method="POST"
                                    onsubmit="return confirm('Hapus data penawaran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-red-600">
                                        <x-lucide-trash-2 class="w-4 h-4" />
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                Belum ada data penawaran yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $penawarans->links() }}</div>

    @elseif ($tab === 'laporan')
        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Produk Dilaporkan</th>
                        <th class="px-4 py-3">Alasan Laporan</th>
                        <th class="px-4 py-3">Detail Penjelasan</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($laporans as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-900">
                                {{ $item->produk?->title ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full bg-red-50 border border-red-200 px-2.5 py-0.5 text-xs font-bold text-red-700">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-600 max-w-sm">
                                {{ $item->deskripsi ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-500">
                                {{ $item->created_at?->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <form action="{{ route('admin.moderasi-blud.destroy-laporan', $item) }}" method="POST"
                                    onsubmit="return confirm('Tandai laporan selesai & hapus catatan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-red-600">
                                        <x-lucide-trash-2 class="w-4 h-4" />
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                                Tidak ada laporan pelanggaran aktif.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $laporans->links() }}</div>
    @endif
@endsection
