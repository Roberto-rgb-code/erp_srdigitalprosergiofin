<?php

namespace App\Http\Controllers;

use App\Models\UsuarioCliente;
use App\Models\Cliente;
use Illuminate\Http\Request;

class UsuarioClienteController extends Controller
{
    public function index()
    {
        $usuarios = UsuarioCliente::with('cliente')->orderByDesc('id')->get();
        return view('usuarios_clientes.index', compact('usuarios'));
    }

    public function create()
{
    $clientes = \App\Models\Cliente::all();
    return view('usuarios_clientes.create', compact('clientes'));
}

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nombre' => 'required|string|max:80',
            'rol' => 'nullable|string|max:50',
            'usuario' => 'required|string|max:60',
            'password' => 'required|string|max:100',
        ]);
        UsuarioCliente::create($request->all());
        return redirect()->route('usuarios_clientes.index')->with('success', 'Usuario registrado');
    }

    public function show(UsuarioCliente $usuarios_cliente)
    {
        $usuarios_cliente->load('cliente');
        return view('usuarios_clientes.show', compact('usuarios_cliente'));
    }

    public function edit($id)
{
    $usuarios_cliente = \App\Models\UsuariosCliente::findOrFail($id);
    $clientes = \App\Models\Cliente::all();
    return view('usuarios_clientes.edit', compact('usuarios_cliente', 'clientes'));
}

    public function update(Request $request, UsuarioCliente $usuarios_cliente)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nombre' => 'required|string|max:80',
            'rol' => 'nullable|string|max:50',
            'usuario' => 'required|string|max:60',
            'password' => 'required|string|max:100',
        ]);
        $usuarios_cliente->update($request->all());
        return redirect()->route('usuarios_clientes.index')->with('success', 'Usuario actualizado');
    }

    public function destroy(UsuarioCliente $usuarios_cliente)
    {
        $usuarios_cliente->delete();
        return redirect()->route('usuarios_clientes.index')->with('success', 'Usuario eliminado');
    }
}
