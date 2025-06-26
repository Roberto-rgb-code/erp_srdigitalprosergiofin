<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioEmpresarial extends Model
{
    use HasFactory;

    protected $table = 'servicios_empresariales';

    protected $fillable = [
        'cliente_id',
        'tipo_poliza',
        'servicios_contratados',
        'servicios_restantes',
        'estatus',
        'fecha_inicio',
        'fecha_fin',
        'comentarios',
    ];

    // Cast para fechas para trabajar con Carbon automáticamente
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    // Habilitar timestamps (created_at, updated_at)
    public $timestamps = true;

    /**
     * Relaciones
     */

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con inventario de equipos asociados a este servicio empresarial
    public function inventarioEquipos()
    {
        return $this->hasMany(InventarioEquipo::class, 'servicio_empresarial_id');
    }

    // Relación con usuarios asignados a la póliza
    public function usuariosPoliza()
    {
        return $this->hasMany(UsuarioPoliza::class, 'servicio_empresarial_id');
    }

    // Relación con tickets de soporte creados para esta póliza
    public function ticketsSoporte()
    {
        return $this->hasMany(TicketSoporte::class, 'servicio_empresarial_id');
    }

    // Relación con mantenimientos programados
    public function mantenimientosProgramados()
    {
        return $this->hasMany(MantenimientoProgramado::class, 'servicio_empresarial_id');
    }

    // Relación con archivos administrativos asociados
    public function archivosAdministrativos()
    {
        return $this->hasMany(ArchivoAdministrativo::class, 'servicio_empresarial_id');
    }
}
