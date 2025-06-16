<?php
namespace App\Http\Controllers;

use App\Models\Ingreso;
use Illuminate\Http\Request;

class IngresoController extends Controller
{
    public function index()
    {
        $ingresos = Ingreso::orderByDesc('id')->paginate(20);
        return view('ingresos.index', compact('ingresos'));
    }

    public function create()
    {
        return view('ingresos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_ingreso' => 'required|string|max:50',
            'referencia_id' => 'nullable|integer',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'cuenta_bancaria_id' => 'required|integer',
            'descripcion' => 'nullable|string',
        ]);
        Ingreso::create($data);
        return redirect()->route('ingresos.index')->with('success', 'Ingreso registrado');
    }

    public function show(Ingreso $ingreso)
    {
        return view('ingresos.show', compact('ingreso'));
    }

    public function edit(Ingreso $ingreso)
    {
        return view('ingresos.edit', compact('ingreso'));
    }

    public function update(Request $request, Ingreso $ingreso)
    {
        $data = $request->validate([
            'tipo_ingreso' => 'required|string|max:50',
            'referencia_id' => 'nullable|integer',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'cuenta_bancaria_id' => 'required|integer',
            'descripcion' => 'nullable|string',
        ]);
        $ingreso->update($data);
        return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado');
    }

    public function destroy(Ingreso $ingreso)
    {
        $ingreso->delete();
        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado');
    }
}

