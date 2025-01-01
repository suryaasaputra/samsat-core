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
    protected $table = 't_lokasi';
    protected $connection;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'kd_lokasi';

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
        'kd_lokasi',
        'nm_lokasi',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the connection based on the user's kd_wilayah
        $this->connection = \Auth::user()->kd_wilayah;
    }

    /**
     * Relationship to Users.
     */

    public function users()
    {
        return $this->hasMany(User::class, 'kd_lokasi', 'kd_lokasi');
    }
}
