<?php

namespace App\Http\Controllers;

use App\Models\PolizaContable;
use Illuminate\Http\Request;

class PolizaContableController extends Controller
{
    public function index()
    {
        $polizas = PolizaContable::orderByDesc('fecha')->paginate(20);
        return view('polizas_contables.index', compact('polizas'));
    }

    public function create()
    {
        return view('polizas_contables.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo'          => 'required|string|max:50',
            'referencia_id' => 'nullable|integer',
            'fecha'         => 'required|date',
            'descripcion'   => 'nullable|string',
            'monto'         => 'required|numeric',
        ]);
        PolizaContable::create($data);
        return redirect()->route('polizas_contables.index')->with('success', 'Póliza registrada');
    }

    public function show(PolizaContable $polizas_contable)
    {
        return view('polizas_contables.show', ['poliza' => $polizas_contable]);
    }

    public function edit(PolizaContable $polizas_contable)
    {
        return view('polizas_contables.edit', ['poliza' => $polizas_contable]);
    }

    public function update(Request $request, PolizaContable $polizas_contable)
    {
        $data = $request->validate([
            'tipo'          => 'required|string|max:50',
            'referencia_id' => 'nullable|integer',
            'fecha'         => 'required|date',
            'descripcion'   => 'nullable|string',
            'monto'         => 'required|numeric',
        ]);
        $polizas_contable->update($data);
        return redirect()->route('polizas_contables.index')->with('success', 'Póliza actualizada');
    }

    public function destroy(PolizaContable $polizas_contable)
    {
        $polizas_contable->delete();
        return redirect()->route('polizas_contables.index')->with('success', 'Póliza eliminada');
    }
}
