@extends('layouts.app')
@section('content')
    <h2>Nuevo Proyecto de Cableado</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('cableado.store') }}">
        @csrf
        <div class="mb-3">
            <label for="nombre_proyecto">Nombre del proyecto</label>
            <input type="text" name="nombre_proyecto" id="nombre_proyecto" class="form-control" value="{{ old('nombre_proyecto') }}" required>
        </div>
        <div class="mb-3">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">Seleccione...</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}" @selected(old('cliente_id') == $c->id)>{{ $c->nombre_completo ?? $c->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tipo_instalacion">Tipo de instalación</label>
            <input type="text" name="tipo_instalacion" id="tipo_instalacion" class="form-control" value="{{ old('tipo_instalacion') }}" required>
        </div>
        <div class="mb-3">
            <label for="direccion">Dirección del proyecto</label>
            <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}" required>
        </div>
        <div class="mb-3">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="fecha_inicio">Fecha de inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" required>
        </div>
        <div class="mb-3">
            <label for="fecha_fin">Fecha de fin estimada</label>
            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}">
        </div>
        <div class="mb-3">
            <label for="responsable_id">Responsable del proyecto</label>
            <select name="responsable_id" id="responsable_id" class="form-select" required>
                <option value="">Seleccione...</option>
                @foreach($responsables as $r)
                    <option value="{{ $r->id }}" @selected(old('responsable_id') == $r->id)>{{ $r->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="costo_estimado">Costo estimado</label>
            <input type="number" step="0.01" name="costo_estimado" id="costo_estimado" class="form-control" value="{{ old('costo_estimado') }}">
        </div>
        <div class="mb-3">
            <label for="costo_real">Costo real</label>
            <input type="number" step="0.01" name="costo_real" id="costo_real" class="form-control" value="{{ old('costo_real') }}">
        </div>
        <div class="mb-3">
            <label for="estatus">Estado del proyecto</label>
            <select name="estatus" id="estatus" class="form-select" required>
                <option value="">Seleccione...</option>
                <option value="Planeado" @selected(old('estatus') == 'Planeado')>Planeado</option>
                <option value="En curso" @selected(old('estatus') == 'En curso')>En curso</option>
                <option value="Finalizado" @selected(old('estatus') == 'Finalizado')>Finalizado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="comentarios">Comentarios</label>
            <textarea name="comentarios" id="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('cableado.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
