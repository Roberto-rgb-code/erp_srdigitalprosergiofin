<?php

namespace App\Http\Controllers;


use App\Models\Cableado;         // <- Agrega esta línea
use App\Models\BalanceCableado;
use App\Models\Empleado;
use Illuminate\Http\Request;

class BalanceCableadoController extends Controller
{
    public function index(Request $request)
    {
        $query = BalanceCableado::with('responsable');

        if ($request->filled('responsable_id')) {
            $query->where('responsable_id', $request->responsable_id);
        }
        if ($request->filled('tipo_movimiento')) {
            $query->where('tipo_movimiento', $request->tipo_movimiento);
        }
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_gasto', [$request->fecha_inicio, $request->fecha_fin]);
        }

        $balances = $query->orderByDesc('fecha_gasto')->paginate(15);
        $responsables = Empleado::orderBy('nombre')->get();

        return view('cableado.balance.index', compact('balances', 'responsables'));
    }

    public function create(Cableado $cableado)
    {
        $responsables = Empleado::orderBy('nombre')->get();
        return view('cableado.balance.create', compact('responsables', 'cableado'));
    }

    public function store(Cableado $cableado, Request $request)
    {
        $validated = $request->validate([
            'responsable_id' => 'required|integer|exists:empleados,id',
            'fecha_gasto' => 'required|date',
            'tipo_movimiento' => 'required|in:ingreso,egreso',
            'monto' => 'required|numeric|min:0',
            'facturable' => 'required|boolean',
        ]);

        $balance = new BalanceCableado($validated);
        $balance->cableado()->associate($cableado);
        $balance->save();

        return redirect()->route('cableado.show', $cableado)->with('success', 'Movimiento de balance registrado correctamente.');
    }

    // Puedes agregar show, edit, update, destroy según necesidades
}
