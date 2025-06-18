<?php

// app/Models/Empleado.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'nombre', 'apellido', 'rfc', 'curp', 'fecha_ingreso', 'status', 'salario', 'puesto_id', 'notas'
    ];

    // Relación con PuestoEmpleado
    public function puesto()
    {
        return $this->belongsTo(PuestoEmpleado::class, 'puesto_id');
    }

    // Submódulos
    public function asistencias()    { return $this->hasMany(Asistencia::class); }
    public function documentos()     { return $this->hasMany(DocumentoEmpleado::class); }
    public function nominas()        { return $this->hasMany(Nomina::class); }
    public function permisos()       { return $this->hasMany(PermisoEmpleado::class); }

    public $timestamps = false;
}
