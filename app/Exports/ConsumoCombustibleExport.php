<?php

namespace App\Exports;

use App\Models\ConsumoCombustible;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConsumoCombustibleExport implements FromCollection, WithHeadings
{
    protected $vehiculo_id;

    public function __construct($vehiculo_id)
    {
        $this->vehiculo_id = $vehiculo_id;
    }

    public function collection()
    {
        return ConsumoCombustible::where('vehiculo_id', $this->vehiculo_id)
            ->select('fecha', 'litros', 'monto', 'ticket')
            ->orderByDesc('fecha')->get();
    }

    public function headings(): array
    {
        return ['Fecha', 'Litros', 'Monto', 'Ticket'];
    }
}
