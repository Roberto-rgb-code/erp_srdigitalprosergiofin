<dl class="row">
    <dt class="col-sm-3">Cliente</dt>
    <dd class="col-sm-9">{{ $taller->cliente->nombre_completo ?? '-' }}</dd>

    <dt class="col-sm-3">Tipo de Cliente</dt>
    <dd class="col-sm-9">{{ $taller->tipo_cliente }}</dd>

    <dt class="col-sm-3">Equipo</dt>
    <dd class="col-sm-9">{{ $taller->equipo->tipo ?? '-' }} {{ $taller->equipo->marca ?? '' }} {{ $taller->equipo->modelo ?? '' }}</dd>

    <dt class="col-sm-3">Técnico</dt>
    <dd class="col-sm-9">{{ $taller->tecnico->nombre ?? '-' }}</dd>

    <dt class="col-sm-3">Ingreso</dt>
    <dd class="col-sm-9">{{ $taller->fecha_ingreso }}</dd>

    <dt class="col-sm-3">Entrega</dt>
    <dd class="col-sm-9">{{ $taller->fecha_entrega }}</dd>

    <dt class="col-sm-3">Detalle del Problema</dt>
    <dd class="col-sm-9">{{ $taller->detalle_problema }}</dd>

    <dt class="col-sm-3">Solución</dt>
    <dd class="col-sm-9">{{ $taller->solucion }}</dd>

    <dt class="col-sm-3">Observaciones</dt>
    <dd class="col-sm-9">{{ $taller->observaciones }}</dd>

    <dt class="col-sm-3">Costo Total</dt>
    <dd class="col-sm-9">${{ number_format($taller->costo_total,2) }}</dd>

    <dt class="col-sm-3">Anticipo</dt>
    <dd class="col-sm-9">${{ number_format($taller->anticipo,2) }}</dd>
</dl>
