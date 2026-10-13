<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ReparacionController;
use App\Http\Controllers\CotizacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('clientes', ClienteController::class);
Route::resource('equipos', EquipoController::class);

Route::resource('reparaciones', ReparacionController::class)
    ->parameters([
        'reparaciones' => 'reparacion',
    ]);

Route::resource('cotizaciones', CotizacionController::class)
    ->parameters([
        'cotizaciones' => 'cotizacion',
    ]);

// Rutas adicionales del taller
Route::post('/equipos/{equipo}/ingresar', [ReparacionController::class, 'ingresarExistente'])->name('equipos.ingresar');
Route::patch('/reparaciones/{reparacion}/estado', [ReparacionController::class, 'actualizarEstado'])->name('reparaciones.estado');


Route::get('inventario/pdf', [ProductoController::class, 'pdf'])->name('inventario.pdf');
Route::resource('inventario', ProductoController::class);

Route::get('/', function () {
    return redirect()->route('dashboard');
});