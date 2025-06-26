<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evidencia;
use App\Models\Taller;
use Illuminate\Support\Facades\Storage;

class EvidenciaController extends Controller
{
    // Almacenar nueva evidencia
    public function store(Request $request)
    {
        $data = $request->validate([
            'taller_id'     => 'required|exists:taller,id',
            'archivo'       => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'descripcion'   => 'required|string|max:255',
            'usuario_subio' => 'required|string|max:255',
        ]);

        // Guardar archivo
        $path = $request->file('archivo')->store('evidencias', 'public');
        $data['archivo'] = $path;

        Evidencia::create($data);

        return redirect()->route('taller.show', $request->taller_id)
            ->with('success', 'Evidencia agregada correctamente.');
    }

    // Eliminar evidencia y archivo
    public function destroy(Evidencia $evidencia)
    {
        $tallerId = $evidencia->taller_id;
        if ($evidencia->archivo && Storage::disk('public')->exists($evidencia->archivo)) {
            Storage::disk('public')->delete($evidencia->archivo);
        }
        $evidencia->delete();
        return redirect()->route('taller.show', $tallerId)
            ->with('success', 'Evidencia eliminada correctamente.');
    }
}
