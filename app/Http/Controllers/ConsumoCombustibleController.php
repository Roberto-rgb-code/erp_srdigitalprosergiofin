<?php

namespace App\Http\Controllers;

use App\Models\ConsumoCombustible;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use App\Exports\ConsumoCombustibleExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ConsumoCombustibleController extends Controller
{
    public function index($vehiculo_id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);
        $consumos = ConsumoCombustible::where('vehiculo_id', $vehiculo_id)
            ->orderByDesc('fecha')->paginate(15);
        return view('consumo_combustible.index', compact('vehiculo', 'consumos'));
    }

    public function create($vehiculo_id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);
        return view('consumo_combustible.create', compact('vehiculo'));
    }

    public function store(Request $request, $vehiculo_id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);

        $validated = $request->validate([
            'litros' => 'required|numeric|min:0.01',
            'monto'  => 'required|numeric|min:0.01',
            'fecha'  => 'required|date',
            'ticket' => 'nullable|string|max:255'
        ]);
        $validated['vehiculo_id'] = $vehiculo_id;
        ConsumoCombustible::create($validated);

        return redirect()->route('vehiculos.consumo.index', $vehiculo_id)->with('success', 'Consumo registrado');
    }

    public function edit($vehiculo_id, $id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);
        $consumo = ConsumoCombustible::findOrFail($id);
        return view('consumo_combustible.edit', compact('vehiculo', 'consumo'));
    }

    public function update(Request $request, $vehiculo_id, $id)
    {
        $consumo = ConsumoCombustible::findOrFail($id);

        $validated = $request->validate([
            'litros' => 'required|numeric|min:0.01',
            'monto'  => 'required|numeric|min:0.01',
            'fecha'  => 'required|date',
            'ticket' => 'nullable|string|max:255'
        ]);
        $consumo->update($validated);

        return redirect()->route('vehiculos.consumo.index', $vehiculo_id)->with('success', 'Consumo actualizado');
    }

    public function destroy($vehiculo_id, $id)
    {
        $consumo = ConsumoCombustible::findOrFail($id);
        $consumo->delete();
        return redirect()->route('vehiculos.consumo.index', $vehiculo_id)->with('success', 'Registro eliminado');
    }

    
public function exportExcel($vehiculo_id)
{
    return Excel::download(new ConsumoCombustibleExport($vehiculo_id), 'consumo_combustible.xlsx');
}

public function exportPDF($vehiculo_id)
{
    $vehiculo = \App\Models\Vehiculo::findOrFail($vehiculo_id);
    $consumos = \App\Models\ConsumoCombustible::where('vehiculo_id', $vehiculo_id)
        ->orderByDesc('fecha')->get();

    $pdf = PDF::loadView('consumo_combustible.pdf', compact('vehiculo', 'consumos'));
    return $pdf->download('consumo_combustible.pdf');
}

}
