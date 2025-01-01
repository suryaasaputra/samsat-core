<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{

    protected $connection = 'induk';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cweb_t_printer';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'term_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'term_id',
        'printer_terminal',
        'act',
        'pdf_path',
    ];

}
