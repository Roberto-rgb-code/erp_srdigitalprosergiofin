<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguimientoCobro extends Model
{
    protected $table = 'seguimientos_cobros';

    protected $fillable = [
        'cuenta_por_cobrar_id',
        'usuario_id',
        'tipo',
        'descripcion',
        'fecha'
    ];

    public function cuentaPorCobrar()
    {
        return $this->belongsTo(CuentaPorCobrar::class, 'cuenta_por_cobrar_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
