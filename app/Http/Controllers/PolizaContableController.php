<?php

namespace App\Http\Controllers;

use App\Models\PolizaContable;
use Illuminate\Http\Request;

class PolizaContableController extends Controller
{
    public function index()
    {
        $polizas = PolizaContable::orderByDesc('fecha')->paginate(20);
        return view('polizas_contables.index', compact('polizas'));
    }

    public function create()
    {
        return view('polizas_contables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'folio' => 'required|unique:polizas_contables,folio',
            'fecha' => 'required|date',
            'tipo_politica' => 'required',
            'descripcion' => 'nullable|string',
        ]);

        PolizaContable::create($request->all());
        return redirect()->route('polizas_contables.index')->with('success', 'Póliza creada');
    }

    // Otros métodos: show, edit, update, destroy similares
}
