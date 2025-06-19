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
        'cuenta_padre_id',
    ];

    // Relación padre-hijo: Una cuenta puede tener una cuenta padre
    public function cuentaPadre()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_padre_id');
    }

    // Relación inversa: una cuenta puede tener muchas cuentas hijas
    public function cuentasHijas()
    {
        return $this->hasMany(CuentaContable::class, 'cuenta_padre_id');
    }
}
