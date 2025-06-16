<?php

namespace App\Http\Controllers;

use App\Models\SeguimientoTicket;
use App\Models\TicketSoporte;
use Illuminate\Http\Request;

class SeguimientoTicketController extends Controller
{
    public function index($ticket_id)
    {
        $ticket = TicketSoporte::findOrFail($ticket_id);
        $seguimientos = $ticket->seguimientos()->orderByDesc('created_at')->get();
        return view('seguimientos_ticket.index', compact('ticket', 'seguimientos'));
    }

    public function create()
{
    $tickets = \App\Models\TicketsSoporte::all();
    $usuarios = \App\Models\UsuariosCliente::all(); // O \App\Models\Usuario si usas tabla general
    return view('seguimientos_ticket.create', compact('tickets', 'usuarios'));
}

public function edit($id)
{
    $seguimientos_ticket = \App\Models\SeguimientosTicket::findOrFail($id);
    $tickets = \App\Models\TicketsSoporte::all();
    $usuarios = \App\Models\UsuariosCliente::all();
    return view('seguimientos_ticket.edit', compact('seguimientos_ticket', 'tickets', 'usuarios'));
}

    public function store(Request $request, $ticket_id)
    {
        $request->validate([
            'comentario' => 'required|string',
            'usuario_id' => 'nullable|integer',
            'visibilidad' => 'nullable|string|max:30'
        ]);
        $data = $request->all();
        $data['ticket_id'] = $ticket_id;
        SeguimientoTicket::create($data);

        return redirect()->route('seguimientos_ticket.index', $ticket_id)->with('success', 'Seguimiento agregado');
    }

    public function destroy($ticket_id, $id)
    {
        $seguimiento = SeguimientoTicket::where('ticket_id', $ticket_id)->where('id', $id)->firstOrFail();
        $seguimiento->delete();
        return redirect()->route('seguimientos_ticket.index', $ticket_id)->with('success', 'Seguimiento eliminado');
    }
}
