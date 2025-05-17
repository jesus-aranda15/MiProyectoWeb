@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agregar nuevo periodo</h1>

    <div class="card">
        <div class="card-body">
            <!--------------------- formulario inicio(funcional) --------------------------->
            <form action="{{ route('periodos.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="nombre_periodo" class="form-label">Nombre del Período</label>
                    <input type="text" class="form-control" id="nombre_periodo" name="nombre_periodo" required>
                </div>
            
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fecha_fin" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                    </div>
                </div>
            
                <div class="mb-3">
                    <label for="estatus" class="form-label">Estatus</label>
                    <select class="form-select" id="estatus" name="estatus" required>
                        <option value="activo" selected>Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('periodos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
                        <!--------------------- formulario fin(funcional) --------------------------->

        </div>
    </div>
</div>
@endsection