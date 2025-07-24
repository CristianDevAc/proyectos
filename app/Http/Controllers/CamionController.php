<?php

namespace App\Http\Controllers;

use App\Models\Camion;
use Illuminate\Http\Request;

class CamionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxStore(Request $request)
    {
        $request->validate([
            'placa' => 'required|unique:camiones,placa',
            'pesaje' => 'required|numeric',
            'descripcion' => 'nullable|string',
        ]);

        $camion = Camion::create([
            'placa' => $request->placa,
            'pesaje' => $request->pesaje,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json([
            'success' => true,
            'camion' => $camion,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Camion  $camion
     * @return \Illuminate\Http\Response
     */
    public function show(Camion $camion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Camion  $camion
     * @return \Illuminate\Http\Response
     */
    public function edit(Camion $camion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Camion  $camion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Camion $camion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Camion  $camion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Camion $camion)
    {
        //
    }
}
