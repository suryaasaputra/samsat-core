<?php

namespace App\Models;

use App\Models\Opsen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trnkb extends Model
{
    use HasFactory;

    protected $table = 't_trnkb';
    protected $primaryKey = 'no_trn'; // Define the string primary key
    public $incrementing = false; // Disable auto-increment (for string primary key)
    protected $keyType = 'string'; // Specify that the primary key is a string
    // Disable timestamps if the table does not have 'created_at' and 'updated_at'
    public $timestamps = false;

    // Make all fields fillable
    protected $fillable = ['*']; // Allow mass assignment for all fields

    public function opsen()
    {
        return $this->hasOne(Opsen::class, 'no_trn', 'no_trn'); // Use 'no_trn' for relation
    }
}