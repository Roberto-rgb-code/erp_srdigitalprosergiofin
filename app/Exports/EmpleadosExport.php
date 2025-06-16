<?php
namespace App\Exports;
use App\Models\Empleado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmpleadosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Empleado::with('puesto')->get()->map(function($e){
            return [
                $e->id, $e->nombre, $e->apellido, $e->puesto->nombre ?? '', $e->fecha_ingreso, $e->status, $e->rfc, $e->curp
            ];
        });
    }
    public function headings(): array
    {
        return ['ID','Nombre','Apellido','Puesto','Fecha Ingreso','Status','RFC','CURP'];
    }
}
