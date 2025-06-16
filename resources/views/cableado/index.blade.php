@extends('layouts.app')
@section('content')
    <h2>Proyectos de Cableado</h2>
    <div class="mb-3 d-flex gap-2 flex-wrap">
        <a href="{{ route('cableado.create') }}" class="btn btn-primary">Nuevo proyecto</a>
        <a href="{{ route('cableado.export.excel', request()->query()) }}" class="btn btn-success">Exportar Excel</a>
        <a href="{{ route('cableado.export.pdf', request()->query()) }}" class="btn btn-danger">Exportar PDF</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filtros --}}
    <form class="row row-cols-lg-auto g-2 align-items-center mb-4" method="GET">
        <div class="col">
            <input type="text" name="nombre_proyecto" class="form-control" placeholder="Proyecto" value="{{ request('nombre_proyecto') }}">
        </div>
        <div class="col">
            <select name="cliente_id" class="form-select">
                <option value="">Cliente</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}" @if(request('cliente_id') == $c->id) selected @endif>{{ $c->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <select name="tipo_instalacion" class="form-select">
                <option value="">Tipo instalación</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->nombre }}" @if(request('tipo_instalacion') == $tipo->nombre) selected @endif>{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <select name="responsable_id" class="form-select">
                <option value="">Responsable</option>
                @foreach($responsables as $r)
                    <option value="{{ $r->id }}" @if(request('responsable_id') == $r->id) selected @endif>{{ $r->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <input type="date" name="fecha_inicio_de" class="form-control" value="{{ request('fecha_inicio_de') }}" placeholder="Fecha inicio de">
        </div>
        <div class="col">
            <input type="date" name="fecha_inicio_hasta" class="form-control" value="{{ request('fecha_inicio_hasta') }}" placeholder="Fecha inicio hasta">
        </div>
        <div class="col">
            <select name="estatus" class="form-select">
                <option value="">Estado</option>
                <option value="Planeado" @if(request('estatus')=='Planeado') selected @endif>Planeado</option>
                <option value="En curso" @if(request('estatus')=='En curso') selected @endif>En curso</option>
                <option value="Finalizado" @if(request('estatus')=='Finalizado') selected @endif>Finalizado</option>
            </select>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-outline-primary">Buscar</button>
            <a href="{{ route('cableado.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Proyecto</th>
                <th>Cliente</th>
                <th>Tipo instalación</th>
                <th>Dirección</th>
                <th>Responsable</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Estado</th>
                <th>Costo estimado</th>
                <th>Costo real</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cableados as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->nombre_proyecto }}</td>
                    <td>{{ $c->cliente->nombre ?? '-' }}</td>
                    <td>{{ $c->tipo_instalacion }}</td>
                    <td>{{ $c->direccion }}</td>
                    <td>{{ $c->responsable->nombre ?? '-' }}</td>
                    <td>{{ $c->fecha_inicio }}</td>
                    <td>{{ $c->fecha_fin }}</td>
                    <td>{{ $c->estatus }}</td>
                    <td>${{ number_format($c->costo_estimado,2) }}</td>
                    <td>${{ number_format($c->costo_real,2) }}</td>
                    <td>
                        <a href="{{ route('cableado.show', $c) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('cableado.edit', $c) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('cableado.destroy', $c) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="12">No hay proyectos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $cableados->appends(request()->except('page'))->links() }}
@endsection
