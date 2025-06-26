<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Refaccion;
use App\Models\Taller;

class RefaccionController extends Controller
{
    // Almacenar una nueva refacción
    public function store(Request $request)
    {
        $data = $request->validate([
            'taller_id'        => 'required|exists:taller,id',
            'nombre'           => 'required|string|max:255',
            'cantidad'         => 'required|integer|min:1',
            'costo'            => 'required|numeric',
            'usuario_solicito' => 'required|string|max:255',
            'usuario_aprobo'   => 'nullable|string|max:255',
            'situacion'        => 'nullable|string|max:255',
        ]);

        Refaccion::create($data);

        return redirect()->route('taller.show', $request->taller_id)
            ->with('success', 'Refacción agregada correctamente.');
    }

    // Eliminar refacción
    public function destroy(Refaccion $refaccion)
    {
        $tallerId = $refaccion->taller_id;
        $refaccion->delete();
        return redirect()->route('taller.show', $tallerId)
            ->with('success', 'Refacción eliminada correctamente.');
    }
}
