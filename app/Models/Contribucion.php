<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribucion extends Model
{

    protected $table = 'contribuciones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'inicial',
        'valor',
    ];

    // Relación: muchas a muchas con liquidaciones
    public function liquidaciones()
    {
        return $this->belongsToMany(Liquidacion::class, 'contribucion_liquidacion')
                    ->withPivot('porcentaje', 'precio')
                    ->withTimestamps();
    }
}