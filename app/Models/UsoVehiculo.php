<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsoVehiculo extends Model
{
    protected $table = 'uso_vehiculo';
    protected $fillable = [
        'vehiculo_id', 'empleado_id', 'fecha_salida', 'hora_salida', 'destino', 'motivo',
        'fecha_retorno', 'hora_retorno', 'observaciones'
    ];
    public $timestamps = false;

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
