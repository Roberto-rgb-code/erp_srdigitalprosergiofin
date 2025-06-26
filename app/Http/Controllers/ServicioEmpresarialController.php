<?php

namespace App\Http\Controllers;

use App\Models\ServicioEmpresarial;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ServicioEmpresarialController extends Controller
{
    public function index()
    {
        $servicios = ServicioEmpresarial::with('cliente')->paginate(10);
        return view('servicios_empresariales.index', compact('servicios'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('servicios_empresariales.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_poliza' => 'required|string|max:50',
            'estatus' => 'required|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'comentarios' => 'nullable|string',
        ]);

        // Inicializar campos internos
        $validated['servicios_contratados'] = 0;
        $validated['servicios_restantes'] = 0;

        ServicioEmpresarial::create($validated);

        return redirect()->route('servicios_empresariales.index')->with('success', 'Servicio Empresarial creado correctamente.');
    }

    public function edit(ServicioEmpresarial $servicio)
    {
        $clientes = Cliente::all();
        return view('servicios_empresariales.edit', compact('servicio', 'clientes'));
    }

    public function update(Request $request, ServicioEmpresarial $servicio)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_poliza' => 'required|string|max:50',
            'estatus' => 'required|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'comentarios' => 'nullable|string',
        ]);

        $servicio->update($validated);

        return redirect()->route('servicios_empresariales.index')->with('success', 'Servicio Empresarial actualizado correctamente.');
    }

    public function destroy(ServicioEmpresarial $servicio)
    {
        $servicio->delete();
        return redirect()->route('servicios_empresariales.index')->with('success', 'Servicio Empresarial eliminado correctamente.');
    }

    public function show(ServicioEmpresarial $servicio_empresarial)
{
    return view('servicios_empresariales.show', compact('servicio_empresarial'));
}


}
