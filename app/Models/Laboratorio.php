<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    protected $fillable = ['nombre', 'responsable', 'telefono', 'direccion'];

    public function muestras()
    {
        return $this->hasMany(MuestraLaboratorio::class);
    }
}