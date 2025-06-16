<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketsSoporte extends Model
{
    // Si la tabla se llama 'tickets_soporte' asegúrate que el nombre sea correcto
    protected $table = 'tickets_soporte';

    protected $fillable = [
        'folio',
        'cliente_id',
        'poliza_id',
        'asunto',
        'descripcion',
        'equipo_id',
        'responsable_id',
        'prioridad',
        'estado'
    ];

    // Si no usas timestamps en la tabla:
    public $timestamps = false;

    // RELACIONES
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'cliente_id');
    }

    public function poliza()
    {
        return $this->belongsTo(\App\Models\PolizaServicio::class, 'poliza_id');
    }

    public function equipo()
    {
        return $this->belongsTo(\App\Models\InventarioCliente::class, 'equipo_id');
    }

    public function responsable()
    {
        return $this->belongsTo(\App\Models\Empleado::class, 'responsable_id');
    }

    public function seguimientos()
    {
        return $this->hasMany(\App\Models\SeguimientosTicket::class, 'ticket_id');
    }

    // BOOT para autogenerar folio si lo deseas
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            // Si no viene folio, generamos uno: TK-00001, etc.
            if (empty($ticket->folio)) {
                $max = static::max('id') + 1;
                $ticket->folio = 'TK-' . str_pad($max, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}
