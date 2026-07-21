<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';
    protected $primaryKey = 'id_kunjungan';
    public $timestamps = false;

    protected $fillable = [
        'id_kunjungan',
        'id_negara_asal',
        'id_negara_tujuan',
        'bulan',
        'jumlah',
    ];

    public function negaraAsal()
    {
        return $this->belongsTo(Negara::class, 'id_negara_asal', 'id_negara');
    }
}
