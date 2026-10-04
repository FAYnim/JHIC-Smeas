<?php

namespace App\Http\Controllers\Admin\Blud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePesananBludRequest;
use App\Models\ProdukBludPenawaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PesananController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = like_escape(trim((string) $request->query('q', '')));

        $pesanans = ProdukBludPenawaran::with('produk')
            ->when(
                array_key_exists((string) $status, ProdukBludPenawaran::STATUSES),
                fn ($query) => $query->where('status', $status),
            )
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('nama', 'like', "%{$search}%")
                        ->orWhere('kontak', 'like', "%{$search}%")
                        ->orWhere('pesan', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = ProdukBludPenawaran::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.blud.pesanan.index', [
            'pesanans' => $pesanans,
            'statuses' => ProdukBludPenawaran::STATUSES,
            'counts' => $counts,
            'status' => $status,
            'search' => $search,
        ]);
    }

    public function show(ProdukBludPenawaran $pesanan): View
    {
        $pesanan->load(['produk', 'penangan']);

        return view('admin.blud.pesanan.show', [
            'pesanan' => $pesanan,
            'statuses' => ProdukBludPenawaran::STATUSES,
            'waUrl' => $this->whatsappUrl($pesanan->kontak, $pesanan->nama),
        ]);
    }

    public function update(UpdatePesananBludRequest $request, ProdukBludPenawaran $pesanan): RedirectResponse
    {
        $pesanan->update([
            ...$request->validated(),
            'ditangani_oleh' => $request->user()->id,
        ]);

        return redirect()->route('admin.pesanan-blud.show', $pesanan)
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(ProdukBludPenawaran $pesanan): RedirectResponse
    {
        $pesanan->delete();

        return redirect()->route('admin.pesanan-blud.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    /**
     * Bangun tautan wa.me dari kontak; null bila kontak bukan nomor telepon.
     */
    protected function whatsappUrl(string $kontak, string $nama): ?string
    {
        $digits = preg_replace('/\D+/', '', $kontak);

        if ($digits === '' || strlen($digits) < 8) {
            return null;
        }

        if (Str::startsWith($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        $text = rawurlencode("Halo {$nama}, kami dari BLUD SMKN 1 Surabaya menindaklanjuti pesanan Anda.");

        return "https://wa.me/{$digits}?text={$text}";
    }
}
