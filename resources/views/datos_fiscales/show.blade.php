@extends('layouts.app')
@section('content')
    <h2>Datos Fiscales del Cliente</h2>
    <div class="card">
        <div class="card-body">
            <p><b>Nombre fiscal:</b> {{ $datoFiscal->nombre_fiscal }}</p>
            <p><b>RFC:</b> {{ $datoFiscal->rfc }}</p>
            <p><b>Dirección fiscal:</b> {{ $datoFiscal->direccion_fiscal }}</p>
            <p><b>Uso CFDI:</b> {{ $datoFiscal->uso_cfdi }}</p>
            <p><b>Correo:</b> {{ $datoFiscal->correo }}</p>
            <p><b>Régimen fiscal:</b> {{ $datoFiscal->regimen_fiscal }}</p>
        </div>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-2">Volver</a>
@endsection
