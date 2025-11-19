<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // =======================
        // Roles
        // =======================
        $super_administrator = Role::firstOrCreate(['name' => 'super_administrator']);
        $administrator       = Role::firstOrCreate(['name' => 'administrator']);
        $publisher           = Role::firstOrCreate(['name' => 'publisher']);
        $author              = Role::firstOrCreate(['name' => 'author']);


        // =======================
        // Permissions (Sesuai Sidebar)
        // =======================
        $permissions = [

            // ==== MENU ====
            'menu-dashboard',
            'menu-main',
            'menu-disposisi',
            'menu-pelayanan',
            'menu-arsip',
            'menu-layanan',
            'menu-report',

            // ==== DASHBOARD ====
            'page-dashboard',

            // ==== MAIN (Kelola Data Utama) ====
            'page-main-permission',
            'page-main-user-data',
            'page-main-user-role',
            'page-main-unit_pengolah',

            // ==== DISPOSISI ====
            'page-disposisi-list',
            'page-disposisi-master',

            // ==== PELAYANAN ====
            'page-pelayanan-input',
            'page-pelayanan-list',

            // ==== ARSIP ====
            'page-arsip-pelayanan',

            // ==== LAYANAN ====
            'page-layanan-jenis',
            'page-layanan-output',
            'page-layanan-daftar',
            'page-layanan-syarat-master',
            'page-layanan-syarat-list',

            // ==== REPORT ====
            'page-report-layanan',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }


        // =======================
        // Assign Permission ke Roles
        // =======================

        // SUPER ADMIN → Full Access
        $super_administrator->syncPermissions(Permission::all());

        // ADMIN → Hampir semua
        $administrator->syncPermissions([
            'menu-dashboard', 'page-dashboard',

            'menu-main',
            'page-main-permission', 'page-main-user-data',
            'page-main-user-role', 'page-main-unit_pengolah',

            'menu-pelayanan',
            'page-pelayanan-input', 'page-pelayanan-list',

            'menu-arsip',
            'page-arsip-pelayanan',

            'menu-layanan',
            'page-layanan-jenis', 'page-layanan-output',
            'page-layanan-daftar', 'page-layanan-syarat-master',
            'page-layanan-syarat-list',

            'menu-report',
            'page-report-layanan',
        ]);

        // PUBLISHER
        $publisher->syncPermissions([
            'menu-dashboard', 'page-dashboard',

            'menu-pelayanan',
            'page-pelayanan-input', 'page-pelayanan-list',

            'menu-arsip',
            'page-arsip-pelayanan',

            'menu-report',
            'page-report-layanan',
        ]);

        // AUTHOR
        $author->syncPermissions([
            'menu-dashboard', 'page-dashboard',

            'menu-pelayanan',
            'page-pelayanan-list',

            'menu-arsip',
            'page-arsip-pelayanan',

            'menu-disposisi',
            'page-disposisi-list', 'page-disposisi-master',

            'menu-layanan',
            'page-layanan-daftar', 'page-layanan-syarat-master',
            'page-layanan-syarat-list',
        ]);


        // =======================
        // Assign Roles ke User
        // =======================

        // Super Admin
        if ($user = User::where('username', '199605222025051001')->first()) {
            $user->assignRole('super_administrator');
        }

        // Admin
        if ($user = User::where('username', '198101212009121006')->first()) {
            $user->assignRole('administrator');
        }

        // Publisher
        $publisherUsers = [
            '197010051991031004',
        ];
        User::whereIn('username', $publisherUsers)
            ->get()->each(fn($user) => $user->assignRole('publisher'));

        // Author
        $authorUsers = [
            '199404032025051006',
        ];
        User::whereIn('username', $authorUsers)
            ->get()->each(fn($user) => $user->assignRole('author'));
    }
}
