@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalle de Equipo en Inventario</h2>
    <div class="card shadow rounded-4 p-4">
        <div class="mb-3">
            <strong>ID:</strong> {{ $equipo->id }}
        </div>
        <div class="mb-3">
            <strong>Cliente:</strong> {{ $equipo->cliente->nombre ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Nombre del Equipo:</strong> {{ $equipo->nombre_equipo }}
        </div>
        <div class="mb-3">
            <strong>Tipo de Equipo:</strong> {{ $equipo->tipo_equipo }}
        </div>
        <div class="mb-3">
            <strong>Modelo:</strong> {{ $equipo->modelo }}
        </div>
        <div class="mb-3">
            <strong>Serie:</strong> {{ $equipo->serie }}
        </div>
        <div class="mb-3">
            <strong>Fecha de registro:</strong> {{ $equipo->created_at->format('d/m/Y H:i') }}
        </div>
        <div>
            <a href="{{ route('inventario_clientes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Regresar
            </a>
        </div>
    </div>
</div>
@endsection
