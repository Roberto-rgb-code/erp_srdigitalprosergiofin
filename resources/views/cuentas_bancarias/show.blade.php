@extends('layouts.app')
@section('content')
<h2>Detalle de cuenta bancaria</h2>
<ul class="list-group mb-3">
    <li class="list-group-item"><b>ID:</b> {{ $cuenta_bancaria->id }}</li>
    <li class="list-group-item"><b>Banco:</b> {{ $cuenta_bancaria->banco }}</li>
    <li class="list-group-item"><b>No. Cuenta:</b> {{ $cuenta_bancaria->numero_cuenta }}</li>
    <li class="list-group-item"><b>CLABE:</b> {{ $cuenta_bancaria->clabe }}</li>
    <li class="list-group-item"><b>Saldo:</b> ${{ number_format($cuenta_bancaria->saldo,2) }}</li>
    <li class="list-group-item"><b>Status:</b> {{ $cuenta_bancaria->status }}</li>
</ul>
<a href="{{ route('cuentas_bancarias.index') }}" class="btn btn-secondary">Volver</a>
@endsection
