@extends('spmb.dashboard.layout')

@section('page-title', 'Orang tua')

@section('content')
    <div class="dash-card max-w-4xl">
        <form method="POST" action="{{ route('spmb.save-orang-tua') }}">
            @csrf

            <div class="pt-tabs">
                <button type="button" class="pt-tab pt-tab--active" data-pt-tab="ayah">Data Ayah</button>
                <button type="button" class="pt-tab" data-pt-tab="ibu">Data Ibu</button>
            </div>

            <div class="pt-panel pt-panel--active" id="pt-panel-ayah">
                <div class="flex flex-wrap items-center gap-5 mb-8">
                    <span class="text-sm font-bold text-slate-700">Status Ayah:</span>
                    <label class="inline-flex items-center gap-2 text-sm font-bold cursor-pointer">
                        <input type="radio" name="status_ayah" value="Masih Hidup" class="accent-blue-600" @checked(old('status_ayah', $calonSiswa->status_ayah ?? '') === 'Masih Hidup')>
                        <span class="text-blue-700">Masih Hidup</span>
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm font-bold cursor-pointer text-slate-400">
                        <input type="radio" name="status_ayah" value="Meninggal Dunia" @checked(old('status_ayah', $calonSiswa->status_ayah ?? '') === 'Meninggal Dunia')>
                        <span>Meninggal Dunia</span>
                    </label>
                </div>
                @error('status_ayah')
                    <span class="field-error-text">{{ $message }}</span>
                @enderror

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10 gap-y-7">
                    <div>
                        <label for="nama_ayah" class="field-label">Nama Lengkap Ayah (Sesuai KTP)</label>
                        <input type="text" id="nama_ayah" name="nama_ayah"
                            class="field-input @error('nama_ayah') input-error @enderror"
                            placeholder="Isi nama..." value="{{ old('nama_ayah', $calonSiswa->nama_ayah ?? '') }}">
                        @error('nama_ayah')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="nik_ayah" class="field-label">NIK Ayah</label>
                        <input type="text" id="nik_ayah" name="nik_ayah" inputmode="numeric" maxlength="16"
                            class="field-input @error('nik_ayah') input-error @enderror" placeholder="NIK 16 digit..."
                            value="{{ old('nik_ayah', $calonSiswa->nik_ayah ?? '') }}">
                        @error('nik_ayah')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="pendidikan_ayah" class="field-label">Pendidikan Terakhir</label>
                        <select id="pendidikan_ayah" name="pendidikan_ayah"
                            class="field-select @error('pendidikan_ayah') input-error @enderror">
                            <option value="" disabled @selected(!old('pendidikan_ayah', $calonSiswa->pendidikan_ayah ?? ''))>Pilih...</option>
                            <option @selected(old('pendidikan_ayah', $calonSiswa->pendidikan_ayah ?? '') === 'SD')>SD</option>
                            <option @selected(old('pendidikan_ayah', $calonSiswa->pendidikan_ayah ?? '') === 'SMP')>SMP</option>
                            <option @selected(old('pendidikan_ayah', $calonSiswa->pendidikan_ayah ?? '') === 'SMA/SMK')>SMA/SMK</option>
                            <option @selected(old('pendidikan_ayah', $calonSiswa->pendidikan_ayah ?? '') === 'Kuliah S1')>Kuliah S1</option>
                        </select>
                        @error('pendidikan_ayah')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="pekerjaan_ayah" class="field-label">Pekerjaan Utama</label>
                        <select id="pekerjaan_ayah" name="pekerjaan_ayah"
                            class="field-select @error('pekerjaan_ayah') input-error @enderror">
                            <option value="" disabled @selected(!old('pekerjaan_ayah', $calonSiswa->pekerjaan_ayah ?? ''))>Pilih...</option>
                            <option @selected(old('pekerjaan_ayah', $calonSiswa->pekerjaan_ayah ?? '') === 'PNS')>PNS</option>
                            <option @selected(old('pekerjaan_ayah', $calonSiswa->pekerjaan_ayah ?? '') === 'Swasta')>Swasta</option>
                            <option @selected(old('pekerjaan_ayah', $calonSiswa->pekerjaan_ayah ?? '') === 'Wiraswasta')>Wiraswasta</option>
                            <option @selected(old('pekerjaan_ayah', $calonSiswa->pekerjaan_ayah ?? '') === 'TNI/Polri')>TNI/Polri</option>
                            <option @selected(old('pekerjaan_ayah', $calonSiswa->pekerjaan_ayah ?? '') === 'Pensiun')>Pensiun</option>
                            <option @selected(old('pekerjaan_ayah', $calonSiswa->pekerjaan_ayah ?? '') === 'Lainnya')>Lainnya</option>
                        </select>
                        @error('pekerjaan_ayah')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="pekerjaan_ayah_lainnya_wrap" class="hidden">
                        <label for="pekerjaan_ayah_lainnya" class="field-label">Pekerjaan Ayah (Lainnya)</label>
                        <input type="text" id="pekerjaan_ayah_lainnya" name="pekerjaan_ayah_lainnya"
                            class="field-input @error('pekerjaan_ayah_lainnya') input-error @endif" placeholder="Isi pekerjaan..."
                            value="{{ old('pekerjaan_ayah_lainnya', $calonSiswa->pekerjaan_ayah_lainnya ?? '') }}">
                        @error('pekerjaan_ayah_lainnya')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="penghasilan_ayah" class="field-label">Penghasilan Bulanan</label>
                        <select id="penghasilan_ayah" name="penghasilan_ayah"
                            class="field-select @error('penghasilan_ayah') input-error @enderror">
                            <option value="" disabled @selected(!old('penghasilan_ayah', $calonSiswa->penghasilan_ayah ?? ''))>Pilih rentang gaji...</option>
                            <option @selected(old('penghasilan_ayah', $calonSiswa->penghasilan_ayah ?? '') === '< 2jt')>&lt; 2jt</option>
                            <option @selected(old('penghasilan_ayah', $calonSiswa->penghasilan_ayah ?? '') === '2jt - 5jt')>2jt - 5jt</option>
                            <option @selected(old('penghasilan_ayah', $calonSiswa->penghasilan_ayah ?? '') === '5jt - 10jt')>5jt - 10jt</option>
                            <option @selected(old('penghasilan_ayah', $calonSiswa->penghasilan_ayah ?? '') === '> 10jt')>&gt; 10jt</option>
                        </select>
                        @error('penghasilan_ayah')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="wa_ayah" class="field-label">Nomor Whatsapps</label>
                        <input type="tel" id="wa_ayah" name="wa_ayah" inputmode="numeric"
                            class="field-input @error('wa_ayah') input-error @enderror"
                            placeholder="Contoh: 08898234..." value="{{ old('wa_ayah', $calonSiswa->wa_ayah ?? '') }}">
                        @error('wa_ayah')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-panel" id="pt-panel-ibu">
                <div class="flex flex-wrap items-center gap-5 mb-8">
                    <span class="text-sm font-bold text-slate-700">Status Ibu:</span>
                    <label class="inline-flex items-center gap-2 text-sm font-bold cursor-pointer">
                        <input type="radio" name="status_ibu" value="Masih Hidup" class="accent-blue-600" @checked(old('status_ibu', $calonSiswa->status_ibu ?? '') === 'Masih Hidup')>
                        <span class="text-blue-700">Masih Hidup</span>
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm font-bold cursor-pointer text-slate-400">
                        <input type="radio" name="status_ibu" value="Meninggal Dunia" @checked(old('status_ibu', $calonSiswa->status_ibu ?? '') === 'Meninggal Dunia')>
                        <span>Meninggal Dunia</span>
                    </label>
                </div>
                @error('status_ibu')
                    <span class="field-error-text">{{ $message }}</span>
                @enderror

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10 gap-y-7">
                    <div>
                        <label for="nama_ibu" class="field-label">Nama Lengkap Ibu (Sesuai KTP)</label>
                        <input type="text" id="nama_ibu" name="nama_ibu"
                            class="field-input @error('nama_ibu') input-error @endif"
                            placeholder="Isi nama..." value="{{ old('nama_ibu', $calonSiswa->nama_ibu ?? '') }}">
                        @error('nama_ibu')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="nik_ibu" class="field-label">NIK Ibu</label>
                        <input type="text" id="nik_ibu" name="nik_ibu" inputmode="numeric" maxlength="16"
                            class="field-input @error('nik_ibu') input-error @endif" placeholder="NIK 16 digit..."
                            value="{{ old('nik_ibu', $calonSiswa->nik_ibu ?? '') }}">
                        @error('nik_ibu')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="pendidikan_ibu" class="field-label">Pendidikan Terakhir</label>
                        <select id="pendidikan_ibu" name="pendidikan_ibu"
                            class="field-select @error('pendidikan_ibu') input-error @endif">
                            <option value="" disabled @selected(!old('pendidikan_ibu', $calonSiswa->pendidikan_ibu ?? ''))>Pilih...</option>
                            <option @selected(old('pendidikan_ibu', $calonSiswa->pendidikan_ibu ?? '') === 'SD')>SD</option>
                            <option @selected(old('pendidikan_ibu', $calonSiswa->pendidikan_ibu ?? '') === 'SMP')>SMP</option>
                            <option @selected(old('pendidikan_ibu', $calonSiswa->pendidikan_ibu ?? '') === 'SMA/SMK')>SMA/SMK</option>
                            <option @selected(old('pendidikan_ibu', $calonSiswa->pendidikan_ibu ?? '') === 'Kuliah S1')>Kuliah S1</option>
                        </select>
                        @error('pendidikan_ibu')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="pekerjaan_ibu" class="field-label">Pekerjaan Utama</label>
                        <select id="pekerjaan_ibu" name="pekerjaan_ibu"
                            class="field-select @error('pekerjaan_ibu') input-error @endif">
                            <option value="" disabled @selected(!old('pekerjaan_ibu', $calonSiswa->pekerjaan_ibu ?? ''))>Pilih...</option>
                            <option @selected(old('pekerjaan_ibu', $calonSiswa->pekerjaan_ibu ?? '') === 'PNS')>PNS</option>
                            <option @selected(old('pekerjaan_ibu', $calonSiswa->pekerjaan_ibu ?? '') === 'Swasta')>Swasta</option>
                            <option @selected(old('pekerjaan_ibu', $calonSiswa->pekerjaan_ibu ?? '') === 'Wiraswasta')>Wiraswasta</option>
                            <option @selected(old('pekerjaan_ibu', $calonSiswa->pekerjaan_ibu ?? '') === 'TNI/Polri')>TNI/Polri</option>
                            <option @selected(old('pekerjaan_ibu', $calonSiswa->pekerjaan_ibu ?? '') === 'Pensiun')>Pensiun</option>
                            <option @selected(old('pekerjaan_ibu', $calonSiswa->pekerjaan_ibu ?? '') === 'Lainnya')>Lainnya</option>
                        </select>
                        @error('pekerjaan_ibu')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="pekerjaan_ibu_lainnya_wrap" class="hidden">
                        <label for="pekerjaan_ibu_lainnya" class="field-label">Pekerjaan Ibu (Lainnya)</label>
                        <input type="text" id="pekerjaan_ibu_lainnya" name="pekerjaan_ibu_lainnya"
                            class="field-input @error('pekerjaan_ibu_lainnya') input-error @endif" placeholder="Isi pekerjaan..."
                            value="{{ old('pekerjaan_ibu_lainnya', $calonSiswa->pekerjaan_ibu_lainnya ?? '') }}">
                        @error('pekerjaan_ibu_lainnya')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="penghasilan_ibu" class="field-label">Penghasilan Bulanan</label>
                        <select id="penghasilan_ibu" name="penghasilan_ibu"
                            class="field-select @error('penghasilan_ibu') input-error @endif">
                            <option value="" disabled @selected(!old('penghasilan_ibu', $calonSiswa->penghasilan_ibu ?? ''))>Pilih rentang gaji...</option>
                            <option @selected(old('penghasilan_ibu', $calonSiswa->penghasilan_ibu ?? '') === '< 2jt')>&lt; 2jt</option>
                            <option @selected(old('penghasilan_ibu', $calonSiswa->penghasilan_ibu ?? '') === '2jt - 5jt')>2jt - 5jt</option>
                            <option @selected(old('penghasilan_ibu', $calonSiswa->penghasilan_ibu ?? '') === '5jt - 10jt')>5jt - 10jt</option>
                            <option @selected(old('penghasilan_ibu', $calonSiswa->penghasilan_ibu ?? '') === '> 10jt')>&gt; 10jt</option>
                        </select>
                        @error('penghasilan_ibu')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="wa_ibu" class="field-label">Nomor Whatsapps</label>
                        <input type="tel" id="wa_ibu" name="wa_ibu" inputmode="numeric"
                            class="field-input @error('wa_ibu') input-error @endif"
                            placeholder="Contoh: 08898234..." value="{{ old('wa_ibu', $calonSiswa->wa_ibu ?? '') }}">
                        @error('wa_ibu')
                            <span class="field-error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-10">
                <button type="submit" class="btn-blue">
                    Simpan
                    <x-lucide-arrow-right />
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.pt-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.pt-tab').forEach(t => t.classList.remove('pt-tab--active'));
                document.querySelectorAll('.pt-panel').forEach(p => p.classList.remove('pt-panel--active'));
                tab.classList.add('pt-tab--active');
                document.getElementById('pt-panel-' + tab.dataset.ptTab).classList.add('pt-panel--active');
            });
        });

        function toggleLainnya(pekerjaanSelectId, lainnyaWrapId) {
            const select = document.getElementById(pekerjaanSelectId);
            const wrap = document.getElementById(lainnyaWrapId);
            if (select.value === 'Lainnya') {
                wrap.classList.remove('hidden');
            } else {
                wrap.classList.add('hidden');
            }
        }

        document.getElementById('pekerjaan_ayah').addEventListener('change', function() {
            toggleLainnya('pekerjaan_ayah', 'pekerjaan_ayah_lainnya_wrap');
        });
        document.getElementById('pekerjaan_ibu').addEventListener('change', function() {
            toggleLainnya('pekerjaan_ibu', 'pekerjaan_ibu_lainnya_wrap');
        });

        toggleLainnya('pekerjaan_ayah', 'pekerjaan_ayah_lainnya_wrap');
        toggleLainnya('pekerjaan_ibu', 'pekerjaan_ibu_lainnya_wrap');
    </script>
@endsection
