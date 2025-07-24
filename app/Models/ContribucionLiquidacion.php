<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContribucionLiquidacion extends Model
{
    protected $table = 'contribucion_liquidacion';

    protected $fillable = [
        'contribucion_id',
        'liquidacion_id',
        'porcentaje',
        'precio',
    ];
}