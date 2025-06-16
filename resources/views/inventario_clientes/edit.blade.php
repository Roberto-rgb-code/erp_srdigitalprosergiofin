@extends('layouts.app')
@section('content')
<h2>Editar equipo</h2>
@if($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form action="{{ route('inventario_clientes.update', $inventario_cliente) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-2"><label>Cliente:</label>
        <select name="cliente_id" class="form-control">
            @foreach($clientes as $c)
                <option value="{{ $c->id }}" @if($c->id == $inventario_cliente->cliente_id) selected @endif>{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2"><label>Nombre equipo:</label><input name="nombre_equipo" class="form-control" value="{{ $inventario_cliente->nombre_equipo }}"></div>
    <div class="mb-2"><label>Tipo equipo:</label><input name="tipo_equipo" class="form-control" value="{{ $inventario_cliente->tipo_equipo }}"></div>
    <div class="mb-2"><label>Modelo:</label><input name="modelo" class="form-control" value="{{ $inventario_cliente->modelo }}"></div>
    <div class="mb-2"><label>Número de serie:</label><input name="serie" class="form-control" value="{{ $inventario_cliente->serie }}"></div>
    <div class="mb-2"><label>Ubicación:</label><input name="ubicacion" class="form-control" value="{{ $inventario_cliente->ubicacion }}"></div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('inventario_clientes.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
