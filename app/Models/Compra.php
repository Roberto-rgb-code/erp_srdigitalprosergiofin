<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $fillable = [
        'proveedor_id',   // FK al proveedor
        'descripcion',
        'monto',
        'fecha_compra',
        'metodo_pago',
        'factura',
        'comentarios',
    ];

    /**
     * Relación Compra → Proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}
