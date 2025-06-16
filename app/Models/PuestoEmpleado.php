<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PuestoEmpleado extends Model
{
    protected $table = 'puestos_empleado';
    protected $fillable = ['nombre'];
    public $timestamps = false;

    public function empleados() {
        return $this->hasMany(Empleado::class, 'puesto_empleado_id');
    }
}
