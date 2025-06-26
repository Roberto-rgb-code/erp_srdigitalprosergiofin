<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioPoliza extends Model
{
    use HasFactory;

    protected $table = 'usuarios_poliza';

    protected $fillable = [
        'servicio_empresarial_id',
        'nombre',
        'correo',
        'password',
        'rol',
        'comentarios',
    ];

    protected $hidden = ['password'];

    public function servicioEmpresarial()
    {
        return $this->belongsTo(ServicioEmpresarial::class, 'servicio_empresarial_id');
    }
}
