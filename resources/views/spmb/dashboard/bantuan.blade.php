@extends('spmb.dashboard.layout')

@section('page-title', 'Bantuan')

@php
    // ponytail: static FAQ until a support-ticket table exists.
    $faq = [
        ['q' => 'Berapa ukuran maksimal file dokumen?', 'a' => 'Maksimal 2MB per berkas. Format yang diterima: PDF, JPG, PNG.'],
        ['q' => 'Bagaimana jika dokumen saya ditolak panitia?', 'a' => 'Lihat status pada menu Dokumen. Jika ada catatan penolakan, unggah ulang berkas yang sesuai, lalu lanjutkan ke tahap berikutnya.'],
        ['q' => 'Kapan hasil pengumuman dirilis?', 'a' => 'Timbul setelah verifikasi administrasi selesai. Pantau menu Pengumuman secara berkala.'],
        ['q' => 'Apakah data bisa direvisi setelah formulir terkirim?', 'a' => 'Tidak. Setelah formulir terkirim, data terkunci. Jika ada kesalahan, hubungi panitia melalui halaman ini.'],
        ['q' => 'Saya tidak bisa login, kenapa?', 'a' => 'Pastikan NISN 10 digit yang Anda masukkan sudah terdaftar. Jika tetap gagal, hubungi panitia dengan menyebutkan NISN Anda.'],
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
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Email</p>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">spmb@smkn1.surabaya.sch.id</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-[#1d5fa8] text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.903.055-1.073.468l-.97 2.257c-.163.384-.563.614-.983.58L4.99 18.723a.75.75 0 01-.747-.615L2.25 6.75z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">WhatsApp / Telepon</p>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">0812-3456-7890</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-[#1d5fa8] text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
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
                            <svg class="w-4 h-4 text-slate-400 transition-transform group-open:rotate-180 shrink-0"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </summary>
                        <p class="text-xs font-medium text-slate-500 leading-relaxed mt-2 pr-6">{{ $item['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </div>
@endsection
