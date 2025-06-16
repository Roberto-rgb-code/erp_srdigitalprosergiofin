@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cuentas por Pagar</h2>

    {{-- Acciones y exportaciones --}}
    <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
        <a href="{{ route('cuentas_por_pagar.create') }}" class="btn btn-primary btn-sm">Nueva Cuenta por Pagar</a>
        <a href="{{ route('cuentas_por_pagar.export.excel') }}" class="btn btn-success btn-sm">Exportar Excel</a>
        <a href="{{ route('cuentas_por_pagar.export.pdf') }}" class="btn btn-danger btn-sm">Exportar PDF</a>
    </div>

    {{-- Filtros --}}
    <form class="row row-cols-lg-auto g-2 align-items-center mb-4" method="GET">
        <div class="col">
            <select name="proveedor_id" class="form-select">
                <option value="">Proveedor</option>
                @foreach($proveedores as $p)
                    <option value="{{ $p->id }}" @if(request('proveedor_id') == $p->id) selected @endif>{{ $p->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <select name="estatus" class="form-select">
                <option value="">Estatus</option>
                <option value="En tiempo" @if(request('estatus') == 'En tiempo') selected @endif>En tiempo</option>
                <option value="Próximo a vencer" @if(request('estatus') == 'Próximo a vencer') selected @endif>Próximo a vencer</option>
                <option value="Vencido" @if(request('estatus') == 'Vencido') selected @endif>Vencido</option>
                <option value="Pagado" @if(request('estatus') == 'Pagado') selected @endif>Pagado</option>
            </select>
        </div>
        <div class="col">
            <label>Vencimiento</label>
            <input type="date" name="desde" class="form-control" value="{{ request('desde') }}">
        </div>
        <div class="col">
            <label>a</label>
            <input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}">
        </div>
        <div class="col">
            <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
        </div>
        <div class="col">
            <a href="{{ route('cuentas_por_pagar.index') }}" class="btn btn-outline-dark">Limpiar</a>
        </div>
    </form>

    {{-- Tabla de registros --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Proveedor</th>
                    <th>Factura</th>
                    <th>Monto</th>
                    <th>Saldo</th>
                    <th>Vencimiento</th>
                    <th>Pago</th>
                    <th>Estatus</th>
                    <th>Comentarios</th>
                    <th>Comprobante</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($registros as $c)
                <tr>
                    <td>{{ $c->proveedor->nombre ?? '-' }}</td>
                    <td>{{ $c->factura }}</td>
                    <td>${{ number_format($c->monto, 2) }}</td>
                    <td>${{ number_format($c->saldo, 2) }}</td>
                    <td>{{ $c->fecha_vencimiento }}</td>
                    <td>{{ $c->fecha_pago ?? '-' }}</td>
                    <td>
                        {{-- Semáforo visual --}}
                        @php
                            $color = match($c->estatus) {
                                'Vencido' => 'danger',
                                'Próximo a vencer' => 'warning',
                                'En tiempo' => 'success',
                                'Pagado' => 'secondary',
                                default => 'light'
                            };
                        @endphp
                        <span class="badge bg-{{ $color }}">{{ $c->estatus }}</span>
                    </td>
                    <td>{{ $c->comentarios }}</td>
                    <td>
                        @if($c->comprobante)
                            <a href="{{ asset('storage/'.$c->comprobante) }}" target="_blank">Ver</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cuentas_por_pagar.show', $c->id) }}" class="btn btn-outline-info btn-sm" title="Ver"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('cuentas_por_pagar.edit', $c->id) }}" class="btn btn-outline-primary btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('cuentas_por_pagar.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este registro?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Sin registros.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación y resumen --}}
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            <b>Total deuda vigente:</b> ${{ number_format($total_deuda, 2) }}
        </div>
        <div>
            {{ $registros->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
