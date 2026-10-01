{{-- Modal Minta Penawaran --}}
<div id="modal-penawaran" class="blud-modal-overlay" hidden aria-hidden="true">
    <div class="blud-modal" role="dialog" aria-modal="true" aria-labelledby="modal-penawaran-title">
        <div class="flex items-start justify-between gap-4 mb-4">
            <div>
                <h2 id="modal-penawaran-title" class="text-lg font-extrabold text-slate-900">Minta Penawaran</h2>
                <p class="text-sm text-slate-500 mt-1">Isi detail kebutuhan Anda, tim {{ $produk->jurusan_nama }} akan menghubungi Anda.</p>
            </div>
            <button type="button" class="blud-modal-close" data-close-modal aria-label="Tutup">&times;</button>
        </div>

        <form method="POST" action="{{ route('blud.penawaran.store', $produk->slug) }}">
            @csrf
            <label class="blud-modal-label" for="penawaran-nama">Nama</label>
            <input type="text" id="penawaran-nama" name="nama" value="{{ old('nama') }}" required maxlength="80"
                class="detail-form-input mb-1" placeholder="Nama Anda">

            @error('nama')
                <p class="text-sm text-red-600 mb-2" role="alert">{{ $message }}</p>
            @enderror

            <label class="blud-modal-label mt-3" for="penawaran-kontak">Kontak (WA / Email)</label>
            <input type="text" id="penawaran-kontak" name="kontak" value="{{ old('kontak') }}" required maxlength="100"
                class="detail-form-input mb-1" placeholder="08xx atau email">

            @error('kontak')
                <p class="text-sm text-red-600 mb-2" role="alert">{{ $message }}</p>
            @enderror

            <label class="blud-modal-label mt-3" for="penawaran-pesan">Pesan Kebutuhan</label>
            <textarea id="penawaran-pesan" name="pesan" rows="4" required maxlength="2000"
                class="detail-form-textarea mb-1" placeholder="Jelaskan kebutuhan, jumlah, dan tenggat Anda">{{ old('pesan') }}</textarea>

            @error('pesan')
                <p class="text-sm text-red-600 mb-2" role="alert">{{ $message }}</p>
            @enderror

            <button type="submit" class="detail-btn-primary mt-4">Kirim Permintaan</button>
        </form>
    </div>
</div>

{{-- Modal Laporkan --}}
<div id="modal-laporkan" class="blud-modal-overlay" hidden aria-hidden="true">
    <div class="blud-modal" role="dialog" aria-modal="true" aria-labelledby="modal-laporkan-title">
        <div class="flex items-start justify-between gap-4 mb-4">
            <div>
                <h2 id="modal-laporkan-title" class="text-lg font-extrabold text-slate-900">Laporkan Produk</h2>
                <p class="text-sm text-slate-500 mt-1">Bantu kami menjaga kualitas konten BLUD.</p>
            </div>
            <button type="button" class="blud-modal-close" data-close-modal aria-label="Tutup">&times;</button>
        </div>

        <form method="POST" action="{{ route('blud.laporkan.store', $produk->slug) }}">
            @csrf
            <label class="blud-modal-label" for="laporkan-kategori">Kategori</label>
            <select id="laporkan-kategori" name="kategori" required class="detail-form-input mb-1">
                <option value="">Pilih kategori</option>
                <option value="Spam" @selected(old('kategori') === 'Spam')>Spam</option>
                <option value="Konten Tidak Pantas" @selected(old('kategori') === 'Konten Tidak Pantas')>Konten Tidak Pantas</option>
                <option value="Hak Cipta" @selected(old('kategori') === 'Hak Cipta')>Hak Cipta</option>
                <option value="Lainnya" @selected(old('kategori') === 'Lainnya')>Lainnya</option>
            </select>

            @error('kategori')
                <p class="text-sm text-red-600 mb-2" role="alert">{{ $message }}</p>
            @enderror

            <label class="blud-modal-label mt-3" for="laporkan-deskripsi">Deskripsi</label>
            <textarea id="laporkan-deskripsi" name="deskripsi" rows="4" required maxlength="2000"
                class="detail-form-textarea mb-1" placeholder="Jelaskan masalah yang Anda temukan">{{ old('deskripsi') }}</textarea>

            @error('deskripsi')
                <p class="text-sm text-red-600 mb-2" role="alert">{{ $message }}</p>
            @enderror

            <button type="submit" class="detail-btn-primary mt-4">Kirim Laporan</button>
        </form>
    </div>
</div>

<script>
    (() => {
        const openers = document.querySelectorAll('[data-open-modal]');
        openers.forEach((btn) => {
            btn.addEventListener('click', () => {
                const modal = document.getElementById(btn.getAttribute('data-open-modal'));
                if (!modal) return;
                modal.hidden = false;
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            });
        });

        document.querySelectorAll('.blud-modal-overlay').forEach((overlay) => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) close(overlay);
            });
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.blud-modal-overlay:not([hidden])').forEach(close);
            }
        });

        function close(overlay) {
            overlay.hidden = true;
            overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
    })();
</script>
