<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionesCliente extends Model
{
    protected $table = 'configuraciones_clientes';

    protected $fillable = [
        'cliente_id',
        'descripcion',
        'datos_red',
        'ips',
        'software'
    ];

    public $timestamps = false;

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'cliente_id');
    }
}
