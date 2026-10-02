<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['name' => 'Administrator', 'email' => 'admin@smkn1.surabaya.sch.id', 'role' => User::ROLE_ADMIN],
            ['name' => 'BKK Pusat Karir', 'email' => 'bkk@smkn1.surabaya.sch.id', 'role' => User::ROLE_BKK],
            ['name' => 'Humas Sekolah', 'email' => 'humas@smkn1.surabaya.sch.id', 'role' => User::ROLE_HUMAS],
            ['name' => 'Panitia SPMB', 'email' => 'spmb@smkn1.surabaya.sch.id', 'role' => User::ROLE_SPMB],
        ];

        foreach ($accounts as $account) {
            User::query()->updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'role' => $account['role'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                ],
            );
        }
    }
}
