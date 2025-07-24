<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $fillable = [
        'documento',
        'nombre_completo',
        'direccion',
        'codigo',
        'telefono',
    ];


    public function cargas()
    {
        return $this->belongsToMany(Carga::class, 'carga_persona')
                    ->withPivot('tipo')
                    ->withTimestamps();
                    
    }
    
}
