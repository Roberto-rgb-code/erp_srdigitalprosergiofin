<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Nomina;
use Illuminate\Http\Request;

class NominaController extends Controller
{
    public function index(Empleado $empleado)
    {
        $nominas = $empleado->nominas()->orderByDesc('fecha_pago')->get();
        return view('recursos_humanos.nominas.index', compact('empleado', 'nominas'));
    }

    public function create(Empleado $empleado)
    {
        return view('recursos_humanos.nominas.create', compact('empleado'));
    }

    public function store(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'sueldo_base'    => 'required|numeric',
            'tipo_pago'      => 'required|string|max:50',
            'cuenta_bancaria'=> 'nullable|string|max:100',
            'fecha_pago'     => 'required|date',
            'monto_pagado'   => 'required|numeric'
        ]);
        $empleado->nominas()->create($validated);
        return redirect()->route('recursos_humanos.nominas.index', $empleado)->with('success', 'Nómina registrada');
    }

    public function edit(Empleado $empleado, Nomina $nomina)
    {
        return view('recursos_humanos.nominas.edit', compact('empleado', 'nomina'));
    }

    public function update(Request $request, Empleado $empleado, Nomina $nomina)
    {
        $validated = $request->validate([
            'sueldo_base'    => 'required|numeric',
            'tipo_pago'      => 'required|string|max:50',
            'cuenta_bancaria'=> 'nullable|string|max:100',
            'fecha_pago'     => 'required|date',
            'monto_pagado'   => 'required|numeric'
        ]);
        $nomina->update($validated);
        return redirect()->route('recursos_humanos.nominas.index', $empleado)->with('success', 'Nómina actualizada');
    }

    public function destroy(Empleado $empleado, Nomina $nomina)
    {
        $nomina->delete();
        return redirect()->route('recursos_humanos.nominas.index', $empleado)->with('success', 'Registro eliminado');
    }
}
