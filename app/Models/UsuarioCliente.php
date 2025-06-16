<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuariosCliente extends Model
{
    protected $table = 'usuarios_clientes';

    protected $fillable = [
        'cliente_id',
        'nombre',
        'email',
        'rol',
        'password' // Si almacenas password, recuerda encriptar
    ];

    public $timestamps = false;

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'cliente_id');
    }

    // Relación con SeguimientosTicket (si el usuario puede comentar)
    public function seguimientos()
    {
        return $this->hasMany(\App\Models\SeguimientosTicket::class, 'usuario_id');
    }
}
