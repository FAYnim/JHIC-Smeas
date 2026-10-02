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

        if ($user->isAdmin()) {
            $stats[] = [
                'label' => 'Total Pengguna',
                'value' => User::query()->count(),
                'icon' => 'shield',
                'tone' => 'violet',
            ];
            $stats[] = [
                'label' => 'Produk BLUD',
                'value' => ProdukBlud::query()->count(),
                'icon' => 'shopping-bag',
                'tone' => 'blue',
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
}
