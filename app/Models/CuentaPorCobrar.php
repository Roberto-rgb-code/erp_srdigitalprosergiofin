<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaPorCobrar extends Model
{
    protected $table = 'cuentas_por_cobrar';

    protected $fillable = [
        'cliente_id',
        'venta_id',
        'monto',
        'saldo',
        'fecha_vencimiento',
        'fecha_pago',
        'estatus',
        'comentarios'
    ];

    // Relaciones principales
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    // Relación: Cobros realizados a esta cuenta por cobrar
    public function cobros()
    {
        return $this->hasMany(Cobro::class, 'cuenta_por_cobrar_id');
    }

    // Relación: Seguimiento/historial de gestión de cobro
    public function seguimientos()
    {
        return $this->hasMany(SeguimientoCobro::class, 'cuenta_por_cobrar_id');
    }

    // Scopes útiles

    // Filtrar cuentas vencidas
    public function scopeVencidas($query)
    {
        return $query->where('fecha_vencimiento', '<', now())->where('saldo', '>', 0);
    }

    // Filtrar por cliente específico
    public function scopePorCliente($query, $clienteId)
    {
        return $query->where('cliente_id', $clienteId);
    }

    // Obtener el porcentaje de impacto respecto al total (útil para gráficos/semaforo)
    public function getImpactoPorcentajeAttribute()
    {
        $total = static::where('saldo', '>', 0)->sum('saldo');
        return $total > 0 ? round($this->saldo / $total * 100, 2) : 0;
    }

    // Semáforo de vencimiento (verde: en tiempo, rojo: atrasado, amarillo: próximo a vencer)
    public function getSemaforoAttribute()
    {
        if ($this->saldo <= 0) {
            return 'pagado'; // o verde
        }
        $hoy = now();
        $vencimiento = \Carbon\Carbon::parse($this->fecha_vencimiento);
        if ($vencimiento->lt($hoy)) {
            return 'rojo'; // atrasado
        } elseif ($vencimiento->diffInDays($hoy) <= 3) {
            return 'amarillo'; // próximo a vencer
        }
        return 'verde'; // en tiempo
    }
}
