@extends('layouts.app')
@section('content')
<h2>Documentos de {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
<a href="{{ route('recursos_humanos.documentos.create', $empleado) }}" class="btn btn-primary mb-2">Nuevo documento</a>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre documento</th>
            <th>Archivo</th>
            <th>Subido el</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($documentos as $doc)
        <tr>
            <td>{{ $doc->nombre_documento }}</td>
            <td>
                @if($doc->archivo)
                    <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank">Ver/Descargar</a>
                @else
                    No disponible
                @endif
            </td>
            <td>{{ $doc->created_at }}</td>
            <td>
                <form action="{{ route('recursos_humanos.documentos.destroy', [$empleado, $doc]) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('recursos_humanos.show', $empleado) }}" class="btn btn-secondary">Regresar</a>
@endsection
