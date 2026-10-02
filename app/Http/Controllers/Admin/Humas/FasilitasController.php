<?php

namespace App\Http\Controllers\Admin\Humas;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Humas\StoreFasilitasRequest;
use App\Http\Requests\Admin\Humas\UpdateFasilitasRequest;
use App\Models\Fasilitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FasilitasController extends Controller
{
    use HandlesUploads;

    public function index(Request $request): View
    {
        $query = Fasilitas::query()->orderBy('urutan');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($builder) use ($q) {
                $builder->where('nama', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%");
            });
        }

        $fasilitas = $query->paginate(15)->withQueryString();

        return view('admin.humas.fasilitas.index', compact('fasilitas'));
    }

    public function create(): View
    {
        return view('admin.humas.fasilitas.create');
    }

    public function store(StoreFasilitasRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image']);
        $data['urutan'] = $request->input('urutan', 0) ?? 0;

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->uploadFile($request->file('image'), 'fasilitas');
        }

        Fasilitas::create($data);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas sarana prasarana berhasil ditambahkan.');
    }

    public function edit(Fasilitas $fasilita): View
    {
        return view('admin.humas.fasilitas.edit', ['fasilitas' => $fasilita]);
    }

    public function update(UpdateFasilitasRequest $request, Fasilitas $fasilita): RedirectResponse
    {
        $data = $request->safe()->except(['image']);
        $data['urutan'] = $request->input('urutan', 0) ?? 0;

        if ($request->hasFile('image')) {
            $this->deleteFile($fasilita->image_path);
            $data['image_path'] = $this->uploadFile($request->file('image'), 'fasilitas');
        }

        $fasilita->update($data);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas sarana prasarana berhasil diperbarui.');
    }

    public function destroy(Fasilitas $fasilita): RedirectResponse
    {
        $this->deleteFile($fasilita->image_path);
        $fasilita->delete();

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas sarana prasarana berhasil dihapus.');
    }
}
