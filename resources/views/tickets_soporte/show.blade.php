@extends('layouts.app')
@section('content')
<h2>Detalle de Ticket de Soporte</h2>
<table class="table">
    <tr><th>Folio</th><td>{{ $tickets_soporte->folio }}</td></tr>
    <tr><th>Cliente</th><td>{{ $tickets_soporte->cliente->nombre ?? '' }}</td></tr>
    <tr><th>Poliza</th><td>{{ $tickets_soporte->poliza->tipo ?? '' }}</td></tr>
    <tr><th>Asunto</th><td>{{ $tickets_soporte->asunto }}</td></tr>
    <tr><th>Descripción</th><td>{{ $tickets_soporte->descripcion }}</td></tr>
    <tr><th>Equipo</th><td>{{ $tickets_soporte->equipo->nombre_equipo ?? '' }}</td></tr>
    <tr><th>Responsable</th><td>{{ $tickets_soporte->responsable->nombre ?? '' }}</td></tr>
    <tr><th>Prioridad</th><td>{{ $tickets_soporte->prioridad }}</td></tr>
    <tr><th>Estado</th><td>{{ $tickets_soporte->estado }}</td></tr>
</table>
<a href="{{ route('tickets_soporte.edit', $tickets_soporte) }}" class="btn btn-warning">Editar</a>
<a href="{{ route('tickets_soporte.index') }}" class="btn btn-secondary">Volver</a>
@endsection
