@extends('layouts.app')
@section('content')
    <h2>Detalle del Cliente</h2>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $cliente->nombre }}</h5>
            <p><b>RFC:</b> {{ $cliente->rfc }}</p>
            <p><b>Dirección:</b> {{ $cliente->direccion }}</p>
            <p><b>Contacto:</b> {{ $cliente->contacto }}</p>
            <p><b>Tipo:</b> {{ $cliente->tipo_cliente }}</p>
            <p><b>¿Requiere factura?:</b> {{ $cliente->requiere_factura ? 'Sí' : 'No' }}</p>
            <p><b>Límite crédito:</b> ${{ number_format($cliente->limite_credito,2) }}</p>
            <p><b>Saldo:</b> ${{ number_format($cliente->saldo,2) }}</p>
            <p><b>Crédito:</b> {{ $cliente->tiene_linea_credito ? 'Sí' : 'No' }}</p>
            <p><b>Estatus:</b> {{ $cliente->status }}</p>
            {{-- Aquí puedes agregar sección para historial, documentos, ventas, etc. --}}
        </div>
    </div>
    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver</a>
@endsection
