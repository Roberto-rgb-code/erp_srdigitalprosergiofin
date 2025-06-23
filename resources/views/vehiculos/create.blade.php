@extends('layouts.app')
@section('content')
    <h2>Registrar Vehículo</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('vehiculos.store') }}">
        @csrf
        <div class="mb-3"><label>Placa</label>
            <input type="text" name="placa" class="form-control" required value="{{ old('placa') }}">
        </div>
        <div class="mb-3"><label>Marca</label>
            <input type="text" name="marca" class="form-control" required value="{{ old('marca') }}">
        </div>
        <div class="mb-3"><label>Modelo</label>
            <input type="text" name="modelo" class="form-control" required value="{{ old('modelo') }}">
        </div>
        <div class="mb-3"><label>Año</label>
            <input type="number" name="año" class="form-control" required value="{{ old('año') }}">
        </div>
        <div class="mb-3"><label>Tipo</label>
            <input type="text" name="tipo" class="form-control" value="{{ old('tipo') }}">
        </div>
        <div class="mb-3"><label>Kilometraje</label>
            <input type="number" step="0.01" name="kilometraje" class="form-control" value="{{ old('kilometraje') }}">
        </div>
        <div class="mb-3"><label>Responsable</label>
            <select name="responsable_id" class="form-select">
                <option value="">Seleccione...</option>
                @foreach($responsables as $r)
                    <option value="{{ $r->id }}" @selected(old('responsable_id') == $r->id)>{{ $r->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3"><label>Estado</label>
            <select name="status" class="form-select" required>
                <option value="">Seleccione...</option>
                <option value="Disponible" @selected(old('status')=='Disponible')>Disponible</option>
                <option value="En uso" @selected(old('status')=='En uso')>En uso</option>
                <option value="En servicio" @selected(old('status')=='En servicio')>En servicio</option>
            </select>
        </div>
        <div class="mb-3"><label>Fecha de adquisición</label>
            <input type="date" name="fecha_adquisicion" class="form-control" value="{{ old('fecha_adquisicion') }}">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
