<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientesExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Cliente::query();

        if (!empty($this->filters['nombre'])) {
            $query->where('nombre', 'ILIKE', "%{$this->filters['nombre']}%");
        }
        if (!empty($this->filters['rfc'])) {
            $query->where('rfc', 'ILIKE', "%{$this->filters['rfc']}%");
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->orderBy('id', 'desc')->get([
            'id', 'nombre', 'rfc', 'direccion', 'contacto', 'tipo_cliente', 'limite_credito', 'saldo', 'status'
        ]);
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'RFC', 'Dirección', 'Contacto', 'Tipo', 'Límite Crédito', 'Saldo', 'Estatus'];
    }
}
