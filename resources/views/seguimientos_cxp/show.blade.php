@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Detalle de Seguimiento</h2>
    <div class="card mb-3">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Fecha</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($seguimiento->fecha)->format('d/m/Y') }}</dd>
                <dt class="col-sm-4">Comentario</dt>
                <dd class="col-sm-8">{{ $seguimiento->comentario }}</dd>
                <dt class="col-sm-4">Tipo</dt>
                <dd class="col-sm-8">{{ ucfirst($seguimiento->tipo) }}</dd>
                <dt class="col-sm-4">Porcentaje de Impacto</dt>
                <dd class="col-sm-8">{{ $seguimiento->porcentaje_impacto }}%</dd>
            </dl>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('cuentas_por_pagar.show', $seguimiento->cuenta_pagar_id) }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>
    </div>
</div>
@endsection
