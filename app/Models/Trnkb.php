<?php

namespace App\Models;

use App\Models\Bbm;
use App\Models\FungsiKb;
use App\Models\IzinAng;
use App\Models\JenisMilik;
use App\Models\Lokasi;
use App\Models\NoHp;
use App\Models\Notice;
use App\Models\Opsen;
use App\Models\Plat;
use App\Models\Tera;
use App\Models\Wilayah;
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // Dynamically set the connection based on the user's kd_wilayah

    }

    public function opsen()
    {
        return $this->hasOne(Opsen::class, 'no_trn', 'no_trn'); // Use 'no_trn' for relation
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'kd_wilayah', 'kd_wilayah');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'kd_lokasi', 'kd_lokasi');
    }

    public function plat()
    {
        return $this->belongsTo(Plat::class, 'kd_plat', 'kd_plat');
    }
    public function bbm()
    {
        return $this->belongsTo(Bbm::class, 'kd_bbm', 'kd_bbm');
    }

    public function fungsikb()
    {
        return $this->belongsTo(FungsiKb::class, 'kd_fungsi', 'kd_fungsi');
    }

    public function jenismilik()
    {
        return $this->belongsTo(JenisMilik::class, 'kd_jen_milik', 'kd_jen_milik');
    }
    public function izinang()
    {
        return $this->belongsTo(IzinAng::class, 'no_polisi', 'no_polisi');
    }

    public function nohp()
    {
        return $this->belongsTo(NoHp::class, 'no_polisi', 'no_polisi');
    }

    public function tera()
    {
        return $this->belongsTo(Tera::class, 'no_trn', 'no_trn');
    }

    public function notice()
    {
        return $this->belongsTo(Notice::class, 'no_trn', 'no_trn');
    }

}
