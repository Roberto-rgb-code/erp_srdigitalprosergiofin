<?php
namespace App\Http\Controllers;

use App\Models\Egreso;
use App\Models\CuentaBancaria;
use Illuminate\Http\Request;

class EgresoController extends Controller
{
    public function index()
    {
        $egresos = Egreso::with('cuentaBancaria')->orderByDesc('id')->paginate(20);
        return view('egresos.index', compact('egresos'));
    }

    public function create()
    {
        $cuentas = CuentaBancaria::all();
        return view('egresos.create', compact('cuentas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_egreso' => 'required|string|max:50',
            'referencia_id' => 'nullable|integer',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'cuenta_bancaria_id' => 'required|integer|exists:cuentas_bancarias,id',
            'descripcion' => 'nullable|string',
        ]);
        Egreso::create($data);
        return redirect()->route('egresos.index')->with('success', 'Egreso registrado');
    }

    public function show(Egreso $egreso)
    {
        return view('egresos.show', compact('egreso'));
    }

    public function edit(Egreso $egreso)
    {
        $cuentas = CuentaBancaria::all();
        return view('egresos.edit', compact('egreso', 'cuentas'));
    }

    public function update(Request $request, Egreso $egreso)
    {
        $data = $request->validate([
            'tipo_egreso' => 'required|string|max:50',
            'referencia_id' => 'nullable|integer',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'cuenta_bancaria_id' => 'required|integer|exists:cuentas_bancarias,id',
            'descripcion' => 'nullable|string',
        ]);
        $egreso->update($data);
        return redirect()->route('egresos.index')->with('success', 'Egreso actualizado');
    }

    public function destroy(Egreso $egreso)
    {
        $egreso->delete();
        return redirect()->route('egresos.index')->with('success', 'Egreso eliminado');
    }
}
