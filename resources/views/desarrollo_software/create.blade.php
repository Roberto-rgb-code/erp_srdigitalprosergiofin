@extends('layouts.app')
@section('content')
<h2>Nuevo Proyecto de Software</h2>
<form method="POST" action="{{ route('desarrollo_software.store') }}">
    @csrf
    <div class="mb-2">
        <label>Cliente:</label>
        <select name="cliente_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($clientes as $c)
                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Nombre del proyecto:</label>
        <input type="text" name="nombre" class="form-control" required maxlength="100">
    </div>
    <div class="mb-2">
        <label>Tipo de software:</label>
        <select name="tipo_software_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($tipos as $t)
                <option value="{{ $t->id }}">{{ $t->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Stack tecnológico:</label>
        <input type="text" name="stack_tecnologico" class="form-control" maxlength="150" placeholder="Ej: Python, Vue, SQL">
    </div>
    <div class="mb-2">
        <label>Fecha inicio:</label>
        <input type="date" name="fecha_inicio" class="form-control" required>
    </div>
    <div class="mb-2">
        <label>Fecha entrega (opcional):</label>
        <input type="date" name="fecha_fin" class="form-control">
    </div>
    <div class="mb-2">
        <label>Responsable:</label>
        <select name="responsable_id" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($responsables as $r)
                <option value="{{ $r->id }}">{{ $r->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Estado:</label>
        <select name="estado" class="form-control" required>
            <option>Planeado</option>
            <option>En desarrollo</option>
            <option>Testing</option>
            <option>Finalizado</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Historial/Notas:</label>
        <textarea name="historial" class="form-control"></textarea>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('desarrollo_software.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
@extends('layouts.app')
@section('content')
<h2>Nuevo Proyecto de Software</h2>
<form method="POST" action="{{ route('desarrollo_software.store') }}">
    @csrf
    <div class="mb-2">
        <label>Cliente:</label>
        <select name="cliente_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($clientes as $c)
                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Nombre del proyecto:</label>
        <input type="text" name="nombre" class="form-control" required maxlength="100">
    </div>
    <div class="mb-2">
        <label>Tipo de software:</label>
        <select name="tipo_software_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($tipos as $t)
                <option value="{{ $t->id }}">{{ $t->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Stack tecnológico:</label>
        <input type="text" name="stack_tecnologico" class="form-control" maxlength="150" placeholder="Ej: Python, Vue, SQL">
    </div>
    <div class="mb-2">
        <label>Fecha inicio:</label>
        <input type="date" name="fecha_inicio" class="form-control" required>
    </div>
    <div class="mb-2">
        <label>Fecha entrega (opcional):</label>
        <input type="date" name="fecha_fin" class="form-control">
    </div>
    <div class="mb-2">
        <label>Responsable:</label>
        <select name="responsable_id" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($responsables as $r)
                <option value="{{ $r->id }}">{{ $r->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Estado:</label>
        <select name="estado" class="form-control" required>
            <option>Planeado</option>
            <option>En desarrollo</option>
            <option>Testing</option>
            <option>Finalizado</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Historial/Notas:</label>
        <textarea name="historial" class="form-control"></textarea>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('desarrollo_software.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
