@extends('layouts.app')
@section('content')
<a href="{{ route('recursos_humanos.index') }}" class="btn btn-secondary mb-2">Regresar</a>
<h2>Detalle de empleado</h2>
<table class="table table-bordered">
    <tr><th>ID</th><td>{{ $empleado->id }}</td></tr>
    <tr><th>Nombre</th><td>{{ $empleado->nombre }} {{ $empleado->apellido }}</td></tr>
    <tr><th>Puesto</th><td>{{ $empleado->puesto->nombre ?? '-' }}</td></tr>
    <tr><th>Fecha ingreso</th><td>{{ $empleado->fecha_ingreso }}</td></tr>
    <tr><th>Estatus</th><td>{{ $empleado->status }}</td></tr>
    <tr><th>RFC</th><td>{{ $empleado->rfc }}</td></tr>
    <tr><th>CURP</th><td>{{ $empleado->curp }}</td></tr>
    <tr><th>Notas internas</th><td>{{ $empleado->notas }}</td></tr>
</table>
{{-- Aquí puedes poner links a submódulos: nómina, permisos, asistencias, docs --}}
<div class="mb-3">
    <a href="{{ route('recursos_humanos.nominas.index', $empleado) }}" class="btn btn-outline-info btn-sm">Nómina</a>
    <a href="{{ route('recursos_humanos.permisos.index', $empleado) }}" class="btn btn-outline-primary btn-sm">Permisos</a>
    <a href="{{ route('recursos_humanos.asistencias.index', $empleado) }}" class="btn btn-outline-warning btn-sm">Asistencias</a>
    <a href="{{ route('recursos_humanos.documentos.index', $empleado) }}" class="btn btn-outline-success btn-sm">Documentos</a>
</div>
<a href="{{ route('recursos_humanos.edit', $empleado) }}" class="btn btn-warning">Editar</a>
@endsection
