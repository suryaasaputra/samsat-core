<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $kasirBpd = Role::create(['name' => 'Kasir Bank Jambi']);

        $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
            'create-role',
            'edit-role',
            'delete-role',
        ]);

        $kasirBpd->givePermissionTo([
            'bayar',
        ]);
    }
}
