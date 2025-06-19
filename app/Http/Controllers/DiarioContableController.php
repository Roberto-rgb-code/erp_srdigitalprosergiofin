<?php

namespace App\Http\Controllers;

use App\Models\DiarioContable;
use Illuminate\Http\Request;

class DiarioContableController extends Controller
{
    public function index()
    {
        // Obtener movimientos con relaciones y paginar
        $movimientos = DiarioContable::with(['poliza', 'cuentaContable'])
            ->orderByDesc('fecha')
            ->paginate(15);

        return view('diario_contable.index', compact('movimientos'));
    }

    public function create()
    {
        // Aquí podrías enviar datos necesarios para crear un movimiento
        return view('diario_contable.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'poliza_id' => 'required|exists:polizas_contables,id',
            'cuenta_contable_id' => 'required|exists:cuentas_contables,id',
            'descripcion' => 'nullable|string|max:255',
            'cargo' => 'nullable|numeric|min:0',
            'abono' => 'nullable|numeric|min:0',
            'fecha' => 'required|date',
        ]);

        DiarioContable::create($request->all());

        return redirect()->route('diario_contable.index')->with('success', 'Movimiento creado.');
    }

    public function edit(DiarioContable $diario_contable)
    {
        // Para editar, enviar el movimiento actual
        return view('diario_contable.edit', compact('diario_contable'));
    }

    public function update(Request $request, DiarioContable $diario_contable)
    {
        $request->validate([
            'poliza_id' => 'required|exists:polizas_contables,id',
            'cuenta_contable_id' => 'required|exists:cuentas_contables,id',
            'descripcion' => 'nullable|string|max:255',
            'cargo' => 'nullable|numeric|min:0',
            'abono' => 'nullable|numeric|min:0',
            'fecha' => 'required|date',
        ]);

        $diario_contable->update($request->all());

        return redirect()->route('diario_contable.index')->with('success', 'Movimiento actualizado.');
    }

    public function destroy(DiarioContable $diario_contable)
    {
        $diario_contable->delete();

        return redirect()->route('diario_contable.index')->with('success', 'Movimiento eliminado.');
    }
}
