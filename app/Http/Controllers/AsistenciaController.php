<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Asistencia;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index(Empleado $empleado)
    {
        $asistencias = $empleado->asistencias()->orderByDesc('fecha')->get();
        return view('recursos_humanos.asistencias.index', compact('empleado', 'asistencias'));
    }

    public function create(Empleado $empleado)
    {
        return view('recursos_humanos.asistencias.create', compact('empleado'));
    }

    public function store(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'tipo'  => 'required|string|max:30', // falta, retardo, asistencia
            'motivo'=> 'nullable|string|max:150'
        ]);
        $empleado->asistencias()->create($validated);
        return redirect()->route('recursos_humanos.asistencias.index', $empleado)->with('success', 'Asistencia registrada');
    }

    public function edit(Empleado $empleado, Asistencia $asistencia)
    {
        return view('recursos_humanos.asistencias.edit', compact('empleado', 'asistencia'));
    }

    public function update(Request $request, Empleado $empleado, Asistencia $asistencia)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'tipo'  => 'required|string|max:30',
            'motivo'=> 'nullable|string|max:150'
        ]);
        $asistencia->update($validated);
        return redirect()->route('recursos_humanos.asistencias.index', $empleado)->with('success', 'Asistencia actualizada');
    }

    public function destroy(Empleado $empleado, Asistencia $asistencia)
    {
        $asistencia->delete();
        return redirect()->route('recursos_humanos.asistencias.index', $empleado)->with('success', 'Registro eliminado');
    }
}
