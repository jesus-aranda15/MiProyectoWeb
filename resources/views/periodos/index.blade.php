@extends('layouts.app')

@section('content')
<div class="container">
    <h1>PERIODOS REGISTRADOS PARA CURSOS DOCENTES</h1>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('periodos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Agregar periodo
        </a>
        
        <!-- Opción para mostrar inactivos - Versión corregida -->
    <div class="form-check form-switch align-self-center">
        <form id="toggleForm" action="{{ route('periodos.index') }}" method="GET">
            @if(request('mostrar_inactivos'))
                <input type="hidden" name="mostrar_inactivos" value="0">
            @else
                <input type="hidden" name="mostrar_inactivos" value="1">
            @endif
            <input class="form-check-input" type="checkbox" id="mostrarInactivosToggle"
                   {{ request('mostrar_inactivos') ? 'checked' : '' }}
                   onchange="document.getElementById('toggleForm').submit()">
            <label class="form-check-label" for="mostrarInactivosToggle">
                Mostrar períodos inactivos
            </label>
        </form>
    </div>
</div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>PERIODO</th>
                            <th>INICIO</th>
                            <th>FIN</th>
                            <th>ESTATUS</th>
                            <th colspan="3">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($periodos as $periodo)
                        <tr>
                            <td>ID-{{ $periodo->id }}</td>
                            <td>{{ $periodo->nombre_periodo }}</td>
                            <td>{{ $periodo->fecha_inicio->format('Y-m-d') }}</td>
                            <td>{{ $periodo->fecha_fin->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $periodo->estatus == 'activo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($periodo->estatus) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('periodos.edit', $periodo->id) }}" 
                                   class="btn btn-sm btn-warning"
                                   title="Editar">
                                   <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('periodos.destroy', $periodo->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Eliminar permanentemente este período?')"
                                            title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('periodos.maestros.create', $periodo->id) }}" 
                                       class="btn btn-sm btn-info"
                                       title="Asignar Maestros">
                                       <i class="fas fa-user-plus"></i>
                                    </a>
                                    <a href="{{ route('periodos.maestros.show', $periodo->id) }}" 
                                       class="btn btn-sm btn-primary"
                                       title="Ver Maestros Asignados">
                                       <i class="fas fa-users"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No hay períodos registrados
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection