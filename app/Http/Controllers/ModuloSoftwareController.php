<?php

namespace App\Http\Controllers;

use App\Models\ModuloSoftware;
use App\Models\DesarrolloSoftware;
use Illuminate\Http\Request;

class ModuloSoftwareController extends Controller
{
    public function index($proyecto)
    {
        $proyecto = DesarrolloSoftware::findOrFail($proyecto);
        $modulos = $proyecto->modulos()->get();
        return view('modulos_software.index', compact('proyecto', 'modulos'));
    }

    public function create($proyecto)
    {
        $proyecto = DesarrolloSoftware::findOrFail($proyecto);
        return view('modulos_software.create', compact('proyecto'));
    }

    public function store(Request $request, $proyecto)
    {
        $validated = $request->validate([
            'nombre'            => 'required|string|max:80',
            'porcentaje_avance' => 'nullable|integer|min:0|max:100',
            'fase'              => 'nullable|string|max:30'
        ]);
        $validated['desarrollo_software_id'] = $proyecto;
        ModuloSoftware::create($validated);
        return redirect()->route('modulos_software.index', $proyecto)->with('success', 'Módulo agregado');
    }

    public function edit($proyecto, ModuloSoftware $modulo)
    {
        $proyecto = DesarrolloSoftware::findOrFail($proyecto);
        return view('modulos_software.edit', compact('proyecto', 'modulo'));
    }

    public function update(Request $request, $proyecto, ModuloSoftware $modulo)
    {
        $validated = $request->validate([
            'nombre'            => 'required|string|max:80',
            'porcentaje_avance' => 'nullable|integer|min:0|max:100',
            'fase'              => 'nullable|string|max:30'
        ]);
        $modulo->update($validated);
        return redirect()->route('modulos_software.index', $proyecto)->with('success', 'Módulo actualizado');
    }

    public function destroy($proyecto, ModuloSoftware $modulo)
    {
        $modulo->delete();
        return back()->with('success', 'Módulo eliminado');
    }
}
