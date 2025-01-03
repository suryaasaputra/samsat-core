<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinAng extends Model
{
    use HasFactory;

    protected $table = 't_izin_ang';
    protected $primaryKey = 'no_polisi'; // Define the string primary key
    public $incrementing = false; // Disable auto-increment (for string primary key)
    protected $keyType = 'string'; // Specify that the primary key is a string
    // Disable timestamps if the table does not have 'created_at' and 'updated_at'
    public $timestamps = false;

    // Make all fields fillable
    protected $fillable = [
        'no_polisi',
        'kd_kb_umum',
        'kd_wilayah',
        'no_siup',
        'str_no_siup',
        'tg_siup',
        'mb_siup',
        'kd_izin_ang',
        'no_izin_ang',
        'str_no_izin_ang',
        'tg_izin_ang',
        'mb_izin_ang',
        'no_kir',
        'str_no_kir',
        'tg_kir',
        'mb_kir',
        'kd_lokasi',
        'user_id',
        'tg_proses',
    ]; // Allow mass assignment for all fields

}