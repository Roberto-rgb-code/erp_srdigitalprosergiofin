@extends('layouts.app')
@section('content')
    <h2>Editar Proyecto de Cableado</h2>
    <form method="POST" action="{{ route('cableado.update', $cableado) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nombre del proyecto</label>
            <input type="text" name="nombre_proyecto" class="form-control" value="{{ old('nombre_proyecto', $cableado->nombre_proyecto) }}" required>
        </div>
        <div class="mb-3">
            <label>Cliente</label>
            <select name="cliente_id" class="form-select" required>
                <option value="">Seleccione...</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}" @selected(old('cliente_id', $cableado->cliente_id) == $c->id)>{{ $c->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Tipo de instalación</label>
            <input type="text" name="tipo_instalacion" class="form-control" value="{{ old('tipo_instalacion', $cableado->tipo_instalacion) }}" required>
        </div>
        <div class="mb-3">
            <label>Dirección del proyecto</label>
            <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $cableado->direccion) }}" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion', $cableado->descripcion) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Fecha de inicio</label>
            <input type="date" name="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $cableado->fecha_inicio) }}" required>
        </div>
        <div class="mb-3">
            <label>Fecha de fin estimada</label>
            <input type="date" name="fecha_fin" class="form-control" value="{{ old('fecha_fin', $cableado->fecha_fin) }}">
        </div>
        <div class="mb-3">
            <label>Responsable del proyecto</label>
            <input type="text" name="responsable" class="form-control" value="{{ old('responsable', $cableado->responsable) }}" required>
        </div>
        <div class="mb-3">
            <label>Costo estimado</label>
            <input type="number" step="0.01" name="costo_estimado" class="form-control" value="{{ old('costo_estimado', $cableado->costo_estimado) }}">
        </div>
        <div class="mb-3">
            <label>Costo real</label>
            <input type="number" step="0.01" name="costo_real" class="form-control" value="{{ old('costo_real', $cableado->costo_real) }}">
        </div>
        <div class="mb-3">
            <label>Estado del proyecto</label>
            <select name="estatus" class="form-select" required>
                <option value="">Seleccione...</option>
                <option value="Planeado" @selected(old('estatus', $cableado->estatus) == 'Planeado')>Planeado</option>
                <option value="En curso" @selected(old('estatus', $cableado->estatus) == 'En curso')>En curso</option>
                <option value="Finalizado" @selected(old('estatus', $cableado->estatus) == 'Finalizado')>Finalizado</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Comentarios</label>
            <textarea name="comentarios" class="form-control">{{ old('comentarios', $cableado->comentarios) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('cableado.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
