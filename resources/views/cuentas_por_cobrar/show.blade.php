@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Detalle de Cuenta por Cobrar</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $cuenta->cliente->nombre ?? 'Sin cliente' }}</h5>
            <p class="card-text">
                <b>Factura (Venta):</b> {{ $cuenta->venta_id ?? '-' }}<br>
                <b>Monto Original:</b> ${{ number_format($cuenta->monto, 2) }}<br>
                <b>Saldo Pendiente:</b> ${{ number_format($cuenta->saldo, 2) }}<br>
                <b>Fecha de Vencimiento:</b> {{ $cuenta->fecha_vencimiento ? \Carbon\Carbon::parse($cuenta->fecha_vencimiento)->format('d/m/Y') : '-' }}<br>
                <b>Estatus:</b> {{ $cuenta->estatus }}<br>
                <b>Semáforo:</b>
                @if($cuenta->semaforo == 'verde')
                    <span style="color:green;">● En tiempo</span>
                @elseif($cuenta->semaforo == 'amarillo')
                    <span style="color:orange;">● Próximo a vencer</span>
                @elseif($cuenta->semaforo == 'rojo')
                    <span style="color:red;">● Vencida</span>
                @else
                    <span style="color:gray;">● Pagado</span>
                @endif
                <br>
                <b>Porcentaje de Impacto:</b> {{ $porcentaje_impacto }}%<br>
                <b>Comentarios:</b> {{ $cuenta->comentarios ?? '-' }}
            </p>
        </div>
    </div>

    {{-- TABLA DE COBROS (PAGOS) --}}
    <h4>Cobros realizados</h4>
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Comentarios</th>
                <th>Recibo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cuenta->cobros as $cobro)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>${{ number_format($cobro->monto, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($cobro->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $cobro->tipo }}</td>
                    <td>{{ $cobro->comentarios }}</td>
                    <td>
                        @if($cobro->recibo)
                            <a href="{{ asset('storage/' . $cobro->recibo) }}" target="_blank">Ver</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Sin cobros registrados.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- FORMULARIO PARA REGISTRAR NUEVO COBRO --}}
    @if($cuenta->saldo > 0)
    <div class="card mb-4">
        <div class="card-body">
            <h5>Registrar cobro</h5>
            <form action="{{ route('cuentas_por_cobrar.cobros', $cuenta->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <label>Monto a pagar</label>
                    <input type="number" name="monto" step="0.01" max="{{ $cuenta->saldo }}" required class="form-control" value="{{ old('monto') }}">
                </div>
                <div class="mb-2">
                    <label>Fecha</label>
                    <input type="date" name="fecha" required class="form-control" value="{{ old('fecha', date('Y-m-d')) }}">
                </div>
                <div class="mb-2">
                    <label>Tipo de pago</label>
                    <select name="tipo" class="form-control" required>
                        <option value="">Selecciona</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Comentarios</label>
                    <input type="text" name="comentarios" class="form-control" value="{{ old('comentarios') }}">
                </div>
                <div class="mb-2">
                    <label>Recibo (opcional)</label>
                    <input type="file" name="recibo" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Registrar cobro</button>
            </form>
        </div>
    </div>
    @endif

    {{-- HISTORIAL DE SEGUIMIENTOS --}}
    <h4>Seguimiento y gestión</h4>
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Usuario</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cuenta->seguimientos as $seg)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $seg->tipo }}</td>
                    <td>{{ $seg->descripcion }}</td>
                    <td>{{ $seg->usuario->nombre ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($seg->fecha)->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Sin seguimientos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- FORMULARIO DE SEGUIMIENTO --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5>Registrar seguimiento</h5>
            <form action="{{ route('cuentas_por_cobrar.seguimientos', $cuenta->id) }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label>Tipo de seguimiento</label>
                    <select name="tipo" class="form-control" required>
                        <option value="">Selecciona</option>
                        <option value="Llamada">Llamada</option>
                        <option value="Correo">Correo</option>
                        <option value="Mensaje">Mensaje</option>
                        <option value="WhatsApp">WhatsApp</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Descripción / Nota</label>
                    <textarea name="descripcion" class="form-control" required>{{ old('descripcion') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Agregar seguimiento</button>
            </form>
        </div>
    </div>

    <a href="{{ route('cuentas_por_cobrar.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
