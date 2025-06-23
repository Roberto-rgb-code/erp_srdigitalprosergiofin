<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Exports\VehiculosExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class VehiculoController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehiculo::with('responsable');

        // Filtros
        if ($request->filled('placa')) {
            $query->where('placa', 'ilike', '%' . $request->placa . '%');
        }
        if ($request->filled('marca')) {
            $query->where('marca', 'ilike', '%' . $request->marca . '%');
        }
        if ($request->filled('modelo')) {
            $query->where('modelo', 'ilike', '%' . $request->modelo . '%');
        }
        if ($request->filled('responsable_id')) {
            $query->where('responsable_id', $request->responsable_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('anio_de') && $request->filled('anio_hasta')) {
            $query->whereBetween('año', [$request->anio_de, $request->anio_hasta]);
        } elseif ($request->filled('anio_de')) {
            $query->where('año', '>=', $request->anio_de);
        } elseif ($request->filled('anio_hasta')) {
            $query->where('año', '<=', $request->anio_hasta);
        }

        $vehiculos = $query->orderByDesc('id')->paginate(15);

        $responsables = Empleado::orderBy('nombre')->get();

        // ------ GRAFICOS --------
        $graficoEstados = Vehiculo::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $graficoMarcas = Vehiculo::selectRaw('marca, count(*) as total')
            ->groupBy('marca')
            ->pluck('total', 'marca')
            ->toArray();

        return view('vehiculos.index', compact(
            'vehiculos',
            'responsables',
            'graficoEstados',
            'graficoMarcas'
        ));
    }

    public function create()
    {
        $responsables = Empleado::orderBy('nombre')->get();
        return view('vehiculos.create', compact('responsables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'placa' => 'required|string|max:20|unique:vehiculos,placa',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'año' => 'required|integer',
            'tipo' => 'nullable|string|max:50',
            'kilometraje' => 'nullable|numeric',
            'responsable_id' => 'nullable|integer|exists:empleados,id',
            'status' => 'required|string|max:30',
            'fecha_adquisicion' => 'nullable|date',
        ]);
        Vehiculo::create($validated);
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo registrado correctamente');
    }

    public function show(Vehiculo $vehiculo)
    {
        $vehiculo->load('responsable');
        return view('vehiculos.show', compact('vehiculo'));
    }

    public function edit(Vehiculo $vehiculo)
    {
        $responsables = Empleado::orderBy('nombre')->get();
        return view('vehiculos.edit', compact('vehiculo', 'responsables'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $validated = $request->validate([
            'placa' => 'required|string|max:20|unique:vehiculos,placa,' . $vehiculo->id,
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'año' => 'required|integer',
            'tipo' => 'nullable|string|max:50',
            'kilometraje' => 'nullable|numeric',
            'responsable_id' => 'nullable|integer|exists:empleados,id',
            'status' => 'required|string|max:30',
            'fecha_adquisicion' => 'nullable|date',
        ]);
        $vehiculo->update($validated);
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo actualizado correctamente');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo eliminado');
    }

    public function exportExcel()
    {
        return Excel::download(new VehiculosExport(), 'vehiculos.xlsx');
    }

    public function exportPDF()
    {
        $vehiculos = Vehiculo::with('responsable')->get();
        $pdf = PDF::loadView('vehiculos.pdf', compact('vehiculos'));
        return $pdf->download('vehiculos.pdf');
    }
}
