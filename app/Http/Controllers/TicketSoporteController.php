<?php

namespace App\Http\Controllers;

use App\Models\TicketSoporte;
use App\Models\ServicioEmpresarial;
use Illuminate\Http\Request;

class TicketSoporteController extends Controller
{
    public function index($servicioId)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicioId);
        $tickets = TicketSoporte::where('servicio_empresarial_id', $servicioId)->paginate(10);
        return view('tickets_soporte.index', compact('tickets', 'servicio'));
    }

    public function create($servicioId)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicioId);
        return view('tickets_soporte.create', compact('servicio'));
    }

    public function store(Request $request, $servicioId)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|string|max:50',
            'prioridad' => 'required|string|max:50',
            'fecha_apertura' => 'required|date',
            'fecha_cierre' => 'nullable|date|after_or_equal:fecha_apertura',
            'asignado_a' => 'nullable|integer',
            'comentarios' => 'nullable|string',
        ]);

        TicketSoporte::create([
            'servicio_empresarial_id' => $servicioId,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
            'prioridad' => $request->prioridad,
            'fecha_apertura' => $request->fecha_apertura,
            'fecha_cierre' => $request->fecha_cierre,
            'asignado_a' => $request->asignado_a,
            'comentarios' => $request->comentarios,
        ]);

        return redirect()->route('tickets_soporte.index', $servicioId)
            ->with('success', 'Ticket de soporte creado correctamente.');
    }

    public function edit($servicioId, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicioId);
        $ticket = TicketSoporte::findOrFail($id);
        return view('tickets_soporte.edit', compact('ticket', 'servicio'));
    }

    public function update(Request $request, $servicioId, $id)
    {
        $ticket = TicketSoporte::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|string|max:50',
            'prioridad' => 'required|string|max:50',
            'fecha_apertura' => 'required|date',
            'fecha_cierre' => 'nullable|date|after_or_equal:fecha_apertura',
            'asignado_a' => 'nullable|integer',
            'comentarios' => 'nullable|string',
        ]);

        $ticket->update($request->all());

        return redirect()->route('tickets_soporte.index', $servicioId)
            ->with('success', 'Ticket actualizado correctamente.');
    }

    public function destroy($servicioId, $id)
    {
        $ticket = TicketSoporte::findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets_soporte.index', $servicioId)
            ->with('success', 'Ticket eliminado correctamente.');
    }
}
