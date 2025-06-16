@extends('layouts.app')
@section('content')
<h2>Caja Chica</h2>
<a href="{{ route('caja_chica.create') }}" class="btn btn-warning mb-3">Registrar movimiento</a>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Monto</th>
            <th>Responsable</th>
            <th>Comprobante</th>
            <th>Comentarios</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($caja as $mov)
        <tr>
            <td>{{ $mov->fecha }}</td>
            <td>{{ $mov->tipo }}</td>
            <td>${{ number_format($mov->monto, 2) }}</td>
            <td>{{ $mov->responsable->nombre ?? '-' }}</td>
            <td>
                @if($mov->comprobante)
                    <a href="{{ asset('storage/'.$mov->comprobante) }}" target="_blank">Ver</a>
                @else
                    -
                @endif
            </td>
            <td>{{ $mov->comentarios }}</td>
            <td>
                <a href="{{ route('caja_chica.edit', $mov) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('caja_chica.destroy', $mov) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
