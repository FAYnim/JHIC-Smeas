<?php

namespace App\Http\Controllers\Admin\Spmb;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Spmb\StorePengumumanRequest;
use App\Http\Requests\Admin\Spmb\UpdatePengumumanRequest;
use App\Models\Pengumuman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PengumumanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pengumuman::query()->latest();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%'.like_escape($request->query('search')).'%');
        }

        $pengumumans = $query->paginate(15)->withQueryString();

        return view('admin.spmb.pengumuman.index', compact('pengumumans'));
    }

    public function create(): View
    {
        return view('admin.spmb.pengumuman.create');
    }

    public function store(StorePengumumanRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $slug = Str::slug($data['judul']);
        $originalSlug = $slug;
        $counter = 1;

        while (Pengumuman::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $data['slug'] = $slug;
        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        Pengumuman::create($data);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman SPMB berhasil diterbitkan.');
    }

    public function edit(Pengumuman $pengumuman): View
    {
        return view('admin.spmb.pengumuman.edit', compact('pengumuman'));
    }

    public function update(UpdatePengumumanRequest $request, Pengumuman $pengumuman): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published'] && ! $pengumuman->published_at) {
            $data['published_at'] = now();
        }

        $pengumuman->update($data);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman SPMB berhasil diperbarui.');
    }

    public function togglePublish(Pengumuman $pengumuman): RedirectResponse
    {
        $newState = ! $pengumuman->is_published;
        $pengumuman->update([
            'is_published' => $newState,
            'published_at' => $newState && ! $pengumuman->published_at ? now() : $pengumuman->published_at,
        ]);

        return redirect()->back()
            ->with('success', 'Status publikasi pengumuman berhasil diubah.');
    }

    public function destroy(Pengumuman $pengumuman): RedirectResponse
    {
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman SPMB berhasil dihapus.');
    }
}
