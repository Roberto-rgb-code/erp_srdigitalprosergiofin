@extends('layouts.app')
@section('content')
    <h2>Nueva Orden de Servicio</h2>
    <form method="POST" action="{{ route('taller.store') }}">
        @csrf

        <div class="mb-3">
            <label>Cliente</label>
            <select name="cliente_id" class="form-select" required>
                <option value="">Seleccione cliente...</option>
                @foreach($clientes as $cl)
                    <option value="{{ $cl->id }}" @selected(old('cliente_id') == $cl->id)>{{ $cl->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tipo de cliente</label>
            <select name="tipo_cliente" class="form-select">
                <option value="">Seleccione...</option>
                <option value="Normal" @selected(old('tipo_cliente') == 'Normal')>Normal</option>
                <option value="Empresa" @selected(old('tipo_cliente') == 'Empresa')>Empresa</option>
                <option value="Otro" @selected(old('tipo_cliente') == 'Otro')>Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Equipo</label>
            <select name="equipo_id" class="form-select" required>
                <option value="">Seleccione equipo...</option>
                @foreach($equipos as $e)
                    <option value="{{ $e->id }}" @selected(old('equipo_id') == $e->id)>
                        {{ $e->tipo }} - {{ $e->marca }} {{ $e->modelo }} ({{ $e->imei }})
                    </option>
                @endforeach
            </select>
            <small><a href="{{ route('equipos.create') }}">Registrar nuevo equipo</a></small>
        </div>

        <div class="mb-3">
            <label>Condición física</label>
            <input type="text" name="condicion_fisica" value="{{ old('condicion_fisica') }}" class="form-control" placeholder="Ejemplo: Encendido, Roto, etc.">
        </div>

        <div class="mb-3">
            <label>Estética</label>
            <select name="estetica" class="form-select">
                <option value="">Seleccione...</option>
                <option value="Bueno" @selected(old('estetica') == 'Bueno')>Bueno</option>
                <option value="Regular" @selected(old('estetica') == 'Regular')>Regular</option>
                <option value="Malo" @selected(old('estetica') == 'Malo')>Malo</option>
            </select>
        </div>

        <div class="mb-3">
            <label>IMEI / Número de serie</label>
            <input type="text" name="imei" value="{{ old('imei') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tipo de bloqueo</label>
            <select name="tipo_bloqueo" class="form-select">
                <option value="">Seleccione...</option>
                <option value="PIN" @selected(old('tipo_bloqueo') == 'PIN')>PIN</option>
                <option value="PATRON" @selected(old('tipo_bloqueo') == 'PATRON')>Patrón</option>
                <option value="NINGUNO" @selected(old('tipo_bloqueo') == 'NINGUNO')>Ninguno</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Zona de trabajo</label>
            <input type="text" name="zona_trabajo" value="{{ old('zona_trabajo') }}" class="form-control" placeholder="Ejemplo: Almacén, Banco de pruebas, etc.">
        </div>

        <div class="mb-3">
            <label>Fecha de ingreso</label>
            <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Fecha de entrega (estimada)</label>
            <input type="date" name="fecha_entrega" value="{{ old('fecha_entrega') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Responsable técnico</label>
            <select name="tecnico_id" class="form-select" required>
                <option value="">Seleccione técnico...</option>
                @foreach($responsables as $r)
                    <option value="{{ $r->id }}" @selected(old('tecnico_id') == $r->id)>{{ $r->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Observaciones del equipo</label>
            <textarea name="observaciones" class="form-control">{{ old('observaciones') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Detalle del problema <span class="text-danger">*</span></label>
            <textarea name="detalle_problema" class="form-control" required>{{ old('detalle_problema') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Solución (opcional)</label>
            <textarea name="solucion" class="form-control">{{ old('solucion') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Costo total</label>
            <input type="number" step="0.01" name="costo_total" value="{{ old('costo_total') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Anticipo</label>
            <input type="number" step="0.01" name="anticipo" value="{{ old('anticipo') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Firma del cliente (texto/base64/imagen)</label>
            <input type="text" name="firma_cliente" value="{{ old('firma_cliente') }}" class="form-control">
            <small>Campo para almacenar firma. (puedes implementar canvas o subir imagen después)</small>
        </div>

        <div class="mb-3">
            <label>Estatus</label>
            <select name="status" class="form-select">
                <option value="">Seleccione...</option>
                <option value="Ingresado" @selected(old('status') == 'Ingresado')>Ingresado</option>
                <option value="En proceso" @selected(old('status') == 'En proceso')>En proceso</option>
                <option value="Terminado" @selected(old('status') == 'Terminado')>Terminado</option>
                <option value="Entregado" @selected(old('status') == 'Entregado')>Entregado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('taller.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
