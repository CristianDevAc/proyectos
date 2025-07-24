<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroAcopio extends Model
{
    use HasFactory;
    public function plataformas()
    {
        return $this->hasMany(Plataforma::class);
    }
}
