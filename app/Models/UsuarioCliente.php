<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioCliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'servicio_empresarial_id',
        'nombre_usuario',
        'email',
        'password',
        'comentarios',
    ];

    public function servicioEmpresarial()
    {
        return $this->belongsTo(ServicioEmpresarial::class, 'servicio_empresarial_id');
    }
}
