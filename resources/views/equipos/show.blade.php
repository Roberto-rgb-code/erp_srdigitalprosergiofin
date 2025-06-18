@extends('layouts.app')
@section('content')
<div class="card mt-4 shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Detalle de Equipo #{{ $equipo->id }}</h4>
        <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Tipo</dt>
            <dd class="col-sm-9">{{ $equipo->tipo }}</dd>
            <dt class="col-sm-3">Marca</dt>
            <dd class="col-sm-9">{{ $equipo->marca }}</dd>
            <dt class="col-sm-3">Modelo</dt>
            <dd class="col-sm-9">{{ $equipo->modelo }}</dd>
            <dt class="col-sm-3">Color</dt>
            <dd class="col-sm-9"><span style="display:inline-block;width:24px;height:24px;border-radius:50%;background:{{ $equipo->color }};border:1px solid #ccc;"></span> {{ $equipo->color }}</dd>
            <dt class="col-sm-3">IMEI/Serie</dt>
            <dd class="col-sm-9">{{ $equipo->imei }}</dd>
            <dt class="col-sm-3">Condición Física</dt>
            <dd class="col-sm-9">{{ $equipo->condicion_fisica }}</dd>
            <dt class="col-sm-3">Estética</dt>
            <dd class="col-sm-9">{{ $equipo->estetica }}</dd>
            <dt class="col-sm-3">Zona de trabajo</dt>
            <dd class="col-sm-9">{{ $equipo->zona_trabajo }}</dd>
        </dl>
    </div>
</div>
@endsection
