<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'super_administrator',
            'admin_instansi', 
            'redaktur',
            'editor',
            'kontributor',
            'viewer'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $this->command->info(count($roles) . ' roles seeded successfully!');
    }
}