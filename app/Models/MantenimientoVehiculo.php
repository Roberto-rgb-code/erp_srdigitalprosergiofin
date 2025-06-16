<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MantenimientoVehiculo extends Model
{
    protected $table = 'mantenimiento_vehiculo';
    protected $fillable = [
        'vehiculo_id', 'tipo_servicio', 'fecha', 'kilometraje', 'costo', 'observaciones'
    ];
    public $timestamps = false;

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }
}
