<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mineral extends Model
{
    use HasFactory;

    // Especificar el nombre correcto de la tabla
    protected $table = 'minerales';

    protected $fillable = [
        'simbolo',
        'nombre',
        'alicuota',
        'conversion',
    ];

    public function cargas()
    {
        return $this->belongsToMany(Carga::class, 'carga_mineral')
                    ->withPivot('porcentaje')
                    ->withTimestamps();
    }
    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }
    public function liquidaciones()
    {
        return $this->belongsToMany(Liquidacion::class, 'leyes_minerales_liquidacion')
                    ->withPivot('ley')
                    ->withTimestamps();
    }
}
