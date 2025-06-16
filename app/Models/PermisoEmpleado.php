<?php

// app/Models/PermisoEmpleado.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermisoEmpleado extends Model
{
    protected $table = 'permisos_empleado';
    protected $fillable = [
        'empleado_id', 'fecha_inicio', 'fecha_fin', 'motivo', 'aprobado'
    ];
    public $timestamps = false;

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}

