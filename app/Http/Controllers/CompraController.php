<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::orderByDesc('fecha_compra')->paginate(15);
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        return view('compras.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'proveedor'    => 'required|string|max:255',
            'descripcion'  => 'required|string|max:500',
            'monto'        => 'nullable|numeric',
            'fecha_compra' => 'required|date',
            'metodo_pago'  => 'nullable|string|max:50',
            'factura'      => 'nullable|boolean',
            'comentarios'  => 'nullable|string',
        ]);
        $data['factura'] = $request->input('factura', 0);
        Compra::create($data);
        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
    }

    public function show(Compra $compra)
    {
        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        return view('compras.edit', compact('compra'));
    }

    public function update(Request $request, Compra $compra)
    {
        $data = $request->validate([
            'proveedor'    => 'required|string|max:255',
            'descripcion'  => 'required|string|max:500',
            'monto'        => 'nullable|numeric',
            'fecha_compra' => 'required|date',
            'metodo_pago'  => 'nullable|string|max:50',
            'factura'      => 'nullable|boolean',
            'comentarios'  => 'nullable|string',
        ]);
        $data['factura'] = $request->input('factura', 0);
        $compra->update($data);
        return redirect()->route('compras.index')->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy(Compra $compra)
    {
        $compra->delete();
        return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
    }
}
