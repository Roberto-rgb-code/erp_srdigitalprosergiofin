<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = 'ingresos';

    protected $fillable = [
        'tipo_ingreso',
        'referencia_id',
        'monto',
        'fecha',
        'cuenta_bancaria_id',
        'descripcion'
    ];

    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }
}
