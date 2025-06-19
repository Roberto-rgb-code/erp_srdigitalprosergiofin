@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Catálogo de Cuentas Contables</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('cuentas_contables.create') }}" class="btn btn-primary mb-3">Nueva Cuenta</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Cuenta Padre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuentas as $cuenta)
            <tr>
                <td>{{ $cuenta->codigo }}</td>
                <td>{{ $cuenta->nombre }}</td>
                <td>{{ $cuenta->tipo }}</td>
                <td>{{ $cuenta->cuentaPadre->nombre ?? '-' }}</td>
                <td>
                    <a href="{{ route('cuentas_contables.edit', $cuenta) }}" class="btn btn-warning btn-sm">Editar</a>

                    <form action="{{ route('cuentas_contables.destroy', $cuenta) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar cuenta?')" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $cuentas->links() }}
</div>
@endsection
