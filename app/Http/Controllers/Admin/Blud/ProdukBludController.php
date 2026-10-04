<?php

namespace App\Http\Controllers\Admin\Blud;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\ProdukBlud;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProdukBludController extends Controller
{
    use HandlesUploads;

    public function index(Request $request): View
    {
        $query = ProdukBlud::query()->with('galeri')->latest();

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->query('tipe'));
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->query('status') === 'published');
        }

        if ($request->filled('jurusan')) {
            $query->where('jurusan_slug', $request->query('jurusan'));
        }

        if ($request->filled('search')) {
            $search = like_escape($request->query('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('jurusan_nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $produkBluds = $query->paginate(15)->withQueryString();

        return view('admin.blud.produk.index', compact('produkBluds'));
    }

    public function togglePublish(ProdukBlud $produkBlud): RedirectResponse
    {
        $produkBlud->update([
            'is_published' => ! $produkBlud->is_published,
        ]);

        return redirect()->back()
            ->with('success', 'Status publikasi produk berhasil diubah.');
    }

    public function create(): View
    {
        return view('admin.blud.produk.create', ['produk' => new ProdukBlud(['tipe' => ProdukBlud::TIPE_SHOWCASE, 'is_published' => true])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $galeri = $data['galeri'];
        unset($data['galeri']);

        $data['slug'] = $this->uniqueSlug($data['title']);

        $produk = ProdukBlud::create($data);
        $this->syncGaleri($produk, $galeri, $request, []);

        return redirect()->route('admin.produk-blud.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(ProdukBlud $produkBlud): View
    {
        $produkBlud->load('galeri');

        return view('admin.blud.produk.edit', ['produk' => $produkBlud]);
    }

    public function update(Request $request, ProdukBlud $produkBlud): RedirectResponse
    {
        $data = $this->validated($request);
        $galeri = $data['galeri'];
        unset($data['galeri']);

        $produkBlud->update($data);
        $this->syncGaleri($produkBlud, $galeri, $request, $request->input('keep', []));

        return redirect()->route('admin.produk-blud.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(ProdukBlud $produkBlud): RedirectResponse
    {
        foreach ($produkBlud->galeri as $item) {
            $this->deleteFile($this->storagePath($item->image_url));
        }

        $produkBlud->delete();

        return redirect()->route('admin.produk-blud.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'tipe' => ['required', 'in:showcase,kustom'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'jurusan_nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'harga_min' => ['nullable', 'integer', 'min:0'],
            'harga_max' => ['nullable', 'integer', 'min:0', 'gte:harga_min'],
            'kategori' => ['nullable', Rule::in(ProdukBlud::KATEGORI)],
            'stok' => ['nullable', 'string', 'max:255'],
            'pengiriman' => ['nullable', 'string', 'max:255'],
            'opsi_custom' => ['nullable', 'string', 'max:255'],
            'quantity_per_pack' => ['nullable', 'string', 'max:255'],
            'wa_number' => ['nullable', 'string', 'max:20'],
            'galeri' => ['nullable', 'string'],
            'gambar' => ['nullable', 'array', 'max:10'],
            'gambar.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'keep' => ['nullable', 'array'],
            'keep.*' => ['integer'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['jurusan_slug'] = Str::slug($data['jurusan_nama']);
        $data['is_published'] = $request->boolean('is_published');
        $data['galeri'] = collect(preg_split('/\R/', (string) ($data['galeri'] ?? '')))
            ->map(fn ($url) => trim($url))
            ->filter()
            ->filter(fn ($url) => filter_var($url, FILTER_VALIDATE_URL) && preg_match('#^https?://#i', $url))
            ->values()
            ->all();

        return $data;
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'produk';
        $slug = $base;
        $i = 2;

        while (ProdukBlud::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    /**
     * @param  array<int, string>  $urls
     * @param  array<int, int|string>  $keepIds
     */
    private function syncGaleri(ProdukBlud $produk, array $urls, Request $request, array $keepIds): void
    {
        foreach ($produk->galeri()->whereNotIn('id', $keepIds)->get() as $item) {
            $this->deleteFile($this->storagePath($item->image_url));
            $item->delete();
        }

        $urutan = (int) $produk->galeri()->max('urutan') + 1;

        foreach ($request->file('gambar', []) as $file) {
            $path = $this->uploadFile($file, 'blud');
            $produk->galeri()->create(['image_url' => '/storage/'.$path, 'urutan' => $urutan++]);
        }

        foreach ($urls as $url) {
            if (! $produk->galeri()->where('image_url', $url)->exists()) {
                $produk->galeri()->create(['image_url' => $url, 'urutan' => $urutan++]);
            }
        }
    }

    private function storagePath(string $imageUrl): ?string
    {
        return str_starts_with($imageUrl, '/storage/') ? substr($imageUrl, 9) : null;
    }
}
