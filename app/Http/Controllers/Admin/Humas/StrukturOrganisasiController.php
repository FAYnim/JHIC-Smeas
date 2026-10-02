<?php

namespace App\Http\Controllers\Admin\Humas;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Humas\StoreStrukturOrganisasiRequest;
use App\Http\Requests\Admin\Humas\UpdateStrukturOrganisasiRequest;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StrukturOrganisasiController extends Controller
{
    use HandlesUploads;

    public function index(Request $request): View
    {
        $wakil = StrukturOrganisasi::where('kategori', 'wakil')->orderBy('urutan')->get();
        $bagian = StrukturOrganisasi::where('kategori', 'bagian')->orderBy('urutan')->get();

        return view('admin.humas.struktur.index', compact('wakil', 'bagian'));
    }

    public function create(): View
    {
        return view('admin.humas.struktur.create');
    }

    public function store(StoreStrukturOrganisasiRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['foto']);
        $data['urutan'] = $request->input('urutan', 0) ?? 0;

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $this->uploadFile($request->file('foto'), 'struktur');
        }

        StrukturOrganisasi::create($data);

        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Entri struktur organisasi berhasil ditambahkan.');
    }

    public function edit(StrukturOrganisasi $strukturOrganisasi): View
    {
        return view('admin.humas.struktur.edit', compact('strukturOrganisasi'));
    }

    public function update(UpdateStrukturOrganisasiRequest $request, StrukturOrganisasi $strukturOrganisasi): RedirectResponse
    {
        $data = $request->safe()->except(['foto']);
        $data['urutan'] = $request->input('urutan', 0) ?? 0;

        if ($request->hasFile('foto')) {
            $this->deleteFile($strukturOrganisasi->foto_path);
            $data['foto_path'] = $this->uploadFile($request->file('foto'), 'struktur');
        }

        $strukturOrganisasi->update($data);

        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Entri struktur organisasi berhasil diperbarui.');
    }

    public function destroy(StrukturOrganisasi $strukturOrganisasi): RedirectResponse
    {
        $this->deleteFile($strukturOrganisasi->foto_path);
        $strukturOrganisasi->delete();

        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Entri struktur organisasi berhasil dihapus.');
    }
}
