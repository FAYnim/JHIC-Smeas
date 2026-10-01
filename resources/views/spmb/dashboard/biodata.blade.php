@extends('spmb.dashboard.layout')

@section('page-title', 'Biodata')

@section('content')
    <div class="dash-card max-w-5xl">
        <form method="POST" action="{{ route('spmb.save-biodata') }}" id="biodata-form">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-7">
                <div>
                    <label for="nama" class="field-label">Nama Lengkap (Sesuai Biodata)</label>
                    <input type="text" id="nama" name="nama"
                        class="field-input @error('nama') input-error @enderror" placeholder="Isi nama..."
                        value="{{ old('nama', $calonSiswa->nama_lengkap ?? '') }}">
                    @error('nama')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="jenis_kelamin" class="field-label">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin"
                        class="field-select @error('jenis_kelamin') input-error @enderror">
                        <option value="" disabled @selected(old('jenis_kelamin', $calonSiswa->jenis_kelamin ?? '') === '')>Pilih...</option>
                        <option value="Pria" @selected(old('jenis_kelamin', $calonSiswa->jenis_kelamin ?? '') === 'Pria')>Pria</option>
                        <option value="Wanita" @selected(old('jenis_kelamin', $calonSiswa->jenis_kelamin ?? '') === 'Wanita')>Wanita</option>
                    </select>
                    @error('jenis_kelamin')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="tempat_lahir" class="field-label">Tempat Lahir</label>
                    <select id="tempat_lahir" name="tempat_lahir"
                        class="field-select @error('tempat_lahir') input-error @enderror">
                        <option value="" disabled @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === '')>Pilih...</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Surabaya')>Surabaya</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Sidoarjo')>Sidoarjo</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Gresik')>Gresik</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Mojokerto')>Mojokerto</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Malang')>Malang</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Kediri')>Kediri</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Jember')>Jember</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Banyuwangi')>Banyuwangi</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Madiun')>Madiun</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Ponorogo')>Ponorogo</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Blitar')>Blitar</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Batu')>Batu</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Pasuruan')>Pasuruan</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Probolinggo')>Probolinggo</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Lumajang')>Lumajang</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Bondowoso')>Bondowoso</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Situbondo')>Situbondo</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Tuban')>Tuban</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Bojonegoro')>Bojonegoro</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Ngawi')>Ngawi</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Magetan')>Magetan</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Pacitan')>Pacitan</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Trenggalek')>Trenggalek</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Tulungagung')>Tulungagung</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Nganjuk')>Nganjuk</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Jombang')>Jombang</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Lamongan')>Lamongan</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Sumenep')>Sumenep</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Pamekasan')>Pamekasan</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Sampang')>Sampang</option>
                        <option @selected(old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') === 'Bangkalan')>Bangkalan</option>
                    </select>
                    @error('tempat_lahir')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_lahir" class="field-label">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                        class="field-input @error('tanggal_lahir') input-error @enderror"
                        value="{{ old('tanggal_lahir', $calonSiswa->tanggal_lahir ?? '') }}"
                        max="{{ now()->subYears(15)->format('Y-m-d') }}">
                    @error('tanggal_lahir')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="alamat" class="field-label">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="4"
                        class="field-input @error('alamat') input-error @enderror" placeholder="Isi alamat...">{{ old('alamat', $calonSiswa->alamat ?? '') }}</textarea>
                    @error('alamat')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="wa" class="field-label">No. WhatsApp</label>
                    <input type="tel" id="wa" name="wa" inputmode="numeric"
                        class="field-input @error('wa') input-error @enderror" placeholder="Contoh: 0889823..."
                        value="{{ old('wa', $calonSiswa->nomor_telepon ?? '') }}">
                    @error('wa')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="field-label">Email</label>
                    <input type="email" id="email" name="email"
                        class="field-input @error('email') input-error @enderror" placeholder="Isi email..."
                        value="{{ old('email', $calonSiswa->email ?? '') }}">
                    @error('email')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="sekolah" class="field-label">Nama Sekolah</label>
                    <input type="text" id="sekolah" name="sekolah"
                        class="field-input @error('sekolah') input-error @enderror" placeholder="Isi nama sekolah..."
                        value="{{ old('sekolah', $calonSiswa->asal_sekolah ?? '') }}">
                    @error('sekolah')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="checkbox-label declaration-box">
                        <input type="checkbox" name="deklarasi" value="1" @checked(old('deklarasi'))>
                        Saya menyatakan bahwa seluruh data dan berkas yang dimasukkan adalah BENAR dan SAH. Jika di
                        kemudian hari ditemukan pemalsuan data, saya siap mendapatkan konsekuensi
                    </label>
                    @error('deklarasi')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-6 mt-8">
                <a href="{{ route('spmb.orang-tua') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700">
                    Simpan & Lanjut
                </a>
                <button type="submit" class="btn-blue">
                    Lanjut
                    <x-lucide-arrow-right />
                </button>
            </div>
        </form>
    </div>
@endsection
