<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\DocumentoEmpleado;
use Illuminate\Http\Request;

class DocumentoEmpleadoController extends Controller
{
    public function index(Empleado $empleado)
    {
        $documentos = $empleado->documentos()->orderByDesc('created_at')->get();
        return view('recursos_humanos.documentos.index', compact('empleado', 'documentos'));
    }

    public function create(Empleado $empleado)
    {
        return view('recursos_humanos.documentos.create', compact('empleado'));
    }

    public function store(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'nombre_documento' => 'required|string|max:150',
            'archivo' => 'required|file|mimes:pdf,jpg,png,doc,docx', // agrega más tipos si ocupas
        ]);

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('documentos_empleado', 'public');
        } else {
            $path = null;
        }

        $empleado->documentos()->create([
            'nombre_documento' => $validated['nombre_documento'],
            'archivo' => $path,
        ]);

        return redirect()->route('recursos_humanos.documentos.index', $empleado)
            ->with('success', 'Documento cargado correctamente');
    }

    public function show(Empleado $empleado, DocumentoEmpleado $documento)
    {
        // (opcional) para mostrar detalles
        return view('recursos_humanos.documentos.show', compact('empleado', 'documento'));
    }

    public function destroy(Empleado $empleado, DocumentoEmpleado $documento)
    {
        // Borra archivo físico también
        if ($documento->archivo && \Storage::disk('public')->exists($documento->archivo)) {
            \Storage::disk('public')->delete($documento->archivo);
        }
        $documento->delete();
        return redirect()->route('recursos_humanos.documentos.index', $empleado)
            ->with('success', 'Documento eliminado');
    }
}
