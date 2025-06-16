<?php

namespace App\Http\Controllers;

use App\Models\CuentaContable;
use Illuminate\Http\Request;

class CuentaContableController extends Controller
{
    public function index()
    {
        $cuentas = CuentaContable::orderBy('codigo')->paginate(20);
        return view('cuentas_contables.index', compact('cuentas'));
    }

    public function create()
    {
        $padres = CuentaContable::all();
        return view('cuentas_contables.create', compact('padres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo'    => 'required|string|max:30|unique:cuentas_contables,codigo',
            'nombre'    => 'required|string|max:80',
            'tipo'      => 'required|string|max:30',
            'nivel'     => 'required|integer',
            'status'    => 'required|string|max:20',
            'padre_id'  => 'nullable|integer|exists:cuentas_contables,id',
        ]);
        CuentaContable::create($data);
        return redirect()->route('cuentas_contables.index')->with('success', 'Cuenta registrada');
    }

    public function show(CuentaContable $cuentas_contable)
    {
        return view('cuentas_contables.show', ['cuenta' => $cuentas_contable]);
    }

    public function edit(CuentaContable $cuentas_contable)
    {
        $padres = CuentaContable::where('id', '!=', $cuentas_contable->id)->get();
        return view('cuentas_contables.edit', ['cuenta' => $cuentas_contable, 'padres' => $padres]);
    }

    public function update(Request $request, CuentaContable $cuentas_contable)
    {
        $data = $request->validate([
            'codigo'    => 'required|string|max:30|unique:cuentas_contables,codigo,' . $cuentas_contable->id,
            'nombre'    => 'required|string|max:80',
            'tipo'      => 'required|string|max:30',
            'nivel'     => 'required|integer',
            'status'    => 'required|string|max:20',
            'padre_id'  => 'nullable|integer|exists:cuentas_contables,id',
        ]);
        $cuentas_contable->update($data);
        return redirect()->route('cuentas_contables.index')->with('success', 'Cuenta actualizada');
    }

    public function destroy(CuentaContable $cuentas_contable)
    {
        $cuentas_contable->delete();
        return redirect()->route('cuentas_contables.index')->with('success', 'Cuenta eliminada');
    }
}
