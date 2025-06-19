<?php

namespace App\Http\Controllers;

use App\Models\TicketSoporte;
use App\Models\Cliente;
use App\Models\ServicioEmpresarial;
use Illuminate\Http\Request;

class TicketSoporteController extends Controller
{
    public function index($servicios_empresariales)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $tickets = TicketSoporte::with('cliente')
            ->where('servicio_empresarial_id', $servicio->id)
            ->orderByDesc('id')
            ->get();

        return view('tickets_soporte.index', compact('tickets', 'servicio'));
    }

    public function create($servicios_empresariales)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $clientes = Cliente::all();
        return view('tickets_soporte.create', compact('clientes', 'servicio'));
    }

    public function store(Request $request, $servicios_empresariales)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo'     => 'required|string|max:100',
            'descripcion'=> 'nullable|string',
            'estatus'    => 'required|string|max:30',
        ]);
        TicketSoporte::create([
            'servicio_empresarial_id' => $servicio->id,
            'cliente_id'  => $request->cliente_id,
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion,
            'estatus'     => $request->estatus,
        ]);
        return redirect()->route('servicios_empresariales.tickets_soporte.index', $servicio->id)
            ->with('success', 'Ticket creado correctamente');
    }

    public function show($servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $ticket = TicketSoporte::with('cliente')
            ->where('servicio_empresarial_id', $servicio->id)
            ->findOrFail($id);
        return view('tickets_soporte.show', compact('ticket', 'servicio'));
    }

    public function edit($servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $ticket = TicketSoporte::where('servicio_empresarial_id', $servicio->id)->findOrFail($id);
        $clientes = Cliente::all();
        return view('tickets_soporte.edit', compact('ticket', 'clientes', 'servicio'));
    }

    public function update(Request $request, $servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $ticket = TicketSoporte::where('servicio_empresarial_id', $servicio->id)->findOrFail($id);
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo'     => 'required|string|max:100',
            'descripcion'=> 'nullable|string',
            'estatus'    => 'required|string|max:30',
        ]);
        $ticket->update([
            'cliente_id'  => $request->cliente_id,
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion,
            'estatus'     => $request->estatus,
        ]);
        return redirect()->route('servicios_empresariales.tickets_soporte.index', $servicio->id)
            ->with('success', 'Ticket actualizado');
    }

    public function destroy($servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $ticket = TicketSoporte::where('servicio_empresarial_id', $servicio->id)->findOrFail($id);
        $ticket->delete();
        return redirect()->route('servicios_empresariales.tickets_soporte.index', $servicio->id)
            ->with('success', 'Ticket eliminado');
    }
}
