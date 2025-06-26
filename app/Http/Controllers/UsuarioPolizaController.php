<?php

namespace App\Http\Controllers;

use App\Models\UsuarioPoliza;
use App\Models\ServicioEmpresarial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioPolizaController extends Controller
{
    public function index($servicioId)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicioId);
        $usuarios = UsuarioPoliza::where('servicio_empresarial_id', $servicioId)->paginate(10);
        return view('usuarios_poliza.index', compact('usuarios', 'servicio'));
    }

    public function create($servicioId)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicioId);
        return view('usuarios_poliza.create', compact('servicio'));
    }

    public function store(Request $request, $servicioId)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'correo' => 'required|email|unique:usuarios_poliza,correo',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'nullable|string|max:50',
            'comentarios' => 'nullable|string',
        ]);

        UsuarioPoliza::create([
            'servicio_empresarial_id' => $servicioId,
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'comentarios' => $request->comentarios,
        ]);

        return redirect()->route('usuarios_poliza.index', $servicioId)
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit($servicioId, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicioId);
        $usuario = UsuarioPoliza::findOrFail($id);
        return view('usuarios_poliza.edit', compact('usuario', 'servicio'));
    }

    public function update(Request $request, $servicioId, $id)
    {
        $usuario = UsuarioPoliza::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:150',
            'correo' => 'required|email|unique:usuarios_poliza,correo,' . $usuario->id,
            'password' => 'nullable|string|min:6|confirmed',
            'rol' => 'nullable|string|max:50',
            'comentarios' => 'nullable|string',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }
        $usuario->rol = $request->rol;
        $usuario->comentarios = $request->comentarios;
        $usuario->save();

        return redirect()->route('usuarios_poliza.index', $servicioId)
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($servicioId, $id)
    {
        $usuario = UsuarioPoliza::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios_poliza.index', $servicioId)
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
