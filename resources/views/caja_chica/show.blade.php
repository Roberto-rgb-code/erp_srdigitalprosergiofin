@extends('layouts.app')
@section('content')
<h2>Detalle de movimiento de Caja Chica</h2>
<ul class="list-group mb-3">
    <li class="list-group-item"><b>ID:</b> {{ $caja_chica->id }}</li>
    <li class="list-group-item"><b>Fecha:</b> {{ $caja_chica->fecha }}</li>
    <li class="list-group-item"><b>Tipo:</b> {{ $caja_chica->tipo }}</li>
    <li class="list-group-item"><b>Monto:</b> ${{ number_format($caja_chica->monto,2) }}</li>
    <li class="list-group-item"><b>Responsable:</b> {{ $caja_chica->responsable->nombre ?? '-' }}</li>
    <li class="list-group-item"><b>Comprobante:</b>
        @if($caja_chica->comprobante)
            <a href="{{ asset('storage/comprobantes/'.$caja_chica->comprobante) }}" target="_blank">Ver comprobante</a>
        @else
            -
        @endif
    </li>
    <li class="list-group-item"><b>Comentarios:</b> {{ $caja_chica->comentarios }}</li>
</ul>
<a href="{{ route('caja_chica.index') }}" class="btn btn-secondary">Volver</a>
@endsection
