<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call(MitraPerusahaanSeeder::class);
        $this->call(LowonganSeeder::class);
        $this->call(ArtikelSeeder::class);
        $this->call(WebinarSeeder::class);
        $this->call(BimbinganKarirSeeder::class);
        $this->call(CalonSiswaSeeder::class);
        $this->call(AlumniSeeder::class);
        $this->call(TracerSeeder::class);
        $this->call(ProdukBludSeeder::class);
    }
}
