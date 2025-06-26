<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionCliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'servicio_empresarial_id',
        'clave',
        'valor',
    ];

    public function servicioEmpresarial()
    {
        return $this->belongsTo(ServicioEmpresarial::class, 'servicio_empresarial_id');
    }
}
