@extends('layouts.app')
@section('content')
<h2>Detalle de egreso</h2>
<ul class="list-group mb-3">
    <li class="list-group-item"><b>ID:</b> {{ $egreso->id }}</li>
    <li class="list-group-item"><b>Tipo:</b> {{ $egreso->tipo_egreso }}</li>
    <li class="list-group-item"><b>Monto:</b> ${{ number_format($egreso->monto,2) }}</li>
    <li class="list-group-item"><b>Fecha:</b> {{ $egreso->fecha }}</li>
    <li class="list-group-item"><b>Cuenta:</b> {{ $egreso->cuentaBancaria->banco ?? '-' }}</li>
    <li class="list-group-item"><b>Descripción:</b> {{ $egreso->descripcion }}</li>
</ul>
<a href="{{ route('egresos.index') }}" class="btn btn-secondary">Volver</a>
@endsection
