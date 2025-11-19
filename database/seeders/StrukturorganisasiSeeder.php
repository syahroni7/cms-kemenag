<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Strukturorganisasi;

class StrukturorganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Pimpinan utama
        $kepala = Strukturorganisasi::create([
            'nama' => 'Kepala Kantor',
            'jabatan' => 'Kepala Kantor',
            'foto' => 'kepala.png',
            'tipe' => 'struktural'
        ]);

        // Kasubbag TU
        $kasub = Strukturorganisasi::create([
            'nama' => 'Kasubbag',
            'jabatan' => 'Kasubbag TU',
            'foto' => 'kasub.png',
            'parent_id' => $kepala->id,
            'tipe' => 'struktural'
        ]);

        // Para Kasie (6 orang)
        $kasieList = [
            ['nama' => 'Kasie 1', 'jabatan' => 'Kasie Pendidikan Madrasah'],
            ['nama' => 'Kasie 2', 'jabatan' => 'Kasie Pendidikan Islam'],
            ['nama' => 'Kasie 3', 'jabatan' => 'Kasie Pd Pontren'],
            ['nama' => 'Kasie 4', 'jabatan' => 'Kasie Haji dan Umrah'],
            ['nama' => 'Kasie 5', 'jabatan' => 'Kasie Bimas Islam'],
            ['nama' => 'Kasie 6', 'jabatan' => 'Kasie Zakat dan Wakaf'],
        ];

        foreach ($kasieList as $k) {
            Strukturorganisasi::create([
                'nama' => $k['nama'],
                'jabatan' => $k['jabatan'],
                'parent_id' => $kasub->id,
                'tipe' => 'struktural'
            ]);
        }

        // Jabatan Fungsional
        Strukturorganisasi::create([
            'nama' => 'Fungsional 1',
            'jabatan' => 'Jabatan Fungsional',
            'foto' => null,
            'tipe' => 'fungsional'
        ]);
    }
}
