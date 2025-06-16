@extends('layouts.app')
@section('content')
<h2>Registrar Ticket de Soporte</h2>
<form action="{{ route('tickets_soporte.store') }}" method="POST">
    @csrf
    <div class="mb-2">
        <label>Cliente:</label>
        <select name="cliente_id" class="form-select" required>
            @foreach($clientes as $c)
                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Tipo de póliza:</label>
        <select name="poliza_servicio_id" class="form-select" required>
            @foreach($polizas as $p)
                <option value="{{ $p->id }}">{{ $p->tipo }} (Remoto: {{ $p->servicios_restantes_remoto }}, Domicilio: {{ $p->servicios_restantes_domicilio }})</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Tipo de Servicio:</label>
        <select name="tipo_servicio" class="form-select" required>
            <option value="Remoto">Remoto</option>
            <option value="Domicilio">Domicilio</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Descripción del Problema:</label>
        <textarea name="descripcion" class="form-control" required></textarea>
    </div>
    <div class="mb-2">
        <label>Prioridad:</label>
        <select name="prioridad" class="form-select">
            <option value="Baja">Baja</option>
            <option value="Media">Media</option>
            <option value="Alta">Alta</option>
            <option value="Crítica">Crítica</option>
        </select>
    </div>
    <button class="btn btn-success">Registrar Ticket</button>
    <a href="{{ route('tickets_soporte.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
