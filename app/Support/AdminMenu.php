<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Route;

class AdminMenu
{
    /**
     * Definisi menu sidebar admin.
     *
     * Route modul Fase 2–4 belum ada; availableItemsFor()
     * menyaring item yang route-nya belum terdaftar agar `route()` tidak
     * melempar exception.
     *
     * @var list<array{group: string, label: string, route: string, icon: string, roles: list<string>}>
     */
    private const ITEMS = [
        [
            'group' => 'Umum',
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'layout-grid',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BKK, User::ROLE_HUMAS, User::ROLE_SPMB],
        ],
        [
            'group' => 'Umum',
            'label' => 'Artikel',
            'route' => 'admin.artikel.index',
            'icon' => 'newspaper',
            'roles' => [User::ROLE_ADMIN, User::ROLE_HUMAS],
        ],
        [
            'group' => 'Pusat Karir',
            'label' => 'Lowongan',
            'route' => 'admin.lowongan.index',
            'icon' => 'briefcase',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BKK],
        ],
        [
            'group' => 'Pusat Karir',
            'label' => 'Lamaran Magang',
            'route' => 'admin.lamaran.index',
            'icon' => 'inbox',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BKK],
        ],
        [
            'group' => 'Pusat Karir',
            'label' => 'Mitra DUDI',
            'route' => 'admin.mitra.index',
            'icon' => 'building-2',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BKK],
        ],
        [
            'group' => 'Pusat Karir',
            'label' => 'Bimbingan Karir',
            'route' => 'admin.bimbingan.index',
            'icon' => 'academic-cap',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BKK],
        ],
        [
            'group' => 'Pusat Karir',
            'label' => 'Tracer Study',
            'route' => 'admin.tracer.index',
            'icon' => 'chart-bar',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BKK],
        ],
        [
            'group' => 'Profil Sekolah',
            'label' => 'Guru & Tendik',
            'route' => 'admin.guru.index',
            'icon' => 'users',
            'roles' => [User::ROLE_ADMIN, User::ROLE_HUMAS],
        ],
        [
            'group' => 'SPMB',
            'label' => 'Calon Siswa',
            'route' => 'admin.calon-siswa.index',
            'icon' => 'graduation-cap',
            'roles' => [User::ROLE_ADMIN, User::ROLE_SPMB],
        ],
        [
            'group' => 'Sistem',
            'label' => 'Pengguna',
            'route' => 'admin.users.index',
            'icon' => 'shield',
            'roles' => [User::ROLE_ADMIN],
        ],
        [
            'group' => 'Sistem',
            'label' => 'Pengaturan',
            'route' => 'admin.settings.edit',
            'icon' => 'settings',
            'roles' => [User::ROLE_ADMIN],
        ],
    ];

    /**
     * @return list<array{group: string, label: string, route: string, icon: string, roles: list<string>}>
     */
    public static function itemsFor(?User $user): array
    {
        if ($user === null) {
            return [];
        }

        if ($user->isAdmin()) {
            return array_map(
                fn (array $item): array => array_merge($item, ['roles' => [$user->role]]),
                self::ITEMS,
            );
        }

        return array_values(array_filter(
            self::ITEMS,
            fn (array $item): bool => $user->hasRole($item['roles']),
        ));
    }

    /**
     * Hanya route yang benar-benar terdaftar, agar `route()` tidak gagal
     * untuk modul yang belum diimplementasikan.
     *
     * @return list<array{group: string, label: string, route: string, icon: string, roles: list<string>}>
     */
    public static function availableItemsFor(?User $user): array
    {
        return array_values(array_filter(
            self::itemsFor($user),
            fn (array $item): bool => Route::has($item['route']),
        ));
    }
}
