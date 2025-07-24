<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MuestraLaboratorio extends Model
{
    protected $table = 'muestra_laboratorio';
    protected $fillable = [
        'carga_id',
        'laboratorio_id',
        'fecha_muestra',
        'tipo',
        'estado',
        'observaciones',
        'imagen_certificado'
    ];

    protected $casts = [
        'fecha_muestra' => 'date',
    ];

    public function carga()
    {
        return $this->belongsTo(Carga::class);
    }

    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class);
    }

    public function detalles()
    {
        return $this->hasMany(MuestraLaboratorioDetail::class);
    }
 
}
