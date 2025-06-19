<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaPorPagar extends Model
{
    protected $table = 'cuentas_por_pagar';
    protected $fillable = [
        'proveedor_id',
        'folio_factura',
        'fecha_emision',
        'fecha_vencimiento',
        'monto_total',
        'saldo_pendiente',
        'estatus',
        'xml',
        'pdf'
    ];

    // Relación con proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
