<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camion extends Model
{
    use HasFactory;
    protected $table = 'camiones';

    protected $fillable = ['placa','pesaje','descripcion']; // muy importante

    public function cargas()
    {
        return $this->hasMany(Carga::class);
    }
}
