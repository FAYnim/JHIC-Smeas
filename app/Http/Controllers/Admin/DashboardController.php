<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Artikel;
use App\Models\CalonSiswa;
use App\Models\Lowongan;
use App\Models\MagangApplication;
use App\Models\MitraPerusahaan;
use App\Models\ProdukBlud;
use App\Models\ProdukBludKomentar;
use App\Models\ProdukBludLaporkan;
use App\Models\ProdukBludPenawaran;
use App\Models\User;
use App\Models\Webinar;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('admin.dashboard', [
            'stats' => $this->statsFor($user),
            'recentLowongans' => $this->canSeePusatKarir($user)
                ? Lowongan::query()->latest()->limit(5)->get()
                : collect(),
            'recentArticles' => $this->canSeeContent($user)
                ? Artikel::query()->latest('published_at')->limit(5)->get()
                : collect(),
            'recentCalonSiswa' => $this->canSeeSpmb($user)
                ? CalonSiswa::query()->latest()->limit(5)->get()
                : collect(),
            'recentPesanans' => $this->canSeeBlud($user)
                ? ProdukBludPenawaran::with('produk')->where('status', ProdukBludPenawaran::STATUS_BARU)->latest()->limit(5)->get()
                : collect(),
            'pendingLaporans' => $this->canSeeBlud($user)
                ? ProdukBludLaporkan::with('produk')->where('status', ProdukBludLaporkan::STATUS_BARU)->latest()->limit(5)->get()
                : collect(),
        ]);
    }

    /**
     * @return list<array{label: string, value: int, icon: string, tone: string}>
     */
    protected function statsFor(User $user): array
    {
        $stats = [];

        if ($this->canSeePusatKarir($user)) {
            $stats[] = [
                'label' => 'Total Lowongan',
                'value' => Lowongan::query()->count(),
                'icon' => 'briefcase',
                'tone' => 'blue',
            ];
            $stats[] = [
                'label' => 'Lamaran Menunggu',
                'value' => MagangApplication::query()->where('status', 'pending')->count(),
                'icon' => 'inbox',
                'tone' => 'amber',
            ];
            $stats[] = [
                'label' => 'Mitra DUDI',
                'value' => MitraPerusahaan::query()->count(),
                'icon' => 'building-2',
                'tone' => 'emerald',
            ];
            $stats[] = [
                'label' => 'Total Alumni',
                'value' => Alumni::query()->count(),
                'icon' => 'graduation-cap',
                'tone' => 'violet',
            ];
        }

        if ($this->canSeeContent($user)) {
            $stats[] = [
                'label' => 'Total Artikel',
                'value' => Artikel::query()->count(),
                'icon' => 'newspaper',
                'tone' => 'blue',
            ];
            $stats[] = [
                'label' => 'Total Webinar',
                'value' => Webinar::query()->count(),
                'icon' => 'video',
                'tone' => 'amber',
            ];
        }

        if ($this->canSeeSpmb($user)) {
            $stats[] = [
                'label' => 'Total Calon Siswa',
                'value' => CalonSiswa::query()->count(),
                'icon' => 'graduation-cap',
                'tone' => 'emerald',
            ];
            $stats[] = [
                'label' => 'Menunggu Verifikasi',
                'value' => CalonSiswa::query()->where('status_verifikasi', 'menunggu')->count(),
                'icon' => 'inbox',
                'tone' => 'amber',
            ];
        }

        if ($this->canSeeBlud($user)) {
            $stats[] = [
                'label' => 'Pesanan Baru',
                'value' => ProdukBludPenawaran::query()->where('status', ProdukBludPenawaran::STATUS_BARU)->count(),
                'icon' => 'shopping-cart',
                'tone' => 'amber',
            ];
            $stats[] = [
                'label' => 'Laporan Belum Ditangani',
                'value' => ProdukBludLaporkan::query()->where('status', ProdukBludLaporkan::STATUS_BARU)->count(),
                'icon' => 'flag',
                'tone' => 'violet',
            ];
            $stats[] = [
                'label' => 'Komentar Baru',
                'value' => ProdukBludKomentar::query()->where('status', ProdukBludKomentar::STATUS_BARU)->count(),
                'icon' => 'message-square',
                'tone' => 'emerald',
            ];
            $stats[] = [
                'label' => 'Total Produk',
                'value' => ProdukBlud::query()->count(),
                'icon' => 'shopping-bag',
                'tone' => 'blue',
            ];
        }

        if ($user->isAdmin()) {
            $stats[] = [
                'label' => 'Total Pengguna',
                'value' => User::query()->count(),
                'icon' => 'shield',
                'tone' => 'violet',
            ];
        }

        return $stats;
    }

    protected function canSeePusatKarir(User $user): bool
    {
        return $user->hasRole([User::ROLE_BKK]);
    }

    protected function canSeeContent(User $user): bool
    {
        return $user->hasRole([User::ROLE_HUMAS]);
    }

    protected function canSeeSpmb(User $user): bool
    {
        return $user->hasRole([User::ROLE_SPMB]);
    }

    protected function canSeeBlud(User $user): bool
    {
        return $user->hasRole([User::ROLE_BLUD]);
    }
}
