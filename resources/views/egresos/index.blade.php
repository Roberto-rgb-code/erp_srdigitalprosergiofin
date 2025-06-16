@extends('layouts.app')
@section('content')
<h2>Egresos</h2>
<a href="{{ route('egresos.create') }}" class="btn btn-danger mb-3">Registrar egreso</a>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Referencia</th>
            <th>Monto</th>
            <th>Cuenta Bancaria</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($egresos as $e)
        <tr>
            <td>{{ $e->fecha }}</td>
            <td>{{ $e->tipo_egreso }}</td>
            <td>{{ $e->referencia_id }}</td>
            <td>${{ number_format($e->monto, 2) }}</td>
            <td>{{ $e->cuentaBancaria->banco ?? '-' }}</td>
            <td>{{ $e->descripcion }}</td>
            <td>
                <a href="{{ route('egresos.edit', $e) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('egresos.destroy', $e) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
