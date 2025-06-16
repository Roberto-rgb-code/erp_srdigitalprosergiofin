<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvidenciaVehiculo extends Model
{
    protected $table = 'evidencia_vehiculo';
    protected $fillable = [
        'vehiculo_id', 'uso_id', 'tipo', 'archivo', 'fecha'
    ];
    public $timestamps = false;

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    public function uso()
    {
        return $this->belongsTo(UsoVehiculo::class, 'uso_id');
    }
}
