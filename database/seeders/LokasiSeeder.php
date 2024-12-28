<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_lokasi')->insert([
            'kd_lokasi' => '01.00',
            'nm_lokasi' => 'Samsat Induk Kota Jambi',
        ]);
    }
}
