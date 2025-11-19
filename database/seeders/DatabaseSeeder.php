<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seeder database aplikasi.
     */
    public function run(): void
    {
        $this->call([
            AccessTypeSeeder::class,
            KontakSeeder::class,
            MenuSeeder::class,
            SocialMediaSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            StrukturorganisasiSeeder::class,
        ]);
    }
}
