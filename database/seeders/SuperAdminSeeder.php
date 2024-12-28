<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'username' => 'super_admin',
            'email' => 'superadmin@gmail.com',
            'kd_wilayah' => '001',
            'kd_lokasi' => '01.00',
            'password' => Hash::make('samsat1234'),
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'kd_wilayah' => '001',
            'kd_lokasi' => '01.00',
            'password' => Hash::make('samsat1234'),
        ]);
        $admin->assignRole('Admin');

        // Creating Product Manager User
        $kasirBpd = User::create([
            'name' => 'Kasir Bank Jambi',
            'username' => 'kasir',
            'email' => 'kasir@gmail.com',
            'kd_wilayah' => '001',
            'kd_lokasi' => '01.00',
            'password' => Hash::make('samsat1234'),
        ]);
        $kasirBpd->assignRole('Kasir Bank Jambi');
    }
}
