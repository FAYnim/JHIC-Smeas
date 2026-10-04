<?php

namespace App\Http\Controllers\Admin\Blud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TindakLanjutBludRequest;
use App\Models\ProdukBludKomentar;
use App\Models\ProdukBludLaporkan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModerasiController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'komentar');

        $komentars = collect();
        $laporans = collect();

        if ($tab === 'laporan') {
            $laporans = ProdukBludLaporkan::with(['produk', 'penangan'])
                ->orderByRaw("status = 'baru' desc")
                ->latest()
                ->paginate(15)
                ->withQueryString();
        } else {
            $tab = 'komentar';
            $komentars = ProdukBludKomentar::with(['produk', 'penangan'])
                ->orderByRaw("status = 'baru' desc")
                ->latest()
                ->paginate(15)
                ->withQueryString();
        }

        $counts = [
            'komentar' => ProdukBludKomentar::where('status', ProdukBludKomentar::STATUS_BARU)->count(),
            'laporan' => ProdukBludLaporkan::where('status', ProdukBludLaporkan::STATUS_BARU)->count(),
        ];

        return view('admin.blud.moderasi.index', compact('tab', 'komentars', 'laporans', 'counts'));
    }

    public function destroyKomentar(ProdukBludKomentar $komentar): RedirectResponse
    {
        $komentar->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }

    public function tindakLanjutKomentar(TindakLanjutBludRequest $request, ProdukBludKomentar $komentar): RedirectResponse
    {
        $komentar->update([
            'status' => ProdukBludKomentar::STATUS_DITINDAKLANJUTI,
            'catatan_internal' => $request->validated('catatan_internal'),
            'ditangani_oleh' => $request->user()->id,
            'ditangani_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Komentar ditandai ditindaklanjuti.');
    }

    public function destroyLaporan(ProdukBludLaporkan $laporan): RedirectResponse
    {
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }

    public function tindakLanjutLaporan(TindakLanjutBludRequest $request, ProdukBludLaporkan $laporan): RedirectResponse
    {
        $laporan->update([
            'status' => ProdukBludLaporkan::STATUS_DITINDAKLANJUTI,
            'catatan_internal' => $request->validated('catatan_internal'),
            'ditangani_oleh' => $request->user()->id,
            'ditangani_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Laporan ditandai ditindaklanjuti.');
    }
}
