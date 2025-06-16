<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguimientosTicket extends Model
{
    protected $table = 'seguimientos_ticket';

    protected $fillable = [
        'ticket_id',
        'comentario',
        'usuario_id',     // Puede ser usuario interno o usuario_cliente
        'visibilidad'     // Pública/Interna
    ];

    public $timestamps = false;

    // Relación con Ticket de soporte
    public function ticket()
    {
        return $this->belongsTo(\App\Models\TicketsSoporte::class, 'ticket_id');
    }

    // Relación con Usuario (ajusta si tus usuarios están en usuarios_clientes o usuarios)
    public function usuario()
    {
        return $this->belongsTo(\App\Models\UsuariosCliente::class, 'usuario_id');
        // O, si manejas ambos tipos de usuario:
        // return $this->belongsTo(\App\Models\User::class, 'usuario_id');
    }
}
