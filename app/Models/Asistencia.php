<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';
    protected $fillable = [
        'empleado_id', 'fecha', 'tipo', // tipo: falta, retardo, asistencia
        'motivo'
    ];
    public $timestamps = false;

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
