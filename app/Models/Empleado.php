<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'nombre',            // Nombre(s)
        'apellido',          // Apellido(s)
        'rfc',
        'curp',
        'fecha_ingreso',
        'status',            // Activo/Inactivo/Baja
        'puesto_empleado_id',// FK a catálogo de puestos
        'notas'              // Notas internas RH
    ];

    public $timestamps = false;

    // -- Relaciones --

    public function puesto()
    {
        return $this->belongsTo(PuestoEmpleado::class, 'puesto_empleado_id');
    }

    public function nominas()
    {
        return $this->hasMany(Nomina::class, 'empleado_id');
    }

    // app/Models/Empleado.php
public function permisos()
{
    return $this->hasMany(\App\Models\PermisoEmpleado::class, 'empleado_id');
}


    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'empleado_id');
    }

    public function documentos()
    {
        return $this->hasMany(DocumentoEmpleado::class, 'empleado_id');
    }

    
}
