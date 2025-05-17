@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Maestros Asignados al Periodo: <strong>{{ $periodo->nombre_periodo }}</strong></h1>
        <a href="{{ route('periodos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">Administración de Maestros Asignados</h2>
            </div>
        </div>

        <!-- boton ver asistencias-->
        <a href="{{ route('asistencias.dias', $periodo->id) }}" target="_blank" class="btn btn-outline-primary">
            <i class="fas fa-calendar-alt"></i> Ver días de asistencia registrados
        </a>
        <!-- boton ver asistencias -->

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>MATRÍCULA</th>
                            <th>NOMBRE COMPLETO</th>
                            <th>DEPARTAMENTO</th>
                            <th>DOCUMENTACIÓN</th>
                            <th>ASISTENCIA (Último registro)</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maestros as $maestro)
                        @php
                            $ultimaAsistencia = $maestro->asistencias()
                                ->where('periodo_id', $periodo->id)
                                ->latest('fecha')
                                ->first();
                        @endphp
                        <tr>
                            <td>{{ $maestro->matricula }}</td>
                            <td>{{ $maestro->nombre_completo }}</td>
                            <td>{{ $maestro->departamento }}</td>
                            <td>
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Completa
                                </span>
                            </td>
                            <td>
                                @if($ultimaAsistencia)
                                    <span class="badge bg-{{ 
                                        $ultimaAsistencia->asistio == 'presente' ? 'success' : 
                                        ($ultimaAsistencia->asistio == 'justificado' ? 'warning' : 'danger') 
                                    }}">
                                        {{ ucfirst($ultimaAsistencia->asistio) }}
                                        <small>({{ \Carbon\Carbon::parse($ultimaAsistencia->fecha)->format('d/m/Y') }})</small>
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Sin registro</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <!-- Botón de asistencia individual en cada fila -->
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#registrarAsistenciaModal{{ $maestro->id }}">
                                        <i class="fas fa-calendar-check"></i> Registrar Asistencia
                                    </button>

                                    <button class="btn btn-info btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('periodos.maestros.destroy', ['periodo' => $periodo->id, 'maestro' => $maestro->id]) }}" 
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Quitar a {{ $maestro->nombre_completo }} de este período?')"
                                                title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal para Registrar Asistencia Individual -->
                        <div class="modal fade" id="registrarAsistenciaModal{{ $maestro->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('asistencias.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="periodo_id" value="{{ $periodo->id }}">
                                        <input type="hidden" name="maestro_id" value="{{ $maestro->id }}"> <!-- Maestro ID agregado -->
                                        <div class="modal-header">
                                            <h5 class="modal-title">Registrar Asistencia para {{ $maestro->nombre_completo }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="fecha_asistencia_{{ $maestro->id }}" class="form-label">Fecha</label>
                                                <input type="date" class="form-control" id="fecha_asistencia_{{ $maestro->id }}" name="fecha" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Estado</label>
                                                <select class="form-select" name="asistio" required>
                                                    <option value="presente">Presente</option>
                                                    <option value="ausente">Ausente</option>
                                                    <option value="justificado">Justificado</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar Asistencia</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No hay maestros asignados a este período
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        // Establecer la fecha predeterminada en todos los campos de fecha
        const dateFields = document.querySelectorAll('input[type="date"]');
        dateFields.forEach(field => {
            field.value = today;
        });
    });
</script>
@endsection
