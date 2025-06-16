<?php

namespace App\Http\Controllers;

use App\Models\CajaChica;
use App\Models\Empleado;
use Illuminate\Http\Request;

class CajaChicaController extends Controller
{
    public function index()
    {
        $registros = CajaChica::with('responsable')->orderByDesc('id')->paginate(20);
        return view('caja_chica.index', compact('registros'));
    }

    public function create()
    {
        $empleados = Empleado::all();
        return view('caja_chica.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fecha' => 'required|date',
            'tipo' => 'required|string|max:20',
            'monto' => 'required|numeric',
            'responsable_id' => 'required|integer|exists:empleados,id',
            'comprobante' => 'nullable|string|max:255',
            'comentarios' => 'nullable|string',
        ]);
        CajaChica::create($data);
        return redirect()->route('caja_chica.index')->with('success', 'Movimiento registrado');
    }

    public function show(CajaChica $caja_chica)
    {
        return view('caja_chica.show', ['registro' => $caja_chica]);
    }

    public function edit(CajaChica $caja_chica)
    {
        $empleados = Empleado::all();
        return view('caja_chica.edit', ['registro' => $caja_chica, 'empleados' => $empleados]);
    }

    public function update(Request $request, CajaChica $caja_chica)
    {
        $data = $request->validate([
            'fecha' => 'required|date',
            'tipo' => 'required|string|max:20',
            'monto' => 'required|numeric',
            'responsable_id' => 'required|integer|exists:empleados,id',
            'comprobante' => 'nullable|string|max:255',
            'comentarios' => 'nullable|string',
        ]);
        $caja_chica->update($data);
        return redirect()->route('caja_chica.index')->with('success', 'Registro actualizado');
    }

    public function destroy(CajaChica $caja_chica)
    {
        $caja_chica->delete();
        return redirect()->route('caja_chica.index')->with('success', 'Registro eliminado');
    }
}

