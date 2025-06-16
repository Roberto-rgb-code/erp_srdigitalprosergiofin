<?php

namespace App\Http\Controllers;

use App\Models\DesarrolloSoftware;
use App\Models\Cliente;
use App\Models\TipoSoftware;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DesarrolloSoftwareExport;
use PDF;

class DesarrolloSoftwareController extends Controller
{
    public function index()
    {
        $proyectos = DesarrolloSoftware::with(['cliente', 'tipoSoftware', 'responsable'])->paginate(10);
        return view('desarrollo_software.index', compact('proyectos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $tipos = TipoSoftware::all();
        $responsables = Empleado::all();
        return view('desarrollo_software.create', compact('clientes', 'tipos', 'responsables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id'        => 'required|exists:clientes,id',
            'nombre'            => 'required|string|max:100',
            'tipo_software_id'  => 'required|exists:tipo_software,id',
            'stack_tecnologico' => 'nullable|string|max:150',
            'fecha_inicio'      => 'required|date',
            'fecha_fin'         => 'nullable|date|after_or_equal:fecha_inicio',
            'responsable_id'    => 'nullable|exists:empleados,id',
            'estado'            => 'required|string|max:30',
            'historial'         => 'nullable|string',
        ]);
        $proyecto = DesarrolloSoftware::create($validated);
        return redirect()->route('desarrollo_software.index')->with('success', 'Proyecto registrado');
    }

    public function show(DesarrolloSoftware $desarrollo_software)
    {
        $desarrollo_software->load(['cliente', 'tipoSoftware', 'responsable', 'modulos']);
        return view('desarrollo_software.show', compact('desarrollo_software'));
    }

    public function edit(DesarrolloSoftware $desarrollo_software)
    {
        $clientes = Cliente::all();
        $tipos = TipoSoftware::all();
        $responsables = Empleado::all();
        return view('desarrollo_software.edit', compact('desarrollo_software', 'clientes', 'tipos', 'responsables'));
    }

    public function update(Request $request, DesarrolloSoftware $desarrollo_software)
    {
        $validated = $request->validate([
            'cliente_id'        => 'required|exists:clientes,id',
            'nombre'            => 'required|string|max:100',
            'tipo_software_id'  => 'required|exists:tipo_software,id',
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
    $proyectos = DesarrolloSoftware::with(['cliente', 'tipoSoftware', 'responsable'])->get();
    $pdf = PDF::loadView('desarrollo_software.export_pdf', compact('proyectos'));
    return $pdf->download('proyectos_software.pdf');
}

}
