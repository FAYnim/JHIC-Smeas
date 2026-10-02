@extends('admin.layout')

@section('title', 'Tracer Study')
@section('page-title', 'Tracer Study')

@section('content')
    <div class="mb-6">
        <h2 class="text-lg font-bold text-slate-900">Manajemen Tracer Study</h2>
        <p class="text-xs text-slate-500">Kelola master alumni, rekap data kuesioner pelacakan lulusan, dan konfigurasi statistik.</p>
    </div>

    <!-- Tab Navigasi -->
    <div class="flex items-center gap-2 border-b border-slate-200 mb-6">
        <a href="{{ route('admin.tracer.index', ['tab' => 'alumni']) }}"
            class="px-4 py-2.5 text-sm font-bold border-b-2 transition {{ $tab === 'alumni' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            Database Alumni ({{ $alumnis->total() }})
        </a>
        <a href="{{ route('admin.tracer.index', ['tab' => 'kuesioner']) }}"
            class="px-4 py-2.5 text-sm font-bold border-b-2 transition {{ $tab === 'kuesioner' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            Respon Kuesioner ({{ $kuesioners->total() }})
        </a>
        <a href="{{ route('admin.tracer.index', ['tab' => 'settings']) }}"
            class="px-4 py-2.5 text-sm font-bold border-b-2 transition {{ $tab === 'settings' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            Pengaturan & Indikator
        </a>
    </div>

    @if ($tab === 'alumni')
        <!-- Tab 1: Database Alumni -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <form method="GET" action="{{ route('admin.tracer.index') }}" class="flex flex-wrap items-center gap-2 flex-1">
                <input type="hidden" name="tab" value="alumni">
                <input type="text" name="q_alumni" value="{{ request('q_alumni') }}" placeholder="Cari nama, NISN, jurusan..."
                    class="px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[220px]">
                <select name="tahun_lulus" onchange="this.form.submit()"
                    class="px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-700">
                    <option value="">Semua Tahun Lulus</option>
                    @foreach ($tahunLulusOptions as $thn)
                        <option value="{{ $thn }}" {{ request('tahun_lulus') == $thn ? 'selected' : '' }}>
                            Lulusan {{ $thn }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-sm font-semibold rounded-lg hover:bg-slate-900 transition">
                    Filter
                </button>
            </form>
            <a href="{{ route('admin.tracer.alumni.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition shrink-0">
                <x-lucide-plus class="w-4 h-4" />
                Tambah Alumni
            </a>
        </div>

        @if ($alumnis->isEmpty())
            <div class="bg-white rounded-xl border border-slate-200 p-8 text-center">
                <p class="text-sm font-semibold text-slate-600 mb-1">Tidak ada data alumni</p>
                <p class="text-xs text-slate-400">Silakan tambahkan data alumni SMKN 1 Surabaya.</p>
            </div>
        @else
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-5 py-3">NISN</th>
                                <th class="px-5 py-3">Nama Alumni</th>
                                <th class="px-5 py-3">Jurusan</th>
                                <th class="px-5 py-3">Tahun Lulus</th>
                                <th class="px-5 py-3">Angkatan</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($alumnis as $al)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-5 py-3 font-mono font-bold text-slate-900">{{ $al->nisn }}</td>
                                    <td class="px-5 py-3 font-semibold text-slate-800 max-w-[12rem] truncate" title="{{ $al->nama }}">{{ $al->nama }}</td>
                                    <td class="px-5 py-3 text-slate-600 max-w-[12rem] truncate" title="{{ $al->jurusan }}">{{ $al->jurusan }}</td>
                                    <td class="px-5 py-3 font-semibold text-blue-700">{{ $al->tahun_lulus }}</td>
                                    <td class="px-5 py-3 text-slate-500">{{ $al->angkatan }}</td>
                                    <td class="px-5 py-3 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-1.5">
                                            <a href="{{ route('admin.tracer.alumni.edit', $al) }}"
                                                class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded transition"
                                                title="Ubah">
                                                <x-lucide-pencil class="w-4 h-4" />
                                            </a>
                                            <form method="POST" action="{{ route('admin.tracer.alumni.destroy', $al) }}"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alumni ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded transition"
                                                    title="Hapus">
                                                    <x-lucide-trash-2 class="w-4 h-4" />
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($alumnis->hasPages())
                    <div class="p-4 border-t border-slate-200">
                        {{ $alumnis->links() }}
                    </div>
                @endif
            </div>
        @endif

    @elseif ($tab === 'kuesioner')
        <!-- Tab 2: Respon Kuesioner Tracer -->
        <div class="mb-4">
            <form method="GET" action="{{ route('admin.tracer.index') }}" class="flex flex-wrap items-center gap-2">
                <input type="hidden" name="tab" value="kuesioner">
                <input type="text" name="q_kuesioner" value="{{ request('q_kuesioner') }}" placeholder="Cari nama, NISN, tempat kerja..."
                    class="px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[220px]">
                <select name="status_pekerjaan" onchange="this.form.submit()"
                    class="px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-700">
                    <option value="">Semua Status Pekerjaan</option>
                    @foreach (\App\Models\KuesionerTracer::STATUS_PEKERJAAN as $st)
                        <option value="{{ $st }}" {{ request('status_pekerjaan') === $st ? 'selected' : '' }}>
                            {{ $st }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-sm font-semibold rounded-lg hover:bg-slate-900 transition">
                    Filter
                </button>
            </form>
        </div>

        @if ($kuesioners->isEmpty())
            <div class="bg-white rounded-xl border border-slate-200 p-8 text-center">
                <p class="text-sm font-semibold text-slate-600 mb-1">Belum ada respon kuesioner</p>
                <p class="text-xs text-slate-400">Respon tracer study alumni akan tampil di tabel ini.</p>
            </div>
        @else
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-5 py-3">Alumni</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3">Tempat Kerja / Posisi</th>
                                <th class="px-5 py-3">Masa Tunggu & Relevansi</th>
                                <th class="px-5 py-3">Konfirmasi</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($kuesioners as $k)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-5 py-3">
                                        <p class="font-bold text-slate-900">{{ $k->nama }}</p>
                                        <p class="text-xs text-slate-500 font-mono">NISN: {{ $k->nisn }} ({{ $k->tahun_lulus }})</p>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="inline-block px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded">
                                            {{ $k->status_pekerjaan }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <p class="font-semibold text-slate-800">{{ $k->nama_perusahaan ?: '-' }}</p>
                                        <p class="text-xs text-slate-500">{{ $k->posisi ?: '-' }}</p>
                                    </td>
                                    <td class="px-5 py-3 text-xs">
                                        <p class="font-medium text-slate-700">Tunggu: {{ $k->masa_tunggu ?: '-' }}</p>
                                        <p class="text-slate-500 font-medium">Relevansi: {{ $k->relevansi }}</p>
                                    </td>
                                    <td class="px-5 py-3">
                                        @if ($k->is_konfirmasi)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded">
                                                Terkonfirmasi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded">
                                                Belum
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-right whitespace-nowrap">
                                        <form method="POST" action="{{ route('admin.tracer.kuesioner.toggle-confirm', $k) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-2.5 py-1 text-xs font-semibold rounded border transition {{ $k->is_konfirmasi ? 'border-amber-200 text-amber-700 hover:bg-amber-50' : 'border-emerald-200 text-emerald-700 hover:bg-emerald-50' }}">
                                                {{ $k->is_konfirmasi ? 'Batalkan' : 'Konfirmasi' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($kuesioners->hasPages())
                    <div class="p-4 border-t border-slate-200">
                        {{ $kuesioners->links() }}
                    </div>
                @endif
            </div>
        @endif

    @else
        <!-- Tab 3: Settings Tracer Study -->
        <div class="max-w-3xl bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
            <h3 class="text-base font-bold text-slate-900 mb-4">Pengaturan Statistik Halaman Publik Tracer Study</h3>
            <form method="POST" action="{{ route('admin.tracer.settings.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tingkat Keterserapan</label>
                        <input type="text" name="tingkat_keterserapan" value="{{ old('tingkat_keterserapan', $setting->tingkat_keterserapan) }}"
                            placeholder="Contoh: 92.5%" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Trend Keterserapan</label>
                        <input type="text" name="keterserapan_trend" value="{{ old('keterserapan_trend', $setting->keterserapan_trend) }}"
                            placeholder="Contoh: +3.2% dari tahun lalu" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Masa Tunggu Rata-rata</label>
                        <input type="text" name="masa_tunggu" value="{{ old('masa_tunggu', $setting->masa_tunggu) }}"
                            placeholder="Contoh: 2.1 Bulan" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Keterangan Masa Tunggu</label>
                        <input type="text" name="masa_tunggu_sub" value="{{ old('masa_tunggu_sub', $setting->masa_tunggu_sub) }}"
                            placeholder="Contoh: Tercepat 2 minggu" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Kesesuaian Bidang</label>
                        <input type="text" name="kesesuaian" value="{{ old('kesesuaian', $setting->kesesuaian) }}"
                            placeholder="Contoh: 88%" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Total Alumni Terdata</label>
                        <input type="text" name="total_alumni" value="{{ old('total_alumni', $setting->total_alumni) }}"
                            placeholder="Contoh: 1.450+" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Catatan Singkat / Info BMW</label>
                    <textarea name="catatan_bmw" rows="3" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg">{{ old('catatan_bmw', $setting->catatan_bmw) }}</textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    @endif
@endsection
