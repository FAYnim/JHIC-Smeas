@extends('spmb.dashboard.layout')

@section('page-title', 'Orang tua')

@section('content')
    <div class="dash-card max-w-4xl">
        <form method="POST" action="{{ route('spmb.save-orang-tua') }}">
            @csrf

            {{-- Parent data tabs --}}
            <div class="pt-tabs">
                <button type="button" class="pt-tab pt-tab--active" data-pt-tab="ayah">Data Ayah</button>
                <button type="button" class="pt-tab" data-pt-tab="ibu">Data Ibu</button>
            </div>

            {{-- ===== Ayah panel ===== --}}
            <div class="pt-panel pt-panel--active" id="pt-panel-ayah">
                <div class="flex flex-wrap items-center gap-5 mb-8">
                    <span class="text-sm font-bold text-slate-700">Status Ayah:</span>
                    <label class="inline-flex items-center gap-2 text-sm font-bold cursor-pointer">
                        <input type="radio" name="status_ayah" value="Masih Hidup" checked class="accent-blue-600">
                        <span class="text-blue-700">Masih Hidup</span>
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm font-bold cursor-pointer text-slate-400">
                        <input type="radio" name="status_ayah" value="Meninggal Dunia">
                        <span>Meninggal Dunia</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10 gap-y-7">
                    <div>
                        <label for="nama_ayah" class="field-label">Nama Lengkap Ayah (Sesuai KTP)</label>
                        <input type="text" id="nama_ayah" name="nama_ayah"
                            class="field-input @error('nama_ayah') input-error @enderror"
                            placeholder="Isi nama..." value="{{ old('nama_ayah', 'Ephraim Sugeng') }}">
                        @error('nama_ayah')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="nik_ayah" class="field-label">NIK Ayah</label>
                        <input type="text" id="nik_ayah" name="nik_ayah" inputmode="numeric"
                            class="field-input @error('nik_ayah') input-error @enderror" placeholder="NIK..."
                            value="{{ old('nik_ayah', '123456') }}">
                        @error('nik_ayah')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="pendidikan_ayah" class="field-label">Pendidikan Terakhir</label>
                        <select id="pendidikan_ayah" name="pendidikan_ayah"
                            class="field-select @error('pendidikan_ayah') input-error @enderror" required>
                            <option value="" disabled @selected(!old('pendidikan_ayah'))>Pilih...</option>
                            <option @selected(old('pendidikan_ayah') === 'SD')>SD</option>
                            <option @selected(old('pendidikan_ayah') === 'SMP')>SMP</option>
                            <option @selected(old('pendidikan_ayah') === 'SMA/SMK')>SMA/SMK</option>
                            <option @selected(old('pendidikan_ayah') === 'Kuliah S1')>Kuliah S1</option>
                        </select>
                        @error('pendidikan_ayah')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="pekerjaan_ayah" class="field-label">Pekerjaan Utama</label>
                        <select id="pekerjaan_ayah" name="pekerjaan_ayah"
                            class="field-select @error('pekerjaan_ayah') input-error @enderror">
                            <option value="" disabled @selected(!old('pekerjaan_ayah'))>Pilih...</option>
                            <option @selected(old('pekerjaan_ayah') === 'PNS')>PNS</option>
                            <option @selected(old('pekerjaan_ayah') === 'Swasta')>Swasta</option>
                            <option @selected(old('pekerjaan_ayah') === 'Wiraswasta')>Wiraswasta</option>
                            <option @selected(old('pekerjaan_ayah') === 'TNI/Polri')>TNI/Polri</option>
                            <option @selected(old('pekerjaan_ayah') === 'Pensiun')>Pensiun</option>
                            <option @selected(old('pekerjaan_ayah') === 'Lainnya')>Lainnya</option>
                        </select>
                        @error('pekerjaan_ayah')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="penghasilan_ayah" class="field-label">Penghasilan Bulanan</label>
                        <select id="penghasilan_ayah" name="penghasilan_ayah"
                            class="field-select @error('penghasilan_ayah') input-error @enderror">
                            <option value="" disabled @selected(!old('penghasilan_ayah'))>Pilih rentang gaji...</option>
                            <option @selected(old('penghasilan_ayah') === '< 2jt')>&lt; 2jt</option>
                            <option @selected(old('penghasilan_ayah') === '2jt - 5jt')>2jt - 5jt</option>
                            <option @selected(old('penghasilan_ayah') === '5jt - 10jt')>5jt - 10jt</option>
                            <option @selected(old('penghasilan_ayah') === '> 10jt')>&gt; 10jt</option>
                        </select>
                        @error('penghasilan_ayah')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="wa_ayah" class="field-label">Nomor Whatsapps</label>
                        <input type="tel" id="wa_ayah" name="wa_ayah" inputmode="numeric"
                            class="field-input @error('wa_ayah') input-error @enderror"
                            placeholder="Contoh: 08898234..." value="{{ old('wa_ayah', '0889876754') }}">
                        @error('wa_ayah')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ===== Ibu panel ===== --}}
            <div class="pt-panel" id="pt-panel-ibu">
                <div class="flex flex-wrap items-center gap-5 mb-8">
                    <span class="text-sm font-bold text-slate-700">Status Ibu:</span>
                    <label class="inline-flex items-center gap-2 text-sm font-bold cursor-pointer">
                        <input type="radio" name="status_ibu" value="Masih Hidup" checked class="accent-blue-600">
                        <span class="text-blue-700">Masih Hidup</span>
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm font-bold cursor-pointer text-slate-400">
                        <input type="radio" name="status_ibu" value="Meninggal Dunia">
                        <span>Meninggal Dunia</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10 gap-y-7">
                    <div>
                        <label for="nama_ibu" class="field-label">Nama Lengkap Ibu (Sesuai KTP)</label>
                        <input type="text" id="nama_ibu" name="nama_ibu"
                            class="field-input @error('nama_ibu') input-error @enderror"
                            placeholder="Isi nama..." value="{{ old('nama_ibu') }}">
                        @error('nama_ibu')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="nik_ibu" class="field-label">NIK Ibu</label>
                        <input type="text" id="nik_ibu" name="nik_ibu" inputmode="numeric"
                            class="field-input @error('nik_ibu') input-error @enderror" placeholder="NIK..."
                            value="{{ old('nik_ibu') }}">
                        @error('nik_ibu')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="pendidikan_ibu" class="field-label">Pendidikan Terakhir</label>
                        <select id="pendidikan_ibu" name="pendidikan_ibu"
                            class="field-select @error('pendidikan_ibu') input-error @enderror" required>
                            <option value="" disabled @selected(!old('pendidikan_ibu'))>Pilih...</option>
                            <option @selected(old('pendidikan_ibu') === 'SD')>SD</option>
                            <option @selected(old('pendidikan_ibu') === 'SMP')>SMP</option>
                            <option @selected(old('pendidikan_ibu') === 'SMA/SMK')>SMA/SMK</option>
                            <option @selected(old('pendidikan_ibu') === 'Kuliah S1')>Kuliah S1</option>
                        </select>
                        @error('pendidikan_ibu')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="pekerjaan_ibu" class="field-label">Pekerjaan Utama</label>
                        <select id="pekerjaan_ibu" name="pekerjaan_ibu"
                            class="field-select @error('pekerjaan_ibu') input-error @enderror">
                            <option value="" disabled @selected(!old('pekerjaan_ibu'))>Pilih...</option>
                            <option @selected(old('pekerjaan_ibu') === 'PNS')>PNS</option>
                            <option @selected(old('pekerjaan_ibu') === 'Swasta')>Swasta</option>
                            <option @selected(old('pekerjaan_ibu') === 'Wiraswasta')>Wiraswasta</option>
                            <option @selected(old('pekerjaan_ibu') === 'TNI/Polri')>TNI/Polri</option>
                            <option @selected(old('pekerjaan_ibu') === 'Pensiun')>Pensiun</option>
                            <option @selected(old('pekerjaan_ibu') === 'Lainnya')>Lainnya</option>
                        </select>
                        @error('pekerjaan_ibu')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="penghasilan_ibu" class="field-label">Penghasilan Bulanan</label>
                        <select id="penghasilan_ibu" name="penghasilan_ibu"
                            class="field-select @error('penghasilan_ibu') input-error @enderror">
                            <option value="" disabled @selected(!old('penghasilan_ibu'))>Pilih rentang gaji...</option>
                            <option @selected(old('penghasilan_ibu') === '< 2jt')>&lt; 2jt</option>
                            <option @selected(old('penghasilan_ibu') === '2jt - 5jt')>2jt - 5jt</option>
                            <option @selected(old('penghasilan_ibu') === '5jt - 10jt')>5jt - 10jt</option>
                            <option @selected(old('penghasilan_ibu') === '> 10jt')>&gt; 10jt</option>
                        </select>
                        @error('penghasilan_ibu')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="wa_ibu" class="field-label">Nomor Whatsapps</label>
                        <input type="tel" id="wa_ibu" name="wa_ibu" inputmode="numeric"
                            class="field-input @error('wa_ibu') input-error @enderror"
                            placeholder="Contoh: 08898234..." value="{{ old('wa_ibu') }}">
                        @error('wa_ibu')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Submit row --}}
            <div class="flex justify-end mt-10">
                <button type="submit" class="btn-blue">
                    Lanjut
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        // Parent data tab switch
        document.querySelectorAll('.pt-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.pt-tab').forEach(t => t.classList.remove('pt-tab--active'));
                document.querySelectorAll('.pt-panel').forEach(p => p.classList.remove('pt-panel--active'));
                tab.classList.add('pt-tab--active');
                document.getElementById('pt-panel-' + tab.dataset.ptTab).classList.add('pt-panel--active');
            });
        });
    </script>
@endsection
