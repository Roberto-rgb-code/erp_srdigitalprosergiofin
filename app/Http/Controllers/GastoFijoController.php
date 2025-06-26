<?php

namespace App\Http\Controllers;

use App\Models\GastoFijo;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class GastoFijoController extends Controller
{
    public function index()
    {
        $gastos = GastoFijo::with('proveedor')->orderByDesc('fecha_inicio')->paginate(20);
        return view('gastos_fijos.index', compact('gastos'));
    }

    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        return view('gastos_fijos.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'proveedor_id'   => 'required|exists:proveedores,id',
            'descripcion'    => 'required|string|max:150',
            'monto'          => 'required|numeric|min:0.01',
            'fecha_inicio'   => 'nullable|date',
            'frecuencia'     => 'required|string|max:20',
            'activo'         => 'boolean',
        ]);
        $data['activo'] = $request->has('activo');
        GastoFijo::create($data);
        return redirect()->route('gastos_fijos.index')->with('success', 'Gasto fijo creado.');
    }

    public function edit(GastoFijo $gastos_fijo)
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        return view('gastos_fijos.edit', compact('gastos_fijo', 'proveedores'));
    }

    public function update(Request $request, GastoFijo $gastos_fijo)
    {
        $data = $request->validate([
            'proveedor_id'   => 'required|exists:proveedores,id',
            'descripcion'    => 'required|string|max:150',
            'monto'          => 'required|numeric|min:0.01',
            'fecha_inicio'   => 'nullable|date',
            'frecuencia'     => 'required|string|max:20',
            'activo'         => 'boolean',
        ]);
        $data['activo'] = $request->has('activo');
        $gastos_fijo->update($data);
        return redirect()->route('gastos_fijos.index')->with('success', 'Gasto fijo actualizado.');
    }

    public function destroy(GastoFijo $gastos_fijo)
    {
        $gastos_fijo->delete();
        return redirect()->route('gastos_fijos.index')->with('success', 'Gasto fijo eliminado.');
    }
}
