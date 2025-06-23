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
        $query = Cliente::with('datoFiscal'); // Para traer el RFC de la relación

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

        // Trae todos los campos que sí existen
        $clientes = $query->orderBy('id', 'desc')->get([
            'id',
            'nombre_completo',
            'direccion',
            'contacto',
            'tipo_cliente',
            'limite_credito',
            'saldo',
            'status'
        ]);

        // Usamos map para incluir el RFC de la relación
        return $clientes->map(function ($c) {
            return [
                'id'             => $c->id,
                'nombre'         => $c->nombre_completo,
                'rfc'            => optional($c->datoFiscal)->rfc,  // Evita error si no tiene datoFiscal
                'direccion'      => $c->direccion,
                'contacto'       => $c->contacto,
                'tipo_cliente'   => $c->tipo_cliente,
                'limite_credito' => $c->limite_credito,
                'saldo'          => $c->saldo,
                'status'         => $c->status,
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
            'Límite Crédito',
            'Saldo',
            'Estatus'
        ];
    }
}
