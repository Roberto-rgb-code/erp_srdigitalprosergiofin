<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaPorPagar extends Model
{
    protected $table = 'cuentas_por_pagar';

    protected $fillable = [
        'proveedor_id',
        'egreso_id',
        'factura',
        'monto',
        'saldo',
        'fecha_vencimiento',
        'fecha_pago',
        'estatus',
        'comprobante',
        'comentarios'
    ];

    // RELACIONES PRINCIPALES

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function egreso()
    {
        return $this->belongsTo(Egreso::class, 'egreso_id');
    }

    // Pagos realizados a esta cuenta por pagar
    public function pagos()
    {
        return $this->hasMany(PagoCXP::class, 'cuenta_por_pagar_id');
    }

    // Seguimientos (llamadas, mensajes, etc)
    public function seguimientos()
    {
        return $this->hasMany(SeguimientoCXP::class, 'cuenta_por_pagar_id');
    }

    // ACCESORES Y SCOPES ÚTILES

    // Porcentaje de impacto respecto al total por pagar
    public function getImpactoPorcentajeAttribute()
    {
        $total = static::where('saldo', '>', 0)->sum('saldo');
        return $total > 0 ? round($this->saldo / $total * 100, 2) : 0;
    }

    // Semáforo de vencimiento (verde: en tiempo, rojo: atrasado, amarillo: próximo a vencer)
    public function getSemaforoAttribute()
    {
        if ($this->saldo <= 0) {
            return 'pagado';
        }
        $hoy = now();
        $vencimiento = \Carbon\Carbon::parse($this->fecha_vencimiento);
        if ($vencimiento->lt($hoy)) {
            return 'rojo';
        } elseif ($vencimiento->diffInDays($hoy) <= 3) {
            return 'amarillo';
        }
        return 'verde';
    }

    // Scope para vencidas
    public function scopeVencidas($query)
    {
        return $query->where('fecha_vencimiento', '<', now())->where('saldo', '>', 0);
    }

    // Scope para proveedor
    public function scopePorProveedor($query, $proveedorId)
    {
        return $query->where('proveedor_id', $proveedorId);
    }
}
