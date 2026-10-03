<?php

namespace App\Http\Controllers\Admin\Bkk;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\SumberRekomendasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SumberRekomendasiController extends Controller
{
    use HandlesUploads;

    public function index(): View
    {
        $sumbers = SumberRekomendasi::orderBy('urutan')->get();

        return view('admin.bkk.sumber-rekomendasi.index', compact('sumbers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'url' => ['required', 'url', 'max:500'],
            'kategori' => ['nullable', 'string', 'max:60'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->uploadFile($request->file('image'), 'sumber-rekomendasi');
        }

        $validated['urutan'] = (SumberRekomendasi::max('urutan') ?? 0) + 1;
        SumberRekomendasi::create($validated);

        return redirect()->route('admin.sumber-rekomendasi.index')
            ->with('success', 'Sumber rekomendasi berhasil ditambahkan.');
    }

    public function destroy(SumberRekomendasi $sumberRekomendasi): RedirectResponse
    {
        $this->deleteFile($sumberRekomendasi->image_path);
        $sumberRekomendasi->delete();

        return redirect()->route('admin.sumber-rekomendasi.index')
            ->with('success', 'Sumber rekomendasi berhasil dihapus.');
    }
}
