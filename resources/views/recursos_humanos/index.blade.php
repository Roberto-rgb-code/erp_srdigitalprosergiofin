@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Empleados</h2>
        <div>
            <a href="{{ route('recursos_humanos.create') }}" class="btn btn-success">Nuevo empleado</a>
            <a href="{{ route('recursos_humanos.export.excel') }}" class="btn btn-outline-success ms-2">Exportar Excel</a>
            <a href="{{ route('recursos_humanos.export.pdf') }}" class="btn btn-outline-danger ms-2">Exportar PDF</a>
        </div>
    </div>

    {{-- FILTROS --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre o Apellido" value="{{ request('nombre') }}">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Estatus</option>
                <option value="Activo" @selected(request('status')=='Activo')>Activo</option>
                <option value="Inactivo" @selected(request('status')=='Inactivo')>Inactivo</option>
                <option value="Baja" @selected(request('status')=='Baja')>Baja</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="fecha_ingreso" class="form-control" value="{{ request('fecha_ingreso') }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="puesto" class="form-control" placeholder="Puesto" value="{{ request('puesto') }}">
        </div>
        <div class="col-md-3 d-flex">
            <button type="submit" class="btn btn-outline-primary me-2">Filtrar</button>
            <a href="{{ route('recursos_humanos.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- RESUMEN ESTADÍSTICO --}}
    <div class="row mb-3">
        <div class="col">
            <div class="card border-secondary text-center">
                <div class="card-body">
                    <h6>Total empleados</h6>
                    <h4>{{ $empleados->total() }}</h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-success text-center">
                <div class="card-body">
                    <h6>Activos</h6>
                    <h4>{{ $empleados->where('status','Activo')->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-warning text-center">
                <div class="card-body">
                    <h6>Inactivos</h6>
                    <h4>{{ $empleados->where('status','Inactivo')->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-danger text-center">
                <div class="card-body">
                    <h6>Baja</h6>
                    <h4>{{ $empleados->where('status','Baja')->count() }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLA PRINCIPAL --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Número Empleado</th>
                    <th>Colaborador</th>
                    <th>Puesto</th>
                    <th>Ingreso</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empleados as $e)
                <tr>
                    <td>{{ $e->id }}</td>
                    <td>{{ $e->numero_empleado }}</td>
                    <td><a href="{{ route('recursos_humanos.show',$e) }}">{{ $e->nombre }} {{ $e->apellido }}</a></td>
                    <td>{{ $e->puesto->nombre ?? '-' }}</td>
                    <td>{{ $e->fecha_ingreso ? \Carbon\Carbon::parse($e->fecha_ingreso)->format('d/m/Y') : '-' }}</td>
                    <td><span class="badge 
                        {{ $e->status=='Activo'?'bg-success':($e->status=='Inactivo'?'bg-warning':'bg-danger') }}">
                        {{ $e->status }}
                    </span></td>
                    <td>
                        <a href="{{ route('recursos_humanos.edit',$e) }}" class="btn btn-sm btn-warning">Editar</a>
                        <a href="{{ route('recursos_humanos.show',$e) }}" class="btn btn-sm btn-info">Ver</a>
                        <form action="{{ route('recursos_humanos.destroy',$e) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('¿Eliminar empleado?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                        <div class="mt-1">
                            <a href="{{ route('recursos_humanos.asistencias.index',$e) }}" class="badge bg-primary">Asistencias</a>
                            <a href="{{ route('recursos_humanos.permisos.index',$e) }}" class="badge bg-info">Permisos</a>
                            <a href="{{ route('recursos_humanos.nominas.index',$e) }}" class="badge bg-success">Nómina</a>
                            <a href="{{ route('recursos_humanos.documentos.index',$e) }}" class="badge bg-secondary">Documentos</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">No hay empleados registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $empleados->links() }}

    {{-- GRÁFICO PIE ESTADOS --}}
    <div class="my-5" style="max-width:400px;">
        <canvas id="graficoEmpleadosEstados"></canvas>
    </div>
</div>

@push('scripts')
<script>
    const ctx = document.getElementById('graficoEmpleadosEstados').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels:['Activo','Inactivo','Baja'],
            datasets:[{ data: [
                {{ $empleados->where('status','Activo')->count() }},
                {{ $empleados->where('status','Inactivo')->count() }},
                {{ $empleados->where('status','Baja')->count() }}
            ]}]
        },
        options:{ plugins:{ legend:{ position:'bottom' } } }
    });
</script>
@endpush
@endsection
