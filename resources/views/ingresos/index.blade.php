@extends('layouts.app')
@section('content')
<h2>Ingresos</h2>
<a href="{{ route('ingresos.create') }}" class="btn btn-success mb-3">Registrar ingreso</a>
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
        @foreach($ingresos as $i)
        <tr>
            <td>{{ $i->fecha }}</td>
            <td>{{ $i->tipo_ingreso }}</td>
            <td>{{ $i->referencia_id }}</td>
            <td>${{ number_format($i->monto, 2) }}</td>
            <td>{{ $i->cuentaBancaria->banco ?? '-' }}</td>
            <td>{{ $i->descripcion }}</td>
            <td>
                <a href="{{ route('ingresos.edit', $i) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('ingresos.destroy', $i) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
