<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionCliente;
use App\Models\Cliente;
use App\Models\ServicioEmpresarial;
use Illuminate\Http\Request;

class ConfiguracionClienteController extends Controller
{
    public function index($servicios_empresariales)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $configuraciones = ConfiguracionCliente::with('cliente')
            ->where('servicio_empresarial_id', $servicio->id)
            ->orderByDesc('id')
            ->get();

        return view('configuraciones_clientes.index', compact('configuraciones', 'servicio'));
    }

    public function create($servicios_empresariales)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $clientes = Cliente::all();
        return view('configuraciones_clientes.create', compact('clientes', 'servicio'));
    }

    public function store(Request $request, $servicios_empresariales)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $request->validate([
            'cliente_id'  => 'required|exists:clientes,id',
            'tipo'        => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:120',
            'dato'        => 'required|string|max:120',
        ]);
        ConfiguracionCliente::create([
            'servicio_empresarial_id' => $servicio->id,
            'cliente_id'  => $request->cliente_id,
            'tipo'        => $request->tipo,
            'descripcion' => $request->descripcion,
            'dato'        => $request->dato,
        ]);
        return redirect()->route('servicios_empresariales.configuraciones_clientes.index', $servicio->id)
            ->with('success', 'Configuración registrada');
    }

    public function show($servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $configuracion = ConfiguracionCliente::with('cliente')
            ->where('servicio_empresarial_id', $servicio->id)
            ->findOrFail($id);
        return view('configuraciones_clientes.show', compact('configuracion', 'servicio'));
    }

    public function edit($servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $configuracion = ConfiguracionCliente::where('servicio_empresarial_id', $servicio->id)->findOrFail($id);
        $clientes = Cliente::all();
        return view('configuraciones_clientes.edit', compact('configuracion', 'clientes', 'servicio'));
    }

    public function update(Request $request, $servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $configuracion = ConfiguracionCliente::where('servicio_empresarial_id', $servicio->id)->findOrFail($id);
        $request->validate([
            'cliente_id'  => 'required|exists:clientes,id',
            'tipo'        => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:120',
            'dato'        => 'required|string|max:120',
        ]);
        $configuracion->update([
            'cliente_id'  => $request->cliente_id,
            'tipo'        => $request->tipo,
            'descripcion' => $request->descripcion,
            'dato'        => $request->dato,
        ]);
        return redirect()->route('servicios_empresariales.configuraciones_clientes.index', $servicio->id)
            ->with('success', 'Configuración actualizada');
    }

    public function destroy($servicios_empresariales, $id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicios_empresariales);
        $configuracion = ConfiguracionCliente::where('servicio_empresarial_id', $servicio->id)->findOrFail($id);
        $configuracion->delete();
        return redirect()->route('servicios_empresariales.configuraciones_clientes.index', $servicio->id)
            ->with('success', 'Configuración eliminada');
    }
}
