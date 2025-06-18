<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Exports\TallerExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class TallerController extends Controller
{
    public function index()
    {
        $talleres = Taller::with(['cliente', 'equipo', 'tecnico'])
            ->orderByDesc('id')
            ->paginate(15);

        $equipos = Equipo::orderByDesc('id')->paginate(10); // Si quieres mostrar catálogo de equipos

        return view('taller.index', compact('talleres', 'equipos'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $equipos = Equipo::orderBy('marca')->get();
        $responsables = Empleado::orderBy('nombre')->get();

        return view('taller.create', compact('clientes', 'equipos', 'responsables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id'      => 'required|integer|exists:clientes,id',
            'tipo_cliente'    => 'nullable|string|max:30',
            'equipo_id'       => 'required|integer|exists:equipos,id',
            'tecnico_id'      => 'required|integer|exists:empleados,id',
            'fecha_ingreso'   => 'required|date',
            'fecha_entrega'   => 'nullable|date|after_or_equal:fecha_ingreso',
            'detalle_problema'=> 'required|string|max:255',
            'solucion'        => 'nullable|string|max:255',
            'observaciones'   => 'nullable|string|max:255',
            'imei'            => 'nullable|string|max:50',
            'condicion_fisica'=> 'nullable|string|max:50',
            'estetica'        => 'nullable|string|max:50',
            'tipo_bloqueo'    => 'nullable|string|max:50',
            'zona_trabajo'    => 'nullable|string|max:50',
            'costo_total'     => 'nullable|numeric',
            'anticipo'        => 'nullable|numeric',
            'firma_cliente'   => 'nullable|string|max:255',
            'status'          => 'nullable|string|max:50',
        ]);

        $taller = Taller::create($validated);

        return redirect()->route('taller.show', $taller)->with('success', 'Orden de servicio creada correctamente');
    }

    public function show(Taller $taller)
    {
        $taller->load(['cliente', 'equipo', 'tecnico']);
        return view('taller.show', compact('taller'));
    }

    public function edit(Taller $taller)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $equipos = Equipo::orderBy('marca')->get();
        $responsables = Empleado::orderBy('nombre')->get();

        return view('taller.edit', compact('taller', 'clientes', 'equipos', 'responsables'));
    }

    public function update(Request $request, Taller $taller)
    {
        $validated = $request->validate([
            'cliente_id'      => 'required|integer|exists:clientes,id',
            'tipo_cliente'    => 'nullable|string|max:30',
            'equipo_id'       => 'required|integer|exists:equipos,id',
            'tecnico_id'      => 'required|integer|exists:empleados,id',
            'fecha_ingreso'   => 'required|date',
            'fecha_entrega'   => 'nullable|date|after_or_equal:fecha_ingreso',
            'detalle_problema'=> 'required|string|max:255',
            'solucion'        => 'nullable|string|max:255',
            'observaciones'   => 'nullable|string|max:255',
            'imei'            => 'nullable|string|max:50',
            'condicion_fisica'=> 'nullable|string|max:50',
            'estetica'        => 'nullable|string|max:50',
            'tipo_bloqueo'    => 'nullable|string|max:50',
            'zona_trabajo'    => 'nullable|string|max:50',
            'costo_total'     => 'nullable|numeric',
            'anticipo'        => 'nullable|numeric',
            'firma_cliente'   => 'nullable|string|max:255',
            'status'          => 'nullable|string|max:50',
        ]);
        $taller->update($validated);

        return redirect()->route('taller.show', $taller)->with('success', 'Orden de servicio actualizada correctamente');
    }

    public function destroy(Taller $taller)
    {
        $taller->delete();
        return redirect()->route('taller.index')->with('success', 'Orden de servicio eliminada');
    }

    public function exportExcel()
    {
        return Excel::download(new TallerExport, 'ordenes_servicio.xlsx');
    }

    public function exportPDF()
    {
        $talleres = Taller::with(['cliente','equipo','tecnico'])->get();
        $pdf = PDF::loadView('taller.export_pdf', compact('talleres'));
        return $pdf->download('ordenes_servicio.pdf');
    }
}
