<?php

namespace App\Http\Controllers\Admin\Humas;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Humas\StoreArtikelRequest;
use App\Http\Requests\Admin\Humas\UpdateArtikelRequest;
use App\Models\Artikel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArtikelController extends Controller
{
    use HandlesUploads;

    public function index(Request $request): View
    {
        $query = Artikel::query()->latest('published_at');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('excerpt', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%");
            });
        }

        $artikels = $query->paginate(12)->withQueryString();

        return view('admin.humas.artikel.index', compact('artikels'));
    }

    public function create(): View
    {
        return view('admin.humas.artikel.create');
    }

    public function store(StoreArtikelRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image']);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->title);
        }

        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if (empty($data['reading_time'])) {
            $wordCount = str_word_count(strip_tags($data['content']));
            $minutes = max(1, ceil($wordCount / 200));
            $data['reading_time'] = "{$minutes} menit baca";
        }

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->uploadFile($request->file('image'), 'artikels');
        }

        Artikel::create($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diterbitkan.');
    }

    public function edit(Artikel $artikel): View
    {
        return view('admin.humas.artikel.edit', compact('artikel'));
    }

    public function update(UpdateArtikelRequest $request, Artikel $artikel): RedirectResponse
    {
        $data = $request->safe()->except(['image']);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->title);
        }

        if ($request->hasFile('image')) {
            $this->deleteFile($artikel->image_path);
            $data['image_path'] = $this->uploadFile($request->file('image'), 'artikels');
        }

        $artikel->update($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Artikel $artikel): RedirectResponse
    {
        $this->deleteFile($artikel->image_path);
        $artikel->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
