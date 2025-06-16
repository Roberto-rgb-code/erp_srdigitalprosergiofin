<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguimientoCXP extends Model
{
    protected $table = 'seguimientos_cxp';
    protected $fillable = [
        'cuenta_por_pagar_id',
        'usuario_id',
        'tipo',
        'descripcion',
        'fecha'
    ];

    public function cuentaPorPagar()
    {
        return $this->belongsTo(CuentaPorPagar::class, 'cuenta_por_pagar_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
