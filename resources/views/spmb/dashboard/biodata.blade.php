@extends('spmb.dashboard.layout')

@section('page-title', 'Biodata')

@section('content')
    <div class="dash-card max-w-5xl">
        <form method="POST" action="{{ route('spmb.save-biodata') }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-7">
                <div>
                    <label for="nisn" class="field-label">NISN</label>
                    <input type="text" id="nisn" name="nisn" inputmode="numeric" maxlength="10"
                        class="field-input @error('nisn') input-error @enderror" placeholder="Isi NISN..."
                        value="{{ old('nisn') }}">
                    @error('nisn')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="nama" class="field-label">Nama Lengkap (Sesuai Biodata)</label>
                    <input type="text" id="nama" name="nama"
                        class="field-input @error('nama') input-error @enderror" placeholder="Isi nama..."
                        value="{{ old('nama') }}">
                    @error('nama')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="jenis_kelamin" class="field-label">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin"
                        class="field-select @error('jenis_kelamin') input-error @enderror">
                        <option value="" disabled @selected(old('jenis_kelamin') === '')>Pilih...</option>
                        <option value="Pria" @selected(old('jenis_kelamin') === 'Pria')>Pria</option>
                        <option value="Wanita" @selected(old('jenis_kelamin') === 'Wanita')>Wanita</option>
                    </select>
                    @error('jenis_kelamin')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="tempat_lahir" class="field-label">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir"
                        class="field-input" placeholder="Contoh: Surabaya"
                        value="{{ old('tempat_lahir') }}">
                </div>

                <div>
                    <label for="tanggal_lahir" class="field-label">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="field-input"
                        value="{{ old('tanggal_lahir') }}">
                </div>

                <div>
                    <label for="status" class="field-label">Status</label>
                    <select id="status" name="status" class="field-select @error('status') input-error @enderror">
                        <option value="" disabled @selected(old('status') === '')>Pilih...</option>
                        <option value="Lulusan SMP" @selected(old('status') === 'Lulusan SMP')>
                            Lulusan SMP</option>
                        <option value="Lulusan Madrasah Diniyah" @selected(old('status') === 'Lulusan Madrasah Diniyah')>
                            Lulusan Madrasah Diniyah</option>
                        <option value="Lulusan Paket B" @selected(old('status') === 'Lulusan Paket B')>
                            Lulusan Paket B</option>
                        <option value="Lulusan Paket A" @selected(old('status') === 'Lulusan Paket A')>
                            Lulusan Paket A</option>
                    </select>
                    @error('status')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="alamat" class="field-label">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="4"
                        class="field-input @error('alamat') input-error @enderror" placeholder="Isi alamat...">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="wa" class="field-label">No. WhatsApp</label>
                    <input type="tel" id="wa" name="wa" inputmode="numeric"
                        class="field-input @error('wa') input-error @enderror" placeholder="Contoh: 0889823..."
                        value="{{ old('wa') }}">
                    @error('wa')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="field-label">Email</label>
                    <input type="email" id="email" name="email"
                        class="field-input @error('email') input-error @enderror" placeholder="Isi email..."
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="field-error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="sekolah" class="field-label">Nama Sekolah</label>
                    <input type="text" id="sekolah" name="sekolah"
                        class="field-input @error('sekolah') input-error @enderror" placeholder="Isi nama sekolah..."
                        value="{{ old('sekolah') }}">
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
                </div>
            </div>

            {{-- Submit row --}}
            <div class="flex items-center justify-end gap-6 mt-8">
                <a href="{{ route('spmb.dokumen') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700">
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
