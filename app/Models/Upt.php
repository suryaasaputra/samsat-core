<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_nm_upt';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'kd_upt';

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
        'kd_upt',
        'nm_upt',
    ];

}
