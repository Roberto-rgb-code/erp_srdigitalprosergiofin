<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolizaContable extends Model
{
    protected $table = 'polizas_contables';

    protected $fillable = [
        'tipo',
        'referencia_id',
        'fecha',
        'descripcion',
        'monto'
    ];

    public function diarioContable()
    {
        return $this->hasMany(DiarioContable::class, 'poliza_id');
    }
}
