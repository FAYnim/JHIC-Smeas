@extends('spmb.dashboard.layout')

@section('page-title', 'Pengumuman')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        @if (isset($pengumumans) && $pengumumans->isNotEmpty())
            <div class="space-y-4">
                @foreach ($pengumumans as $item)
                    <div class="dash-card">
                        <div class="flex items-center justify-between gap-4 mb-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-[#1d5fa8]/10 text-[#1d5fa8]">
                                <x-lucide-megaphone class="w-3.5 h-3.5" />
                                Pengumuman Resmi
                            </span>
                            <span class="text-xs font-semibold text-slate-400">
                                {{ $item->published_at ? $item->published_at->format('d M Y, H:i') : $item->created_at->format('d M Y') }} WIB
                            </span>
                        </div>
                        <h2 class="text-lg font-extrabold text-slate-900 mb-2">{{ $item->judul }}</h2>
                        <div class="text-sm font-medium text-slate-600 leading-relaxed whitespace-pre-line">
                            {{ $item->konten }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="dash-card text-center py-12">
                <div
                    class="w-16 h-16 rounded-full bg-[#1d5fa8]/10 text-[#1d5fa8] flex items-center justify-center mx-auto">
                    <x-lucide-clock class="w-8 h-8" />
                </div>

                <h2 class="text-xl font-extrabold text-slate-900 mt-5">Pengumuman Belum Diterbitkan</h2>
                <p class="text-sm font-medium text-slate-500 mt-2 leading-relaxed max-w-md mx-auto">
                    Hasil seleksi masih dalam proses verifikasi administrasi. Pantau halaman ini secara berkala.
                </p>

                <div class="mt-8">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Status</p>
                    <p class="text-lg font-extrabold text-slate-900 mt-1">Verifikasi berjalan</p>
                </div>
            </div>
        @endif
    </div>
@endsection
