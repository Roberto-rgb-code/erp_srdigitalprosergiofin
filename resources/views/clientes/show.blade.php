@extends('layouts.app')
@section('content')
    <h2>Detalle Cliente</h2>
    <table class="table">
        <tr><th>Folio</th><td>{{ $cliente->folio }}</td></tr>
        <tr><th>Nombre</th><td>{{ $cliente->nombre }}</td></tr>
        <tr><th>RFC</th><td>{{ $cliente->rfc }}</td></tr>
        <tr><th>Dirección</th><td>{{ $cliente->direccion }}</td></tr>
        <tr><th>Contacto</th><td>{{ $cliente->contacto }}</td></tr>
        <tr><th>Tipo</th><td>{{ $cliente->tipo_cliente }}</td></tr>
        <tr><th>Límite crédito</th><td>${{ number_format($cliente->limite_credito,2) }}</td></tr>
        <tr><th>Saldo</th><td>${{ number_format($cliente->saldo,2) }}</td></tr>
        <tr><th>Estatus</th><td>{{ $cliente->status }}</td></tr>
    </table>
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Regresar</a>
    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">Editar</a>
@endsection
