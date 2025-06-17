<?php

namespace App\Http\Controllers;

use App\Models\Cableado;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Exports\CableadoExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class CableadoController extends Controller
{
    public function index(Request $request)
    {
        $query = Cableado::with('cliente');

        if ($request->filled('nombre_proyecto')) {
            $query->where('nombre_proyecto', 'ilike', '%' . $request->nombre_proyecto . '%');
        }
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }
        if ($request->filled('tipo_instalacion')) {
            $query->where('tipo_instalacion', $request->tipo_instalacion);
        }
        if ($request->filled('responsable')) {
            $query->where('responsable', 'ilike', '%' . $request->responsable . '%');
        }
        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }
        if ($request->filled('fecha_inicio_de') && $request->filled('fecha_inicio_hasta')) {
            $query->whereBetween('fecha_inicio', [$request->fecha_inicio_de, $request->fecha_inicio_hasta]);
        } elseif ($request->filled('fecha_inicio_de')) {
            $query->where('fecha_inicio', '>=', $request->fecha_inicio_de);
        } elseif ($request->filled('fecha_inicio_hasta')) {
            $query->where('fecha_inicio', '<=', $request->fecha_inicio_hasta);
        }

        $cableados = $query->orderByDesc('id')->paginate(15);

        $clientes = Cliente::orderBy('nombre')->get();

        return view('cableado.index', compact('cableados', 'clientes'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('cableado.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'nombre_proyecto' => 'required|string|max:100|unique:cableado,nombre_proyecto',
            'tipo_instalacion' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'responsable' => 'required|string|max:100',
            'costo_estimado' => 'nullable|numeric',
            'costo_real' => 'nullable|numeric',
            'estatus' => 'required|string|max:50',
            'comentarios' => 'nullable|string'
        ]);
        Cableado::create($validated);
        return redirect()->route('cableado.index')->with('success', 'Proyecto de cableado registrado correctamente');
    }

    public function show(Cableado $cableado)
    {
        $cableado->load('cliente');
        return view('cableado.show', compact('cableado'));
    }

    public function edit(Cableado $cableado)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('cableado.edit', compact('cableado', 'clientes'));
    }

    public function update(Request $request, Cableado $cableado)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'nombre_proyecto' => 'required|string|max:100|unique:cableado,nombre_proyecto,' . $cableado->id,
            'tipo_instalacion' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'responsable' => 'required|string|max:100',
            'costo_estimado' => 'nullable|numeric',
            'costo_real' => 'nullable|numeric',
            'estatus' => 'required|string|max:50',
            'comentarios' => 'nullable|string'
        ]);
        $cableado->update($validated);
        return redirect()->route('cableado.index')->with('success', 'Proyecto de cableado actualizado correctamente');
    }

    public function destroy(Cableado $cableado)
    {
        $cableado->delete();
        return redirect()->route('cableado.index')->with('success', 'Proyecto de cableado eliminado');
    }

    public function exportExcel()
    {
        return Excel::download(new CableadoExport, 'proyectos_cableado.xlsx');
    }

    public function exportPDF()
    {
        $cableados = Cableado::with('cliente')->get();
        $pdf = PDF::loadView('cableado.export_pdf', compact('cableados'));
        return $pdf->download('proyectos_cableado.pdf');
    }
}
