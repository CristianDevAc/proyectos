<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plataforma extends Model
{
    use HasFactory;
    public function centroAcopio()
    {
        return $this->belongsTo(CentroAcopio::class);
    }
    public function cargas()
    {
        return $this->hasMany(Carga::class);
    }
}
