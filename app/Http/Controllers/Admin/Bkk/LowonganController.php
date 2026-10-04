<?php

namespace App\Http\Controllers\Admin\Bkk;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Bkk\StoreLowonganRequest;
use App\Http\Requests\Admin\Bkk\UpdateLowonganRequest;
use App\Models\Lowongan;
use App\Models\MitraPerusahaan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LowonganController extends Controller
{
    use HandlesUploads;

    public function index(Request $request): View
    {
        $query = Lowongan::query()->latest();

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->input('jenis'));
        }

        if ($request->filled('status')) {
            $isPublished = $request->input('status') === 'published';
            $query->where('is_published', $isPublished);
        }

        if ($request->filled('q')) {
            $q = like_escape($request->string('q')->toString());
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('company_name', 'like', "%{$q}%");
            });
        }

        $lowongans = $query->paginate(10)->withQueryString();

        return view('admin.bkk.lowongan.index', compact('lowongans'));
    }

    public function create(): View
    {
        $mitras = MitraPerusahaan::orderBy('name')->get();

        return view('admin.bkk.lowongan.create', compact('mitras'));
    }

    public function store(StoreLowonganRequest $request): RedirectResponse
    {
        $data = $this->prepareData($request);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $this->uploadFile($request->file('logo'), 'logos');
        }

        Lowongan::create($data);

        return redirect()->route('admin.lowongan.index')
            ->with('success', 'Lowongan berhasil ditambahkan.');
    }

    public function edit(Lowongan $lowongan): View
    {
        $mitras = MitraPerusahaan::orderBy('name')->get();

        return view('admin.bkk.lowongan.edit', compact('lowongan', 'mitras'));
    }

    public function update(UpdateLowonganRequest $request, Lowongan $lowongan): RedirectResponse
    {
        $data = $this->prepareData($request);

        if ($request->hasFile('logo')) {
            $this->deleteFile($lowongan->logo_path);
            $data['logo_path'] = $this->uploadFile($request->file('logo'), 'logos');
        }

        $lowongan->update($data);

        return redirect()->route('admin.lowongan.index')
            ->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(Lowongan $lowongan): RedirectResponse
    {
        $this->deleteFile($lowongan->logo_path);
        $lowongan->delete();

        return redirect()->route('admin.lowongan.index')
            ->with('success', 'Lowongan berhasil dihapus.');
    }

    public function togglePublish(Lowongan $lowongan): RedirectResponse
    {
        $lowongan->update(['is_published' => ! $lowongan->is_published]);

        return redirect()->route('admin.lowongan.index')
            ->with('success', $lowongan->is_published ? 'Lowongan dipublikasikan.' : 'Lowongan disembunyikan.');
    }

    protected function prepareData(Request $request): array
    {
        $data = $request->validated();

        $data['slug'] = $this->generateUniqueSlug($data['title']);

        $data['tanggung_jawab'] = $this->parseMultiline($data['tanggung_jawab'] ?? null);
        $data['kualifikasi'] = $this->parseMultiline($data['kualifikasi'] ?? null);
        $data['benefits'] = $this->parseMultiline($data['benefits'] ?? null);
        $data['dokumen'] = $data['dokumen'] ?? [];

        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }

    protected function parseMultiline(?string $value): array
    {
        if (! $value) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode("\n", $value)), fn ($line) => $line !== ''));
    }

    protected function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 1;

        while (Lowongan::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
