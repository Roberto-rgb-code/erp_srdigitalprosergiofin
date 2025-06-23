<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesarrolloSoftware extends Model
{
    protected $table = 'desarrollo_software';

    protected $fillable = [
        'cliente_id',
        'nombre',
        'tipo_software', // texto libre
        'stack_tecnologico',
        'fecha_inicio',
        'fecha_fin',
        'responsable_id',
        'estado',
        'historial'
    ];

    public $timestamps = true; // Si usas timestamps

    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'cliente_id');
    }

    public function responsable()
    {
        return $this->belongsTo(\App\Models\Empleado::class, 'responsable_id');
    }
}
