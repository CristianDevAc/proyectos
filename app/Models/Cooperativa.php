<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooperativa extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion'];

    public function cargas()
    {
        return $this->hasMany(Carga::class);
    }
}