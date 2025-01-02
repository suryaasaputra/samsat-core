<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTrnkb extends Model
{
    use HasFactory;

    protected $table = 't_log_trnkb'; // Define the table name

    protected $primaryKey = 'no_trn'; // Define the string primary key
    public $incrementing = false; // Disable auto-increment (for string primary key)
    protected $keyType = 'string'; // Specify that the primary key is a string
    // Disable timestamps if the table does not have 'created_at' and 'updated_at'
    public $timestamps = false;

    // Make all fields fillable
    protected $fillable = ["no_trn",
        "no_polisi",
        "nopol_lama",
        "tg_daftar",
        "kd_mohon",
        "kd_proses",
        "jam_proses",
        "nm_merek_kb",
        "nm_model_kb",
        "nm_jenis_kb",
        "th_rakitan",
        "nilai_jual",
        "tg_akhir_pkb",
        "pkb_pok",
        "pkb_den",
        "bbn1_pok",
        "bbn1_den",
        "bbn2_pok",
        "bbn2_den",
        "swd_pok",
        "swd_den"]; // Allow mass assignment for all fields
}
