<?php

namespace App\Http\Controllers;

use App\Models\UsuarioCliente;
use App\Models\Cliente;
use App\Models\ServicioEmpresarial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioClienteController extends Controller
{
    public function index($servicios_empresariales)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $usuarios = UsuarioCliente::with('cliente')
            ->where('servicio_empresarial_id', $servicio->id)
            ->orderByDesc('id')
            ->get();

        return view('usuarios_clientes.index', compact('usuarios', 'servicio'));
    }

    public function create($servicios_empresariales)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $clientes = Cliente::all();
        return view('usuarios_clientes.create', compact('clientes', 'servicio'));
    }

    public function store(Request $request, $servicios_empresariales)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nombre'     => 'required|string|max:80',
            'rol'        => 'nullable|string|max:50',
            'usuario'    => 'required|string|max:60',
            'password'   => 'required|string|max:100',
        ]);
        UsuarioCliente::create([
            'servicio_empresarial_id' => $servicio->id,
            'cliente_id' => $request->cliente_id,
            'nombre'     => $request->nombre,
            'rol'        => $request->rol,
            'usuario'    => $request->usuario,
            'password'   => Hash::make($request->password), // Importante: Hashea la contraseña
        ]);
        return redirect()->route('servicios_empresariales.usuarios_clientes.index', $servicio->id)
            ->with('success', 'Usuario registrado');
    }

    public function show($servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $usuario = UsuarioCliente::with('cliente')->where('servicio_empresarial_id', $servicio->id)->findOrFail($id);
        return view('usuarios_clientes.show', compact('usuario', 'servicio'));
    }

    public function edit($servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $usuario = UsuarioCliente::where('servicio_empresarial_id', $servicio->id)->findOrFail($id);
        $clientes = Cliente::all();
        return view('usuarios_clientes.edit', compact('usuario', 'clientes', 'servicio'));
    }

    public function update(Request $request, $servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $usuario = UsuarioCliente::where('servicio_empresarial_id', $servicio->id)->findOrFail($id);

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nombre'     => 'required|string|max:80',
            'rol'        => 'nullable|string|max:50',
            'usuario'    => 'required|string|max:60',
            'password'   => 'nullable|string|max:100', // Opcional en edición
        ]);

        $usuario->cliente_id = $request->cliente_id;
        $usuario->nombre = $request->nombre;
        $usuario->rol = $request->rol;
        $usuario->usuario = $request->usuario;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }
        $usuario->save();

        return redirect()->route('servicios_empresariales.usuarios_clientes.index', $servicio->id)
            ->with('success', 'Usuario actualizado');
    }

    public function destroy($servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $usuario = UsuarioCliente::where('servicio_empresarial_id', $servicio->id)->findOrFail($id);
        $usuario->delete();
        return redirect()->route('servicios_empresariales.usuarios_clientes.index', $servicio->id)
            ->with('success', 'Usuario eliminado');
    }
}
