<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Empleado;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Exports\VehiculosExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class VehiculoController extends Controller
{
    public function index(Request $request)
{
    $query = \App\Models\Vehiculo::with(['responsable', 'cliente']);

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
    // Filtro por rango de año
    if ($request->filled('anio_de') && $request->filled('anio_hasta')) {
        $query->whereBetween('año', [$request->anio_de, $request->anio_hasta]);
    } elseif ($request->filled('anio_de')) {
        $query->where('año', '>=', $request->anio_de);
    } elseif ($request->filled('anio_hasta')) {
        $query->where('año', '<=', $request->anio_hasta);
    }

    $vehiculos = $query->orderByDesc('id')->paginate(15);

    $responsables = \App\Models\Empleado::orderBy('nombre')->get();

    return view('vehiculos.index', compact('vehiculos', 'responsables'));
}


    public function create()
    {
        $responsables = Empleado::orderBy('nombre')->get();
        $clientes = Cliente::orderBy('nombre')->get();
        return view('vehiculos.create', compact('responsables', 'clientes'));
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
            'cliente_id' => 'nullable|integer|exists:clientes,id',
            'status' => 'required|string|max:30',
            'fecha_adquisicion' => 'nullable|date',
        ]);
        Vehiculo::create($validated);
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo registrado correctamente');
    }

    public function show(Vehiculo $vehiculo)
    {
        $vehiculo->load(['responsable', 'cliente']);
        return view('vehiculos.show', compact('vehiculo'));
    }

    public function edit(Vehiculo $vehiculo)
    {
        $responsables = Empleado::orderBy('nombre')->get();
        $clientes = Cliente::orderBy('nombre')->get();
        return view('vehiculos.edit', compact('vehiculo', 'responsables', 'clientes'));
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
            'cliente_id' => 'nullable|integer|exists:clientes,id',
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
    $vehiculos = \App\Models\Vehiculo::with(['responsable', 'cliente'])->get();
    $pdf = PDF::loadView('vehiculos.pdf', compact('vehiculos'));
    return $pdf->download('vehiculos.pdf');
}
}
