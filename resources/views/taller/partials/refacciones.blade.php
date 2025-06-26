<h5>Refacciones</h5>
<table class="table table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Refacción</th>
            <th>Piezas</th>
            <th>COSTO</th>
            <th>Fecha de solicitud</th>
            <th>Usuario solicitó</th>
            <th>Usuario aprobó</th>
            <th>Situación</th>
        </tr>
    </thead>
    <tbody>
        @foreach($taller->refacciones as $i => $ref)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $ref->nombre }}</td>
                <td>{{ $ref->cantidad }}</td>
                <td>{{ $ref->costo }}</td>
                <td>{{ $ref->fecha_solicitud }}</td>
                <td>{{ $ref->usuario_solicito }}</td>
                <td>{{ $ref->usuario_aprobo }}</td>
                <td>{{ $ref->situacion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<hr>
<h6>Agregar nueva refacción</h6>
<form method="POST" action="{{ route('refacciones.store') }}">
    @csrf
    <input type="hidden" name="taller_id" value="{{ $taller->id }}">
    <div class="row g-2 align-items-end">
        <div class="col">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre de la refacción" required>
        </div>
        <div class="col">
            <input type="number" name="cantidad" class="form-control" placeholder="Cantidad" min="1" value="1" required>
        </div>
        <div class="col">
            <input type="number" step="0.01" name="costo" class="form-control" placeholder="Costo" required>
        </div>
        <div class="col">
            <input type="text" name="usuario_solicito" class="form-control" placeholder="Usuario solicitó" required>
        </div>
        <div class="col">
            <input type="text" name="usuario_aprobo" class="form-control" placeholder="Usuario aprobó">
        </div>
        <div class="col">
            <input type="text" name="situacion" class="form-control" placeholder="Situación">
        </div>
        <div class="col">
            <button type="submit" class="btn btn-success">Agregar</button>
        </div>
    </div>
</form>
