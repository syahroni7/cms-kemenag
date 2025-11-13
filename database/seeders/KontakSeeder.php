<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KontakSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kontak')->insert([
            'nama_kantor' => 'Kantor Kemenag Lebak',
            'alamat' => 'Jl. Siliwangi No. 2 Rangkasbitung, Kel. Muara Ciujung Barat Kec. Rangkasbitung Kabupaten Lebak',
            'telepon' => '0252-201319',
            'email' => 'sekjen_416610@kemenag.go.id',
            'jam_operasional' => "Senin - Kamis 07.30 - 16.00\nIstirahat 12.00 - 13.00\nJumat 07.30 - 16.30",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
