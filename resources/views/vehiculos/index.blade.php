@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
        <h2 class="mb-0">Control de Vehículos</h2>
        <div>
            <a href="{{ route('vehiculos.create') }}" class="btn btn-primary">Nuevo vehículo</a>
            <a href="{{ route('vehiculos.export.excel') }}" class="btn btn-outline-success">Exportar Excel</a>
            <a href="{{ route('vehiculos.export.pdf') }}" class="btn btn-outline-danger">Exportar PDF</a>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- GRAFICOS RESUMEN --}}
    <div class="row mt-3 mb-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Vehículos por Estado</h6>
                    <canvas id="graficoEstados" height="130"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Vehículos por Marca</h6>
                    <canvas id="graficoMarcas" height="130"></canvas>
                </div>
            </div>
        </div>
    </div>

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

    {{-- Tabla de vehículos --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle rounded shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Tipo</th>
                    <th>Kilometraje</th>
                    <th>Responsable</th>
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
                        <td>
                            <span class="badge
                                @if($v->status=='Disponible') bg-success
                                @elseif($v->status=='En uso') bg-primary
                                @else bg-warning text-dark
                                @endif">
                                {{ $v->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('vehiculos.show', $v) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('vehiculos.edit', $v) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('vehiculos.destroy', $v) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
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
                    <tr><td colspan="10" class="text-center">No hay vehículos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $vehiculos->appends(request()->except('page'))->links() }}
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Datos desde el controlador para los gráficos
    const estados = {!! json_encode(array_keys($graficoEstados)) !!};
    const cantidadesEstados = {!! json_encode(array_values($graficoEstados)) !!};
    const marcas = {!! json_encode(array_keys($graficoMarcas)) !!};
    const cantidadesMarcas = {!! json_encode(array_values($graficoMarcas)) !!};

    // Gráfico de Estado
    new Chart(document.getElementById('graficoEstados'), {
        type: 'pie',
        data: {
            labels: estados,
            datasets: [{
                data: cantidadesEstados,
                backgroundColor: ['#49c79b', '#007bff', '#ffc107', '#ddd'],
                borderWidth: 1
            }]
        }
    });
    // Gráfico de Marcas
    new Chart(document.getElementById('graficoMarcas'), {
        type: 'bar',
        data: {
            labels: marcas,
            datasets: [{
                data: cantidadesMarcas,
                backgroundColor: '#36a2eb'
            }]
        }
    });
</script>
@endpush
