<?php

namespace App\Http\Controllers\Admin\Blud;

use App\Http\Controllers\Controller;
use App\Models\ProdukBlud;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukBludController extends Controller
{
    public function index(Request $request): View
    {
        $query = ProdukBlud::query()->with('galeri')->latest();

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->query('tipe'));
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->query('status') === 'published');
        }

        if ($request->filled('jurusan')) {
            $query->where('jurusan_slug', $request->query('jurusan'));
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('jurusan_nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $produkBluds = $query->paginate(15)->withQueryString();

        return view('admin.blud.produk.index', compact('produkBluds'));
    }

    public function togglePublish(ProdukBlud $produkBlud): RedirectResponse
    {
        $produkBlud->update([
            'is_published' => ! $produkBlud->is_published,
        ]);

        return redirect()->back()
            ->with('success', 'Status publikasi produk berhasil diubah.');
    }
}
