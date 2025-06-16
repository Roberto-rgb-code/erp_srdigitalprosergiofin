<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    // Lista de campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'rfc',
        'direccion',
        'contacto',
        'tipo_cliente',
        'limite_credito',
        'saldo',
        'ejecutivo_id',
        'status',
    ];

    // Si tu tabla NO tiene created_at/updated_at
    public $timestamps = false;

    // Folio automático usando el id
    public function getFolioAttribute()
    {
        return 'CL-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

    // Si quieres la relación con empleados (ejecutivo)
    public function ejecutivo()
    {
        return $this->belongsTo(\App\Models\Empleado::class, 'ejecutivo_id');
    }
}
