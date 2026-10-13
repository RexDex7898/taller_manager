<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ReparacionController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReporteController;

// Dashboard principal
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Módulos principales
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

// Rutas de Inventario
Route::get('inventario/pdf', [ProductoController::class, 'pdf'])->name('inventario.pdf');
Route::resource('inventario', ProductoController::class);

// Acciones adicionales
Route::post('/equipos/{equipo}/ingresar', [ReparacionController::class, 'ingresarExistente'])->name('equipos.ingresar');
Route::patch('/reparaciones/{reparacion}/estado', [ReparacionController::class, 'actualizarEstado'])->name('reparaciones.estado');

Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');