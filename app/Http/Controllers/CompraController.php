<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        // Carga compras con relación a proveedores para mostrar nombre en index
        $compras = Compra::with('proveedor')
                         ->orderByDesc('fecha_compra')
                         ->paginate(15);
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        return view('compras.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'proveedor'    => 'required|string|max:255', // Campo libre
            'descripcion'  => 'required|string|max:500',
            'monto'        => 'nullable|numeric',
            'fecha_compra' => 'required|date',
            'metodo_pago'  => 'nullable|string|max:50',
            'factura'      => 'nullable|boolean',
            'comentarios'  => 'nullable|string',
        ]);

        // Buscar o crear proveedor por nombre
        $proveedor = Proveedor::firstOrCreate(
            ['nombre' => $data['proveedor']],
            ['tipo' => 'desconocido'] // Puedes cambiar el valor por defecto
        );

        // Crear compra con FK proveedor_id y nombre proveedor libre
        $compra = new Compra();
        $compra->proveedor_id = $proveedor->id;
        $compra->proveedor = $data['proveedor']; // Guarda nombre proveedor libre
        $compra->descripcion = $data['descripcion'];
        $compra->monto = $data['monto'] ?? null;
        $compra->fecha_compra = $data['fecha_compra'];
        $compra->metodo_pago = $data['metodo_pago'] ?? null;
        $compra->factura = $data['factura'] ?? 0;
        $compra->comentarios = $data['comentarios'] ?? null;
        $compra->save();

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

        // Buscar o crear proveedor
        $proveedor = Proveedor::firstOrCreate(
            ['nombre' => $data['proveedor']],
            ['tipo' => 'desconocido']
        );

        // Actualizar compra
        $compra->proveedor_id = $proveedor->id;
        $compra->proveedor = $data['proveedor'];
        $compra->descripcion = $data['descripcion'];
        $compra->monto = $data['monto'] ?? null;
        $compra->fecha_compra = $data['fecha_compra'];
        $compra->metodo_pago = $data['metodo_pago'] ?? null;
        $compra->factura = $data['factura'] ?? 0;
        $compra->comentarios = $data['comentarios'] ?? null;
        $compra->save();

        return redirect()->route('compras.index')->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy(Compra $compra)
    {
        $compra->delete();
        return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
    }
}
