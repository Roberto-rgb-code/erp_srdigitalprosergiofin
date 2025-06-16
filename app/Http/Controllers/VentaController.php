<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::orderBy('nombre')->get();

        $query = Venta::with('cliente');
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }
        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }
        if ($request->filled('tipo_venta')) {
            $query->where('tipo_venta', $request->tipo_venta);
        }
        if ($request->filled('fecha_venta')) {
            $query->where('fecha_venta', $request->fecha_venta);
        }
        $ventas = $query->orderBy('id', 'desc')->paginate(15);

        return view('ventas.index', compact('ventas', 'clientes'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('ventas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id'    => 'required|integer|exists:clientes,id',
            'fecha_venta'   => 'required|date',
            'monto_total'   => 'required|numeric',
            'estatus'       => 'nullable|string|max:50',
            'tipo_venta'    => 'nullable|string|max:50',
            'comentarios'   => 'nullable|string|max:255',
        ]);
        // usuario_id si tienes auth, si no pon 1 fijo:
        $validated['usuario_id'] = auth()->id() ?? 1;
        $venta = Venta::create($validated);
        return redirect()->route('ventas.index')->with('success', 'Venta creada correctamente');
    }

    public function show(Venta $venta)
    {
        $venta->load('cliente', 'detalles');
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('ventas.edit', compact('venta', 'clientes'));
    }

    public function update(Request $request, Venta $venta)
    {
        $validated = $request->validate([
            'cliente_id'    => 'required|integer|exists:clientes,id',
            'fecha_venta'   => 'required|date',
            'monto_total'   => 'required|numeric',
            'estatus'       => 'nullable|string|max:50',
            'tipo_venta'    => 'nullable|string|max:50',
            'comentarios'   => 'nullable|string|max:255',
        ]);
        $venta->update($validated);
        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente');
    }

    public function destroy(Venta $venta)
    {
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente');
    }

    // Exportar a Excel
    public function exportExcel(Request $request)
    {
        $filters = $request->only(['cliente_id', 'estatus', 'tipo_venta', 'fecha_venta']);
        return Excel::download(new VentasExport($filters), 'ventas.xlsx');
    }

    // Exportar a PDF
    public function exportPDF(Request $request)
    {
        $query = Venta::with('cliente');
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }
        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }
        if ($request->filled('tipo_venta')) {
            $query->where('tipo_venta', $request->tipo_venta);
        }
        if ($request->filled('fecha_venta')) {
            $query->where('fecha_venta', $request->fecha_venta);
        }
        $ventas = $query->orderBy('id', 'desc')->get();

        $pdf = PDF::loadView('ventas.export_pdf', compact('ventas'));
        return $pdf->download('ventas.pdf');
    }

    // Descargar factura PDF de una venta
    public function factura(Venta $venta)
    {
        $venta->load('cliente', 'detalles');
        $pdf = PDF::loadView('ventas.factura_pdf', compact('venta'));
        return $pdf->download('factura_' . $venta->folio . '.pdf');
    }
}
