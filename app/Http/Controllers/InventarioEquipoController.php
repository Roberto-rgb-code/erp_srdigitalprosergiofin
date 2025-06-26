<?php

namespace App\Http\Controllers;

use App\Models\InventarioEquipo;
use App\Models\ServicioEmpresarial;
use Illuminate\Http\Request;

class InventarioEquipoController extends Controller
{
    public function index($servicioId)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicioId);
        $inventarios = InventarioEquipo::where('servicio_empresarial_id', $servicioId)->paginate(10);
        return view('inventario_equipos.index', compact('inventarios', 'servicio'));
    }

    public function create($servicioId)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicioId);
        return view('inventario_equipos.create', compact('servicio'));
    }

    public function store(Request $request, $servicioId)
    {
        $request->validate([
            'tipo_equipo' => 'required|string|max:100',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'estado' => 'nullable|string|max:50',
        ]);

        InventarioEquipo::create(array_merge($request->all(), ['servicio_empresarial_id' => $servicioId]));

        return redirect()->route('inventario_equipos.index', $servicioId)
            ->with('success', 'Equipo agregado al inventario.');
    }

    public function edit($servicioId, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicioId);
        $inventario = InventarioEquipo::findOrFail($id);
        return view('inventario_equipos.edit', compact('inventario', 'servicio'));
    }

    public function update(Request $request, $servicioId, $id)
    {
        $request->validate([
            'tipo_equipo' => 'required|string|max:100',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'estado' => 'nullable|string|max:50',
        ]);

        $inventario = InventarioEquipo::findOrFail($id);
        $inventario->update($request->all());

        return redirect()->route('inventario_equipos.index', $servicioId)
            ->with('success', 'Inventario actualizado correctamente.');
    }

    public function destroy($servicioId, $id)
    {
        $inventario = InventarioEquipo::findOrFail($id);
        $inventario->delete();

        return redirect()->route('inventario_equipos.index', $servicioId)
            ->with('success', 'Inventario eliminado correctamente.');
    }
}
