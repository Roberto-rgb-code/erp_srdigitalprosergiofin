@extends('layouts.app')
@section('content')
<h2>Registrar nuevo empleado</h2>

@if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif

<form action="{{ route('recursos_humanos.store') }}" method="POST">
    @csrf
    <div class="mb-2">
        <label>Nombre:</label>
        <input type="text" name="nombre" class="form-control" required value="{{ old('nombre') }}">
    </div>
    <div class="mb-2">
        <label>Apellido:</label>
        <input type="text" name="apellido" class="form-control" required value="{{ old('apellido') }}">
    </div>
    <div class="mb-2">
        <label>RFC:</label>
        <input type="text" name="rfc" class="form-control" value="{{ old('rfc') }}">
    </div>
    <div class="mb-2">
        <label>CURP:</label>
        <input type="text" name="curp" class="form-control" value="{{ old('curp') }}">
    </div>
    <div class="mb-2">
        <label>Puesto:</label>
        <input type="text" name="puesto" class="form-control" value="{{ old('puesto') }}">
    </div>
    <div class="mb-2">
        <label>Fecha de ingreso:</label>
        <input type="date" name="fecha_ingreso" class="form-control" required value="{{ old('fecha_ingreso') }}">
    </div>
    <div class="mb-2">
        <label>Status:</label>
        <select name="status" class="form-control">
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
            <option value="Baja">Baja</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Salario:</label>
        <input type="number" name="salario" class="form-control" step="0.01" value="{{ old('salario') }}">
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('recursos_humanos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
