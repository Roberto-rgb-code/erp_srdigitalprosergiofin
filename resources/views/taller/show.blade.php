@extends('layouts.app')
@section('content')
    <h2>Detalle Orden de Servicio</h2>
    <table class="table">
        <tr><th>Folio</th><td>{{ $taller->folio }}</td></tr>
        <tr><th>Cliente</th><td>{{ $taller->cliente->nombre ?? '-' }}</td></tr>
        <tr><th>Tipo de cliente</th><td>{{ $taller->tipo_cliente }}</td></tr>
        <tr>
            <th>Equipo</th>
            <td>
                {{ $taller->equipo->tipo ?? '-' }} 
                {{ $taller->equipo->marca ?? '' }} 
                {{ $taller->equipo->modelo ?? '' }} 
                ({{ $taller->equipo->imei ?? '' }})
            </td>
        </tr>
        <tr><th>Condición física</th><td>{{ $taller->condicion_fisica }}</td></tr>
        <tr><th>Estética</th><td>{{ $taller->estetica }}</td></tr>
        <tr><th>IMEI / Número de serie</th><td>{{ $taller->imei }}</td></tr>
        <tr><th>Tipo de bloqueo</th><td>{{ $taller->tipo_bloqueo }}</td></tr>
        <tr><th>Zona de trabajo</th><td>{{ $taller->zona_trabajo }}</td></tr>
        <tr><th>Fecha de ingreso</th><td>{{ $taller->fecha_ingreso }}</td></tr>
        <tr><th>Fecha de entrega</th><td>{{ $taller->fecha_entrega }}</td></tr>
        <tr><th>Responsable técnico</th><td>{{ $taller->tecnico->nombre ?? '-' }}</td></tr>
        <tr><th>Observaciones del equipo</th><td>{{ $taller->observaciones }}</td></tr>
        <tr><th>Detalle del problema</th><td>{{ $taller->detalle_problema }}</td></tr>
        <tr><th>Solución</th><td>{{ $taller->solucion }}</td></tr>
        <tr><th>Costo total</th><td>${{ number_format($taller->costo_total,2) }}</td></tr>
        <tr><th>Anticipo</th><td>${{ number_format($taller->anticipo,2) }}</td></tr>
        <tr><th>Firma del cliente</th><td>{{ $taller->firma_cliente }}</td></tr>
        <tr><th>Estatus</th><td>{{ $taller->status }}</td></tr>
    </table>
    <a href="{{ route('taller.index') }}" class="btn btn-secondary">Regresar</a>
    <a href="{{ route('taller.edit', $taller) }}" class="btn btn-warning">Editar</a>
@endsection
