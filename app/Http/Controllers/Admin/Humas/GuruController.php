<?php

namespace App\Http\Controllers\Admin\Humas;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Humas\StoreGuruRequest;
use App\Http\Requests\Admin\Humas\UpdateGuruRequest;
use App\Models\Guru;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuruController extends Controller
{
    use HandlesUploads;

    public function index(Request $request): View
    {
        $query = Guru::query()->orderBy('urutan');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        if ($request->filled('q')) {
            $q = like_escape($request->string('q')->toString());
            $query->where(function ($builder) use ($q) {
                $builder->where('nama', 'like', "%{$q}%")
                    ->orWhere('jabatan', 'like', "%{$q}%")
                    ->orWhere('mapel', 'like', "%{$q}%");
            });
        }

        $gurus = $query->paginate(15)->withQueryString();

        return view('admin.humas.guru.index', compact('gurus'));
    }

    public function create(): View
    {
        return view('admin.humas.guru.create');
    }

    public function store(StoreGuruRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['foto']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['urutan'] = $request->input('urutan', 0) ?? 0;

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $this->uploadFile($request->file('foto'), 'guru');
        }

        Guru::create($data);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru/tendik berhasil ditambahkan.');
    }

    public function edit(Guru $guru): View
    {
        return view('admin.humas.guru.edit', compact('guru'));
    }

    public function update(UpdateGuruRequest $request, Guru $guru): RedirectResponse
    {
        $data = $request->safe()->except(['foto']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['urutan'] = $request->input('urutan', 0) ?? 0;

        if ($request->hasFile('foto')) {
            $this->deleteFile($guru->foto_path);
            $data['foto_path'] = $this->uploadFile($request->file('foto'), 'guru');
        }

        $guru->update($data);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru/tendik berhasil diperbarui.');
    }

    public function destroy(Guru $guru): RedirectResponse
    {
        $this->deleteFile($guru->foto_path);
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru/tendik berhasil dihapus.');
    }

    public function toggleActive(Guru $guru): RedirectResponse
    {
        $guru->update(['is_active' => ! $guru->is_active]);

        return back()->with('success', 'Status keaktifan berhasil diubah.');
    }
}
