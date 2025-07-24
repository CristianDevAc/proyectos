<?php

namespace App\Http\Controllers;

use App\Models\Cooperativa;
use Illuminate\Http\Request;

class CooperativaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:cooperativas,nombre',
            'descripcion' => 'nullable|string'
        ]);

        $cooperativa = Cooperativa::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        return response()->json([
            'success' => true,
            'cooperativa' => $cooperativa,
            'message' => 'Cooperativa registrada correctamente'
        ]);
    }

    public function index()
    {
        return Cooperativa::all();
    }

}
