<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use Illuminate\Http\Request;

class LaboratorioController extends Controller
{
    public function index()
    {
        $laboratorios = Laboratorio::latest()->paginate(10);
        return view('laboratorios.index', compact('laboratorios'));
    }

    public function create()
    {
        return view('laboratorios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'telefono'    => 'nullable|string|max:20',
            'direccion'   => 'nullable|string|max:255',
        ]);

        Laboratorio::create($request->all());

        return redirect()->route('laboratorios.index')->with('success', 'Laboratorio registrado correctamente.');
    }
    public function ajaxStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'telefono' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
        ]);

        $laboratorio = Laboratorio::create($request->all());

        return response()->json([
            'success' => true,
            'laboratorio' => $laboratorio,
        ]);
    }

    public function edit(Laboratorio $laboratorio)
    {
        return view('laboratorios.edit', compact('laboratorio'));
    }

    public function update(Request $request, Laboratorio $laboratorio)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'telefono'    => 'nullable|string|max:20',
            'direccion'   => 'nullable|string|max:255',
        ]);

        $laboratorio->update($request->all());

        return redirect()->route('laboratorios.index')->with('success', 'Laboratorio actualizado correctamente.');
    }

    public function destroy(Laboratorio $laboratorio)
    {
        $laboratorio->delete();

        return redirect()->route('laboratorios.index')->with('success', 'Laboratorio eliminado correctamente.');
    }
}