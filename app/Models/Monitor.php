<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    use HasFactory;

    protected $connection = 'induk';
    protected $table = 't_monitor'; // Define the table name

    protected $primaryKey = 'no_trn'; // Define the string primary key
    public $incrementing = false; // Disable auto-increment (for string primary key)
    protected $keyType = 'string'; // Specify that the primary key is a string
    // Disable timestamps if the table does not have 'created_at' and 'updated_at'
    public $timestamps = false;

    // Make all fields fillable
    protected $fillable = ["no_trn",
        "no_polisi",
        "tg_daftar",
        "kd_lokasi",
        'kd_upt',
        'kd_proses',
        'tg_proses',
        'jam_proses',
        'jml_pkb',
        'jml_bbn1',
        'jml_bbn2',
        'jml_swd',
        'tg_bayar',
        'kd_status']; // Allow mass assignment for all fields
}
