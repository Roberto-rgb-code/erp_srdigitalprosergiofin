@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Diario Contable</h2>
    <a href="{{ route('diario_contable.create') }}" class="btn btn-primary mb-3">Nuevo Movimiento</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Póliza</th>
                <th>Cuenta</th>
                <th>Descripción</th>
                <th>Cargo</th>
                <th>Abono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $m)
            <tr>
                <td>{{ $m->poliza->id ?? '-' }} - {{ $m->poliza->descripcion ?? '-' }}</td>
                <td>{{ $m->cuenta->codigo ?? '' }} {{ $m->cuenta->nombre ?? '' }}</td>
                <td>{{ $m->descripcion }}</td>
                <td>${{ number_format($m->cargo, 2) }}</td>
                <td>${{ number_format($m->abono, 2) }}</td>
                <td>
                    <a href="{{ route('diario_contable.edit', $m) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('diario_contable.destroy', $m) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('¿Eliminar?')" class="btn btn-danger btn-sm">Borrar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
