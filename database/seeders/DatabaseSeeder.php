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
        $this->call([
            // ── Seeder manual (firstOrCreate / updateOrCreate, aman di-rerun) ──
            RoleSeeder::class,
            UserSeeder::class,
            SiswaSeeder::class,
            MenuSeeder::class,
            RoleMenuSeeder::class,

            // ── Seeder iseed (data real dari DB) ──────────────────────────────
            AppSekolahTableSeeder::class,
            GuruSekolahTableSeeder::class,
            AppSiswaTableSeeder::class,
        ]);
    }
}
