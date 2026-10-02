@php
    $komentars ??= $produk->komentars;
@endphp
@if (!empty($komentarSuccess))
    <div class="detail-success-banner mb-4" role="status">{{ $komentarSuccess }}</div>
@endif
<section class="detail-card p-4 sm:p-5">
    <h2 class="detail-section-header">Komentar</h2>
    <div class="mt-2 px-1" id="detail-comments-list">
        @forelse ($komentars as $komentar)
            <div class="detail-comment-item" data-rating="{{ $komentar->rating }}">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="detail-badge-name">{{ $komentar->nama ?: 'Anonim' }}</span>
                    @if ($komentar->rating)
                        <span class="text-xs font-semibold text-slate-500">
                            {{ $komentar->rating }} bintang
                        </span>
                    @endif
                </div>
                <p class="mt-2 text-sm text-slate-700 leading-relaxed">{{ $komentar->komentar }}</p>
            </div>
        @empty
            <p class="text-sm text-slate-500 py-4">Belum ada komentar.</p>
        @endforelse
    </div>

    <div class="mt-6 pt-4 border-t border-slate-200">
        <h3 class="font-bold text-slate-900 mb-3">Beri Rating dan Tulis Komentar</h3>
        <form method="POST" action="{{ route('blud.komentar.store', $produk->slug) }}">
            @csrf
            <div class="detail-rating-input-stars mb-3" id="detail-star-input" role="group"
                aria-label="Pilih rating">
                @for ($i = 1; $i <= 5; $i++)
                    <button type="button" class="detail-star-btn" data-star="{{ $i }}"
                        aria-label="{{ $i }} bintang">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.077 10.1c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </button>
                @endfor
                <input type="hidden" name="rating" id="detail-rating-value" value="">
            </div>
            <input type="text" name="nama" class="detail-form-input mb-3"
                placeholder="Nama (opsional)" maxlength="80" aria-label="Nama">
            <textarea name="komentar" rows="4" class="detail-form-input mb-2"
                placeholder="Tulis komentar Anda..." required maxlength="2000" aria-label="Komentar"></textarea>
            @error('komentar')
                <p class="text-sm text-red-600 mb-2" role="alert">{{ $message }}</p>
            @enderror
            @error('nama')
                <p class="text-sm text-red-600 mb-2" role="alert">{{ $message }}</p>
            @enderror
            @error('rating')
                <p class="text-sm text-red-600 mb-2" role="alert">{{ $message }}</p>
            @enderror
            <button type="submit" class="detail-btn-primary mt-2">Kirim</button>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const starButtons = document.querySelectorAll('#detail-star-input [data-star]');
        const ratingInput = document.getElementById('detail-rating-value');
        starButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                const value = btn.getAttribute('data-star');
                if (ratingInput) ratingInput.value = value;
                starButtons.forEach((b) => {
                    const starVal = parseInt(b.getAttribute('data-star'), 10);
                    b.classList.toggle('is-active', starVal <= parseInt(value, 10));
                });
            });
        });
    });
</script>
