<?php

namespace App\Http\Controllers;

use App\Models\MantenimientoProgramado;
use App\Models\ServicioEmpresarial;
use Illuminate\Http\Request;

class MantenimientoProgramadoController extends Controller
{
    public function index($servicioId)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicioId);
        $mantenimientos = MantenimientoProgramado::where('servicio_empresarial_id', $servicioId)->paginate(10);
        return view('mantenimientos_programados.index', compact('mantenimientos', 'servicio'));
    }

    public function create($servicioId)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicioId);
        return view('mantenimientos_programados.create', compact('servicio'));
    }

    public function store(Request $request, $servicioId)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'fecha_programada' => 'required|date',
            'estado' => 'required|string|max:50',
            'comentarios' => 'nullable|string',
        ]);

        MantenimientoProgramado::create([
            'servicio_empresarial_id' => $servicioId,
            'descripcion' => $request->descripcion,
            'fecha_programada' => $request->fecha_programada,
            'estado' => $request->estado,
            'comentarios' => $request->comentarios,
        ]);

        return redirect()->route('mantenimientos_programados.index', $servicioId)
            ->with('success', 'Mantenimiento programado creado correctamente.');
    }

    public function edit($servicioId, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicioId);
        $mantenimiento = MantenimientoProgramado::findOrFail($id);
        return view('mantenimientos_programados.edit', compact('mantenimiento', 'servicio'));
    }

    public function update(Request $request, $servicioId, $id)
    {
        $mantenimiento = MantenimientoProgramado::findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string',
            'fecha_programada' => 'required|date',
            'estado' => 'required|string|max:50',
            'comentarios' => 'nullable|string',
        ]);

        $mantenimiento->update($request->all());

        return redirect()->route('mantenimientos_programados.index', $servicioId)
            ->with('success', 'Mantenimiento actualizado correctamente.');
    }

    public function destroy($servicioId, $id)
    {
        $mantenimiento = MantenimientoProgramado::findOrFail($id);
        $mantenimiento->delete();

        return redirect()->route('mantenimientos_programados.index', $servicioId)
            ->with('success', 'Mantenimiento eliminado correctamente.');
    }
}
