@extends('layouts.app')
@section('content')
    <h2>Bitácora de Uso - {{ $vehiculo->placa }}</h2>
    <a href="{{ route('vehiculos.uso.create', $vehiculo->id) }}" class="btn btn-primary mb-2">Registrar uso</a>
    <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary mb-2">Regresar</a>
    <a href="{{ route('vehiculos.uso.exportExcel', $vehiculo->id) }}" class="btn btn-outline-success mb-2">Exportar Excel</a>
    <a href="{{ route('vehiculos.uso.exportPDF', $vehiculo->id) }}" class="btn btn-outline-danger mb-2">Exportar PDF</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Fecha salida</th>
                <th>Hora salida</th>
                <th>Destino</th>
                <th>Motivo</th>
                <th>Fecha retorno</th>
                <th>Hora retorno</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usos as $u)
                <tr>
                    <td>{{ $u->empleado->nombre ?? '-' }}</td>
                    <td>{{ $u->fecha_salida }}</td>
                    <td>{{ $u->hora_salida }}</td>
                    <td>{{ $u->destino }}</td>
                    <td>{{ $u->motivo }}</td>
                    <td>{{ $u->fecha_retorno }}</td>
                    <td>{{ $u->hora_retorno }}</td>
                    <td>{{ $u->observaciones }}</td>
                    <td>
                        <a href="{{ route('vehiculos.uso.edit', [$vehiculo->id, $u->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('vehiculos.uso.destroy', [$vehiculo->id, $u->id]) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9">No hay registros de uso.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $usos->links() }}
@endsection
