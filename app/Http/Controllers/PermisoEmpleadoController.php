<?php

// app/Http/Controllers/PermisoEmpleadoController.php
namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\PermisoEmpleado;
use Illuminate\Http\Request;

class PermisoEmpleadoController extends Controller
{
    public function index(Empleado $empleado)
    {
        $permisos = $empleado->permisos()->orderByDesc('fecha_inicio')->get();
        return view('recursos_humanos.permisos.index', compact('empleado', 'permisos'));
    }

    public function create(Empleado $empleado)
    {
        return view('recursos_humanos.permisos.create', compact('empleado'));
    }

    public function store(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'motivo'       => 'required|string|max:255',
            'aprobado'     => 'required|in:0,1',
        ]);
        $validated['empleado_id'] = $empleado->id;
        PermisoEmpleado::create($validated);

        return redirect()->route('recursos_humanos.permisos.index', $empleado)
            ->with('success', 'Permiso registrado correctamente');
    }

    public function edit(Empleado $empleado, PermisoEmpleado $permiso)
    {
        return view('recursos_humanos.permisos.edit', compact('empleado', 'permiso'));
    }

    public function update(Request $request, Empleado $empleado, PermisoEmpleado $permiso)
    {
        $validated = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'motivo'       => 'required|string|max:255',
            'aprobado'     => 'required|in:0,1',
        ]);
        $permiso->update($validated);
        return redirect()->route('recursos_humanos.permisos.index', $empleado)
            ->with('success', 'Permiso actualizado correctamente');
    }

    public function destroy(Empleado $empleado, PermisoEmpleado $permiso)
    {
        $permiso->delete();
        return redirect()->route('recursos_humanos.permisos.index', $empleado)
            ->with('success', 'Permiso eliminado correctamente');
    }
}
