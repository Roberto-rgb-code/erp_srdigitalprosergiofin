@extends('layouts.app')
@section('content')
    <h2>Tickets de Soporte</h2>
    <div class="mb-2">
        <a href="{{ route('tickets_soporte.create') }}" class="btn btn-primary">Nuevo Ticket</a>
        <a href="{{ route('tickets_soporte.export.excel') }}" class="btn btn-success">Exportar Excel</a>
        <a href="{{ route('tickets_soporte.export.pdf') }}" class="btn btn-danger">Exportar PDF</a>
    </div>
    <form method="GET" class="row g-2 mb-3">
        <div class="col">
            <input type="text" name="folio" class="form-control" placeholder="Folio" value="{{ request('folio') }}">
        </div>
        <div class="col">
            <select name="estado" class="form-select">
                <option value="">Estado</option>
                <option value="Pendiente" @if(request('estado')=='Pendiente') selected @endif>Pendiente</option>
                <option value="En proceso" @if(request('estado')=='En proceso') selected @endif>En proceso</option>
                <option value="Resuelto" @if(request('estado')=='Resuelto') selected @endif>Resuelto</option>
                <option value="Cerrado" @if(request('estado')=='Cerrado') selected @endif>Cerrado</option>
            </select>
        </div>
        <div class="col">
            <input type="text" name="cliente" class="form-control" placeholder="Cliente" value="{{ request('cliente') }}">
        </div>
        <div class="col">
            <button type="submit" class="btn btn-outline-primary">Buscar</button>
            <a href="{{ route('tickets_soporte.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Cliente</th>
                <th>Tipo de póliza</th>
                <th>Estado</th>
                <th>Asignado</th>
                <th>Fecha registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->folio }}</td>
                    <td>{{ $ticket->cliente->nombre ?? '-' }}</td>
                    <td>{{ $ticket->poliza->tipo ?? '-' }}</td>
                    <td>{{ $ticket->estado }}</td>
                    <td>{{ $ticket->tecnico->nombre ?? '-' }}</td>
                    <td>{{ $ticket->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('tickets_soporte.show', $ticket) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('tickets_soporte.edit', $ticket) }}" class="btn btn-warning btn-sm">Editar</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">Sin tickets registrados</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $tickets->appends(request()->all())->links() }}
@endsection
