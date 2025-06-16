<?php

namespace App\Http\Controllers;

use App\Models\CuentaBancaria;
use Illuminate\Http\Request;

class CuentaBancariaController extends Controller
{
    public function index()
    {
        $cuentas = CuentaBancaria::orderByDesc('id')->paginate(20);
        return view('cuentas_bancarias.index', compact('cuentas'));
    }

    public function create()
    {
        return view('cuentas_bancarias.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'banco' => 'required|string|max:50',
            'numero_cuenta' => 'required|string|max:30',
            'clabe' => 'required|string|max:30',
            'saldo' => 'required|numeric',
            'status' => 'required|string|max:20',
        ]);
        CuentaBancaria::create($data);
        return redirect()->route('cuentas_bancarias.index')->with('success', 'Cuenta bancaria registrada');
    }

    public function show(CuentaBancaria $cuentas_bancaria)
    {
        return view('cuentas_bancarias.show', ['cuenta' => $cuentas_bancaria]);
    }

    public function edit(CuentaBancaria $cuentas_bancaria)
    {
        return view('cuentas_bancarias.edit', ['cuenta' => $cuentas_bancaria]);
    }

    public function update(Request $request, CuentaBancaria $cuentas_bancaria)
    {
        $data = $request->validate([
            'banco' => 'required|string|max:50',
            'numero_cuenta' => 'required|string|max:30',
            'clabe' => 'required|string|max:30',
            'saldo' => 'required|numeric',
            'status' => 'required|string|max:20',
        ]);
        $cuentas_bancaria->update($data);
        return redirect()->route('cuentas_bancarias.index')->with('success', 'Cuenta bancaria actualizada');
    }

    public function destroy(CuentaBancaria $cuentas_bancaria)
    {
        $cuentas_bancaria->delete();
        return redirect()->route('cuentas_bancarias.index')->with('success', 'Cuenta bancaria eliminada');
    }
}
