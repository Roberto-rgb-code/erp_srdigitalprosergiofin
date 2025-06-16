<?php

namespace App\Http\Controllers;

use App\Models\UsoVehiculo;
use App\Models\Vehiculo;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Exports\UsoVehiculoExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class UsoVehiculoController extends Controller
{
    public function index($vehiculo_id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);
        $usos = UsoVehiculo::with('empleado')->where('vehiculo_id', $vehiculo_id)
            ->orderByDesc('fecha_salida')->paginate(15);
        return view('uso_vehiculo.index', compact('vehiculo', 'usos'));
    }

    public function create($vehiculo_id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);
        $empleados = Empleado::orderBy('nombre')->get();
        return view('uso_vehiculo.create', compact('vehiculo', 'empleados'));
    }

    public function store(Request $request, $vehiculo_id)
    {
        $validated = $request->validate([
            'empleado_id'    => 'required|integer|exists:empleados,id',
            'fecha_salida'   => 'required|date',
            'hora_salida'    => 'required',
            'destino'        => 'required|string|max:100',
            'motivo'         => 'required|string',
            'fecha_retorno'  => 'nullable|date',
            'hora_retorno'   => 'nullable',
            'observaciones'  => 'nullable|string'
        ]);
        $validated['vehiculo_id'] = $vehiculo_id;
        UsoVehiculo::create($validated);

        return redirect()->route('vehiculos.uso.index', $vehiculo_id)->with('success', 'Registro de uso guardado');
    }

    public function edit($vehiculo_id, $id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);
        $empleados = Empleado::orderBy('nombre')->get();
        $uso = UsoVehiculo::findOrFail($id);
        return view('uso_vehiculo.edit', compact('vehiculo', 'empleados', 'uso'));
    }

    public function update(Request $request, $vehiculo_id, $id)
    {
        $uso = UsoVehiculo::findOrFail($id);
        $validated = $request->validate([
            'empleado_id'    => 'required|integer|exists:empleados,id',
            'fecha_salida'   => 'required|date',
            'hora_salida'    => 'required',
            'destino'        => 'required|string|max:100',
            'motivo'         => 'required|string',
            'fecha_retorno'  => 'nullable|date',
            'hora_retorno'   => 'nullable',
            'observaciones'  => 'nullable|string'
        ]);
        $uso->update($validated);

        return redirect()->route('vehiculos.uso.index', $vehiculo_id)->with('success', 'Registro de uso actualizado');
    }

    public function destroy($vehiculo_id, $id)
    {
        $uso = UsoVehiculo::findOrFail($id);
        $uso->delete();
        return redirect()->route('vehiculos.uso.index', $vehiculo_id)->with('success', 'Registro eliminado');
    }

    public function exportExcel($vehiculo_id)
{
    return Excel::download(new UsoVehiculoExport($vehiculo_id), 'bitacora_uso.xlsx');
}

public function exportPDF($vehiculo_id)
{
    $vehiculo = \App\Models\Vehiculo::findOrFail($vehiculo_id);
    $usos = \App\Models\UsoVehiculo::with('empleado')->where('vehiculo_id', $vehiculo_id)
        ->orderByDesc('fecha_salida')->get();

    $pdf = PDF::loadView('uso_vehiculo.pdf', compact('vehiculo', 'usos'));
    return $pdf->download('bitacora_uso.pdf');
}

}
