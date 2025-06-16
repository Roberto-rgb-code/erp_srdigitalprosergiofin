@extends('layouts.app')
@section('content')
<h2>Cuentas Bancarias</h2>
<a href="{{ route('cuentas_bancarias.create') }}" class="btn btn-primary mb-3">Nueva cuenta bancaria</a>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Banco</th>
            <th>No. Cuenta</th>
            <th>CLABE</th>
            <th>Saldo</th>
            <th>Status</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cuentas as $c)
        <tr>
            <td>{{ $c->banco }}</td>
            <td>{{ $c->numero_cuenta }}</td>
            <td>{{ $c->clabe }}</td>
            <td>${{ number_format($c->saldo, 2) }}</td>
            <td>{{ $c->status }}</td>
            <td>
                <a href="{{ route('cuentas_bancarias.edit', $c) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('cuentas_bancarias.destroy', $c) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
