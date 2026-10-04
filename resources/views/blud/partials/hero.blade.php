@if ($hero)
    <section class="blud-hero" aria-label="Banner layanan unggulan">
        <img src="{{ $hero->galeri->first()?->image_url ?? 'https://placehold.co/1600x560/0f172a/94a3b8?text=' . urlencode($hero->title) }}"
            alt="{{ $hero->title }}" width="1600" height="560" loading="eager" fetchpriority="high">
        <div class="blud-hero__overlay"></div>
        <div class="blud-hero__content">
            <h1 class="blud-hero__title">{{ $hero->title }}</h1>
            <p class="blud-hero__subtitle">{{ $hero->jurusan_nama }}@if ($hero->deskripsi) · {{ Str::limit($hero->deskripsi, 120) }}@endif</p>
            <a href="{{ route('blud.detail', $hero->slug) }}" class="blud-hero__cta">Lihat Detail</a>
        </div>
    </section>
@endif
