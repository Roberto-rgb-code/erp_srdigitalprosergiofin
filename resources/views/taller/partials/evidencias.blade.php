<h5>Evidencias</h5>
<table class="table table-sm">
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Descripción</th>
            <th>Usuario subió</th>
            <th>Fecha registro</th>
        </tr>
    </thead>
    <tbody>
        @foreach($taller->evidencias as $ev)
            <tr>
                <td>
                    @if($ev->archivo)
                        <img src="{{ asset('storage/' . $ev->archivo) }}" width="70">
                    @endif
                </td>
                <td>{{ $ev->descripcion }}</td>
                <td>{{ $ev->usuario_subio }}</td>
                <td>{{ $ev->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<hr>
<h6>Agregar nueva evidencia</h6>
<form method="POST" action="{{ route('evidencias.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="taller_id" value="{{ $taller->id }}">
    <div class="row g-2 align-items-end">
        <div class="col">
            <input type="file" name="archivo" class="form-control" required>
        </div>
        <div class="col">
            <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required>
        </div>
        <div class="col">
            <input type="text" name="usuario_subio" class="form-control" placeholder="Usuario subió" required>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-success">Agregar</button>
        </div>
    </div>
</form>
