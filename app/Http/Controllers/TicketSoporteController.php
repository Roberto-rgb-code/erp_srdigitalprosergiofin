<?php

namespace App\Http\Controllers;

use App\Models\TicketSoporte;
use App\Models\Cliente;
use App\Models\PolizaServicio;
use App\Models\InventarioCliente;
use App\Models\Empleado;
use Illuminate\Http\Request;

class TicketSoporteController extends Controller
{
    public function index()
    {
        $tickets = TicketSoporte::with(['cliente', 'poliza', 'equipo', 'responsable'])->orderByDesc('id')->get();
        return view('tickets_soporte.index', compact('tickets'));
    }

    public function create()
{
    $clientes = \App\Models\Cliente::all();
    $polizas = \App\Models\PolizaServicio::all();
    $equipos = \App\Models\InventarioCliente::all();
    $empleados = \App\Models\Empleado::all();
    return view('tickets_soporte.create', compact('clientes', 'polizas', 'equipos', 'empleados'));
}

    public function store(Request $request)
    {
        $request->validate([
            'folio' => 'nullable|string|max:30|unique:tickets_soporte,folio',
            'cliente_id' => 'required|exists:clientes,id',
            'poliza_id' => 'nullable|exists:polizas_servicio,id',
            'asunto' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'equipo_id' => 'nullable|exists:inventario_clientes,id',
            'usuario_id' => 'nullable|integer',
            'responsable_id' => 'nullable|exists:empleados,id',
            'prioridad' => 'nullable|string|max:30',
            'estado' => 'nullable|string|max:30',
        ]);

        $data = $request->all();
        // Folio autogenerado si no se proporciona:
        if (empty($data['folio'])) {
            $data['folio'] = 'TK-' . (TicketSoporte::max('id') + 1);
        }
        TicketSoporte::create($data);

        return redirect()->route('tickets_soporte.index')->with('success', 'Ticket registrado');
    }

    public function show(TicketSoporte $tickets_soporte)
    {
        $tickets_soporte->load(['cliente', 'poliza', 'equipo', 'responsable', 'seguimientos']);
        return view('tickets_soporte.show', compact('tickets_soporte'));
    }

    public function edit($id)
{
    $tickets_soporte = \App\Models\TicketsSoporte::findOrFail($id);
    $clientes = \App\Models\Cliente::all();
    $polizas = \App\Models\PolizaServicio::all();
    $equipos = \App\Models\InventarioCliente::all();
    $empleados = \App\Models\Empleado::all();
    return view('tickets_soporte.edit', compact('tickets_soporte', 'clientes', 'polizas', 'equipos', 'empleados'));
}

    public function update(Request $request, TicketSoporte $tickets_soporte)
    {
        $request->validate([
            'folio' => 'nullable|string|max:30|unique:tickets_soporte,folio,' . $tickets_soporte->id,
            'cliente_id' => 'required|exists:clientes,id',
            'poliza_id' => 'nullable|exists:polizas_servicio,id',
            'asunto' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'equipo_id' => 'nullable|exists:inventario_clientes,id',
            'usuario_id' => 'nullable|integer',
            'responsable_id' => 'nullable|exists:empleados,id',
            'prioridad' => 'nullable|string|max:30',
            'estado' => 'nullable|string|max:30',
        ]);
        $tickets_soporte->update($request->all());
        return redirect()->route('tickets_soporte.index')->with('success', 'Ticket actualizado');
    }

    public function destroy(TicketSoporte $tickets_soporte)
    {
        $tickets_soporte->delete();
        return redirect()->route('tickets_soporte.index')->with('success', 'Ticket eliminado');
    }
}
