@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            <i class="fas fa-user-plus"></i> Asignar Maestros
        </h1>
        <div>
            <a href="{{ route('periodos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">
                <i class="fas fa-users"></i> Maestros Disponibles
                <span class="badge bg-white text-primary ms-2">
                    {{ $maestros->count() }} disponibles
                </span>
            </h2>
        </div>

        <div class="card-body">
            @if($maestros->isEmpty())
            <div class="alert alert-info mb-0">
                <i class="fas fa-info-circle"></i> Todos los maestros están asignados a este período.
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="table-light">
                            <th width="15%">Matrícula</th>
                            <th>Nombre Completo</th>
                            <th width="20%">Departamento</th>
                            <th width="15%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($maestros as $maestro)
                        <tr>
                            <td class="fw-bold">{{ $maestro->matricula }}</td>
                            <td>{{ $maestro->nombre_completo }}</td>
                            <td>{{ $maestro->departamento }}</td>
                            <td>
                                <form method="POST" 
                                      action="{{ route('periodos.maestros.store', $periodo->id) }}">
                                    @csrf
                                    <input type="hidden" name="maestro_id" value="{{ $maestro->id }}">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-user-plus"></i> Asignar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection