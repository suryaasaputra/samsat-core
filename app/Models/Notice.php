<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $table = 't_notice'; // Define the table name

    protected $primaryKey = 'no_trn'; // Define the string primary key
    public $incrementing = false; // Disable auto-increment (for string primary key)
    protected $keyType = 'string'; // Specify that the primary key is a string
    // Disable timestamps if the table does not have 'created_at' and 'updated_at'
    public $timestamps = false;

    // Make all fields fillable
    protected $fillable = [
        'no_trn',
        'kd_lokasi',
        'no_polisi',
        'tg_daftar',
        'no_urut_trn',
        'tg_cetak',
        'no_notice',
        'kd_notice',
        'jml_tetap',
        'user_id',
        'flag_notice',
        'catatan',
    ];
}