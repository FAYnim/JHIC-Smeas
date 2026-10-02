<?php

namespace App\Http\Controllers\Admin\Bkk;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Bkk\StoreBimbinganRequest;
use App\Http\Requests\Admin\Bkk\UpdateBimbinganRequest;
use App\Models\BimbinganKarir;
use App\Models\BimbinganKategori;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BimbinganController extends Controller
{
    public function index(Request $request): View
    {
        $kategoriList = BimbinganKategori::orderBy('nama')->get();
        $query = BimbinganKarir::with('kategori')->latest();

        if ($request->filled('kategori')) {
            $query->where('bimbingan_kategori_id', $request->input('kategori'));
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $bimbingans = $query->paginate(12)->withQueryString();

        return view('admin.bkk.bimbingan.index', compact('bimbingans', 'kategoriList'));
    }

    public function create(): View
    {
        $kategoriList = BimbinganKategori::orderBy('nama')->get();

        return view('admin.bkk.bimbingan.create', compact('kategoriList'));
    }

    public function store(StoreBimbinganRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->generateUniqueSlug($data['title']);
        $data['is_published'] = $request->boolean('is_published', true);

        BimbinganKarir::create($data);

        return redirect()->route('admin.bimbingan.index')
            ->with('success', 'Materi bimbingan karir berhasil ditambahkan.');
    }

    public function edit(BimbinganKarir $bimbingan): View
    {
        $kategoriList = BimbinganKategori::orderBy('nama')->get();

        return view('admin.bkk.bimbingan.edit', compact('bimbingan', 'kategoriList'));
    }

    public function update(UpdateBimbinganRequest $request, BimbinganKarir $bimbingan): RedirectResponse
    {
        $data = $request->validated();
        if ($data['title'] !== $bimbingan->title) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $bimbingan->id);
        }
        $data['is_published'] = $request->boolean('is_published');

        $bimbingan->update($data);

        return redirect()->route('admin.bimbingan.index')
            ->with('success', 'Materi bimbingan karir berhasil diperbarui.');
    }

    public function destroy(BimbinganKarir $bimbingan): RedirectResponse
    {
        $bimbingan->delete();

        return redirect()->route('admin.bimbingan.index')
            ->with('success', 'Materi bimbingan karir berhasil dihapus.');
    }

    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 1;

        while (BimbinganKarir::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
