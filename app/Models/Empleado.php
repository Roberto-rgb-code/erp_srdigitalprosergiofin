<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $fillable = [
        'nombre',
        'apellido',
        'rfc',
        'curp',
        'puesto',
        'usuario_id',
        'fecha_ingreso',
        'status',
        'salario',
    ];
    public $timestamps = false;

    // Relaciones útiles
    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'usuario_id');
    }
}
