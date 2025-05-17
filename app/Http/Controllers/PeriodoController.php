<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    /**
     * inicio ocultar cursos
     */
    public function index(Request $request)
{
    $mostrarInactivos = $request->input('mostrar_inactivos', false);
    
    $periodos = Periodo::when(!$mostrarInactivos, function($query) {
        return $query->where('estatus', 'activo');
    })
    ->orderBy('fecha_inicio', 'desc')
    ->get();

    return view('periodos.index', [
        'periodos' => $periodos,
        'mostrarInactivos' => $mostrarInactivos
    ]);
}
    /*** fin ocultar cursos*/

    /** inicio crear periodos*/
    public function create()
    {
        return view('periodos.create');
    }
    /** fin crear periodos*/

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'nombre_periodo' => 'required|string|max:255',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after:fecha_inicio',
        'estatus' => 'required|in:activo,inactivo'
    ]);

    try {
        $periodo = Periodo::create($validatedData);
        
        return redirect()->route('periodos.index')
                         ->with('success', 'Período creado exitosamente');
    } catch (\Exception $e) {
        return back()->withInput()
                     ->with('error', 'Error al crear el período: '.$e->getMessage());
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Periodo $periodo)
    {
        return view('periodos.show', compact('periodo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Periodo $periodo)
    {
        return view('periodos.edit', compact('periodo'));
    }

    /**
     * actualizar periodo.
     */
    public function update(Request $request, Periodo $periodo)
    {
        $validated = $request->validate([
            'nombre_periodo' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estatus' => 'required|in:activo,inactivo',
        ]);

        $periodo->update($validated);

        return redirect()->route('periodos.index')
                         ->with('success', 'Período actualizado exitosamente.');
    }

    /**
     * ELiminar periodo
     */
    public function destroy(Periodo $periodo)
    {
        $periodo->delete();

        return redirect()->route('periodos.index')
                         ->with('success', 'Período eliminado exitosamente.');
    }
}