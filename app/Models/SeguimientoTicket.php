<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_soporte_id',
        'comentario',
    ];

    public function ticketSoporte()
    {
        return $this->belongsTo(TicketSoporte::class, 'ticket_soporte_id');
    }
}
