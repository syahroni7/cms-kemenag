<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('access_type')->insert([
            [
                'code' => 'superadmin',
                'name' => 'Super Administrator',
                'description' => 'Memiliki seluruh akses sistem',
            ],
            [
                'code' => 'admin',
                'name' => 'Administrator',
                'description' => 'Mengelola modul utama sistem',
            ],
            [
                'code' => 'publisher',
                'name' => 'Publisher',
                'description' => 'Mempublikasikan konten',
            ],
            [
                'code' => 'author',
                'name' => 'Author',
                'description' => 'Menulis dan mengelola konten',
            ],
        ]);
    }
}
