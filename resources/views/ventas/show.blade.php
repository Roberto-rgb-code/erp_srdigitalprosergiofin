@extends('layouts.app')
@section('content')
    <h2>Detalle de Venta</h2>
    <table class="table">
        <tr><th>Folio</th><td>{{ $venta->folio }}</td></tr>
        <tr><th>ID</th><td>{{ $venta->id }}</td></tr>
        <tr><th>Cliente</th><td>{{ $venta->cliente->nombre ?? '-' }}</td></tr>
        <tr><th>Fecha</th><td>{{ $venta->fecha_venta }}</td></tr>
        <tr><th>Monto Total</th><td>${{ number_format($venta->monto_total,2) }}</td></tr>
        <tr><th>Estatus</th><td>{{ $venta->estatus }}</td></tr>
        <tr><th>Tipo de Venta</th><td>{{ $venta->tipo_venta }}</td></tr>
        <tr><th>Comentarios</th><td>{{ $venta->comentarios }}</td></tr>
    </table>
    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Regresar</a>
    <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('ventas.factura', $venta) }}" class="btn btn-success">Descargar Factura PDF</a>
@endsection
