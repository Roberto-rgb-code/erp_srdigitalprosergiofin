<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionCliente;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ConfiguracionClienteController extends Controller
{
    public function index()
    {
        $configuraciones = ConfiguracionCliente::with('cliente')->orderByDesc('id')->get();
        return view('configuraciones_clientes.index', compact('configuraciones'));
    }

    public function create()
{
    $clientes = \App\Models\Cliente::all();
    return view('configuraciones_clientes.create', compact('clientes'));
}

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:120',
            'dato' => 'required|string|max:120',
        ]);
        ConfiguracionCliente::create($request->all());
        return redirect()->route('configuraciones_clientes.index')->with('success', 'Configuración registrada');
    }

    public function show(ConfiguracionCliente $configuraciones_cliente)
    {
        $configuraciones_cliente->load('cliente');
        return view('configuraciones_clientes.show', compact('configuraciones_cliente'));
    }

    public function edit($id)
{
    $configuraciones_cliente = \App\Models\ConfiguracionesCliente::findOrFail($id);
    $clientes = \App\Models\Cliente::all();
    return view('configuraciones_clientes.edit', compact('configuraciones_cliente', 'clientes'));
}

    public function update(Request $request, ConfiguracionCliente $configuraciones_cliente)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:120',
            'dato' => 'required|string|max:120',
        ]);
        $configuraciones_cliente->update($request->all());
        return redirect()->route('configuraciones_clientes.index')->with('success', 'Configuración actualizada');
    }

    public function destroy(ConfiguracionCliente $configuraciones_cliente)
    {
        $configuraciones_cliente->delete();
        return redirect()->route('configuraciones_clientes.index')->with('success', 'Configuración eliminada');
    }
}
