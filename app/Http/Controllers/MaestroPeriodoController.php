<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use App\Models\Maestro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaestroPeriodoController extends Controller
{
    public function create(Periodo $periodo)
    {
        // Obtener maestros no asignados con búsqueda opcional
        $maestros = Maestro::whereDoesntHave('periodos', function($query) use ($periodo) {
            $query->where('periodo_id', $periodo->id);
        })
        ->orderBy('nombre_completo')
        ->get();

        return view('periodos.asignar-maestros', [
            'periodo' => $periodo,
            'maestros' => $maestros,
            'maestrosAsignadosCount' => $periodo->maestros()->count()
        ]);
    }

    public function store(Request $request, Periodo $periodo)
    {
        $validated = $request->validate([
            'maestro_id' => [
                'required',
                'exists:maestros,id',
                Rule::unique('periodo_maestro')->where(function ($query) use ($periodo) {
                    return $query->where('periodo_id', $periodo->id);
                })
            ]
        ]);

        $periodo->maestros()->attach($validated['maestro_id']);

        return redirect()
                ->route('periodos.maestros.create', $periodo->id)
                ->with('success', 'Maestro asignado correctamente');
    }

    public function show(Periodo $periodo)
    {
        return view('periodos.maestros-asignados', [
            'periodo' => $periodo,
            'maestros' => $periodo->maestros()->orderBy('nombre_completo')->get()
        ]);
    }

    //-----------de la ventana de maestros asignados

    public function destroy(Periodo $periodo, Maestro $maestro)
{
    $periodo->maestros()->detach($maestro->id);
    
    return redirect()
           ->route('periodos.maestros.show', $periodo->id)
           ->with('success', 'Maestro eliminado del período correctamente');
}
}