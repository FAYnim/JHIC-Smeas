<?php

namespace App\Http\Controllers\Admin\Bkk;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Bkk\StoreMitraRequest;
use App\Http\Requests\Admin\Bkk\UpdateMitraRequest;
use App\Models\MitraPerusahaan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MitraController extends Controller
{
    use HandlesUploads;

    public function index(Request $request): View
    {
        $query = MitraPerusahaan::query()->latest();

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('sector', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%");
            });
        }

        $mitras = $query->paginate(10)->withQueryString();

        return view('admin.bkk.mitra.index', compact('mitras'));
    }

    public function create(): View
    {
        return view('admin.bkk.mitra.create');
    }

    public function store(StoreMitraRequest $request): RedirectResponse
    {
        $data = $this->prepareData($request);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $this->uploadFile($request->file('logo'), 'mitra');
        }

        MitraPerusahaan::create($data);

        return redirect()->route('admin.mitra.index')
            ->with('success', 'Mitra DUDI berhasil ditambahkan.');
    }

    public function edit(MitraPerusahaan $mitra): View
    {
        return view('admin.bkk.mitra.edit', compact('mitra'));
    }

    public function update(UpdateMitraRequest $request, MitraPerusahaan $mitra): RedirectResponse
    {
        $data = $this->prepareData($request);

        if ($request->hasFile('logo')) {
            $this->deleteFile($mitra->logo_path);
            $data['logo_path'] = $this->uploadFile($request->file('logo'), 'mitra');
        }

        $mitra->update($data);

        return redirect()->route('admin.mitra.index')
            ->with('success', 'Mitra DUDI berhasil diperbarui.');
    }

    public function destroy(MitraPerusahaan $mitra): RedirectResponse
    {
        $this->deleteFile($mitra->logo_path);
        $mitra->delete();

        return redirect()->route('admin.mitra.index')
            ->with('success', 'Mitra DUDI berhasil dihapus.');
    }

    protected function prepareData(Request $request): array
    {
        $data = $request->validated();

        $data['slug'] = $this->generateUniqueSlug($data['name']);

        $data['programs'] = $this->parseMultiline($data['programs'] ?? null);

        $data['is_mou_active'] = $request->boolean('is_mou_active');

        if (array_key_exists('mou_until_year', $data)) {
            $data['mou_until'] = filled($data['mou_until_year']) ? $data['mou_until_year'].'-12-31' : null;
            unset($data['mou_until_year']);
        }

        return $data;
    }

    protected function parseMultiline(?string $value): array
    {
        if (! $value) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode("\n", $value)), fn ($line) => $line !== ''));
    }

    protected function generateUniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 1;

        while (MitraPerusahaan::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
