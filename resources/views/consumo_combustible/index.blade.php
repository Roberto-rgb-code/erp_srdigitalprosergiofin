@extends('layouts.app')
@section('content')
    <h2>Consumo de Combustible - {{ $vehiculo->placa }}</h2>
    <a href="{{ route('vehiculos.consumo.create', $vehiculo->id) }}" class="btn btn-primary mb-2">Registrar consumo</a>
    <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary mb-2">Regresar</a>
    <a href="{{ route('vehiculos.consumo.exportExcel', $vehiculo->id) }}" class="btn btn-outline-success mb-2">Exportar Excel</a>
    <a href="{{ route('vehiculos.consumo.exportPDF', $vehiculo->id) }}" class="btn btn-outline-danger mb-2">Exportar PDF</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Litros</th>
                <th>Monto</th>
                <th>Ticket</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($consumos as $c)
                <tr>
                    <td>{{ $c->fecha }}</td>
                    <td>{{ $c->litros }}</td>
                    <td>${{ number_format($c->monto,2) }}</td>
                    <td>{{ $c->ticket ?? '-' }}</td>
                    <td>
                        <a href="{{ route('vehiculos.consumo.edit', [$vehiculo->id, $c->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('vehiculos.consumo.destroy', [$vehiculo->id, $c->id]) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No hay consumos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $consumos->links() }}
@endsection
