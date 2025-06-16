<?php

namespace App\Http\Controllers;

use App\Models\EntregaModulo;
use App\Models\ModuloSoftware;
use Illuminate\Http\Request;

class EntregaModuloController extends Controller
{
    public function index($proyecto, $modulo)
    {
        $modulo = ModuloSoftware::findOrFail($modulo);
        $entregas = $modulo->entregas()->get();
        return view('entregas_modulo.index', compact('modulo', 'entregas', 'proyecto'));
    }

    public function create($proyecto, $modulo)
    {
        $modulo = ModuloSoftware::findOrFail($modulo);
        return view('entregas_modulo.create', compact('modulo', 'proyecto'));
    }

    public function store(Request $request, $proyecto, $modulo)
    {
        $validated = $request->validate([
            'descripcion' => 'nullable|string',
            'archivo'     => 'nullable|file',
            'version'     => 'nullable|string|max:20',
            'fecha'       => 'nullable|date'
        ]);
        $validated['modulo_software_id'] = $modulo;
        if ($request->hasFile('archivo')) {
            $validated['archivo'] = $request->file('archivo')->store('entregas');
        }
        EntregaModulo::create($validated);
        return redirect()->route('modulos_software.entregas.index', [$proyecto, $modulo])->with('success', 'Entrega registrada');
    }

    public function destroy($proyecto, $modulo, EntregaModulo $entrega)
    {
        if ($entrega->archivo) {
            \Storage::delete($entrega->archivo);
        }
        $entrega->delete();
        return back()->with('success', 'Entrega eliminada');
    }
}
