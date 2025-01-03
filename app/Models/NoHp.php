<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoHp extends Model
{
    use HasFactory;

    protected $connection = 'induk'; // Define the connection name
    protected $table = 't_no_hp';
    protected $primaryKey = 'no_polisi'; // Define the string primary key
    public $incrementing = false; // Disable auto-increment (for string primary key)
    protected $keyType = 'string'; // Specify that the primary key is a string
    // Disable timestamps if the table does not have 'created_at' and 'updated_at'
    public $timestamps = false;

    // Make all fields fillable
    protected $fillable = [
        'no_polisi',
        'no_hp',
    ]; // Allow mass assignment for all fields

}