<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GastoFijo extends Model
{
    protected $table = 'gastos_fijos';

    protected $fillable = [
        'proveedor_id',
        'descripcion',
        'monto',
        'fecha_inicio',
        'frecuencia',    // mensual, semanal, anual, etc.
        'activo'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}
