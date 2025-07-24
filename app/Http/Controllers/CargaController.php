<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use App\Models\Cooperativa;
use App\Models\Camion;
use App\Models\CentroAcopio;
use App\Models\Plataforma;
use App\Models\ConcesionMina;
use App\Models\Mineral;
use App\Models\Municipio;
use App\Models\Persona;
use Carbon\Carbon;

use App\Models\Cotizacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;


class CargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Carga::with(['plataforma', 'cooperativa', 'concesionMina', 'camion', 'personas', 'minerales']);

        // 🔍 Filtro por lote o nombre del proveedor
        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->where('lote', 'like', "%{$busqueda}%")
                ->orWhereHas('personas', function ($q) use ($busqueda) {
                    $q->where('nombre_completo', 'like', "%{$busqueda}%");
                });
        }

        // 📊 Cantidad de resultados por página
        $perPage = $request->input('per_page', 10);  // Valor por defecto: 10

        // ⚙️ Paginación
        $cargas = $query->latest()->paginate($perPage);

        return view('cargas.index', compact('cargas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cooperativas = Cooperativa::all();
        $camiones = Camion::all();
        $concesiones = ConcesionMina::all();
        $plataformas = Plataforma::all();
        $centrosAcopio = CentroAcopio::all();
        $municipios = Municipio::all();
        $minerales = Mineral::all();
        $personas = Persona::all();

        return view('cargas.create', compact('cooperativas', 'camiones',
         'concesiones', 'plataformas','centrosAcopio','municipios','minerales','personas'));
    }
    public function obtenerMinerales($cargaId)
    {
        $carga = Carga::with('minerales')->find($cargaId);

        if (!$carga) {
            return response()->json([], 404);
        }

        $minerales = $carga->minerales->map(function ($mineral) {
            return [
                'id' => $mineral->id,
                'nombre' => $mineral->nombre,
            ];
        });

        return response()->json($minerales);
    }
    public function cotizacionesPorCarga($cargaId, $fecha)
    {
        $carga = Carga::with('minerales')->find($cargaId);

        if (!$carga) {
            return response()->json(['error' => 'Carga no encontrada'], 404);
        }

        $fechaCarbon = Carbon::parse($fecha);

        $gestion = $fechaCarbon->year;
        $mes = $fechaCarbon->month;
        $dia = $fechaCarbon->day;

        $quincena = $dia <= 15 ? 'PRIMERA' : 'SEGUNDA';

        $cotizaciones = [];

        foreach ($carga->minerales as $mineral) {
            $cotizacion = Cotizacion::where('mineral_id', $mineral->id)
                ->where('gestion', $gestion)
                ->where('mes', $mes)
                ->where('quincena', $quincena)
                ->first();

            $cotizaciones[] = [
                'mineral_id' => $mineral->id,
                'mineral_nombre' => $mineral->nombre,
                'valor_cotizacion' => $cotizacion->valor ?? null,
                'quincena' => $quincena,
                'mes' => $mes,
                'gestion' => $gestion,
            ];
        }

        return response()->json($cotizaciones);
    }
    public function store(Request $request)
    {
        $tipoCarga = $request->input('tipo');

        $reglas = [
            'plataforma_id'     => 'required|exists:plataformas,id',
            'lote'              => 'required|string',
            'producto'          => 'nullable|string',
            'minerales'   => 'required|array|min:1',
            'minerales.*' => 'exists:minerales,id',
            'fecha_registro'    => 'required|date',
            'numero_boleta'     => 'required|string',
            'cooperativa_id'    => 'nullable|exists:cooperativas,id',
            'concesion_mina_id' => 'nullable|exists:concesion_minas,id',
            'proveedor_id'      => 'required|exists:personas,id',
            'socio_id'          => 'nullable|exists:personas,id',
            'estado'            => 'required|in:PESAJE,ACUMULACION,LIQUIDACION,EXPORTADO',
            'tipo'              => 'required|in:BROSA,CONCENTRADO,SACOS',
            'peso_bruto'        => 'required|integer|min:1',
            'peso_tara'         => 'required|integer|min:0',
            'peso_neto'         => 'required|integer|min:1',
            'observaciones'     => 'nullable|string',
        ];

        $atributos = [
            'minerales' => 'minerales seleccionados',
            'plataforma_id'     => 'plataforma',
            'proveedor_id'      => 'proveedor',
            'cooperativa_id'    => 'cooperativa',
            'concesion_mina_id' => 'concesión minera',
            'socio_id'          => 'socio',
            'camion_id'         => 'camión',
            'conductor_id'      => 'conductor',
        ];

        $mensajes = [
            'minerales.required' => 'Debe seleccionar al menos un mineral.',
            'minerales.min' => 'Debe seleccionar al menos un mineral.',
        ];

        if (in_array($tipoCarga, ['BROSA', 'CONCENTRADO'])) {
            $reglas['conductor_id'] = 'required|exists:personas,id';
            $reglas['camion_id'] = 'required|exists:camiones,id';
            $reglas['cantidad_sacos'] = 'nullable|integer';
        } elseif ($tipoCarga === 'SACOS') {
            $reglas['cantidad_sacos'] = 'required|integer|min:1';
            $reglas['conductor_id'] = 'nullable|exists:personas,id';
            $reglas['camion_id'] = 'nullable|exists:camiones,id';
        }

        $validated = $request->validate($reglas, [], $atributos);

        DB::beginTransaction();

        try {
            $carga = Carga::create([
                'cooperativa_id'    => $request->cooperativa_id ?: null,
                'camion_id'         => $request->camion_id ?: null,
                'concesion_mina_id' => $request->concesion_mina_id ?: null,
                'plataforma_id'     => $request->plataforma_id,
                'lote'              => $request->lote,
                'producto'          => $request->producto,
                'peso_tara'         => $request->peso_tara,
                'peso_bruto'        => $request->peso_bruto,
                'peso_neto'         => $request->peso_neto,
                'fecha_registro'    => $request->fecha_registro,
                'numero_boleta'     => $request->numero_boleta,
                'observaciones'     => $request->observaciones,
                'cantidad_sacos'    => $request->cantidad_sacos ?: 0,
                'estado'            => $request->estado,
                'tipo'              => $request->tipo,
            ]);
         

            if (!empty($request->minerales)) {
                $carga->minerales()->attach($request->minerales);
            }

            $carga->personas()->attach($request->proveedor_id, ['tipo' => 'PROVEEDOR']);

            if ($request->filled('socio_id')) {
                $carga->personas()->attach($request->socio_id, ['tipo' => 'SOCIO']);
            }

            if ($request->filled('conductor_id')) {
                $carga->personas()->attach($request->conductor_id, ['tipo' => 'CONDUCTOR']);
            }
      
            DB::commit();
            
            return redirect()->route('cargas.index')->with('success', 'Carga registrada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            dd('ERROR DETECTADO', $e->getMessage(), $e);
        }
    }
    public function obtenerLaboratorios($cargaId)
    {
        $carga = Carga::with('muestrasLaboratorio')->find($cargaId);

        if (!$carga) {
            return response()->json([], 404);
        }

        $laboratorios = $carga->muestrasLaboratorio->map(function ($laboratorio) {
            $imagenUrl = $laboratorio->imagen_certificado
                ? asset('storage/' . $laboratorio->imagen_certificado)
                : null;
            return [
                'id' => $laboratorio->id,
                'fecha_laboratorio' => $laboratorio->fecha_muestra
                    ? $laboratorio->fecha_muestra->format('Y-m-d')
                    : 'Sin fecha',
                'tipo' => $laboratorio->tipo,
                'imagen_url' => $imagenUrl
            ];
        });

        return response()->json($laboratorios);
    }
    public function show(Carga $carga)
    {
        $carga->load('plataforma', 'cooperativa', 'concesionMina', 'camion', 'minerales', 'personas');
        return view('cargas.show', compact('carga'));
    }


    public function reportePdf(Carga $carga)
    {
        $pdf = Pdf::loadView('cargas.reporte', compact('carga'));
        return $pdf->stream('reporte-carga-'.$carga->id.'.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carga  $carga
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carga  $carga
     * @return \Illuminate\Http\Response
     */
    public function edit(Carga $carga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carga  $carga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carga $carga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carga  $carga
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carga $carga)
    {
        //
    }
}
