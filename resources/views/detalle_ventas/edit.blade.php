@extends('layouts.app')
@section('content')
    <h2>Editar producto/servicio en venta #{{ $venta->id }}</h2>
    <form method="POST" action="{{ route('ventas.detalle_ventas.update', [$venta->id, $detalle->id]) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Producto o Servicio</label>
            <input type="text" name="producto_servicio" value="{{ old('producto_servicio', $detalle->producto_servicio) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Cantidad</label>
            <input type="number" step="1" name="cantidad" value="{{ old('cantidad', $detalle->cantidad) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Precio Unitario</label>
            <input type="number" step="0.01" name="precio_unitario" value="{{ old('precio_unitario', $detalle->precio_unitario) }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('ventas.detalle_ventas.index', $venta->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
