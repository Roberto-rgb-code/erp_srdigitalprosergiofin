@extends('layouts.app')
@section('content')
<h2>Detalle de ingreso</h2>
<ul class="list-group mb-3">
    <li class="list-group-item"><b>ID:</b> {{ $ingreso->id }}</li>
    <li class="list-group-item"><b>Tipo:</b> {{ $ingreso->tipo_ingreso }}</li>
    <li class="list-group-item"><b>Monto:</b> ${{ number_format($ingreso->monto,2) }}</li>
    <li class="list-group-item"><b>Fecha:</b> {{ $ingreso->fecha }}</li>
    <li class="list-group-item"><b>Cuenta:</b> {{ $ingreso->cuentaBancaria->banco ?? '-' }}</li>
    <li class="list-group-item"><b>Descripción:</b> {{ $ingreso->descripcion }}</li>
</ul>
<a href="{{ route('ingresos.index') }}" class="btn btn-secondary">Volver</a>
@endsection
