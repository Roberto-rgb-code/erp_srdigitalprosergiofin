@extends('layouts.app')
@section('content')
    <h2>Detalle del Proyecto de Cableado</h2>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $cableado->nombre_proyecto }}</h5>
            <dl class="row">
                <dt class="col-sm-4">Cliente</dt>
                <dd class="col-sm-8">{{ $cableado->cliente->nombre_completo ?? '-' }}</dd>

                <dt class="col-sm-4">Tipo de instalación</dt>
                <dd class="col-sm-8">{{ $cableado->tipo_instalacion }}</dd>

                <dt class="col-sm-4">Dirección</dt>
                <dd class="col-sm-8">{{ $cableado->direccion }}</dd>

                <dt class="col-sm-4">Descripción</dt>
                <dd class="col-sm-8">{{ $cableado->descripcion ?? '-' }}</dd>

                <dt class="col-sm-4">Fecha de inicio</dt>
                <dd class="col-sm-8">{{ $cableado->fecha_inicio }}</dd>

                <dt class="col-sm-4">Fecha de fin</dt>
                <dd class="col-sm-8">{{ $cableado->fecha_fin ?? '-' }}</dd>

                <dt class="col-sm-4">Responsable</dt>
                <dd class="col-sm-8">{{ $cableado->responsable->nombre ?? '-' }}</dd>

                <dt class="col-sm-4">Costo estimado</dt>
                <dd class="col-sm-8">${{ number_format($cableado->costo_estimado ?? 0, 2) }}</dd>

                <dt class="col-sm-4">Costo real</dt>
                <dd class="col-sm-8">${{ number_format($cableado->costo_real ?? 0, 2) }}</dd>

                <dt class="col-sm-4">Estado</dt>
                <dd class="col-sm-8">
                    <span class="badge
                        @if($cableado->estatus == 'Planeado') bg-secondary
                        @elseif($cableado->estatus == 'En curso') bg-warning
                        @elseif($cableado->estatus == 'Finalizado') bg-success
                        @else bg-light text-dark @endif">
                        {{ $cableado->estatus }}
                    </span>
                </dd>

                <dt class="col-sm-4">Comentarios</dt>
                <dd class="col-sm-8">{{ $cableado->comentarios ?? '-' }}</dd>
            </dl>

            <a href="{{ route('cableado.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('cableado.edit', $cableado) }}" class="btn btn-warning">Editar</a>
        </div>
    </div>

    {{-- Sección de movimientos de balance --}}
    <h3>Movimientos de Balance</h3>
    <a href="{{ route('balance.create', $cableado) }}" class="btn btn-success mb-3">Agregar Movimiento</a>

    @if($cableado->balances->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Responsable</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Monto</th>
                    <th>Facturable</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cableado->balances as $balance)
                    <tr>
                        <td>{{ $balance->responsable->nombre ?? '-' }}</td>
                        <td>{{ $balance->fecha_gasto }}</td>
                        <td>{{ ucfirst($balance->tipo_movimiento) }}</td>
                        <td>${{ number_format($balance->monto, 2) }}</td>
                        <td>{{ $balance->facturable ? 'Sí' : 'No' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay movimientos registrados para este proyecto.</p>
    @endif
@endsection
