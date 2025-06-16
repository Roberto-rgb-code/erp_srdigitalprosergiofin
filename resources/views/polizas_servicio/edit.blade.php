@extends('layouts.app')
@section('content')
<h2>Editar Póliza</h2>
@if($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form action="{{ route('polizas_servicio.update', $polizas_servicio) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-2">
        <label>Cliente:</label>
        <select name="cliente_id" class="form-control">
            @foreach($clientes as $c)
                <option value="{{ $c->id }}" @if($c->id == $polizas_servicio->cliente_id) selected @endif>{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2"><label>Tipo:</label><input name="tipo" class="form-control" value="{{ $polizas_servicio->tipo }}"></div>
    <div class="mb-2"><label>Servicios Remotos:</label><input type="number" name="servicios_remotos" class="form-control" value="{{ $polizas_servicio->servicios_remotos }}"></div>
    <div class="mb-2"><label>Servicios Domicilio:</label><input type="number" name="servicios_domicilio" class="form-control" value="{{ $polizas_servicio->servicios_domicilio }}"></div>
    <div class="mb-2"><label>Fecha inicio:</label><input type="date" name="fecha_inicio" class="form-control" value="{{ $polizas_servicio->fecha_inicio }}"></div>
    <div class="mb-2"><label>Fecha fin:</label><input type="date" name="fecha_fin" class="form-control" value="{{ $polizas_servicio->fecha_fin }}"></div>
    <div class="mb-2"><label>Estado:</label>
        <select name="estatus" class="form-control">
            <option @if($polizas_servicio->estatus == 'Activa') selected @endif>Activa</option>
            <option @if($polizas_servicio->estatus == 'Vencida') selected @endif>Vencida</option>
        </select>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('polizas_servicio.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
