<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceCableado extends Model
{
    // Campos asignables
    protected $fillable = [
        'responsable_id',
        'fecha_gasto',
        'tipo_movimiento',
        'monto',
        'facturable',
        'cableado_id',  // asegurate que esté aquí
    ];

    // Relación con Cableado
    public function cableado()
    {
        return $this->belongsTo(Cableado::class);
    }

    // Relación con Empleado responsable
    public function responsable()
    {
        return $this->belongsTo(Empleado::class, 'responsable_id');
    }
}
