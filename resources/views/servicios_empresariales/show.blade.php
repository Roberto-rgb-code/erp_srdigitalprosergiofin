@extends('layouts.app')
@section('content')
<h2>Detalle del Servicio Empresarial</h2>
<ul class="list-group mb-3">
    <li class="list-group-item"><strong>Cliente:</strong> {{ $servicios_empresariales->cliente->nombre ?? '-' }}</li>
    <li class="list-group-item"><strong>Poliza:</strong> {{ $servicios_empresariales->poliza->tipo ?? '-' }}</li>
    <li class="list-group-item"><strong>Estatus:</strong> {{ $servicios_empresariales->estatus }}</li>
    <li class="list-group-item"><strong>Comentarios:</strong> {{ $servicios_empresariales->comentarios }}</li>
</ul>
<a href="{{ route('servicios_empresariales.index') }}" class="btn btn-secondary">Volver</a>
@endsection
