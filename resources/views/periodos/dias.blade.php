@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Días de Asistencia Registrados para el Período: <strong>{{ $periodo->nombre_periodo }}</strong></h2>
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Regresar
    </a>

    @if($asistenciasPorFecha->isEmpty())
        <div class="alert alert-info">
            No se han registrado asistencias aún para este período.
        </div>
    @else
        @foreach($asistenciasPorFecha as $fecha => $asistencias)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0 table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre del Maestro</th>
                                <th>Estado de Asistencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $asistencia)
                                <tr>
                                    <td>{{ $asistencia->maestro->nombre_completo }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $asistencia->asistio == 'presente' ? 'success' : 
                                            ($asistencia->asistio == 'justificado' ? 'warning' : 'danger') 
                                        }}">
                                            {{ ucfirst($asistencia->asistio) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
