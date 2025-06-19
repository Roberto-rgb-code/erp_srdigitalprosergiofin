<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionCliente extends Model
{
    use HasFactory;

    protected $table = 'configuracion_clientes';

    protected $fillable = [
        'servicio_empresarial_id',
        'cliente_id',
        'tipo',
        'descripcion',
        'dato',
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
