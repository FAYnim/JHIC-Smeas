@extends('spmb.dashboard.layout')

@section('page-title', 'Bantuan')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-5xl">
        {{-- Contact card --}}
        <div class="dash-card">
            <p class="text-xs font-bold tracking-wide text-slate-500 uppercase">Hubungi Panitia</p>

            <div class="flex flex-col gap-4 mt-4">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-[#1d5fa8] text-white flex items-center justify-center shrink-0">
                        <x-lucide-mail class="w-4 h-4" />
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Email</p>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">{{ $contactEmail ?? 'spmb@smkn1.surabaya.sch.id' }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-[#1d5fa8] text-white flex items-center justify-center shrink-0">
                        <x-lucide-phone class="w-4 h-4" />
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">WhatsApp / Telepon</p>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">{{ $contactPhone ?? '0812-3456-7890' }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-[#1d5fa8] text-white flex items-center justify-center shrink-0">
                        <x-lucide-clock class="w-4 h-4" />
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Jam Pelayanan</p>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">{{ $serviceHours ?? 'Senin–Jumat, 07.30–15.00 WIB' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FAQ card --}}
        <div class="dash-card lg:col-span-2">
            <p class="text-xs font-bold tracking-wide text-slate-500 uppercase">Pertanyaan Umum</p>

            <div class="divide-y divide-slate-100 mt-2">
                @forelse ($faqs ?? [] as $item)
                    <details class="group py-3">
                        <summary
                            class="flex items-center justify-between cursor-pointer text-sm font-bold text-slate-900 list-none group-open:text-[#1d5fa8]">
                            {{ $item->pertanyaan }}
                            <x-lucide-chevron-down
                                class="w-4 h-4 text-slate-400 transition-transform group-open:rotate-180 shrink-0" />
                        </summary>
                        <p class="text-xs font-medium text-slate-500 leading-relaxed mt-2 pr-6">
                            {{ $item->jawaban }}
                        </p>
                    </details>
                @empty
                    <p class="text-xs font-medium text-slate-400 py-4">Belum ada daftar pertanyaan umum.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
