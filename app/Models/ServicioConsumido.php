<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioConsumido extends Model
{
    protected $table = 'servicios_consumidos';

    protected $fillable = [
        'poliza_servicio_id', 'cliente_id', 'ticket_id', 'fecha', 'tipo_servicio',
        'descripcion', 'realizado_por'
    ];

    public function poliza()
    {
        return $this->belongsTo(PolizaServicio::class, 'poliza_servicio_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function ticket()
    {
        return $this->belongsTo(TicketSoporte::class, 'ticket_id');
    }
}
