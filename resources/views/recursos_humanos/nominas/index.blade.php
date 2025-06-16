@extends('layouts.app')
@section('content')
<h2>Nómina de {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
<a href="{{ route('recursos_humanos.nominas.create', $empleado) }}" class="btn btn-primary mb-2">Nueva nómina</a>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Fecha pago</th><th>Sueldo base</th><th>Monto pagado</th><th>Tipo pago</th><th>Cuenta</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($nominas as $n)
        <tr>
            <td>{{ $n->fecha_pago }}</td>
            <td>${{ number_format($n->sueldo_base,2) }}</td>
            <td>${{ number_format($n->monto_pagado,2) }}</td>
            <td>{{ $n->tipo_pago }}</td>
            <td>{{ $n->cuenta_bancaria }}</td>
            <td>
                <a href="{{ route('recursos_humanos.nominas.edit', [$empleado, $n]) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('recursos_humanos.nominas.destroy', [$empleado, $n]) }}" method="POST" style="display:inline-block">
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
