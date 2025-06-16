@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cuentas por Pagar</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FILTROS --}}
    <form class="row row-cols-lg-auto g-2 align-items-center mb-4" method="GET">
        <div class="col">
            <select name="proveedor_id" class="form-select">
                <option value="">Todos los proveedores</option>
                @foreach($proveedores as $prov)
                    <option value="{{ $prov->id }}" {{ request('proveedor_id') == $prov->id ? 'selected' : '' }}>
                        {{ $prov->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <select name="estatus" class="form-select">
                <option value="">Todos los estatus</option>
                <option value="En tiempo" {{ request('estatus') == 'En tiempo' ? 'selected' : '' }}>En tiempo</option>
                <option value="Próximo a vencer" {{ request('estatus') == 'Próximo a vencer' ? 'selected' : '' }}>Próximo a vencer</option>
                <option value="Vencido" {{ request('estatus') == 'Vencido' ? 'selected' : '' }}>Vencido</option>
                <option value="Pagado" {{ request('estatus') == 'Pagado' ? 'selected' : '' }}>Pagado</option>
            </select>
        </div>
        <div class="col">
            <input type="date" name="desde" class="form-control" value="{{ request('desde') }}">
        </div>
        <div class="col">
            <input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}">
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
        <div class="col">
            <a href="{{ route('cuentas_por_pagar.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>

    <div class="mb-3">
        <a href="{{ route('cuentas_por_pagar.create') }}" class="btn btn-success">Registrar nueva CxP</a>
        {{-- Puedes agregar botones de exportación aquí si tienes exportaciones --}}
    </div>

    <div class="alert alert-info">
        <b>Total por pagar:</b> ${{ number_format($total_deuda ?? 0, 2) }}
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Proveedor</th>
                    <th>Factura</th>
                    <th>Monto</th>
                    <th>Saldo</th>
                    <th>Vencimiento</th>
                    <th>Estatus</th>
                    <th>Semáforo</th>
                    <th>% Impacto</th>
                    <th>Comprobante</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($registros as $reg)
                <tr>
                    <td>{{ $registros->firstItem() + $loop->index }}</td>
                    <td>{{ $reg->proveedor->nombre ?? '-' }}</td>
                    <td>{{ $reg->factura ?? '-' }}</td>
                    <td>${{ number_format($reg->monto, 2) }}</td>
                    <td>
                        ${{ number_format($reg->saldo, 2) }}
                        @if($reg->saldo == 0)
                            <span class="badge bg-success">Pagado</span>
                        @elseif($reg->semaforo == 'rojo')
                            <span class="badge bg-danger">Vencido</span>
                        @elseif($reg->semaforo == 'amarillo')
                            <span class="badge bg-warning text-dark">Próx. a vencer</span>
                        @else
                            <span class="badge bg-info text-dark">En tiempo</span>
                        @endif
                    </td>
                    <td>{{ $reg->fecha_vencimiento ? \Carbon\Carbon::parse($reg->fecha_vencimiento)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $reg->estatus }}</td>
                    <td>
                        @if($reg->semaforo == 'verde')
                            <span style="color:green;">●</span>
                        @elseif($reg->semaforo == 'amarillo')
                            <span style="color:orange;">●</span>
                        @elseif($reg->semaforo == 'rojo')
                            <span style="color:red;">●</span>
                        @else
                            <span style="color:gray;">●</span>
                        @endif
                    </td>
                    <td>{{ $reg->impacto_porcentaje ?? 0 }}%</td>
                    <td>
                        @if($reg->comprobante)
                            <a href="{{ asset('storage/' . $reg->comprobante) }}" target="_blank">Ver</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cuentas_por_pagar.show', $reg->id) }}" class="btn btn-sm btn-primary">Ver</a>
                        <a href="{{ route('cuentas_por_pagar.edit', $reg->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('cuentas_por_pagar.destroy', $reg->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('¿Eliminar?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="11">No hay cuentas por pagar.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $registros->links() }}
    </div>
</div>
@endsection
