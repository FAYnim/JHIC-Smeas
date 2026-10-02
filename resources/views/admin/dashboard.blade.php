@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <p class="text-sm font-medium text-slate-500 mb-6">
        Ringkasan data sesuai cakupan akses Anda
        ({{ auth()->user()->roleLabel() }}).
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
        @foreach ($stats as $stat)
            @php
                $tones = [
                    'blue' => 'bg-blue-50 text-blue-700',
                    'amber' => 'bg-amber-50 text-amber-700',
                    'emerald' => 'bg-emerald-50 text-emerald-700',
                    'violet' => 'bg-violet-50 text-violet-700',
                ];
                $tone = $tones[$stat['tone']] ?? $tones['blue'];
            @endphp

            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">{{ $stat['label'] }}</p>
                    <span class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 {{ $tone }}">
                        @switch($stat['icon'])
                            @case('briefcase')
                                <x-lucide-briefcase class="w-4 h-4" />
                            @break
                            @case('inbox')
                                <x-lucide-inbox class="w-4 h-4" />
                            @break
                            @case('building-2')
                                <x-lucide-building-2 class="w-4 h-4" />
                            @break
                            @case('graduation-cap')
                                <x-lucide-graduation-cap class="w-4 h-4" />
                            @break
                            @case('newspaper')
                                <x-lucide-newspaper class="w-4 h-4" />
                            @break
                            @case('video')
                                <x-lucide-video class="w-4 h-4" />
                            @break
                            @default
                                <x-lucide-circle class="w-4 h-4" />
                        @endswitch
                    </span>
                </div>
                <p class="mt-3 text-3xl font-extrabold text-blue-700">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @if ($recentLowongans->isNotEmpty())
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-500 mb-4">
                    Lowongan Terbaru
                </p>
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentLowongans as $lowongan)
                        <li class="py-3 first:pt-0 last:pb-0">
                            <p class="text-sm font-bold text-slate-900">{{ $lowongan->title }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">
                                {{ $lowongan->company_name }} · {{ $lowongan->created_at?->format('d M Y') }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($recentArticles->isNotEmpty())
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-500 mb-4">
                    Artikel Terbaru
                </p>
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentArticles as $artikel)
                        <li class="py-3 first:pt-0 last:pb-0">
                            <p class="text-sm font-bold text-slate-900">{{ $artikel->title }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">
                                {{ $artikel->kategori }} · {{ $artikel->published_at?->format('d M Y') }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($recentCalonSiswa->isNotEmpty())
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-500 mb-4">
                    Calon Siswa Terbaru
                </p>
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentCalonSiswa as $calonSiswa)
                        <li class="py-3 first:pt-0 last:pb-0">
                            <p class="text-sm font-bold text-slate-900">{{ $calonSiswa->nama_lengkap }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">
                                {{ $calonSiswa->jurusan_pilihan }} · {{ $calonSiswa->created_at?->format('d M Y') }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
