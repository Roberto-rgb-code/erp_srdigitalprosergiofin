<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaContable extends Model
{
    protected $table = 'cuentas_contables';

    protected $fillable = [
        'codigo',
        'nombre',
        'tipo',
        'nivel',
        'padre_id', // Si manejas jerarquía
        'status'
    ];

    // Relación padre-hijos para árbol de cuentas
    public function padre()
    {
        return $this->belongsTo(CuentaContable::class, 'padre_id');
    }

    public function hijos()
    {
        return $this->hasMany(CuentaContable::class, 'padre_id');
    }

    public function diarioContable()
    {
        return $this->hasMany(DiarioContable::class, 'cuenta_contable_id');
    }
}
