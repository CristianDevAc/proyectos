<?php

namespace App\Http\Controllers;

use App\Models\Contribucion;
use Illuminate\Http\Request;

class ContribucionController extends Controller
{
     public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'valor' => 'required|numeric|min:0',
        ]);

        $contribucion = Contribucion::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'valor' => $request->valor,
            'inicial' => 0, // Siempre como inicial 0 al registrar desde el modal
        ]);

        return response()->json(['success' => true, 'contribucion' => $contribucion]);
    }
    public function listar()
    {
        $contribuciones = Contribucion::all();

        return response()->json([
            'contribuciones' => $contribuciones
        ]);
    }
}