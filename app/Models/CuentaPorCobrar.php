<?php

// app/Models/CuentaPorCobrar.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaPorCobrar extends Model
{
    protected $table = 'cuentas_por_cobrar';

    protected $fillable = [
        'cliente_id',
        'venta_id',
        'folio_factura',
        'fecha_emision',
        'fecha_vencimiento',
        'monto_total',
        'saldo_pendiente',
        'documento'
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con Venta (ESTA ES LA QUE FALTABA)
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    // Si tienes relación con cobros
    // public function cobros()
    // {
    //     return $this->hasMany(CobroCuentaPorCobrar::class);
    // }
}
