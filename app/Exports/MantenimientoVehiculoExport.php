<?php

namespace App\Exports;

use App\Models\MantenimientoVehiculo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MantenimientoVehiculoExport implements FromCollection, WithHeadings
{
    protected $vehiculo_id;

    public function __construct($vehiculo_id)
    {
        $this->vehiculo_id = $vehiculo_id;
    }

    public function collection()
    {
        return MantenimientoVehiculo::where('vehiculo_id', $this->vehiculo_id)
            ->select('fecha', 'tipo_servicio', 'kilometraje', 'costo', 'observaciones')
            ->orderByDesc('fecha')->get();
    }

    public function headings(): array
    {
        return ['Fecha', 'Tipo de servicio', 'Kilometraje', 'Costo', 'Observaciones'];
    }
}
