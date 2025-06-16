<?php

namespace App\Exports;

use App\Models\UsoVehiculo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsoVehiculoExport implements FromCollection, WithHeadings
{
    protected $vehiculo_id;

    public function __construct($vehiculo_id)
    {
        $this->vehiculo_id = $vehiculo_id;
    }

    public function collection()
    {
        return UsoVehiculo::with('empleado')->where('vehiculo_id', $this->vehiculo_id)
            ->get()
            ->map(function($u) {
                return [
                    'Empleado'      => $u->empleado->nombre ?? '-',
                    'Fecha salida'  => $u->fecha_salida,
                    'Hora salida'   => $u->hora_salida,
                    'Destino'       => $u->destino,
                    'Motivo'        => $u->motivo,
                    'Fecha retorno' => $u->fecha_retorno,
                    'Hora retorno'  => $u->hora_retorno,
                    'Observaciones' => $u->observaciones
                ];
            });
    }

    public function headings(): array
    {
        return ['Empleado', 'Fecha salida', 'Hora salida', 'Destino', 'Motivo', 'Fecha retorno', 'Hora retorno', 'Observaciones'];
    }
}
