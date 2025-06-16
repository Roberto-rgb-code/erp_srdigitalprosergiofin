@extends('layouts.app')
@section('content')
    <h2>Mantenimientos - {{ $vehiculo->placa }}</h2>
    <a href="{{ route('vehiculos.mantenimiento.create', $vehiculo->id) }}" class="btn btn-primary mb-2">Registrar mantenimiento</a>
    <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary mb-2">Regresar</a>
    <a href="{{ route('vehiculos.mantenimiento.exportExcel', $vehiculo->id) }}" class="btn btn-outline-success mb-2">Exportar Excel</a>
    <a href="{{ route('vehiculos.mantenimiento.exportPDF', $vehiculo->id) }}" class="btn btn-outline-danger mb-2">Exportar PDF</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo de servicio</th>
                <th>Kilometraje</th>
                <th>Costo</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mantenimientos as $m)
                <tr>
                    <td>{{ $m->fecha }}</td>
                    <td>{{ $m->tipo_servicio }}</td>
                    <td>{{ $m->kilometraje }}</td>
                    <td>${{ number_format($m->costo,2) }}</td>
                    <td>{{ $m->observaciones }}</td>
                    <td>
                        <a href="{{ route('vehiculos.mantenimiento.edit', [$vehiculo->id, $m->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('vehiculos.mantenimiento.destroy', [$vehiculo->id, $m->id]) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No hay mantenimientos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $mantenimientos->links() }}
@endsection
