@extends('spmb.dashboard.layout')

@section('page-title', 'Verifikasi')

@section('content')
    <div class="max-w-4xl flex flex-col gap-6">
        <div class="dash-card">
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-bold tracking-wide text-slate-500 uppercase">Data Biodata</p>
                <a href="{{ route('spmb.biodata') }}"
                    class="text-xs font-bold text-[#1d5fa8] hover:underline">Perbaiki</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-4">
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">NISN</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->nisn ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Nama Lengkap</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->nama_lengkap ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Jenis Kelamin</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->jenis_kelamin ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Tempat Lahir</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->tempat_lahir ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Tanggal Lahir</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->tanggal_lahir ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Alamat</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->alamat ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">No. WhatsApp</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->nomor_telepon ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Email</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->email ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Nama Sekolah</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->asal_sekolah ?? '—' }}</p>
                </div>
            </div>
        </div>

        <div class="dash-card">
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-bold tracking-wide text-slate-500 uppercase">Data Orang Tua</p>
                <a href="{{ route('spmb.orang-tua') }}"
                    class="text-xs font-bold text-[#1d5fa8] hover:underline">Perbaiki</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-4">
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Nama Ayah</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->nama_ayah ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Pekerjaan Ayah</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->pekerjaan_ayah ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Nama Ibu</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->nama_ibu ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Pekerjaan Ibu</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->pekerjaan_ibu ?? '—' }}</p>
                </div>
            </div>
        </div>

        <div class="dash-card">
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-bold tracking-wide text-slate-500 uppercase">Dokumen</p>
                <a href="{{ route('spmb.dokumen') }}"
                    class="text-xs font-bold text-[#1d5fa8] hover:underline">Kelola</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-50 border border-slate-100">
                    <div class="w-8 h-8 rounded-md bg-[#1d5fa8]/10 text-[#1d5fa8] flex items-center justify-center shrink-0">
                        <x-lucide-book class="w-4 h-4" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-900 truncate">AKTA KELAHIRAN</p>
                        <p class="text-[0.65rem] font-semibold text-slate-400">Wajib diunggah</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-50 border border-slate-100">
                    <div class="w-8 h-8 rounded-md bg-[#1d5fa8]/10 text-[#1d5fa8] flex items-center justify-center shrink-0">
                        <x-lucide-book class="w-4 h-4" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-900 truncate">KARTU KELUARGA</p>
                        <p class="text-[0.65rem] font-semibold text-slate-400">Wajib diunggah</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-50 border border-slate-100">
                    <div class="w-8 h-8 rounded-md bg-[#1d5fa8]/10 text-[#1d5fa8] flex items-center justify-center shrink-0">
                        <x-lucide-book class="w-4 h-4" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-900 truncate">IJAZAH SMP</p>
                        <p class="text-[0.65rem] font-semibold text-slate-400">Wajib diunggah</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="dash-card">
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-bold tracking-wide text-slate-500 uppercase">Formulir</p>
                <a href="{{ route('spmb.formulir') }}"
                    class="text-xs font-bold text-[#1d5fa8] hover:underline">Perbaiki</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-10 gap-y-4">
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Jalur Seleksi</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->jalur_pendaftaran ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Jurusan</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->jurusan_pilihan ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Pernyataan</p>
                    <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $calonSiswa->jalur_pendaftaran ? 'Sudah dinyatakan' : 'Belum dinyatakan' }}</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-6">
            <a href="{{ route('spmb.pengumuman') }}" class="btn-blue">
                Selesai, Lihat Pengumuman
                <x-lucide-arrow-right />
            </a>
        </div>
    </div>
@endsection
