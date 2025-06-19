<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoTicket extends Model
{
    use HasFactory;

    protected $table = 'seguimientos_ticket';

    protected $fillable = [
        'servicio_empresarial_id',
        'ticket_soporte_id',
        'cliente_id',
        'comentario',
        'estatus'
    ];

    public function ticket()
    {
        return $this->belongsTo(TicketSoporte::class, 'ticket_soporte_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function servicioEmpresarial()
    {
        return $this->belongsTo(ServicioEmpresarial::class, 'servicio_empresarial_id');
    }
}
