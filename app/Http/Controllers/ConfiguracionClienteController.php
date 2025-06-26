<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionCliente;
use App\Models\ServicioEmpresarial;
use Illuminate\Http\Request;

class ConfiguracionClienteController extends Controller
{
    public function index($servicio_empresarial_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $configuraciones = ConfiguracionCliente::where('servicio_empresarial_id', $servicio_empresarial_id)->get();
        return view('configuracion_clientes.index', compact('servicio', 'configuraciones'));
    }

    public function create($servicio_empresarial_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        return view('configuracion_clientes.create', compact('servicio'));
    }

    public function store(Request $request, $servicio_empresarial_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $validated = $request->validate([
            'parametro'   => 'required|string|max:255',
            'valor'    => 'nullable|string|max:255',
        ]);
        $validated['servicio_empresarial_id'] = $servicio->id;
        ConfiguracionCliente::create($validated);

        return redirect()
            ->route('servicios_empresariales.configuraciones_clientes.index', $servicio->id)
            ->with('success', 'Configuración creada correctamente');
    }

    public function edit($servicio_empresarial_id, $config_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $configuracion = ConfiguracionCliente::where('servicio_empresarial_id', $servicio->id)
                                       ->where('id', $config_id)
                                       ->firstOrFail();
        return view('configuracion_clientes.edit', compact('servicio', 'configuracion'));
    }

    public function update(Request $request, $servicio_empresarial_id, $config_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $configuracion = ConfiguracionCliente::where('servicio_empresarial_id', $servicio->id)
                                       ->where('id', $config_id)
                                       ->firstOrFail();
        $validated = $request->validate([
            'parametro'   => 'required|string|max:255',
            'valor'    => 'nullable|string|max:255',
        ]);
        $configuracion->update($validated);

        return redirect()
            ->route('servicios_empresariales.configuraciones_clientes.index', $servicio->id)
            ->with('success', 'Configuración actualizada correctamente');
    }

    public function destroy($servicio_empresarial_id, $config_id)
    {
        $servicio = ServicioEmpresarial::findOrFail($servicio_empresarial_id);
        $configuracion = ConfiguracionCliente::where('servicio_empresarial_id', $servicio->id)
                                       ->where('id', $config_id)
                                       ->firstOrFail();
        $configuracion->delete();

        return redirect()
            ->route('servicios_empresariales.configuraciones_clientes.index', $servicio->id)
            ->with('success', 'Configuración eliminada correctamente');
    }
}
