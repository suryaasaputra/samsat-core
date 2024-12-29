<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    use HasFactory;

    protected $table = 't_plat';
    protected $primaryKey = 'kd_plat'; // Define the string primary key
    public $incrementing = false; // Disable auto-increment (for string primary key)
    protected $keyType = 'string'; // Specify that the primary key is a string
    // Disable timestamps if the table does not have 'created_at' and 'updated_at'
    public $timestamps = false;

    // Make all fields fillable
    protected $fillable = ['*']; // Allow mass assignment for all fields

}