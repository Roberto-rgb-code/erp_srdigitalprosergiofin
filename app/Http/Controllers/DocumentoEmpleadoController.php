<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\DocumentoEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoEmpleadoController extends Controller
{
    public function index(Empleado $empleado)
    {
        $documentos = $empleado->documentos()->get();
        return view('recursos_humanos.documentos.index', compact('empleado', 'documentos'));
    }

    public function create(Empleado $empleado)
    {
        return view('recursos_humanos.documentos.create', compact('empleado'));
    }

    public function store(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'archivo'=> 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);
        $path = $request->file('archivo')->store('documentos_empleado', 'public');
        $empleado->documentos()->create([
            'nombre' => $validated['nombre'],
            'archivo' => $path
        ]);
        return redirect()->route('recursos_humanos.documentos.index', $empleado)->with('success', 'Documento registrado');
    }

    public function edit(Empleado $empleado, DocumentoEmpleado $documento)
    {
        return view('recursos_humanos.documentos.edit', compact('empleado', 'documento'));
    }

    public function update(Request $request, Empleado $empleado, DocumentoEmpleado $documento)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'archivo'=> 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);
        if ($request->hasFile('archivo')) {
            Storage::disk('public')->delete($documento->archivo);
            $path = $request->file('archivo')->store('documentos_empleado', 'public');
            $documento->archivo = $path;
        }
        $documento->nombre = $validated['nombre'];
        $documento->save();
        return redirect()->route('recursos_humanos.documentos.index', $empleado)->with('success', 'Documento actualizado');
    }

    public function destroy(Empleado $empleado, DocumentoEmpleado $documento)
    {
        Storage::disk('public')->delete($documento->archivo);
        $documento->delete();
        return redirect()->route('recursos_humanos.documentos.index', $empleado)->with('success', 'Documento eliminado');
    }
}
