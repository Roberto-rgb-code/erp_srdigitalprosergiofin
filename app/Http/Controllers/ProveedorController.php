<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::orderBy('nombre')->paginate(15);
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'           => 'required|string|max:255',
            'ejecutivo_venta'  => 'nullable|string|max:150',
            'telefono'         => 'nullable|string|max:50',
            'direccion'        => 'nullable|string|max:255',
            'linea_credito'    => 'nullable|numeric',
            'linea_usada'      => 'nullable|numeric',
            'tiempo_credito'   => 'nullable|integer',
            'metodos_entrega'  => 'nullable|string|max:100',
            'categoria'        => 'nullable|string|max:100',
            'comentarios'      => 'nullable|string',
            'tipo'             => 'nullable|string|max:30',      // mayorista, menudeo, etc.
            'metodo_pago'      => 'nullable|string|max:50',
            'factura'          => 'nullable|boolean',
        ]);
        // Por si viene null el checkbox
        $data['factura'] = $request->has('factura') ? 1 : 0;

        Proveedor::create($data);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado correctamente.');
    }

    public function show(Proveedor $proveedor)
    {
        // Puedes cargar cuentas por pagar y gastos fijos si lo necesitas
        $proveedor->load('cuentasPorPagar', 'gastosFijos');
        return view('proveedores.show', compact('proveedor'));
    }

    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $data = $request->validate([
            'nombre'           => 'required|string|max:255',
            'ejecutivo_venta'  => 'nullable|string|max:150',
            'telefono'         => 'nullable|string|max:50',
            'direccion'        => 'nullable|string|max:255',
            'linea_credito'    => 'nullable|numeric',
            'linea_usada'      => 'nullable|numeric',
            'tiempo_credito'   => 'nullable|integer',
            'metodos_entrega'  => 'nullable|string|max:100',
            'categoria'        => 'nullable|string|max:100',
            'comentarios'      => 'nullable|string',
            'tipo'             => 'nullable|string|max:30',
            'metodo_pago'      => 'nullable|string|max:50',
            'factura'          => 'nullable|boolean',
        ]);
        $data['factura'] = $request->has('factura') ? 1 : 0;

        $proveedor->update($data);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        // Si tiene cuentas por pagar o gastos fijos puedes proteger el borrado aquí (opcional)
        $proveedor->delete();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
