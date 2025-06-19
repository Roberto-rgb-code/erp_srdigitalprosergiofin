<?php

namespace App\Http\Controllers;

use App\Models\CuentaContable;
use Illuminate\Http\Request;

class CuentaContableController extends Controller
{
    public function index()
    {
        $cuentas = CuentaContable::with('cuentaPadre')->paginate(15);
        return view('cuentas_contables.index', compact('cuentas'));
    }

    public function create()
    {
        $padres = CuentaContable::all();
        return view('cuentas_contables.create', compact('padres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:cuentas_contables,codigo',
            'nombre' => 'required',
            'tipo'   => 'required',
        ]);

        CuentaContable::create($request->all());

        return redirect()->route('cuentas_contables.index')->with('success', 'Cuenta registrada');
    }

    public function edit(CuentaContable $cuentas_contable)
    {
        $padres = CuentaContable::all();
        return view('cuentas_contables.edit', compact('cuentas_contable', 'padres'));
    }

    public function update(Request $request, CuentaContable $cuentas_contable)
    {
        $request->validate([
            'codigo' => 'required|unique:cuentas_contables,codigo,' . $cuentas_contable->id,
            'nombre' => 'required',
            'tipo'   => 'required',
        ]);

        $cuentas_contable->update($request->all());

        return redirect()->route('cuentas_contables.index')->with('success', 'Cuenta actualizada');
    }

    public function destroy(CuentaContable $cuentas_contable)
    {
        $cuentas_contable->delete();
        return redirect()->route('cuentas_contables.index')->with('success', 'Cuenta eliminada');
    }
}
