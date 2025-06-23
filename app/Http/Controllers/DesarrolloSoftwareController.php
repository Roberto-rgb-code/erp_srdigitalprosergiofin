<?php

namespace App\Http\Controllers;

use App\Models\DesarrolloSoftware;
use App\Models\Cliente;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DesarrolloSoftwareExport;
use PDF;

class DesarrolloSoftwareController extends Controller
{
    public function index()
    {
        $proyectos = DesarrolloSoftware::with(['cliente', 'responsable'])->paginate(10);

        $graficoEstados = DesarrolloSoftware::select('estado')
            ->selectRaw('count(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        $totalProyectos = DesarrolloSoftware::count();
        $proyectosFinalizados = DesarrolloSoftware::where('estado', 'Finalizado')->count();
        $proyectosEnDesarrollo = DesarrolloSoftware::where('estado', 'En desarrollo')->count();
        $proyectosTesting = DesarrolloSoftware::where('estado', 'Testing')->count();
        $proyectosPlaneados = DesarrolloSoftware::where('estado', 'Planeado')->count();

        return view('desarrollo_software.index', compact(
            'proyectos', 'graficoEstados',
            'totalProyectos', 'proyectosFinalizados', 'proyectosEnDesarrollo', 'proyectosTesting', 'proyectosPlaneados'
        ));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $responsables = Empleado::all();
        return view('desarrollo_software.create', compact('clientes', 'responsables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id'        => 'required|exists:clientes,id',
            'nombre'            => 'required|string|max:100',
            'tipo_software'     => 'required|string|max:150',
            'stack_tecnologico' => 'nullable|string|max:150',
            'fecha_inicio'      => 'required|date',
            'fecha_fin'         => 'nullable|date|after_or_equal:fecha_inicio',
            'responsable_id'    => 'nullable|exists:empleados,id',
            'estado'            => 'required|string|max:30',
            'historial'         => 'nullable|string',
        ]);

        DesarrolloSoftware::create($validated);

        return redirect()->route('desarrollo_software.index')->with('success', 'Proyecto registrado');
    }

    public function show(DesarrolloSoftware $desarrollo_software)
    {
        $desarrollo_software->load(['cliente', 'responsable']);
        return view('desarrollo_software.show', compact('desarrollo_software'));
    }

    public function edit(DesarrolloSoftware $desarrollo_software)
    {
        $clientes = Cliente::all();
        $responsables = Empleado::all();
        return view('desarrollo_software.edit', compact('desarrollo_software', 'clientes', 'responsables'));
    }

    public function update(Request $request, DesarrolloSoftware $desarrollo_software)
    {
        $validated = $request->validate([
            'cliente_id'        => 'required|exists:clientes,id',
            'nombre'            => 'required|string|max:100',
            'tipo_software'     => 'required|string|max:150',
            'stack_tecnologico' => 'nullable|string|max:150',
            'fecha_inicio'      => 'required|date',
            'fecha_fin'         => 'nullable|date|after_or_equal:fecha_inicio',
            'responsable_id'    => 'nullable|exists:empleados,id',
            'estado'            => 'required|string|max:30',
            'historial'         => 'nullable|string',
        ]);

        $desarrollo_software->update($validated);

        return redirect()->route('desarrollo_software.index')->with('success', 'Proyecto actualizado');
    }

    public function destroy(DesarrolloSoftware $desarrollo_software)
    {
        $desarrollo_software->delete();
        return back()->with('success', 'Proyecto eliminado');
    }

    public function exportExcel()
    {
        return Excel::download(new DesarrolloSoftwareExport, 'proyectos_software.xlsx');
    }

    public function exportPDF()
    {
        $proyectos = DesarrolloSoftware::with(['cliente', 'responsable'])->get();
        $pdf = PDF::loadView('desarrollo_software.export_pdf', compact('proyectos'));
        return $pdf->download('proyectos_software.pdf');
    }

    // Nuevo método para actualizar solo el estado vía AJAX
    public function actualizarEstado(Request $request, DesarrolloSoftware $desarrollo_software)
    {
        $validated = $request->validate([
            'estado' => 'required|string|in:Planeado,En desarrollo,Testing,Finalizado',
        ]);

        $desarrollo_software->update(['estado' => $validated['estado']]);

        return response()->json([
            'success' => true,
            'mensaje' => 'Estado actualizado',
            'nuevo_estado' => $validated['estado']
        ]);
    }
}
