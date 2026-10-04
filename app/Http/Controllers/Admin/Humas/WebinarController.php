<?php

namespace App\Http\Controllers\Admin\Humas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Humas\StoreWebinarRequest;
use App\Http\Requests\Admin\Humas\UpdateWebinarRequest;
use App\Models\Webinar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WebinarController extends Controller
{
    public function index(Request $request): View
    {
        $query = Webinar::query()->latest('start_date');

        if ($request->filled('status')) {
            $query->where('is_published', $request->input('status') === 'published');
        }

        if ($request->filled('q')) {
            $q = like_escape($request->string('q')->toString());
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('speaker', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $webinars = $query->paginate(12)->withQueryString();

        return view('admin.humas.webinar.index', compact('webinars'));
    }

    public function create(): View
    {
        return view('admin.humas.webinar.create');
    }

    public function store(StoreWebinarRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->title);
        }

        $data['is_published'] = $request->boolean('is_published', true);

        Webinar::create($data);

        return redirect()->route('admin.webinar.index')->with('success', 'Webinar berhasil ditambahkan.');
    }

    public function edit(Webinar $webinar): View
    {
        return view('admin.humas.webinar.edit', compact('webinar'));
    }

    public function update(UpdateWebinarRequest $request, Webinar $webinar): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->title);
        }

        $data['is_published'] = $request->boolean('is_published', true);

        $webinar->update($data);

        return redirect()->route('admin.webinar.index')->with('success', 'Webinar berhasil diperbarui.');
    }

    public function destroy(Webinar $webinar): RedirectResponse
    {
        $webinar->delete();

        return redirect()->route('admin.webinar.index')->with('success', 'Webinar berhasil dihapus.');
    }

    public function togglePublish(Webinar $webinar): RedirectResponse
    {
        $webinar->update(['is_published' => ! $webinar->is_published]);

        return back()->with('success', 'Status publikasi webinar berhasil diubah.');
    }
}
