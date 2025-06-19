@extends('layouts.app')
@section('content')
<h2>{{ isset($desarrollo_software) ? 'Editar' : 'Nuevo' }} Proyecto de Software</h2>
<form method="POST" 
      action="{{ isset($desarrollo_software) ? route('desarrollo_software.update', $desarrollo_software) : route('desarrollo_software.store') }}">
    @csrf
    @if(isset($desarrollo_software))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label>Cliente:</label>
        <select name="cliente_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($clientes as $c)
                <option value="{{ $c->id }}" 
                    @selected(old('cliente_id', $desarrollo_software->cliente_id ?? '') == $c->id)>
                    {{ $c->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Nombre del proyecto:</label>
        <input type="text" name="nombre" class="form-control"
               value="{{ old('nombre', $desarrollo_software->nombre ?? '') }}" required maxlength="100">
    </div>

    <div class="mb-3">
        <label>Tipo de software:</label>
        <select name="tipo_software_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($tipos as $t)
                <option value="{{ $t->id }}"
                    @selected(old('tipo_software_id', $desarrollo_software->tipo_software_id ?? '') == $t->id)>
                    {{ $t->nombre }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">El catálogo de tipos se administra en la tabla tipo_software.</small>
    </div>

    <div class="mb-3">
        <label>Stack tecnológico:</label>
        <input type="text" name="stack_tecnologico" class="form-control"
            value="{{ old('stack_tecnologico', $desarrollo_software->stack_tecnologico ?? '') }}"
            list="stacks_tec" maxlength="150" placeholder="Ej: Python, Vue, SQL">
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
        <label>Fecha inicio:</label>
        <input type="date" name="fecha_inicio" class="form-control"
            value="{{ old('fecha_inicio', $desarrollo_software->fecha_inicio ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label>Fecha entrega (opcional):</label>
        <input type="date" name="fecha_fin" class="form-control"
            value="{{ old('fecha_fin', $desarrollo_software->fecha_fin ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Responsable:</label>
        <select name="responsable_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($responsables as $r)
                <option value="{{ $r->id }}"
                    @selected(old('responsable_id', $desarrollo_software->responsable_id ?? '') == $r->id)>
                    {{ $r->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Estado:</label>
        @php
            $estados = ['Planeado', 'En desarrollo', 'Testing', 'Finalizado'];
        @endphp
        <select name="estado" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($estados as $estado)
                <option value="{{ $estado }}"
                    @selected(old('estado', $desarrollo_software->estado ?? '') == $estado)>
                    {{ $estado }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Historial/Notas:</label>
        <textarea name="historial" class="form-control">{{ old('historial', $desarrollo_software->historial ?? '') }}</textarea>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('desarrollo_software.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
