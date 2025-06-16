<?php

namespace App\Http\Controllers;

use App\Models\PolizaServicio;
use App\Models\Cliente;
use Illuminate\Http\Request;

class PolizaServicioController extends Controller
{
    public function create()
    {
        $clientes = Cliente::all();
        return view('polizas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id'         => 'required|exists:clientes,id',
            'tipo'               => 'required|string|max:50',
            'servicios_remoto'   => 'required|integer|min:0',
            'servicios_domicilio'=> 'required|integer|min:0',
            'fecha_inicio'       => 'nullable|date',
            'fecha_fin'          => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        PolizaServicio::create($validated);

        return redirect()->route('polizas.create')->with('success', 'Póliza creada correctamente');
    }
}
