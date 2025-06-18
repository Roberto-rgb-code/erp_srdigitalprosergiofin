@extends('layouts.app')
@section('content')
    <h2>Editar Vehículo</h2>
    @if ($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form method="POST" action="{{ route('vehiculos.update', $vehiculo) }}">
        @csrf @method('PUT')
        <div class="mb-3"><label>Placa</label>
            <input type="text" name="placa" class="form-control" required value="{{ old('placa', $vehiculo->placa) }}">
        </div>
        <div class="mb-3"><label>Marca</label>
            <input type="text" name="marca" class="form-control" required value="{{ old('marca', $vehiculo->marca) }}">
        </div>
        <div class="mb-3"><label>Modelo</label>
            <input type="text" name="modelo" class="form-control" required value="{{ old('modelo', $vehiculo->modelo) }}">
        </div>
        <div class="mb-3"><label>Año</label>
            <input type="number" name="año" class="form-control" required value="{{ old('año', $vehiculo->año) }}">
        </div>
        <div class="mb-3"><label>Tipo</label>
            <input type="text" name="tipo" class="form-control" value="{{ old('tipo', $vehiculo->tipo) }}">
        </div>
        <div class="mb-3"><label>Kilometraje</label>
            <input type="number" step="0.01" name="kilometraje" class="form-control" value="{{ old('kilometraje', $vehiculo->kilometraje) }}">
        </div>
        <div class="mb-3"><label>Responsable</label>
            <select name="responsable_id" class="form-select">
                <option value="">Seleccione...</option>
                @foreach($responsables as $r)
                    <option value="{{ $r->id }}" @selected(old('responsable_id', $vehiculo->responsable_id) == $r->id)>{{ $r->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3"><label>Cliente</label>
            <select name="cliente_id" class="form-select">
                <option value="">Seleccione...</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}" @selected(old('cliente_id', $vehiculo->cliente_id) == $c->id)>{{ $c->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3"><label>Estado</label>
            <select name="status" class="form-select" required>
                <option value="">Seleccione...</option>
                <option value="Disponible" @selected(old('status', $vehiculo->status)=='Disponible')>Disponible</option>
                <option value="En uso" @selected(old('status', $vehiculo->status)=='En uso')>En uso</option>
                <option value="En servicio" @selected(old('status', $vehiculo->status)=='En servicio')>En servicio</option>
            </select>
        </div>
        <div class="mb-3"><label>Fecha de adquisición</label>
            <input type="date" name="fecha_adquisicion" class="form-control" value="{{ old('fecha_adquisicion', $vehiculo->fecha_adquisicion) }}">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
