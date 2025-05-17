<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\MaestroPeriodoController;
use App\Http\Controllers\AsistenciaController;
//-------------------------

// ruta crear periodo funcional
Route::resource('periodos', PeriodoController::class);
// ruta crear periodo funcional

Route::resource('periodos.maestros', MaestroPeriodoController::class)
     ->only(['create', 'store'])
     ->names([
         'create' => 'periodos.maestros.create',
         'store' => 'periodos.maestros.store'
     ]);


Route::prefix('periodos/{periodo}')->group(function () {
    // inicio para asignar maestros
    Route::get('maestros/asignar', [MaestroPeriodoController::class, 'create'])
         ->name('periodos.maestros.create');
         
    Route::post('maestros', [MaestroPeriodoController::class, 'store'])
         ->name('periodos.maestros.store');
    // fin para asignar maestros 

    // para ver maestros asignados
    Route::get('maestros', [MaestroPeriodoController::class, 'show'])
         ->name('periodos.maestros.show');
     });

//-----------de la ventana de maestros asignados
Route::delete('periodos/{periodo}/maestros/{maestro}', [MaestroPeriodoController::class, 'destroy'])
     ->name('periodos.maestros.destroy');

//-----------asistencia------------
Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
Route::post('/asistencias/individual', [AsistenciaController::class, 'storeIndividual'])->name('asistencias.individual');
//--------ver asistencias----------
Route::get('/periodos/{periodo}/asistencias-dias', [App\Http\Controllers\AsistenciaController::class, 'verDiasRegistrados'])
    ->name('asistencias.dias');
