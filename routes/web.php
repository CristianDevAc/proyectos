<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\CooperativaController;
use App\Http\Controllers\ConcesionMinaController;
use App\Http\Controllers\CamionController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\MuestraLaboratorioController;
use App\Http\Controllers\LiquidacionController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\ContribucionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'minerales'])->name('dashboard');
});
Route::prefix('cargas')->group(function () {
    Route::get('/', [CargaController::class, 'index'])->middleware('can:ver cargas')->name('cargas.index');
    Route::get('/create', [CargaController::class, 'create'])->middleware('can:crear cargas')->name('cargas.create');
    Route::post('/', [CargaController::class, 'store'])->middleware('can:crear cargas')->name('cargas.store');
    Route::get('/{carga}/edit', [CargaController::class, 'edit'])->middleware('can:editar cargas')->name('cargas.edit');
    Route::put('/{carga}', [CargaController::class, 'update'])->middleware('can:editar cargas')->name('cargas.update');
    Route::get('/cargas/{carga}', [CargaController::class, 'show'])->middleware('can:ver cargas')->name('cargas.show');
    Route::get('cargas/{carga}/reporte', [CargaController::class, 'reportePdf'])->middleware('can:ver cargas')->name('cargas.reporte');
    // etc...
});

Route::prefix('laboratorios')->middleware('can:ver laboratorio')->group(function () {
    Route::get('/', [LaboratorioController::class, 'index'])->name('laboratorios.index');
    Route::get('/create', [LaboratorioController::class, 'create'])->middleware('can:crear laboratorio')->name('laboratorios.create');
    Route::post('/', [LaboratorioController::class, 'ajaxStore'])->middleware('can:crear laboratorio')->name('laboratorios.store');
    Route::get('/{laboratorio}/edit', [LaboratorioController::class, 'edit'])->middleware('can:editar laboratorio')->name('laboratorios.edit');
    Route::put('/{laboratorio}', [LaboratorioController::class, 'update'])->middleware('can:editar laboratorio')->name('laboratorios.update');
    Route::delete('/{laboratorio}', [LaboratorioController::class, 'destroy'])->middleware('can:eliminar laboratorio')->name('laboratorios.destroy');
});



Route::prefix('muestras')->group(function () {
        Route::get('/', [MuestraLaboratorioController::class, 'index'])->name('muestras.index');
        Route::get('/create', [MuestraLaboratorioController::class, 'create'])->name('muestras.create');
        Route::post('/', [MuestraLaboratorioController::class, 'store'])->name('muestras.store');
        Route::get('/{muestra}/edit', [MuestraLaboratorioController::class, 'edit'])->name('muestras.edit');
        Route::put('/{muestra}', [MuestraLaboratorioController::class, 'update'])->name('muestras.update');
        Route::get('/{muestra}', [MuestraLaboratorioController::class, 'show'])->name('muestras.show');
    });


Route::middleware(['auth'])->group(function () {
    Route::resource('cotizacion', CotizacionController::class)->except(['show']);
    
});

Route::post('/contribuciones', [ContribucionController::class, 'store'])->name('contribuciones.store');
Route::get('/contribuciones/listar', [ContribucionController::class, 'listar'])->name('contribuciones.listar');


Route::prefix('liquidaciones')->group(function () {
    Route::get('/', [LiquidacionController::class, 'index'])
        ->middleware('can:ver liquidaciones')
        ->name('liquidaciones.index');

    Route::get('/create', [LiquidacionController::class, 'create'])
        ->middleware('can:crear liquidaciones')
        ->name('liquidacion.create');

    Route::post('/', [LiquidacionController::class, 'store'])
        ->middleware('can:crear liquidaciones')
        ->name('liquidaciones.store');

    Route::get('/{liquidacion}/edit', [LiquidacionController::class, 'edit'])
        ->middleware('can:editar liquidaciones')
        ->name('liquidaciones.edit');

    Route::put('/{liquidacion}', [LiquidacionController::class, 'update'])
        ->middleware('can:editar liquidaciones')
        ->name('liquidaciones.update');

    // Ruta para PDF — debe ir antes de la ruta show para no interferir
    Route::get('/{liquidacion}/pdf', [LiquidacionController::class, 'pdf'])
        ->middleware('can:ver liquidaciones')
        ->name('liquidaciones.pdf');

    Route::get('/{liquidacion}', [LiquidacionController::class, 'show'])
        ->middleware('can:ver liquidaciones')
        ->name('liquidaciones.show');

    Route::delete('/{liquidacion}', [LiquidacionController::class, 'destroy'])
        ->middleware('can:eliminar liquidaciones')
        ->name('liquidaciones.destroy');
});



Route::prefix('reportes')->group(function () {
    Route::get('/', [ReportesController::class, 'index'])->name('reportes.index');
    Route::post('/filtrar', [ReportesController::class, 'filtrar'])->name('reportes.filtrar');
    Route::post('/m02', [ReportesController::class, 'm02'])->name('reportes.m02');
});


Route::post('/cooperativas/ajax-store', [CooperativaController::class, 'store'])->name('cooperativas.ajax.store');
Route::post('/concesiones/ajax-store', [ConcesionMinaController::class, 'store'])->name('concesiones.ajax.store');

Route::post('/proveedores/ajax-store', [PersonaController::class, 'ajaxStore'])->name('proveedores.ajax.store');
Route::post('/camiones/ajax-store', [CamionController::class, 'ajaxStore'])->name('camiones.ajax.store');


Route::get('/api/cargas/{carga}/cotizaciones/{fecha}', [CargaController::class, 'cotizacionesPorCarga']);
Route::get('/cargas/{carga}/laboratorios', [CargaController::class, 'obtenerLaboratorios']);


Route::prefix('admin')->group(function () {
        Route::get('/usuarios', [UserController::class, 'index'])->middleware('can:ver usuarios')->name('admin.usuarios.index');
        Route::get('/usuarios/create', [UserController::class, 'create'])->middleware('can:crear usuarios')->name('admin.usuarios.create');
        Route::post('/usuarios', [UserController::class, 'store'])->middleware('can:crear usuarios')->name('admin.usuarios.store');
        Route::get('/usuarios/{user}/edit', [UserController::class, 'edit'])->middleware('can:editar usuarios')->name('admin.usuarios.edit');
        Route::put('/usuarios/{user}', [UserController::class, 'update'])->middleware('can:editar usuarios')->name('admin.usuarios.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
