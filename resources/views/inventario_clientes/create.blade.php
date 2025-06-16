@extends('layouts.app')
@section('content')
    <h2>Agregar equipo a inventario</h2>
    <form action="{{ route('inventario_clientes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Servicio Empresarial</label>
            <select name="servicios_empresariales_id" class="form-select" required>
                <option value="">--Selecciona--</option>
                @foreach($servicios as $s)
                    <option value="{{ $s->id }}">{{ $s->id }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Cliente</label>
            <select name="cliente_id" class="form-select">
                <option value="">--Selecciona--</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Nombre equipo</label>
            <input type="text" name="nombre_equipo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tipo equipo</label>
            <input type="text" name="tipo_equipo" class="form-control">
        </div>
        <div class="mb-3">
            <label>Modelo</label>
            <input type="text" name="modelo" class="form-control">
        </div>
        <div class="mb-3">
            <label>Serie</label>
            <input type="text" name="serie" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
@endsection
