<?php

namespace App\Exports;

use App\Models\EvidenciaVehiculo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EvidenciaVehiculoExport implements FromCollection, WithHeadings
{
    protected $vehiculo_id;

    public function __construct($vehiculo_id)
    {
        $this->vehiculo_id = $vehiculo_id;
    }

    public function collection()
    {
        return EvidenciaVehiculo::with('uso')->where('vehiculo_id', $this->vehiculo_id)
            ->get()
            ->map(function($e) {
                return [
                    'Fecha'         => $e->fecha,
                    'Tipo'          => $e->tipo,
                    'Relacionado a' => $e->uso ? "Uso #".$e->uso->id : '-',
                    'Archivo'       => $e->archivo
                ];
            });
    }

    public function headings(): array
    {
        return ['Fecha', 'Tipo', 'Relacionado a', 'Archivo'];
    }
}
