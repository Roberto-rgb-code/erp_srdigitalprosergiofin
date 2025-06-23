@extends('layouts.app')
@section('content')
    <h2>Detalle del Cliente</h2>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $cliente->nombre_completo }}</h5>
            @if($cliente->empresa)
                <p><b>Empresa:</b> {{ $cliente->empresa }}</p>
            @endif
            <p><b>Contacto:</b> {{ $cliente->contacto }}</p>
            <p><b>Dirección:</b> {{ $cliente->direccion }}</p>
            <p><b>Tipo:</b> {{ $cliente->tipo_cliente }}</p>
            <p><b>Estatus:</b> {{ $cliente->status }}</p>
            <hr>
            <h6 class="fw-bold">Datos fiscales</h6>
            @if($cliente->datoFiscal)
                <p><b>Nombre fiscal:</b> {{ $cliente->datoFiscal->nombre_fiscal }}</p>
                <p><b>RFC:</b> {{ $cliente->datoFiscal->rfc }}</p>
                <p><b>Dirección fiscal:</b> {{ $cliente->datoFiscal->direccion_fiscal }}</p>
                <p><b>Uso de CFDI:</b> {{ $cliente->datoFiscal->uso_cfdi }}</p>
                <p><b>Correo electrónico:</b> {{ $cliente->datoFiscal->correo }}</p>
                <p><b>Régimen fiscal:</b> {{ $cliente->datoFiscal->regimen_fiscal }}</p>
            @else
                <p class="text-muted">No hay datos fiscales registrados.</p>
            @endif
            {{-- Puedes agregar aquí sección para historial, documentos, ventas, etc. --}}
        </div>
    </div>
    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver</a>
@endsection
