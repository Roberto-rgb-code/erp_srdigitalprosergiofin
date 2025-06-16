<?php

namespace App\Http\Controllers;

use App\Models\MantenimientoVehiculo;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use App\Exports\MantenimientoVehiculoExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class MantenimientoVehiculoController extends Controller
{
    public function index($vehiculo_id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);
        $mantenimientos = MantenimientoVehiculo::where('vehiculo_id', $vehiculo_id)
            ->orderByDesc('fecha')->paginate(15);
        return view('mantenimiento_vehiculo.index', compact('vehiculo', 'mantenimientos'));
    }

    public function create($vehiculo_id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);
        return view('mantenimiento_vehiculo.create', compact('vehiculo'));
    }

    public function store(Request $request, $vehiculo_id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);
        $validated = $request->validate([
            'tipo_servicio' => 'required|string|max:100',
            'fecha'         => 'required|date',
            'kilometraje'   => 'nullable|numeric',
            'costo'         => 'nullable|numeric',
            'observaciones' => 'nullable|string'
        ]);
        $validated['vehiculo_id'] = $vehiculo_id;
        MantenimientoVehiculo::create($validated);
        return redirect()->route('vehiculos.mantenimiento.index', $vehiculo_id)->with('success', 'Mantenimiento registrado');
    }

    public function edit($vehiculo_id, $id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);
        $mantenimiento = MantenimientoVehiculo::findOrFail($id);
        return view('mantenimiento_vehiculo.edit', compact('vehiculo', 'mantenimiento'));
    }

    public function update(Request $request, $vehiculo_id, $id)
    {
        $mantenimiento = MantenimientoVehiculo::findOrFail($id);
        $validated = $request->validate([
            'tipo_servicio' => 'required|string|max:100',
            'fecha'         => 'required|date',
            'kilometraje'   => 'nullable|numeric',
            'costo'         => 'nullable|numeric',
            'observaciones' => 'nullable|string'
        ]);
        $mantenimiento->update($validated);
        return redirect()->route('vehiculos.mantenimiento.index', $vehiculo_id)->with('success', 'Mantenimiento actualizado');
    }

    public function destroy($vehiculo_id, $id)
    {
        $mantenimiento = MantenimientoVehiculo::findOrFail($id);
        $mantenimiento->delete();
        return redirect()->route('vehiculos.mantenimiento.index', $vehiculo_id)->with('success', 'Registro eliminado');
    }

    public function exportExcel($vehiculo_id)
{
    return Excel::download(new MantenimientoVehiculoExport($vehiculo_id), 'mantenimientos.xlsx');
}

public function exportPDF($vehiculo_id)
{
    $vehiculo = \App\Models\Vehiculo::findOrFail($vehiculo_id);
    $mantenimientos = \App\Models\MantenimientoVehiculo::where('vehiculo_id', $vehiculo_id)
        ->orderByDesc('fecha')->get();

    $pdf = PDF::loadView('mantenimiento_vehiculo.pdf', compact('vehiculo', 'mantenimientos'));
    return $pdf->download('mantenimientos.pdf');
}
}
