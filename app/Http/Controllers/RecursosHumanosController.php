<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\PuestoEmpleado;
use Illuminate\Http\Request;

class RecursosHumanosController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with('puesto')->paginate(10);
        return view('recursos_humanos.index', compact('empleados'));
    }

    public function create()
    {
        $puestos = PuestoEmpleado::all();
        return view('recursos_humanos.create', compact('puestos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'        => 'required|string|max:100',
            'apellido'      => 'required|string|max:100',
            'rfc'           => 'nullable|string|max:13',
            'curp'          => 'nullable|string|max:18',
            'puesto_id'     => 'required|exists:puestos_empleado,id',
            'fecha_ingreso' => 'required|date',
            'status'        => 'required|in:Activo,Inactivo,Baja',
            'salario'       => 'required|numeric|min:0',
            'notas'         => 'nullable|string',
        ]);
        Empleado::create($validated);
        return redirect()->route('recursos_humanos.index')->with('success', 'Empleado registrado');
    }

    public function show(Empleado $recursos_humano)
    {
        $empleado = $recursos_humano->load('puesto', 'asistencias', 'documentos', 'nominas', 'permisos');
        return view('recursos_humanos.show', compact('empleado'));
    }

    public function edit(Empleado $recursos_humano)
    {
        $puestos = PuestoEmpleado::all();
        return view('recursos_humanos.edit', [
            'empleado' => $recursos_humano,
            'puestos'  => $puestos
        ]);
    }

    public function update(Request $request, Empleado $recursos_humano)
    {
        $validated = $request->validate([
            'nombre'        => 'required|string|max:100',
            'apellido'      => 'required|string|max:100',
            'rfc'           => 'nullable|string|max:13',
            'curp'          => 'nullable|string|max:18',
            'puesto_id'     => 'required|exists:puestos_empleado,id',
            'fecha_ingreso' => 'required|date',
            'status'        => 'required|in:Activo,Inactivo,Baja',
            'salario'       => 'required|numeric|min:0',
            'notas'         => 'nullable|string',
        ]);
        $recursos_humano->update($validated);
        return redirect()->route('recursos_humanos.index')->with('success', 'Empleado actualizado');
    }

    public function destroy(Empleado $recursos_humano)
    {
        $recursos_humano->delete();
        return back()->with('success', 'Empleado eliminado');
    }
}
