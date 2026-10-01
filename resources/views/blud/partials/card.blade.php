<article class="blud-card" data-blud-card
    data-search="{{ strtolower($p->title . ' ' . $p->jurusan_nama) }}">
    <div class="blud-card__media">
        @if ($showBadge ?? true)
            <span class="blud-badge-major">{{ $p->jurusan_nama }}</span>
        @endif
        <img src="{{ $p->galeri->first()?->image_url ?? 'https://placehold.co/480x420/e2e8f0/64748b?text=' . urlencode($p->title) }}"
            alt="{{ $p->title }}" width="480" height="420" loading="lazy">
    </div>
    <div class="blud-card__body">
        <h3 class="blud-card__title">{{ $p->title }}</h3>
        @if ($p->tipe === \App\Models\ProdukBlud::TIPE_SHOWCASE)
            <p class="blud-card__desc">Rp {{ number_format($p->harga_min ?? 0) }} - Rp {{ number_format($p->harga_max ?? 0) }}</p>
        @else
            <span class="inline-flex items-center self-start bg-blue-700 text-white text-[0.7rem] font-bold px-2.5 py-0.5 rounded-full">
                Karya Siswa
            </span>
        @endif
        @if (($showRating ?? true) && $p->rating !== null)
            <p class="text-xs font-semibold text-amber-600">
                ★ {{ number_format((float) $p->rating, 1) }}
                <span class="text-slate-500 font-normal">({{ $p->rating_count ?? 0 }})</span>
            </p>
        @endif
        <a href="{{ route('blud.detail', $p->slug) }}" class="blud-btn-detail">
            Detail lebih lanjut
        </a>
    </div>
</article>
