@extends('admin.layout')

@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan Umum & Kontak')

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-4xl rounded-xl border border-slate-200 bg-white p-6">
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Bagian 1: Identitas Sekolah --}}
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b">
                    Identitas Lembaga & Website
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Situs / Sekolah</label>
                        <input type="text" name="settings[site_name]" value="{{ $settings['site_name'] ?? 'SMKN 1 Surabaya' }}"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Slogan / Tagline</label>
                        <input type="text" name="settings[site_tagline]" value="{{ $settings['site_tagline'] ?? '' }}"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap</label>
                        <textarea name="settings[school_address]" rows="2"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ $settings['school_address'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Bagian 2: Kontak & Layanan --}}
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b">
                    Kontak Resmi & Jam Operasional
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Telepon Kantor</label>
                        <input type="text" name="settings[school_phone]" value="{{ $settings['school_phone'] ?? '' }}"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Sekolah</label>
                        <input type="email" name="settings[school_email]" value="{{ $settings['school_email'] ?? '' }}"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">WhatsApp Sekolah</label>
                        <input type="text" name="settings[school_whatsapp]" value="{{ $settings['school_whatsapp'] ?? '' }}"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jam Pelayanan SPMB / Kantor</label>
                        <input type="text" name="settings[spmb_service_hours]" value="{{ $settings['spmb_service_hours'] ?? 'Senin–Jumat, 07.30–15.00 WIB' }}"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                </div>
            </div>

            {{-- Bagian 3: Media Sosial --}}
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b">
                    Media Sosial
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Instagram URL</label>
                        <input type="text" name="settings[social_instagram]" value="{{ $settings['social_instagram'] ?? '' }}"
                            placeholder="https://instagram.com/..."
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">YouTube URL</label>
                        <input type="text" name="settings[social_youtube]" value="{{ $settings['social_youtube'] ?? '' }}"
                            placeholder="https://youtube.com/..."
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Facebook URL</label>
                        <input type="text" name="settings[social_facebook]" value="{{ $settings['social_facebook'] ?? '' }}"
                            placeholder="https://facebook.com/..."
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                </div>
            </div>

            {{-- Bagian 4: Helpdesk SPMB --}}
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b">
                    Helpdesk Khusus SPMB
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Panitia SPMB</label>
                        <input type="email" name="settings[spmb_contact_email]" value="{{ $settings['spmb_contact_email'] ?? 'spmb@smkn1.surabaya.sch.id' }}"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">WhatsApp / Call Center SPMB</label>
                        <input type="text" name="settings[spmb_contact_phone]" value="{{ $settings['spmb_contact_phone'] ?? '0812-3456-7890' }}"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t flex justify-end">
                <button type="submit"
                    class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-blue-700 transition">
                    Simpan Seluruh Pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection
