@extends('layouts.app')
@section('content')
<h2>Nuevo Proyecto de Software</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('desarrollo_software.store') }}">
    @csrf

    <div class="mb-3">
        <label for="cliente_id">Cliente:</label>
        <select name="cliente_id" id="cliente_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($clientes as $c)
            <option value="{{ $c->id }}" @selected(old('cliente_id') == $c->id)>{{ $c->nombre_completo }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="nombre">Nombre del proyecto:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required maxlength="100"
            value="{{ old('nombre') }}">
    </div>

    <div class="mb-3">
        <label for="tipo_software">Tipo de software:</label>
        <input type="text" name="tipo_software" id="tipo_software" class="form-control" maxlength="150"
            placeholder="Ej: Web, Móvil, API, Escritorio" value="{{ old('tipo_software') }}" list="tipos_software">
        <datalist id="tipos_software">
            <option value="Web">
            <option value="Móvil">
            <option value="API">
            <option value="Escritorio">
            <option value="Servicio en la nube">
            <option value="Microservicio">
            <option value="IoT">
            <option value="Otro">
        </datalist>
        <small class="text-muted">Escribe libremente o elige una opción.</small>
    </div>

    <div class="mb-3">
        <label for="stack_tecnologico">Stack tecnológico:</label>
        <input type="text" name="stack_tecnologico" id="stack_tecnologico" class="form-control" maxlength="150"
            placeholder="Ej: Python, Vue, SQL" value="{{ old('stack_tecnologico') }}" list="stacks_tec">
        <datalist id="stacks_tec">
            <option value="Laravel, Vue, MySQL">
            <option value="React, Node.js, PostgreSQL">
            <option value="Django, React, PostgreSQL">
            <option value="Spring Boot, Angular, Oracle">
            <option value="Flask, React Native, SQLite">
            <option value="Express, Next.js, MongoDB">
            <option value="Ruby on Rails, React, PostgreSQL">
            <option value=".NET Core, Blazor, SQL Server">
            <option value="Python, FastAPI, MongoDB">
            <option value="Flutter, Firebase">
            <option value="Otros...">
        </datalist>
        <small class="text-muted">Escribe libremente o elige una sugerencia.</small>
    </div>

    <div class="mb-3">
        <label for="fecha_inicio">Fecha inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required
            value="{{ old('fecha_inicio') }}">
    </div>

    <div class="mb-3">
        <label for="fecha_fin">Fecha entrega (opcional):</label>
        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}">
    </div>

    <div class="mb-3">
        <label for="responsable_id">Responsable:</label>
        <select name="responsable_id" id="responsable_id" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($responsables as $r)
            <option value="{{ $r->id }}" @selected(old('responsable_id') == $r->id)>{{ $r->nombre }}</option>
            @endforeach
        </select>
        <small class="text-muted">Opcional</small>
    </div>

    <div class="mb-3">
        <label for="estado">Estado:</label>
        @php
        $estados = ['Planeado', 'En desarrollo', 'Testing', 'Finalizado'];
        @endphp
        <select name="estado" id="estado" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($estados as $estado)
            <option value="{{ $estado }}" @selected(old('estado') == $estado)>{{ $estado }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="historial">Historial/Notas:</label>
        <textarea name="historial" id="historial" class="form-control">{{ old('historial') }}</textarea>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('desarrollo_software.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
