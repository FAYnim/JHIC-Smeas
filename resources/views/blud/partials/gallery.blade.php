@php
    $galeriItems = $produk->galeri->take(5);
    $mainImage = $galeriItems->first()?->image_url
        ?? 'https://placehold.co/800x600/e2e8f0/64748b?text=' . urlencode($produk->title);
@endphp
<img id="detail-main-image" class="detail-main-img" src="{{ $mainImage }}"
    alt="{{ $produk->title }}" width="800" height="600">
@if ($galeriItems->count() > 1)
    <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
        @foreach ($galeriItems as $index => $thumb)
            <button type="button" class="detail-thumb {{ $index === 0 ? 'is-active' : '' }}"
                data-detail-thumb="{{ $thumb->image_url }}" aria-label="Gambar {{ $index + 1 }}">
                <img src="{{ $thumb->image_url }}" alt="{{ $thumb->caption ?? $produk->title }}"
                    class="w-full h-full object-cover" loading="lazy">
            </button>
        @endforeach
    </div>
@elseif ($galeriItems->isEmpty())
    <p class="text-xs text-slate-400 mt-2">Belum ada foto galeri.</p>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const mainImage = document.getElementById('detail-main-image');
        document.querySelectorAll('[data-detail-thumb]').forEach((thumb) => {
            thumb.addEventListener('click', () => {
                const src = thumb.getAttribute('data-detail-thumb');
                if (mainImage && src) {
                    mainImage.src = src;
                }
                document.querySelectorAll('[data-detail-thumb]').forEach((t) => t.classList.remove('is-active'));
                thumb.classList.add('is-active');
            });
        });
    });
</script>
