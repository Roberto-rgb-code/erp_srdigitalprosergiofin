<?php

namespace App\Http\Controllers;

use App\Models\SeguimientoTicket;
use App\Models\TicketSoporte;
use App\Models\Cliente;
use App\Models\ServicioEmpresarial;
use Illuminate\Http\Request;

class SeguimientoTicketController extends Controller
{
    public function index($servicios_empresariales)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $seguimientos = SeguimientoTicket::with('ticket', 'cliente')
            ->where('servicio_empresarial_id', $servicio->id)
            ->orderByDesc('id')->get();

        return view('seguimientos_ticket.index', compact('seguimientos', 'servicio'));
    }

    public function create($servicios_empresariales)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $clientes = Cliente::all();
        $tickets = TicketSoporte::where('servicio_empresarial_id', $servicio->id)->get();
        return view('seguimientos_ticket.create', compact('clientes', 'tickets', 'servicio'));
    }

    public function store(Request $request, $servicios_empresariales)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);

        $request->validate([
            'ticket_soporte_id' => 'required|exists:tickets_soporte,id',
            'cliente_id'        => 'required|exists:clientes,id',
            'comentario'        => 'nullable|string',
            'estatus'           => 'required|string|max:30',
        ]);

        SeguimientoTicket::create([
            'servicio_empresarial_id' => $servicio->id,
            'ticket_soporte_id'       => $request->ticket_soporte_id,
            'cliente_id'              => $request->cliente_id,
            'comentario'              => $request->comentario,
            'estatus'                 => $request->estatus,
        ]);
        return redirect()->route('servicios_empresariales.seguimientos_ticket.index', $servicio->id)
            ->with('success', 'Seguimiento creado');
    }

    public function show($servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $seguimiento = SeguimientoTicket::with('ticket', 'cliente')
            ->where('servicio_empresarial_id', $servicio->id)
            ->findOrFail($id);
        return view('seguimientos_ticket.show', compact('seguimiento', 'servicio'));
    }

    public function edit($servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $seguimiento = SeguimientoTicket::where('servicio_empresarial_id', $servicio->id)->findOrFail($id);
        $clientes = Cliente::all();
        $tickets = TicketSoporte::where('servicio_empresarial_id', $servicio->id)->get();
        return view('seguimientos_ticket.edit', compact('seguimiento', 'clientes', 'tickets', 'servicio'));
    }

    public function update(Request $request, $servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $seguimiento = SeguimientoTicket::where('servicio_empresarial_id', $servicio->id)->findOrFail($id);

        $request->validate([
            'ticket_soporte_id' => 'required|exists:tickets_soporte,id',
            'cliente_id'        => 'required|exists:clientes,id',
            'comentario'        => 'nullable|string',
            'estatus'           => 'required|string|max:30',
        ]);

        $seguimiento->update([
            'ticket_soporte_id' => $request->ticket_soporte_id,
            'cliente_id'        => $request->cliente_id,
            'comentario'        => $request->comentario,
            'estatus'           => $request->estatus,
        ]);
        return redirect()->route('servicios_empresariales.seguimientos_ticket.index', $servicio->id)
            ->with('success', 'Seguimiento actualizado');
    }

    public function destroy($servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $seguimiento = SeguimientoTicket::where('servicio_empresarial_id', $servicio->id)->findOrFail($id);
        $seguimiento->delete();
        return redirect()->route('servicios_empresariales.seguimientos_ticket.index', $servicio->id)
            ->with('success', 'Seguimiento eliminado');
    }
}
