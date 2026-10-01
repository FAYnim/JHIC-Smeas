@extends('spmb.dashboard.layout')

@section('page-title', 'Bantuan')

@php
    // ponytail: static FAQ until a support-ticket table exists.
    $faq = [
        ['q' => 'Berapa ukuran maksimal file dokumen?', 'a' => 'Maksimal 2MB per berkas. Format yang diterima: PDF, JPG, PNG.'],
        ['q' => 'Bagaimana jika dokumen saya ditolak panitia?', 'a' => 'Lihat status pada menu Dokumen. Jika ada catatan penolakan, unggah ulang berkas yang sesuai, lalu lanjutkan ke tahap berikutnya.'],
        ['q' => 'Kapan hasil pengumuman dirilis?', 'a' => 'Timbul setelah verifikasi administrasi selesai. Pantau menu Pengumuman secara berkala.'],
        ['q' => 'Apakah data bisa direvisi setelah formulir terkirim?', 'a' => 'Tidak. Setelah formulir terkirim, data terkunci. Jika ada kesalahan, hubungi panitia melalui halaman ini.'],
    ];
@endphp

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
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">spmb@smkn1.surabaya.sch.id</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-[#1d5fa8] text-white flex items-center justify-center shrink-0">
                        <x-lucide-phone class="w-4 h-4" />
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">WhatsApp / Telepon</p>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">0812-3456-7890</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-[#1d5fa8] text-white flex items-center justify-center shrink-0">
                        <x-lucide-clock class="w-4 h-4" />
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Jam Pelayanan</p>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">Senin–Jumat, 07.30–15.00 WIB</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FAQ card --}}
        <div class="dash-card lg:col-span-2">
            <p class="text-xs font-bold tracking-wide text-slate-500 uppercase">Pertanyaan Umum</p>

            <div class="divide-y divide-slate-100 mt-2">
                @foreach ($faq as $item)
                    <details class="group py-3">
                        <summary
                            class="flex items-center justify-between cursor-pointer text-sm font-bold text-slate-900 list-none group-open:text-[#1d5fa8]">
                            {{ $item['q'] }}
                            <x-lucide-chevron-down
                                class="w-4 h-4 text-slate-400 transition-transform group-open:rotate-180 shrink-0" />
                        </summary>
                        <p class="text-xs font-medium text-slate-500 leading-relaxed mt-2 pr-6">{{ $item['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </div>
@endsection
