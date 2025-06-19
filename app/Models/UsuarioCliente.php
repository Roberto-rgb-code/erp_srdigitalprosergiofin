<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioCliente extends Model
{
    use HasFactory;

    protected $table = 'usuario_clientes';

    protected $fillable = [
        'servicio_empresarial_id',
        'cliente_id',
        'nombre',
        'rol',
        'usuario',
        'password',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function servicioEmpresarial()
    {
        return $this->belongsTo(ServicioEmpresarial::class);
    }
}
