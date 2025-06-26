<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaPorPagar extends Model
{
    protected $table = 'cuentas_por_pagar';

    protected $fillable = [
        'proveedor_id',
        'folio_factura',
        'monto',
        'fecha_emision',
        'fecha_vencimiento',
        'saldo_pendiente',
        'estatus',         // pendiente, pagada, parcial, vencida, etc.
        'xml_path',
        'pdf_path',
        'comentarios'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function pagos()
    {
        return $this->hasMany(PagoCxp::class, 'cuenta_pagar_id');
    }

    public function seguimientos()
    {
        return $this->hasMany(SeguimientoCxp::class, 'cuenta_pagar_id');
    }
}
