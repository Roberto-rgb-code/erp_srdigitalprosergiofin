<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolizaServicio extends Model
{
    protected $table = 'polizas_servicio';

    protected $fillable = [
        'nombre',              // Ejemplo: Básica, Avanzada
        'servicios_remoto',    // Número de servicios remotos permitidos
        'servicios_domicilio', // Número de servicios a domicilio permitidos
        'duracion_meses',      // Opcional: duración de la póliza en meses
        'estatus',             // Activa/Inactiva
    ];

    // Relaciones
    public function serviciosEmpresariales()
    {
        return $this->hasMany(\App\Models\ServicioEmpresarial::class, 'poliza_servicio_id');
    }
}
