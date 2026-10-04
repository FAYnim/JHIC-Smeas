<?php

namespace App\Http\Controllers\Admin\Spmb;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Spmb\StoreFaqRequest;
use App\Http\Requests\Admin\Spmb\UpdateFaqRequest;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(Request $request): View
    {
        $query = Faq::query()->orderBy('urutan');

        if ($request->filled('search')) {
            $search = like_escape($request->query('search'));
            $query->where('pertanyaan', 'like', "%{$search}%")
                ->orWhere('jawaban', 'like', "%{$search}%");
        }

        $faqs = $query->paginate(15)->withQueryString();

        return view('admin.spmb.faq.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('admin.spmb.faq.create');
    }

    public function store(StoreFaqRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['urutan'] = $data['urutan'] ?? (Faq::max('urutan') + 1);

        Faq::create($data);

        return redirect()->route('admin.faq.index')
            ->with('success', 'Pertanyaan FAQ berhasil ditambahkan.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.spmb.faq.edit', compact('faq'));
    }

    public function update(UpdateFaqRequest $request, Faq $faq): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $faq->update($data);

        return redirect()->route('admin.faq.index')
            ->with('success', 'Pertanyaan FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('admin.faq.index')
            ->with('success', 'Pertanyaan FAQ berhasil dihapus.');
    }
}
