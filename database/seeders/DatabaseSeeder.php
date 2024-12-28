<?php

namespace Database\Seeders;

use Database\Seeders\LokasiSeeder;
use Database\Seeders\WilayahSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            WilayahSeeder::class,
            LokasiSeeder::class,
        ]);
    }
}
