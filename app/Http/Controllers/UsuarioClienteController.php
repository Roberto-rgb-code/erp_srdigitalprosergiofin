<?php

namespace App\Http\Controllers;

use App\Models\UsuarioCliente;
use App\Models\ServicioEmpresarial;
use Illuminate\Http\Request;

class UsuarioClienteController extends Controller
{
    public function index($servicio_empresarial_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $usuarios = UsuarioCliente::where('servicio_empresarial_id', $servicio_empresarial_id)->get();
        return view('usuario_clientes.index', compact('servicio', 'usuarios'));
    }

    public function create($servicio_empresarial_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        return view('usuario_clientes.create', compact('servicio'));
    }

    public function store(Request $request, $servicio_empresarial_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $validated = $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => 'nullable|email|max:255',
        ]);
        $validated['servicio_empresarial_id'] = $servicio->id;
        UsuarioCliente::create($validated);

        return redirect()
            ->route('servicios_empresariales.usuarios_clientes.index', $servicio->id)
            ->with('success', 'Usuario creado correctamente');
    }

    public function edit($servicio_empresarial_id, $usuario_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $usuario = UsuarioCliente::where('servicio_empresarial_id', $servicio->id)
                                       ->where('id', $usuario_id)
                                       ->firstOrFail();
        return view('usuario_clientes.edit', compact('servicio', 'usuario'));
    }

    public function update(Request $request, $servicio_empresarial_id, $usuario_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $usuario = UsuarioCliente::where('servicio_empresarial_id', $servicio->id)
                                       ->where('id', $usuario_id)
                                       ->firstOrFail();
        $validated = $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => 'nullable|email|max:255',
        ]);
        $usuario->update($validated);

        return redirect()
            ->route('servicios_empresariales.usuarios_clientes.index', $servicio->id)
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($servicio_empresarial_id, $usuario_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $usuario = UsuarioCliente::where('servicio_empresarial_id', $servicio->id)
                                       ->where('id', $usuario_id)
                                       ->firstOrFail();
        $usuario->delete();

        return redirect()
            ->route('servicios_empresariales.usuarios_clientes.index', $servicio->id)
            ->with('success', 'Usuario eliminado correctamente');
    }
}
