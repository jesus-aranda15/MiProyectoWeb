<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Maestro;
use App\Models\Periodo;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'periodo_id' => 'required|exists:periodos,id',
        'maestro_id' => 'required|exists:maestros,id',
        'fecha' => 'required|date',
        'asistio' => 'required|in:presente,ausente,justificado',
    ]);

    // Crea la asistencia
    $asistencia = new Asistencia();
    $asistencia->periodo_id = $request->periodo_id;
    $asistencia->maestro_id = $request->maestro_id;
    $asistencia->fecha = $request->fecha;
    $asistencia->asistio = $request->asistio;
    $asistencia->save();

    return redirect()->back()->with('success', 'Asistencia registrada correctamente');
}


public function storeIndividual(Request $request)
{
    $request->validate([
        'maestro_id' => 'required|exists:maestros,id',
        'periodo_id' => 'required|exists:periodos,id',
        'fecha' => 'required|date',
        'asistio' => 'required|in:presente,ausente,justificado',
    ]);

    Asistencia::updateOrCreate([
        'maestro_id' => $request->maestro_id,
        'periodo_id' => $request->periodo_id,
        'fecha' => $request->fecha,
    ], [
        'asistio' => $request->asistio,
        'observaciones' => $request->observaciones,
    ]);

    return redirect()->back()->with('success', 'Asistencia individual guardada correctamente.');
}

//---------------------ver los dias de asistencia---------------------------------
public function verDiasRegistrados($periodoId)
{
    $periodo = Periodo::findOrFail($periodoId);

    // Obtener las asistencias agrupadas por fecha
    $asistenciasPorFecha = Asistencia::where('periodo_id', $periodoId)
        ->with('maestro') // asegúrate de tener esta relación en el modelo Asistencia
        ->orderBy('fecha', 'desc')
        ->get()
        ->groupBy('fecha');

    return view('periodos.dias', compact('periodo', 'asistenciasPorFecha'));
}
//---------------------ver los dias de asistencia---------------------------------
}