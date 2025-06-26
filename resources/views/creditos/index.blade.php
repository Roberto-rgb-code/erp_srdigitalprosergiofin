@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Créditos</h3>
        <a href="{{ route('creditos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Crédito
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Cliente</th>
                <th>Línea Total</th>
                <th>Línea Usada</th>
                <th>Línea Libre</th>
                <th>Saldo Actual</th>
                <th>Estatus</th>
                <th>Semáforo</th>
                <th style="width: 180px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($creditos as $credito)
            <tr>
                <td>{{ $credito->cliente->nombre_completo ?? '-' }}</td>
                <td>${{ number_format($credito->linea_total,2) }}</td>
                <td>${{ number_format($credito->linea_usada,2) }}</td>
                <td>
                    ${{ number_format($credito->linea_total - $credito->linea_usada, 2) }}
                </td>
                <td>${{ number_format($credito->saldo_actual,2) }}</td>
                <td>
                    <span class="badge bg-secondary">{{ $credito->status_credito }}</span>
                </td>
                <td>
                    <span class="badge bg-{{ $credito->semaforo ?? 'secondary' }}">
                        {{ ucfirst($credito->semaforo ?? 'N/A') }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('creditos.show', $credito) }}" class="btn btn-sm btn-outline-primary me-1" title="Ver">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('creditos.edit', $credito) }}" class="btn btn-sm btn-outline-warning me-1" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('creditos.destroy', $credito) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('¿Estás seguro de eliminar este crédito?')"
                            title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center">No hay créditos registrados.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $creditos->links() }}
    </div>
@endsection
