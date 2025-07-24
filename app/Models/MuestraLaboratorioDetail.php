<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuestraLaboratorioDetail extends Model
{
    protected $table = 'muestra_laboratorio_detail';
    protected $fillable = [
        'muestra_laboratorio_id',
        'mineral_id',
        'humedad',
        'ley'
    ];

    public function muestraLaboratorio()
    {
        return $this->belongsTo(MuestraLaboratorio::class);
    }

    public function mineral()
    {
        return $this->belongsTo(Mineral::class);
    }
}
