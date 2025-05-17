@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar periodo</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('periodos.update', $periodo->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre_periodo">PERIODO</label>
                    <input type="text" class="form-control" id="nombre_periodo" name="nombre_periodo" value="{{ $periodo->nombre_periodo }}" required>
                </div>
                <div class="form-group">
                    <label for="fecha_inicio">INICIO</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $periodo->fecha_inicio->format('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="fecha_fin">FIN</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ $periodo->fecha_fin->format('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="estatus">ESTATUS</label>
                    <select class="form-control" id="estatus" name="estatus">
                        <option value="activo" {{ $periodo->estatus == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ $periodo->estatus == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('periodos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection