<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DocumentoEmpleado extends Model
{
    protected $table = 'documentos_empleado';
    protected $fillable = [
        'empleado_id', 'nombre', 'archivo'
    ];
    public $timestamps = false;

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
