@extends('admin.layout')

@section('title', 'Detail Calon Siswa — ' . $calonSiswa->nama_lengkap)
@section('page-title', 'Detail Calon Siswa')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.calon-siswa.index') }}"
            class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800">
            <x-lucide-arrow-left class="w-4 h-4" />
            Kembali ke Daftar Calon Siswa
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Biodata & Data Orang Tua --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Biodata Siswa --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Biodata Calon Siswa</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-slate-400 font-semibold">NISN</p>
                        <p class="font-bold text-slate-900 font-mono">{{ $calonSiswa->nisn }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold">Nama Lengkap</p>
                        <p class="font-bold text-slate-900">{{ $calonSiswa->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold">Jenis Kelamin</p>
                        <p class="font-medium text-slate-800">{{ $calonSiswa->jenis_kelamin ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold">Tempat, Tanggal Lahir</p>
                        <p class="font-medium text-slate-800">
                            {{ $calonSiswa->tempat_lahir ?? '—' }}{{ $calonSiswa->tanggal_lahir ? ', ' . $calonSiswa->tanggal_lahir : '' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold">Asal Sekolah</p>
                        <p class="font-medium text-slate-800">{{ $calonSiswa->asal_sekolah }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold">Nomor WhatsApp / Telepon</p>
                        <p class="font-medium text-slate-800">{{ $calonSiswa->nomor_telepon ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold">Email</p>
                        <p class="font-medium text-slate-800">{{ $calonSiswa->email ?? '—' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs text-slate-400 font-semibold">Alamat</p>
                        <p class="font-medium text-slate-800">{{ $calonSiswa->alamat ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Pilihan Jurusan & Jalur --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Pilihan Pendaftaran</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-slate-400 font-semibold">Jurusan Pilihan</p>
                        <p class="text-base font-extrabold text-blue-700">{{ $calonSiswa->jurusan_pilihan ?? 'Belum memilih' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold">Jalur Pendaftaran</p>
                        <p class="text-base font-extrabold text-slate-900">{{ $calonSiswa->jalur_pendaftaran ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Data Orang Tua --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Data Orang Tua / Wali</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div class="space-y-2">
                        <h4 class="font-bold text-slate-700 border-b pb-1 text-xs uppercase">Data Ayah</h4>
                        <p><span class="text-xs text-slate-400">Nama:</span> <br><strong>{{ $calonSiswa->nama_ayah ?? '—' }}</strong></p>
                        <p><span class="text-xs text-slate-400">NIK:</span> <br>{{ $calonSiswa->nik_ayah ?? '—' }}</p>
                        <p><span class="text-xs text-slate-400">Pekerjaan:</span> <br>{{ $calonSiswa->pekerjaan_ayah ?? '—' }}</p>
                        <p><span class="text-xs text-slate-400">Penghasilan:</span> <br>{{ $calonSiswa->penghasilan_ayah ?? '—' }}</p>
                        <p><span class="text-xs text-slate-400">Kontak WA:</span> <br>{{ $calonSiswa->wa_ayah ?? '—' }}</p>
                    </div>
                    <div class="space-y-2">
                        <h4 class="font-bold text-slate-700 border-b pb-1 text-xs uppercase">Data Ibu</h4>
                        <p><span class="text-xs text-slate-400">Nama:</span> <br><strong>{{ $calonSiswa->nama_ibu ?? '—' }}</strong></p>
                        <p><span class="text-xs text-slate-400">NIK:</span> <br>{{ $calonSiswa->nik_ibu ?? '—' }}</p>
                        <p><span class="text-xs text-slate-400">Pekerjaan:</span> <br>{{ $calonSiswa->pekerjaan_ibu ?? '—' }}</p>
                        <p><span class="text-xs text-slate-400">Penghasilan:</span> <br>{{ $calonSiswa->penghasilan_ibu ?? '—' }}</p>
                        <p><span class="text-xs text-slate-400">Kontak WA:</span> <br>{{ $calonSiswa->wa_ibu ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Status Verifikasi & Berkas Lampiran --}}
        <div class="space-y-6">
            {{-- Form Verifikasi --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Verifikasi Berkas</h3>
                
                <form action="{{ route('admin.calon-siswa.update-verifikasi', $calonSiswa) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status Verifikasi</label>
                        <select name="status_verifikasi" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                            <option value="menunggu" {{ old('status_verifikasi', $calonSiswa->status_verifikasi) === 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="terverifikasi" {{ old('status_verifikasi', $calonSiswa->status_verifikasi) === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi (Lengkap & Valid)</option>
                            <option value="ditolak" {{ old('status_verifikasi', $calonSiswa->status_verifikasi) === 'ditolak' ? 'selected' : '' }}>Ditolak (Perlu Perbaikan)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Catatan Panitia <span class="text-red-500">(wajib jika status "Ditolak")</span>
                        </label>
                        <textarea name="catatan_verifikasi" rows="4" maxlength="1000" placeholder="Misal: Scan Kartu Keluarga buram, harap perbarui..."
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('catatan_verifikasi') border-red-500 @enderror">{{ old('catatan_verifikasi', $calonSiswa->catatan_verifikasi) }}</textarea>
                        @error('catatan_verifikasi')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-blue-700 transition">
                        Simpan Keputusan Verifikasi
                    </button>
                </form>
            </div>

            {{-- Dokumen Terunggah --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Berkas Lampiran Siswa</h3>

                <ul class="divide-y divide-slate-100">
                    @foreach ($documents as $doc)
                        <li class="py-3 first:pt-0 last:pb-0 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-800 truncate">{{ $doc['label'] }}</p>
                                @if ($doc['uploaded'])
                                    <p class="text-xs text-slate-400">{{ $doc['name'] }} &middot; {{ round($doc['size'] / 1024, 1) }} KB</p>
                                @else
                                    <p class="text-xs font-semibold text-red-500">Belum diunggah</p>
                                @endif
                            </div>
                            @if ($doc['uploaded'])
                                <a href="{{ $doc['url'] }}" target="_blank" rel="noopener"
                                    class="inline-flex items-center gap-1 rounded-md bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-700 hover:bg-slate-200 shrink-0">
                                    <x-lucide-external-link class="w-3.5 h-3.5" />
                                    Buka
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
