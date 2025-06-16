<?php

namespace App\Http\Controllers;

use App\Models\ServicioEmpresarial;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ServicioEmpresarialController extends Controller
{
    public function index(Request $request)
    {
        $query = ServicioEmpresarial::with('cliente');

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }
        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }

        $servicios = $query->orderByDesc('id')->paginate(15);
        $clientes = Cliente::all();

        return view('servicios_empresariales.index', compact('servicios', 'clientes'));
    }

    public function create()
{
    $clientes = \App\Models\Cliente::all();
    $polizas = \App\Models\PolizaServicio::all();
    return view('servicios_empresariales.create', compact('clientes', 'polizas'));
}


public function store(Request $request)
{
    $validated = $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'poliza'     => 'required|string|max:100',
        'estatus'    => 'required|string|max:50',
        'comentarios'=> 'nullable|string'
    ]);

    ServicioEmpresarial::create($validated);

    return redirect()->route('servicios_empresariales.index')->with('success', 'Servicio registrado');
}



    public function edit(ServicioEmpresarial $servicios_empresariales)
    {
        $clientes = Cliente::all();
        return view('servicios_empresariales.edit', [
            'servicio' => $servicios_empresariales,
            'clientes' => $clientes
        ]);
    }

    public function update(Request $request, ServicioEmpresarial $servicios_empresariales)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'poliza'     => 'required|string|max:100',
            'estatus'    => 'required|string|max:50',
            'comentarios'=> 'nullable|string'
        ]);
        $servicios_empresariales->update($validated);

        return redirect()->route('servicios_empresariales.index')->with('success', 'Servicio actualizado');
    }

    public function destroy(ServicioEmpresarial $servicios_empresariales)
    {
        $servicios_empresariales->delete();
        return redirect()->route('servicios_empresariales.index')->with('success', 'Eliminado correctamente');
    }
}
