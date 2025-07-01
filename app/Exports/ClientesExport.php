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
        $query = Cliente::with('datoFiscal');

        if (!empty($this->filters['nombre'])) {
            $query->where('nombre_completo', 'ILIKE', "%{$this->filters['nombre']}%");
        }
        if (!empty($this->filters['rfc'])) {
            $query->whereHas('datoFiscal', function ($q) {
                $q->where('rfc', 'ILIKE', "%{$this->filters['rfc']}%");
            });
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        $clientes = $query->orderBy('id', 'desc')->get([
            'id',
            'nombre_completo',
            'direccion',
            'contacto',
            'tipo_cliente',
            // 'limite_credito',
            // 'saldo',
            // 'status'
        ]);

        return $clientes->map(function ($c) {
            return [
                'ID'        => $c->id,
                'Nombre'    => $c->nombre_completo,
                'RFC'       => optional($c->datoFiscal)->rfc,
                'Dirección' => $c->direccion,
                'Contacto'  => $c->contacto,
                'Tipo'      => $c->tipo_cliente,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'RFC',
            'Dirección',
            'Contacto',
            'Tipo',
        ];
    }
}
