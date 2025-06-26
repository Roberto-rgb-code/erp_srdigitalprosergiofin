<?php

namespace App\Http\Controllers;

use App\Models\InventarioCliente;
use App\Models\ServicioEmpresarial;
use Illuminate\Http\Request;

class InventarioClienteController extends Controller
{
    // Listar inventarios (puedes ajustar según necesidad)
    public function index()
    {
        $inventarios = InventarioCliente::with('servicio')->paginate(15);
        return view('inventario_clientes.index', compact('inventarios'));
    }

    // Mostrar formulario para crear nuevo inventario
    public function create()
    {
        $servicios = ServicioEmpresarial::with('cliente')->get();
        return view('inventario_clientes.create', compact('servicios'));
    }

    // Guardar inventario nuevo
    public function store(Request $request)
    {
        $validated = $request->validate([
            'servicio_empresarial_id' => 'required|exists:servicios_empresariales,id',
            'nombre_equipo'           => 'required|string|max:255',
            'descripcion'             => 'nullable|string',
            'numero_serie'            => 'nullable|string|max:255',
        ]);

        InventarioCliente::create($validated);

        return redirect()->route('inventario_clientes.index')
            ->with('success', 'Inventario creado correctamente');
    }

    // Mostrar formulario para editar inventario
    public function edit(InventarioCliente $inventario_cliente)
    {
        $servicios = ServicioEmpresarial::with('cliente')->get();
        return view('inventario_clientes.edit', compact('inventario_cliente', 'servicios'));
    }

    // Actualizar inventario
    public function update(Request $request, InventarioCliente $inventario_cliente)
    {
        $validated = $request->validate([
            'servicio_empresarial_id' => 'required|exists:servicios_empresariales,id',
            'nombre_equipo'           => 'required|string|max:255',
            'descripcion'             => 'nullable|string',
            'numero_serie'            => 'nullable|string|max:255',
        ]);

        $inventario_cliente->update($validated);

        return redirect()->route('inventario_clientes.index')
            ->with('success', 'Inventario actualizado correctamente');
    }

    // Eliminar inventario
    public function destroy(InventarioCliente $inventario_cliente)
    {
        $inventario_cliente->delete();

        return redirect()->route('inventario_clientes.index')
            ->with('success', 'Inventario eliminado correctamente');
    }
}
