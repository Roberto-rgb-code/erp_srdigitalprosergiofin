<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos'; // asegúrate que coincide con tu tabla
    protected $fillable = [
        'placa',
        'marca',
        'modelo',
        'año',
        'tipo',
        'responsable_id',
        'cliente_id',
        'status',
        'fecha_adquisicion',
    ];
    public $timestamps = false;

    // Relaciones útiles si lo necesitas:
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'cliente_id');
    }

    public function responsable()
    {
        return $this->belongsTo(\App\Models\Empleado::class, 'responsable_id');
    }
}
