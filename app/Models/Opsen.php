<?php

namespace App\Models;

use App\Models\Trnkb;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opsen extends Model
{
    use HasFactory;

    // Set the table name if it's not the plural form of the model name
    protected $table = 'cweb_t_opsen';

    // Set the primary key if it's not 'id'
    protected $primaryKey = 'no_trn';

    // Indicate if the primary key is not an incrementing integer
    public $incrementing = false;

    // Set the data type of the primary key if it's not an integer
    protected $keyType = 'string';

    // Disable timestamps if the table does not have 'created_at' and 'updated_at'
    public $timestamps = false;

    // Fillable properties for mass assignment
    // Make all fields fillable
    protected $fillable = ['*']; // Allow mass assignment for all fields

    public function trnkb()
    {
        return $this->belongsTo(Trnkb::class, 'no_trn', 'no_trn'); // Use 'no_trn' for relation
    }
}