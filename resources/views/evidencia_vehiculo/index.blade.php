@extends('layouts.app')
@section('content')
    <h2>Evidencias - {{ $vehiculo->placa }}</h2>
    <a href="{{ route('vehiculos.evidencia.create', $vehiculo->id) }}" class="btn btn-primary mb-2">Agregar evidencia</a>
    <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary mb-2">Regresar</a>
    <a href="{{ route('vehiculos.evidencia.exportExcel', $vehiculo->id) }}" class="btn btn-outline-success mb-2">Exportar Excel</a>
    <a href="{{ route('vehiculos.evidencia.exportPDF', $vehiculo->id) }}" class="btn btn-outline-danger mb-2">Exportar PDF</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Relacionado a uso</th>
                <th>Archivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($evidencias as $e)
                <tr>
                    <td>{{ $e->fecha }}</td>
                    <td>{{ $e->tipo }}</td>
                    <td>
                        @if($e->uso)
                            Uso #{{ $e->uso->id }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($e->archivo)
                            <a href="{{ asset('storage/'.$e->archivo) }}" target="_blank">Ver archivo</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('vehiculos.evidencia.destroy', [$vehiculo->id, $e->id]) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No hay evidencias.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $evidencias->links() }}
@endsection
