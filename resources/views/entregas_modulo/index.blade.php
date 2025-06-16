@extends('layouts.app')
@section('content')
    <h3>Entregas del módulo: {{ $modulo->nombre }}</h3>
    <a href="{{ route('modulos_software.entregas.create', [$proyecto, $modulo->id]) }}" class="btn btn-primary mb-2">Agregar entrega</a>
    <a href="{{ route('modulos_software.index', $proyecto) }}" class="btn btn-secondary mb-2">Regresar a módulos</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Archivo</th>
                <th>Versión</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entregas as $e)
                <tr>
                    <td>{{ $e->descripcion }}</td>
                    <td>
                        @if($e->archivo)
                            <a href="{{ asset('storage/'.$e->archivo) }}" target="_blank">Ver archivo</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $e->version }}</td>
                    <td>{{ $e->fecha }}</td>
                    <td>
                        <form action="{{ route('modulos_software.entregas.destroy', [$proyecto, $modulo->id, $e->id]) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
