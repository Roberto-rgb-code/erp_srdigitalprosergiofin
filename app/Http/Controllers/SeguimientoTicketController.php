<?php

namespace App\Http\Controllers;

use App\Models\SeguimientoTicket;
use App\Models\ServicioEmpresarial;
use App\Models\TicketSoporte;
use Illuminate\Http\Request;

class SeguimientoTicketController extends Controller
{
    public function index($servicio_empresarial_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $seguimientos = SeguimientoTicket::where('servicio_empresarial_id', $servicio_empresarial_id)->get();
        return view('seguimientos_ticket.index', compact('servicio', 'seguimientos'));
    }

    public function create($servicio_empresarial_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $tickets = TicketSoporte::where('servicio_empresarial_id', $servicio_empresarial_id)->get();
        return view('seguimientos_ticket.create', compact('servicio', 'tickets'));
    }

    public function store(Request $request, $servicio_empresarial_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $validated = $request->validate([
            'ticket_soporte_id' => 'required|exists:tickets_soporte,id',
            'comentario' => 'required|string|max:1000',
            'estatus' => 'required|string|max:100'
        ]);
        $validated['servicio_empresarial_id'] = $servicio_empresarial_id;
        $validated['cliente_id'] = $servicio->cliente_id;
        SeguimientoTicket::create($validated);
        return redirect()->route('servicios_empresariales.seguimientos_ticket.index', $servicio_empresarial_id)->with('success', 'Seguimiento agregado');
    }

    public function edit($servicio_empresarial_id, $seguimiento_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $seguimiento = SeguimientoTicket::findOrFail($seguimiento_id);
        $tickets = TicketSoporte::where('servicio_empresarial_id', $servicio_empresarial_id)->get();
        return view('seguimientos_ticket.edit', compact('servicio', 'seguimiento', 'tickets'));
    }

    public function update(Request $request, $servicio_empresarial_id, $seguimiento_id)
    {
        $seguimiento = SeguimientoTicket::findOrFail($seguimiento_id);
        $validated = $request->validate([
            'ticket_soporte_id' => 'required|exists:tickets_soporte,id',
            'comentario' => 'required|string|max:1000',
            'estatus' => 'required|string|max:100'
        ]);
        $seguimiento->update($validated);
        return redirect()->route('servicios_empresariales.seguimientos_ticket.index', $servicio_empresarial_id)->with('success', 'Seguimiento actualizado');
    }

    public function destroy($servicio_empresarial_id, $seguimiento_id)
    {
        $seguimiento = SeguimientoTicket::findOrFail($seguimiento_id);
        $seguimiento->delete();
        return redirect()->route('servicios_empresariales.seguimientos_ticket.index', $servicio_empresarial_id)->with('success', 'Seguimiento eliminado');
    }
}
