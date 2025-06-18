<?php

namespace App\Http\Controllers;

use App\Models\EvidenciaVehiculo;
use App\Models\Vehiculo;
use App\Models\UsoVehiculo;
use Illuminate\Http\Request;
use App\Exports\EvidenciaVehiculoExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class EvidenciaVehiculoController extends Controller
{
    public function index($vehiculo_id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);
        $evidencias = EvidenciaVehiculo::where('vehiculo_id', $vehiculo_id)
            ->orderByDesc('fecha')->paginate(15);
        return view('evidencia_vehiculo.index', compact('vehiculo', 'evidencias'));
    }

    public function create($vehiculo_id)
    {
        $vehiculo = Vehiculo::findOrFail($vehiculo_id);
        $usos = UsoVehiculo::where('vehiculo_id', $vehiculo_id)->get();
        return view('evidencia_vehiculo.create', compact('vehiculo', 'usos'));
    }

    public function store(Request $request, $vehiculo_id)
    {
        $validated = $request->validate([
            'uso_id' => 'nullable|integer|exists:uso_vehiculo,id',
            'tipo'   => 'required|string|max:30',
            'archivo' => 'required|file|mimes:pdf,jpeg,png,jpg,gif,webp|max:10240',
            'fecha'  => 'required|date'
        ]);

        $archivoPath = null;
        if ($request->hasFile('archivo')) {
            $archivoPath = $request->file('archivo')->store('evidencias_vehiculo', 'public');
        }

        $data = [
            'vehiculo_id' => $vehiculo_id,
            'uso_id' => $validated['uso_id'] ?? null,
            'tipo' => $validated['tipo'],
            'archivo' => $archivoPath,
            'fecha' => $validated['fecha'],
        ];

        EvidenciaVehiculo::create($data);

        return redirect()->route('vehiculos.evidencia.index', $vehiculo_id)->with('success', 'Evidencia registrada');
    }

    public function destroy($vehiculo_id, $id)
    {
        $evidencia = EvidenciaVehiculo::findOrFail($id);
        // Borra el archivo real
        if ($evidencia->archivo && \Storage::disk('public')->exists($evidencia->archivo)) {
            \Storage::disk('public')->delete($evidencia->archivo);
        }
        $evidencia->delete();
        return redirect()->route('vehiculos.evidencia.index', $vehiculo_id)->with('success', 'Evidencia eliminada');
    }

    public function exportExcel($vehiculo_id)
    {
        return Excel::download(new EvidenciaVehiculoExport($vehiculo_id), 'evidencias.xlsx');
    }

    public function exportPDF($vehiculo_id)
    {
        $vehiculo = \App\Models\Vehiculo::findOrFail($vehiculo_id);
        $evidencias = \App\Models\EvidenciaVehiculo::with('uso')->where('vehiculo_id', $vehiculo_id)
            ->orderByDesc('fecha')->get();

        $pdf = PDF::loadView('evidencia_vehiculo.pdf', compact('vehiculo', 'evidencias'));
        return $pdf->download('evidencias.pdf');
    }
}
