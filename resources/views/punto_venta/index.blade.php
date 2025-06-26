@extends('layouts.app')
@section('content')
<h3>Punto de Venta — Movimientos de Caja</h3>

<div class="mb-3">
    <a href="{{ route('punto_venta.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Registrar movimiento
    </a>
</div>
<div class="mb-3">
    <strong>Saldo disponible:</strong> ${{ number_format($saldo, 2) }}
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped table-hover">
    <thead class="table-light">
        <tr>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Monto</th>
            <th>Descripción</th>
            <th>Comprobante</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @forelse($movimientos as $punto_ventum)
        <tr>
            <td>{{ \Carbon\Carbon::parse($punto_ventum->fecha)->format('d/m/Y') }}</td>
            <td>
                @if($punto_ventum->tipo == 'entrada')
                    <span class="badge bg-success">Entrada</span>
                @else
                    <span class="badge bg-danger">Salida</span>
                @endif
            </td>
            <td>${{ number_format($punto_ventum->monto, 2) }}</td>
            <td>{{ $punto_ventum->descripcion }}</td>
            <td>
                @if($punto_ventum->comprobante)
                    <a href="{{ asset('storage/'.$punto_ventum->comprobante) }}" target="_blank">Ver archivo</a>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>
                <a href="{{ route('punto_venta.show', ['punto_ventum' => $punto_ventum->id]) }}" class="btn btn-primary btn-sm" title="Ver">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('punto_venta.edit', ['punto_ventum' => $punto_ventum->id]) }}" class="btn btn-warning btn-sm" title="Editar">
                    <i class="bi bi-pencil"></i>
                </a>
                <form method="POST" action="{{ route('punto_venta.destroy', ['punto_ventum' => $punto_ventum->id]) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este movimiento?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center">No hay movimientos registrados.</td></tr>
    @endforelse
    </tbody>
</table>
{{ $movimientos->links() }}
@endsection
