@extends('admin.layout')

@section('title', 'Pendaftar Calon Siswa (SPMB)')
@section('page-title', 'Pendaftar Calon Siswa')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.calon-siswa.index') }}" class="flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NISN, nama, sekolah..."
                class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
            
            <select name="status" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="terverifikasi" {{ request('status') === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>

            <select name="jurusan" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Semua Jurusan</option>
                @foreach ($jurusanOptions as $jurusan)
                    <option value="{{ $jurusan }}" {{ request('jurusan') === $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                @endforeach
            </select>

            <select name="jalur" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Semua Jalur</option>
                @foreach ($jalurOptions as $jalur)
                    <option value="{{ $jalur }}" {{ request('jalur') === $jalur ? 'selected' : '' }}>{{ $jalur }}</option>
                @endforeach
            </select>

            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-bold text-white hover:bg-slate-900">
                Filter
            </button>
            @if (request()->hasAny(['search', 'status', 'jurusan', 'jalur']))
                <a href="{{ route('admin.calon-siswa.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700">Reset</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3">NISN & Nama</th>
                    <th class="px-4 py-3">Asal Sekolah</th>
                    <th class="px-4 py-3">Pilihan Jurusan & Jalur</th>
                    <th class="px-4 py-3">Status Verifikasi</th>
                    <th class="px-4 py-3">Tanggal Daftar</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($calonSiswas as $siswa)
                    @php
                        $badges = [
                            'menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'terverifikasi' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                        ];
                        $badgeClass = $badges[$siswa->status_verifikasi ?? 'menunggu'] ?? $badges['menunggu'];
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <p class="font-bold text-slate-900">{{ $siswa->nama_lengkap }}</p>
                            <p class="text-xs font-mono text-slate-500">{{ $siswa->nisn }}</p>
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ $siswa->asal_sekolah }}
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-slate-900">{{ $siswa->jurusan_pilihan ?? 'Belum memilih' }}</p>
                            <p class="text-xs text-slate-500">{{ $siswa->jalur_pendaftaran ?? '—' }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-bold capitalize {{ $badgeClass }}">
                                {{ $siswa->status_verifikasi ?? 'menunggu' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-slate-500">
                            {{ $siswa->created_at?->format('d M Y, H:i') ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.calon-siswa.show', $siswa) }}"
                                class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700 hover:bg-blue-100">
                                Detail & Berkas
                                <x-lucide-arrow-right class="w-3.5 h-3.5" />
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                            Tidak ada data calon siswa ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $calonSiswas->links() }}
    </div>
@endsection
