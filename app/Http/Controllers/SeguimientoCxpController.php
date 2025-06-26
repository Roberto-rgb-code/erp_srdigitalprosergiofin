<?php

namespace App\Http\Controllers;

use App\Models\SeguimientoCxp;
use App\Models\CuentaPorPagar;
use Illuminate\Http\Request;

class SeguimientoCxpController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'cuenta_pagar_id'   => 'required|exists:cuentas_por_pagar,id',
            'fecha'             => 'required|date',
            'comentario'        => 'nullable|string|max:1000',
            'tipo'              => 'nullable|string|max:30',
            'porcentaje_impacto'=> 'nullable|numeric|min:0|max:100',
        ]);
        SeguimientoCxp::create($data);
        return back()->with('success', 'Seguimiento registrado.');
    }

    public function destroy(SeguimientoCxp $seguimientos_cxp)
    {
        $seguimientos_cxp->delete();
        return back()->with('success', 'Seguimiento eliminado.');
    }
}
