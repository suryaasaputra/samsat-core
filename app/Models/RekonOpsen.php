<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekonOpsen extends Model
{
    use HasFactory;
    protected $table = 'cweb_rekon_opsen'; // Define table name if different

    protected $fillable = [
        'tgl_trn',
        'kd_upt',
        'kd_wilayah',
        'kd_ref',
        'jml_trf',
        'keterangan',
        'file_path',
    ];
}
