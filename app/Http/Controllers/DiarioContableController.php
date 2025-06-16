<?php

namespace App\Http\Controllers;

use App\Models\DiarioContable;
use App\Models\PolizaContable;
use App\Models\CuentaContable;
use Illuminate\Http\Request;

class DiarioContableController extends Controller
{
    public function index(Request $request)
    {
        // Permite filtrar por fecha, cuenta o póliza
        $query = DiarioContable::with(['poliza', 'cuenta']);

        if ($request->filled('fecha')) {
            $query->where('fecha', $request->fecha);
        }
        if ($request->filled('poliza_id')) {
            $query->where('poliza_id', $request->poliza_id);
        }
        if ($request->filled('cuenta_contable_id')) {
            $query->where('cuenta_contable_id', $request->cuenta_contable_id);
        }

        $registros = $query->orderByDesc('fecha')->paginate(20);

        return view('diario_contable.index', compact('registros'));
    }

    public function create()
    {
        $polizas = PolizaContable::orderByDesc('fecha')->get();
        $cuentas = CuentaContable::orderBy('codigo')->get();
        return view('diario_contable.create', compact('polizas', 'cuentas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'poliza_id'          => 'required|integer|exists:polizas_contables,id',
            'cuenta_contable_id' => 'required|integer|exists:cuentas_contables,id',
            'debe'               => 'required|numeric|min:0',
            'haber'              => 'required|numeric|min:0',
            'fecha'              => 'required|date',
        ]);
        DiarioContable::create($data);
        return redirect()->route('diario_contable.index')->with('success', 'Registro contable creado');
    }

    public function show(DiarioContable $diario_contable)
    {
        $diario_contable->load(['poliza', 'cuenta']);
        return view('diario_contable.show', compact('diario_contable'));
    }

    public function edit(DiarioContable $diario_contable)
    {
        $polizas = PolizaContable::orderByDesc('fecha')->get();
        $cuentas = CuentaContable::orderBy('codigo')->get();
        return view('diario_contable.edit', compact('diario_contable', 'polizas', 'cuentas'));
    }

    public function update(Request $request, DiarioContable $diario_contable)
    {
        $data = $request->validate([
            'poliza_id'          => 'required|integer|exists:polizas_contables,id',
            'cuenta_contable_id' => 'required|integer|exists:cuentas_contables,id',
            'debe'               => 'required|numeric|min:0',
            'haber'              => 'required|numeric|min:0',
            'fecha'              => 'required|date',
        ]);
        $diario_contable->update($data);
        return redirect()->route('diario_contable.index')->with('success', 'Registro contable actualizado');
    }

    public function destroy(DiarioContable $diario_contable)
    {
        $diario_contable->delete();
        return redirect()->route('diario_contable.index')->with('success', 'Registro eliminado');
    }
}
