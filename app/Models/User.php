<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'kd_wilayah', 'kd_lokasi', 'printer_term',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationship to Wilayah (t_wilayah).
     */
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'kd_wilayah', 'kd_wilayah');
    }

    /**
     * Relationship to Lokasi (t_lokasi).
     */
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'kd_lokasi', 'kd_lokasi');
    }
}
