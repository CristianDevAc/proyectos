<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    use HasFactory;


    protected $fillable = [
        'cooperativa_id',
        'camion_id',
        'concesion_mina_id',
        'plataforma_id',
        'lote',
        'peso_tara',
        'peso_bruto',
        'peso_neto',
        'numero_boleta',
        'observaciones',
        'cantidad_sacos',
        'estado',
        'tipo',
        'producto',
        'fecha_registro',
    ];
    protected $casts = [
        'fecha_registro' => 'date',
    ];

    public function cooperativa()
    {
        return $this->belongsTo(Cooperativa::class);
    }
    public function camion()
    {
        return $this->belongsTo(Camion::class);
    }
    public function concesionMina()
    {
        return $this->belongsTo(ConcesionMina::class);
    }

    public function plataforma()
    {
        return $this->belongsTo(Plataforma::class);
    }
    public function minerales()
    {
        return $this->belongsToMany(Mineral::class, 'carga_mineral')->withTimestamps();
    }

    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'carga_persona')
                    ->withPivot('tipo')
                    ->withTimestamps();
    }
    public function muestrasLaboratorio()
    {
        return $this->hasMany(MuestraLaboratorio::class);
    }
    public function lotes()
    {
        return $this->belongsToMany(Lote::class, 'carga_lote')->withTimestamps();
    }
   
}
