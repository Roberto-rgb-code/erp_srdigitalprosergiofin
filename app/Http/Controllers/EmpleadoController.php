<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\PuestoEmpleado;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmpleadosExport;
use PDF;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with('puesto')->orderBy('nombre')->paginate(15);
        return view('recursos_humanos.index', compact('empleados'));
    }

    public function create()
    {
        $puestos = PuestoEmpleado::orderBy('nombre')->get();
        return view('recursos_humanos.create', compact('puestos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:80',
            'apellido' => 'nullable|string|max:80',
            'rfc' => 'nullable|string|max:20',
            'curp' => 'nullable|string|max:20',
            'fecha_ingreso' => 'required|date',
            'status' => 'required|string|max:20',
            'puesto_empleado_id' => 'nullable|integer|exists:puestos_empleado,id',
            'notas' => 'nullable|string',
        ]);
        $empleado = Empleado::create($validated);
        return redirect()->route('recursos_humanos.index')->with('success', 'Empleado registrado');
    }

    public function show(Empleado $recursos_humano)
    {
        $empleado = $recursos_humano->load('puesto', 'nominas', 'permisos', 'asistencias', 'documentos');
        return view('recursos_humanos.show', compact('empleado'));
    }

    public function edit(Empleado $recursos_humano)
    {
        $empleado = $recursos_humano;
        $puestos = PuestoEmpleado::orderBy('nombre')->get();
        return view('recursos_humanos.edit', compact('empleado', 'puestos'));
    }

    public function update(Request $request, Empleado $recursos_humano)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:80',
            'apellido' => 'nullable|string|max:80',
            'rfc' => 'nullable|string|max:20',
            'curp' => 'nullable|string|max:20',
            'fecha_ingreso' => 'required|date',
            'status' => 'required|string|max:20',
            'puesto_empleado_id' => 'nullable|integer|exists:puestos_empleado,id',
            'notas' => 'nullable|string',
        ]);
        $recursos_humano->update($validated);
        return redirect()->route('recursos_humanos.show', $recursos_humano)->with('success', 'Empleado actualizado');
    }

    public function destroy(Empleado $recursos_humano)
    {
        $recursos_humano->delete();
        return redirect()->route('recursos_humanos.index')->with('success', 'Empleado eliminado');
    }

    public function exportExcel()
{
    return Excel::download(new EmpleadosExport, 'empleados.xlsx');
}

public function exportPDF()
{
    $empleados = \App\Models\Empleado::with('puesto')->get();
    $pdf = PDF::loadView('recursos_humanos.export_pdf', compact('empleados'));
    return $pdf->download('empleados.pdf');
}
}
