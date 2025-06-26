<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolizaServicio extends Model
{
    protected $table = 'polizas_servicio';

    protected $fillable = [
        'cliente_id', 'tipo', 'modalidad', 'servicios_incluidos', 'servicios_consumidos',
        'fecha_inicio', 'fecha_fin', 'estatus', 'comentarios'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function serviciosConsumidos()
    {
        return $this->hasMany(ServicioConsumido::class, 'poliza_servicio_id');
    }

    public function inventarios()
    {
        return $this->hasMany(InventarioEquipo::class, 'poliza_servicio_id');
    }

    public function usuariosCliente()
    {
        return $this->hasMany(UsuarioCliente::class, 'poliza_servicio_id');
    }

    public function configuracionesCliente()
    {
        return $this->hasMany(ConfiguracionCliente::class, 'poliza_servicio_id');
    }

    public function ticketsSoporte()
    {
        return $this->hasMany(TicketSoporte::class, 'poliza_servicio_id');
    }

    public function documentosAdministrativos()
    {
        return $this->hasMany(DocumentoAdministrativo::class, 'poliza_servicio_id');
    }
}
