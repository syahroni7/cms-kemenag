<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'access_type_id' => 1, // superadmin
                'name'        => 'super_administrator',
                'jabatan'     => 'Superadmin',
                'username'    => '199605222025051001',
                'email'       => 'superadmin@example.com',
                'password'    => Hash::make('password'),
                'block'       => 'no',
                'status'      => 'active',
                'created_by'  => 'system',
                'updated_by'  => 'system',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'access_type_id' => 2, // admin
                'name'        => 'administrator',
                'jabatan'     => 'Administrator',
                'username'    => '198101212009121006',
                'email'       => 'administrator@example.com',
                'password'    => Hash::make('password'),
                'block'       => 'no',
                'status'      => 'active',
                'created_by'  => 'system',
                'updated_by'  => 'system',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'access_type_id' => 3, // publisher
                'name'        => 'publisher',
                'jabatan'     => 'Publisher',
                'username'    => '197010051991031004',
                'email'       => 'publisher@example.com',
                'password'    => Hash::make('password'),
                'block'       => 'no',
                'status'      => 'active',
                'created_by'  => 'system',
                'updated_by'  => 'system',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'access_type_id' => 4, // author
                'name'        => 'author',
                'jabatan'     => 'Author',
                'username'    => '199404032025051006',
                'email'       => 'author@example.com',
                'password'    => Hash::make('password'),
                'block'       => 'no',
                'status'      => 'active',
                'created_by'  => 'system',
                'updated_by'  => 'system',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
