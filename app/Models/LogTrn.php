<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogTrn extends Model
{
    // Define the table name
    protected $table = 't_log_trn';

    // Define the primary key
    protected $primaryKey = 'no_trn';

    // Indicate if the primary key is not auto-incrementing
    public $incrementing = false;

    // Specify the key type (string in this case)
    protected $keyType = 'string';

    // Disable timestamps if `created_at` and `updated_at` are not present
    public $timestamps = false;

    // Define fillable columns for mass assignment
    protected $fillable = [
        'no_trn', 'no_polisi', 'tg_daftar', 'kd_lokasi', 'kd_proses',
        'kd_status', 'jam_proses', 'term_id', 'user_id',
    ];
}
