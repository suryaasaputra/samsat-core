<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RekonOpsenSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 0; $i <= 10; $i++) {
            $data[] = [
                'tgl_trn'    => Carbon::yesterday(),     // Tanggal acak dalam 30 hari terakhir
                'kd_upt'     => '01.00',                 // Contoh kode UPT
                'kd_wilayah' => '00' . $i,               // Kode wilayah acak
                'kd_ref'     => Str::random(10),         // Random string 5 karakter
                'jml_trf'    => rand(1000000, 50000000), // Jumlah transfer acak
                'keterangan' => '',
                'file_path'  => 'uploads/files/file' . $i . '.pdf',
                'created_at' => Carbon::yesterday(),
                'updated_at' => Carbon::yesterday(),
            ];
        }

        DB::table('cweb_rekon_opsen')->insert($data);
    }
}
