<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'numero_empleado',
        'nombre',
        'apellido',
        'rfc',
        'curp',
        'fecha_ingreso',
        'status',
        'salario',
        'puesto_empleado_id', // <--- RELACIÓN
        'notas',
        'sucursal',
        'telefono',
        'correo',
        'tipo_contrato',
        'nss',
        'salario_diario_fiscal',
        'salario_diario_no_fiscal',
        'salario_mensual_fiscal',
        'salario_mensual_no_fiscal',
        'sexo',
        'edad',
        'tipo_sangre',
        'fecha_nacimiento',
        'estado_civil',
        'domicilio',
        'contacto_emergencia',
        'parentesco',
        'telefono_beneficiario',
        'cuenta_fiscal',
        'cuenta_no_fiscal',
        'banco_fiscal',
        'clabe_fiscal',
        'banco_no_fiscal',
        'clabe_no_fiscal',
        'tipo_empleado',
        'horario',
        'dias_laborales',
        'justificantes_incapacidad'
    ];

    // RELACIÓN: Un empleado pertenece a un puesto
    public function puesto()
    {
        return $this->belongsTo(PuestoEmpleado::class, 'puesto_empleado_id');
    }
}
