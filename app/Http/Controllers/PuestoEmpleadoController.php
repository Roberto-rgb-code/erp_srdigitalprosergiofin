<?php

namespace App\Http\Controllers;

use App\Models\PuestoEmpleado;
use Illuminate\Http\Request;

class PuestoEmpleadoController extends Controller
{
    public function index()
    {
        $puestos = PuestoEmpleado::orderBy('nombre')->get();
        return view('recursos_humanos.puestos.index', compact('puestos'));
    }

    public function create()
    {
        return view('recursos_humanos.puestos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['nombre' => 'required|string|max:100']);
        PuestoEmpleado::create($validated);
        return redirect()->route('puestos_empleado.index')->with('success', 'Puesto registrado');
    }
}
