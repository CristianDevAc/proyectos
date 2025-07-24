<?php

namespace App\Http\Controllers;

use App\Models\ConcesionMina;
use Illuminate\Http\Request;

class ConcesionMinaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:concesion_minas,codigo',
            'mina' => 'required|string',
            'municipio_id' => 'required|exists:municipios,id',
        ]);

        $concesion = ConcesionMina::create([
            'codigo' => $request->codigo,
            'mina' => $request->mina,
            'municipio_id' => $request->municipio_id
        ]);

        return response()->json([
            'success' => true,
            'concesion' => $concesion,
            'message' => 'Concesión registrada correctamente'
        ]);
    }
    public function index()
    {
        return ConcesionMina::all();
    }
}
