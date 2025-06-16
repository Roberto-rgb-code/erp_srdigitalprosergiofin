<?php

namespace App\Http\Controllers;

use App\Models\InventarioCliente;
use App\Models\Cliente;
use Illuminate\Http\Request;

class InventarioClienteController extends Controller
{
    public function index()
    {
        $equipos = InventarioCliente::with('cliente')->orderByDesc('id')->get();
        return view('inventario_clientes.index', compact('equipos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('inventario_clientes.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nombre_equipo' => 'required|string|max:80',
            'tipo_equipo' => 'nullable|string|max:50',
            'modelo' => 'nullable|string|max:50',
            'serie' => 'nullable|string|max:50',
            'ubicacion' => 'nullable|string|max:100',
        ]);
        InventarioCliente::create($request->all());
        return redirect()->route('inventario_clientes.index')->with('success', 'Equipo registrado');
    }

    public function show(InventarioCliente $inventario_cliente)
    {
        $inventario_cliente->load('cliente');
        return view('inventario_clientes.show', compact('inventario_cliente'));
    }

    public function edit(InventarioCliente $inventario_cliente)
    {
        $clientes = Cliente::all();
        return view('inventario_clientes.edit', compact('inventario_cliente', 'clientes'));
    }

    public function update(Request $request, InventarioCliente $inventario_cliente)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nombre_equipo' => 'required|string|max:80',
            'tipo_equipo' => 'nullable|string|max:50',
            'modelo' => 'nullable|string|max:50',
            'serie' => 'nullable|string|max:50',
            'ubicacion' => 'nullable|string|max:100',
        ]);
        $inventario_cliente->update($request->all());
        return redirect()->route('inventario_clientes.index')->with('success', 'Equipo actualizado');
    }

    public function destroy(InventarioCliente $inventario_cliente)
    {
        $inventario_cliente->delete();
        return redirect()->route('inventario_clientes.index')->with('success', 'Equipo eliminado');
    }
}
