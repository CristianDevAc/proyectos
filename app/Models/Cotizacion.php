<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    protected $table = 'cotizaciones';

    protected $fillable = [
        'mineral_id',
        'quincena',
        'gestion',
        'mes',
        'valor',
    ];

    public function mineral()
    {
        return $this->belongsTo(Mineral::class);
    }
}