<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CargaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('cargas/{carga}/minerales', function(App\Models\Carga $carga) {
    // Obtener minerales asociados con su alícuota (que está en la tabla minerales)
    return $carga->minerales()->select('minerales.id', 'minerales.nombre', 'minerales.alicuota','minerales.conversion')->get();
});

Route::get('/cargas/{carga}/laboratorios', [CargaController::class, 'obtenerLaboratorios']);



