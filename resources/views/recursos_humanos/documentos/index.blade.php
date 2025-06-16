@extends('layouts.app')
@section('content')
<h2>Documentos de {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
<a href="{{ route('recursos_humanos.documentos.create', $empleado) }}" class="btn btn-primary mb-2">Nuevo documento</a>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th><th>Archivo</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($documentos as $d)
        <tr>
            <td>{{ $d->nombre }}</td>
            <td>
                @if($d->archivo)
                    <a href="{{ asset('storage/' . $d->archivo) }}" target="_blank">Ver archivo</a>
                @endif
            </td>
            <td>
                <a href="{{ route('recursos_humanos.documentos.edit', [$empleado, $d]) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('recursos_humanos.documentos.destroy', [$empleado, $d]) }}" method="POST" style="display:inline-block">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('¿Eliminar?')" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('recursos_humanos.show', $empleado) }}" class="btn btn-secondary">Regresar</a>
@endsection
