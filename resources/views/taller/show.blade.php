@extends('layouts.app')
@section('content')
<div class="card mt-4 shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Detalle de Orden: {{ $taller->folio }}</h4>
        <a href="{{ route('taller.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Cliente</dt>
            <dd class="col-sm-9">{{ $taller->cliente->nombre ?? '-' }}</dd>

            <dt class="col-sm-3">Tipo de Cliente</dt>
            <dd class="col-sm-9">{{ $taller->tipo_cliente }}</dd>

            <dt class="col-sm-3">Equipo</dt>
            <dd class="col-sm-9">{{ $taller->equipo->tipo ?? '-' }} {{ $taller->equipo->marca ?? '' }} {{ $taller->equipo->modelo ?? '' }}</dd>

            <dt class="col-sm-3">Técnico</dt>
            <dd class="col-sm-9">{{ $taller->tecnico->nombre ?? '-' }}</dd>

            <dt class="col-sm-3">Ingreso</dt>
            <dd class="col-sm-9">{{ $taller->fecha_ingreso }}</dd>

            <dt class="col-sm-3">Entrega</dt>
            <dd class="col-sm-9">{{ $taller->fecha_entrega }}</dd>

            <dt class="col-sm-3">Detalle del Problema</dt>
            <dd class="col-sm-9">{{ $taller->detalle_problema }}</dd>

            <dt class="col-sm-3">Solución</dt>
            <dd class="col-sm-9">{{ $taller->solucion }}</dd>

            <dt class="col-sm-3">Observaciones</dt>
            <dd class="col-sm-9">{{ $taller->observaciones }}</dd>

            <dt class="col-sm-3">Costo Total</dt>
            <dd class="col-sm-9">${{ number_format($taller->costo_total,2) }}</dd>

            <dt class="col-sm-3">Anticipo</dt>
            <dd class="col-sm-9">${{ number_format($taller->anticipo,2) }}</dd>
        </dl>
    </div>
</div>
@endsection
