<?php

namespace App\Exports;

use App\Models\ServicioEmpresarial;
use Maatwebsite\Excel\Concerns\FromCollection;

class ServiciosEmpresarialesExport implements FromCollection
{
    public function collection()
    {
        return ServicioEmpresarial::with('cliente')->get();
    }
}
