<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::orderByDesc('id')->paginate(20);
        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        return view('equipos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:50',
            'marca' => 'nullable|string|max:50',
            'modelo' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'imei' => 'nullable|string|max:50',
            'condicion_fisica' => 'nullable|string|max:50',
            'estetica' => 'nullable|string|max:50',
            'tipo_bloqueo' => 'nullable|string|max:50',
            'zona_trabajo' => 'nullable|string|max:50',
        ]);
        Equipo::create($validated);
        return redirect()->route('taller.index')->with('success', 'Equipo registrado correctamente. Ya puedes usarlo en una orden.');

    }

    public function show(Equipo $equipo)
    {
        return view('equipos.show', compact('equipo'));
    }

    public function edit(Equipo $equipo)
    {
        return view('equipos.edit', compact('equipo'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:50',
            'marca' => 'nullable|string|max:50',
            'modelo' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'imei' => 'nullable|string|max:50',
            'condicion_fisica' => 'nullable|string|max:50',
            'estetica' => 'nullable|string|max:50',
            'tipo_bloqueo' => 'nullable|string|max:50',
            'zona_trabajo' => 'nullable|string|max:50',
        ]);
        $equipo->update($validated);
        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado correctamente');
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado');
    }
}
