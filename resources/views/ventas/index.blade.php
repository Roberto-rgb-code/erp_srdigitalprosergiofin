@extends('layouts.app')
@section('content')
    <h2>Ventas</h2>
    <a href="{{ route('ventas.create') }}" class="btn btn-primary mb-3">Nueva Venta</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form class="row g-2 mb-3" method="GET">
        <div class="col">
            <select name="cliente_id" class="form-select">
                <option value="">Cliente</option>
                @foreach($clientes as $cl)
                    <option value="{{ $cl->id }}" @selected(request('cliente_id') == $cl->id)>{{ $cl->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <input type="date" name="fecha_venta" class="form-control" value="{{ request('fecha_venta') }}">
        </div>
        <div class="col">
            <input type="text" name="tipo_venta" class="form-control" placeholder="Tipo de venta" value="{{ request('tipo_venta') }}">
        </div>
        <div class="col">
            <select name="estatus" class="form-select">
                <option value="">Estatus</option>
                <option value="Pagado" @selected(request('estatus')=='Pagado')>Pagado</option>
                <option value="Pendiente" @selected(request('estatus')=='Pendiente')>Pendiente</option>
                <option value="Cancelado" @selected(request('estatus')=='Cancelado')>Cancelado</option>
            </select>
        </div>
        <div class="col">
            <button class="btn btn-secondary">Buscar</button>
            <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
        <div class="col">
            <a href="{{ route('ventas.export.excel', request()->all()) }}" class="btn btn-success">Exportar Excel</a>
            <a href="{{ route('ventas.export.pdf', request()->all()) }}" class="btn btn-danger">Exportar PDF</a>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Folio</th>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Monto Total</th>
                <th>Estatus</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ventas as $v)
                <tr>
                    <td>{{ $v->folio }}</td>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->cliente->nombre ?? '-' }}</td>
                    <td>{{ $v->fecha_venta }}</td>
                    <td>${{ number_format($v->monto_total,2) }}</td>
                    <td>{{ $v->estatus }}</td>
                    <td>{{ $v->tipo_venta }}</td>
                    <td>
                        <a href="{{ route('ventas.show', $v) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('ventas.edit', $v) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('ventas.destroy', $v) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">No hay ventas.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $ventas->links() }}
@endsection
