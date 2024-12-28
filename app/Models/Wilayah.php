<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_wilayah';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'kd_wilayah';

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
        'kd_wilayah',
        'nm_wilayah',
    ];

    /**
     * Relationship to Users.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'kd_wilayah', 'kd_wilayah');
    }
}
