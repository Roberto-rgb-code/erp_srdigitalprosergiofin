<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoEmpleado extends Model
{
    protected $table = 'documentos_empleado';

    protected $fillable = [
        'empleado_id',
        'nombre_documento',
        'archivo',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
