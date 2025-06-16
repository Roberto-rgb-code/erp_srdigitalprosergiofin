<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioCliente extends Model
{
    protected $table = 'inventario_clientes';
    protected $fillable = [
        'servicios_empresariales_id', 'cliente_id', 'nombre_equipo', 'tipo_equipo', 'modelo', 'serie'
    ];

    // Relación con ServicioEmpresarial
    public function servicioEmpresarial() {
        return $this->belongsTo(ServicioEmpresarial::class, 'servicios_empresariales_id');
    }

    // Relación con Cliente
    public function cliente() {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
