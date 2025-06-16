<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    protected $table = 'nominas';
    protected $fillable = [
        'empleado_id', 'sueldo_base', 'tipo_pago',
        'cuenta_bancaria', 'fecha_pago', 'monto_pagado'
    ];
    public $timestamps = false;

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
