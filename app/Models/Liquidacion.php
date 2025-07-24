<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    protected $table = 'liquidaciones';

    protected $fillable = [
        'carga_id',
        'fecha_liquidacion',
        'peso_humedo',
        'humedad',
        'peso_seco',
        'valor_tonelada_bs',
        'importe_total',
        'valor_bruto_compra',
        'total_deducciones',
        'cotizacion_dolar',
        'liquido_pagable',
        'total_regalia',
        'muestra',
    ];
    protected $casts = [
        'fecha_liquidacion' => 'datetime',
    ];

    // Relación: una liquidación pertenece a una carga
    public function carga()
    {
        return $this->belongsTo(Carga::class);
    }

    // Relación: muchas a muchas con contribuciones (si sigues usando contribuciones asociadas)
    public function contribuciones()
    {
        return $this->belongsToMany(Contribucion::class, 'contribucion_liquidacion')
                    ->withPivot('porcentaje', 'precio')
                    ->withTimestamps();
    }
    public function muestraSeleccionada()
    {
        return $this->belongsTo(MuestraLaboratorio::class, 'muestra');
    }
    public function minerales()
    {
        return $this->belongsToMany(Mineral::class, 'leyes_minerales_liquidacion')
                    ->withPivot('ley')
                    ->withTimestamps();
    }
}