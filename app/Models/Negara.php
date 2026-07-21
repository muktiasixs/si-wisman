<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negara extends Model
{
    use HasFactory;

    protected $table = 'negara';
    protected $primaryKey = 'id_negara';
    public $timestamps = false;

    protected $guarded = [];

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'id_negara_asal', 'id_negara');
    }
}
