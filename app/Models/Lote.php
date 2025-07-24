<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes';
    protected $fillable = [
        'codigo',
        'estado',
        'fecha_exportacion',
        'observacion',
    ];

    // Relación: un lote contiene muchas cargas
    public function cargas()
    {
        return $this->belongsToMany(Carga::class, 'carga_lote')->withTimestamps();
    }
}
