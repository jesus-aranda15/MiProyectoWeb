<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\MaestroPeriodoController;
use App\Http\Controllers\AsistenciaController;

//-------------------------

// ruta crear periodo funcional
Route::resource('periodos', PeriodoController::class);

// ruta para asignar maestros (solo create y store)
Route::resource('periodos.maestros', MaestroPeriodoController::class)
     ->only(['create', 'store'])
     ->names([
         'create' => 'periodos.maestros.create',
         'store' => 'periodos.maestros.store'
     ]);

Route::prefix('periodos/{periodo}')->group(function () {
    // para ver maestros asignados
    Route::get('maestros', [MaestroPeriodoController::class, 'show'])
         ->name('periodos.maestros.show');
});

// eliminar maestro asignado
Route::delete('periodos/{periodo}/maestros/{maestro}', [MaestroPeriodoController::class, 'destroy'])
     ->name('periodos.maestros.destroy');

//-----------asistencia------------
Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
Route::post('/asistencias/individual', [AsistenciaController::class, 'storeIndividual'])->name('asistencias.individual');

//--------ver asistencias----------
Route::get('/periodos/{periodo}/asistencias-dias', [AsistenciaController::class, 'verDiasRegistrados'])
    ->name('asistencias.dias');
