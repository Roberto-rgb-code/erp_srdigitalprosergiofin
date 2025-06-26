<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'ejecutivo_venta',
        'telefono',
        'direccion',
        'linea_credito',
        'linea_usada',
        'tiempo_credito',
        'metodos_entrega',
        'categoria',
        'comentarios',
        'tipo', // mayorista, menudeo, ambos
        'metodo_pago',
        'factura'
    ];

    // Relación con compras (si las usas en el ERP)
    public function compras()
    {
        return $this->hasMany(Compra::class, 'proveedor_id');
    }

    // Relación con cuentas por pagar
    public function cuentasPorPagar()
    {
        return $this->hasMany(CuentaPorPagar::class, 'proveedor_id');
    }

    // Relación con gastos fijos
    public function gastosFijos()
    {
        return $this->hasMany(GastoFijo::class, 'proveedor_id');
    }
}
