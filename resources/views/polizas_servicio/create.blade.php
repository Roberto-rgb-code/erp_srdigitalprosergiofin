@extends('layouts.app')
@section('content')
<h2>Nueva Póliza</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif

<form action="{{ route('polizas.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="cliente_id" class="form-label">Cliente</label>
        <select name="cliente_id" id="cliente_id" class="form-select" required>
            <option value="">-- Selecciona --</option>
            @foreach($clientes as $c)
                <option value="{{ $c->id }}" {{ old('cliente_id') == $c->id ? 'selected' : '' }}>
                    {{ $c->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo de póliza</label>
        <input type="text" name="tipo" class="form-control" value="{{ old('tipo') }}" required>
    </div>
    <div class="mb-3">
        <label for="servicios_remoto" class="form-label">Servicios Remoto</label>
        <input type="number" name="servicios_remoto" class="form-control" min="0" value="{{ old('servicios_remoto', 0) }}" required>
    </div>
    <div class="mb-3">
        <label for="servicios_domicilio" class="form-label">Servicios a Domicilio</label>
        <input type="number" name="servicios_domicilio" class="form-control" min="0" value="{{ old('servicios_domicilio', 0) }}" required>
    </div>
    <div class="mb-3">
        <label for="fecha_inicio" class="form-label">Fecha inicio</label>
        <input type="date" name="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}">
    </div>
    <div class="mb-3">
        <label for="fecha_fin" class="form-label">Fecha fin</label>
        <input type="date" name="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}">
    </div>
    <button class="btn btn-primary">Guardar</button>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
