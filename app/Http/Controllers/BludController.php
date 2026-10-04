<?php

namespace App\Http\Controllers;

use App\Models\ProdukBlud;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BludController extends Controller
{
    public function index(Request $request): View
    {
        $query = ProdukBlud::where('is_published', true)
            ->with('galeri')
            ->orderByDesc('created_at');

        if ($request->filled('q')) {
            $q = like_escape($request->string('q')->toString());
            $query->where(fn ($b) => $b->where('title', 'like', "%{$q}%")
                ->orWhere('jurusan_nama', 'like', "%{$q}%")
                ->orWhere('deskripsi', 'like', "%{$q}%"));
        }

        $produkBluds = $query->get();

        // Sort stabil: prioritas rating > penilaian_count > created_at
        // (primary diterapkan terakhir).
        $hero = $produkBluds
            ->sortByDesc('created_at')
            ->sortByDesc('penilaian_count')
            ->sortByDesc('rating')
            ->first();

        return view('blud.index', compact('produkBluds', 'hero'));
    }

    public function detail(string $slug): View
    {
        $produk = ProdukBlud::where('slug', $slug)
            ->where('is_published', true)
            ->with(['galeri', 'komentars'])
            ->firstOrFail();

        $related = ProdukBlud::where('jurusan_slug', $produk->jurusan_slug)
            ->where('slug', '!=', $produk->slug)
            ->where('is_published', true)
            ->with('galeri')
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        if ($produk->tipe === ProdukBlud::TIPE_KUSTOM) {
            return view('blud.detail-kustom', compact('produk', 'related'));
        }

        return view('blud.detail-showcase', compact('produk', 'related'));
    }

    public function storeKomentar(Request $request, string $slug): RedirectResponse
    {
        $produk = ProdukBlud::where('slug', $slug)->where('is_published', true)->firstOrFail();

        $validated = $request->validate([
            'nama' => ['nullable', 'string', 'max:80'],
            'komentar' => ['required', 'string', 'max:2000'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $produk->komentars()->create([
            'nama' => $validated['nama'] ?? 'Anonim',
            'komentar' => $validated['komentar'],
            'rating' => $validated['rating'] ?? null,
        ]);

        return redirect()->route('blud.detail', $slug)->with('success', 'Komentar terkirim.');
    }

    public function storePenawaran(Request $request, string $slug): RedirectResponse
    {
        $produk = ProdukBlud::where('slug', $slug)->where('is_published', true)->firstOrFail();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:80'],
            'kontak' => ['required', 'string', 'max:100'],
            'pesan' => ['required', 'string', 'max:2000'],
        ]);

        $produk->penawarans()->create($validated);

        return redirect()->route('blud.detail', $slug)
            ->with('success', 'Permintaan penawaran Anda telah terkirim.');
    }

    public function storeLaporkan(Request $request, string $slug): RedirectResponse
    {
        $produk = ProdukBlud::where('slug', $slug)->where('is_published', true)->firstOrFail();

        $validated = $request->validate([
            'kategori' => ['required', 'in:Spam,Konten Tidak Pantas,Hak Cipta,Lainnya'],
            'deskripsi' => ['required', 'string', 'max:2000'],
        ]);

        $produk->laporans()->create($validated);

        return redirect()->route('blud.detail', $slug)
            ->with('success', 'Laporan Anda telah terkirim. Kami akan segera meninjau.');
    }
}
