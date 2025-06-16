@extends('layouts.app')
@section('content')
    <h2>Control de Vehículos</h2>
    <a href="{{ route('vehiculos.create') }}" class="btn btn-primary mb-3">Nuevo vehículo</a>
    <a href="{{ route('vehiculos.export.excel') }}" class="btn btn-outline-success mb-3">Exportar Excel</a>
    <a href="{{ route('vehiculos.export.pdf') }}" class="btn btn-outline-danger mb-3">Exportar PDF</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filtros --}}
    <form class="row row-cols-lg-auto g-2 align-items-center mb-4" method="GET">
        <div class="col">
            <input type="text" name="placa" class="form-control" placeholder="Placa" value="{{ request('placa') }}">
        </div>
        <div class="col">
            <input type="text" name="marca" class="form-control" placeholder="Marca" value="{{ request('marca') }}">
        </div>
        <div class="col">
            <input type="text" name="modelo" class="form-control" placeholder="Modelo" value="{{ request('modelo') }}">
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
            <input type="number" name="anio_de" class="form-control" placeholder="Año desde" value="{{ request('anio_de') }}">
        </div>
        <div class="col">
            <input type="number" name="anio_hasta" class="form-control" placeholder="Año hasta" value="{{ request('anio_hasta') }}">
        </div>
        <div class="col">
            <select name="status" class="form-select">
                <option value="">Estado</option>
                <option value="Disponible" @if(request('status')=='Disponible') selected @endif>Disponible</option>
                <option value="En uso" @if(request('status')=='En uso') selected @endif>En uso</option>
                <option value="En servicio" @if(request('status')=='En servicio') selected @endif>En servicio</option>
            </select>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-outline-primary">Buscar</button>
            <a href="{{ route('vehiculos.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Tipo</th>
                <th>Kilometraje</th>
                <th>Responsable</th>
                <th>Cliente</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vehiculos as $v)
                <tr>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->placa }}</td>
                    <td>{{ $v->marca }}</td>
                    <td>{{ $v->modelo }}</td>
                    <td>{{ $v->año }}</td>
                    <td>{{ $v->tipo }}</td>
                    <td>{{ $v->kilometraje ?? 0 }}</td>
                    <td>{{ $v->responsable->nombre ?? '-' }}</td>
                    <td>{{ $v->cliente->nombre ?? '-' }}</td>
                    <td>{{ $v->status }}</td>
                    <td>
                        <a href="{{ route('vehiculos.show', $v) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('vehiculos.edit', $v) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('vehiculos.destroy', $v) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                        <div class="btn-group mt-1">
                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Submódulos
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('vehiculos.consumo.index', $v->id) }}">Consumo</a></li>
                                <li><a class="dropdown-item" href="{{ route('vehiculos.mantenimiento.index', $v->id) }}">Mantenimientos</a></li>
                                <li><a class="dropdown-item" href="{{ route('vehiculos.uso.index', $v->id) }}">Uso</a></li>
                                <li><a class="dropdown-item" href="{{ route('vehiculos.evidencia.index', $v->id) }}">Evidencias</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="11">No hay vehículos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $vehiculos->appends(request()->except('page'))->links() }}
@endsection
