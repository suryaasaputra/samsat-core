<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_wilayah')->insert([
            'kd_wilayah' => '001',
            'nm_wilayah' => 'Kota Jambi',
        ]);
    }
}
