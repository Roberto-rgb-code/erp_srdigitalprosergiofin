<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    protected $table = 'egresos';

    protected $fillable = [
        'tipo_egreso',
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
