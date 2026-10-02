<?php

namespace App\Http\Controllers\Admin\Blud;

use App\Http\Controllers\Controller;
use App\Models\ProdukBludKomentar;
use App\Models\ProdukBludLaporkan;
use App\Models\ProdukBludPenawaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModerasiController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'komentar');

        $komentars = collect();
        $penawarans = collect();
        $laporans = collect();

        if ($tab === 'penawaran') {
            $penawarans = ProdukBludPenawaran::with('produk')->latest()->paginate(15)->withQueryString();
        } elseif ($tab === 'laporan') {
            $laporans = ProdukBludLaporkan::with('produk')->latest()->paginate(15)->withQueryString();
        } else {
            $tab = 'komentar';
            $komentars = ProdukBludKomentar::with('produk')->latest()->paginate(15)->withQueryString();
        }

        $counts = [
            'komentar' => ProdukBludKomentar::count(),
            'penawaran' => ProdukBludPenawaran::count(),
            'laporan' => ProdukBludLaporkan::count(),
        ];

        return view('admin.blud.moderasi.index', compact('tab', 'komentars', 'penawarans', 'laporans', 'counts'));
    }

    public function destroyKomentar(ProdukBludKomentar $komentar): RedirectResponse
    {
        $komentar->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }

    public function destroyPenawaran(ProdukBludPenawaran $penawaran): RedirectResponse
    {
        $penawaran->delete();

        return redirect()->back()->with('success', 'Data penawaran berhasil dihapus.');
    }

    public function destroyLaporan(ProdukBludLaporkan $laporan): RedirectResponse
    {
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil ditindaklanjuti/dihapus.');
    }
}
