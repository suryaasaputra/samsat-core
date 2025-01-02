<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tera extends Model
{
    use HasFactory;

    protected $table = 't_tera'; // Define the table name

    protected $primaryKey = 'no_trn'; // Define the string primary key
    public $incrementing = false; // Disable auto-increment (for string primary key)
    protected $keyType = 'string'; // Specify that the primary key is a string
    // Disable timestamps if the table does not have 'created_at' and 'updated_at'
    public $timestamps = false;

    // Make all fields fillable
    protected $fillable = ["no_trn",
        "no_polisi",
        "tg_daftar",
        "kd_notice",
        "user_id",
        "kd_kasir",
        "jml_byr",
        "tg_tera",
        "no_tera",
        "cap_tera",
        "flag_tera"]; // Allow mass assignment for all fields
}
