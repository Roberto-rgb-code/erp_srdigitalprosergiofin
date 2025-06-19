<?php

namespace App\Http\Controllers;

use App\Models\CuentaPorCobrar;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;

// Exportadores
use App\Exports\CuentasPorCobrarExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class CuentasPorCobrarController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::all();
        $cuentas = CuentaPorCobrar::with(['cliente', 'venta'])
            ->when($request->cliente_id, fn($q) => $q->where('cliente_id', $request->cliente_id))
            ->orderByDesc('id')
            ->paginate(15);

        $totalDeuda = CuentaPorCobrar::sum('saldo_pendiente');

        return view('cuentas_por_cobrar.index', compact('cuentas', 'clientes', 'totalDeuda'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $ventas = Venta::all();
        return view('cuentas_por_cobrar.create', compact('clientes', 'ventas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'        => 'required|exists:clientes,id',
            'venta_id'          => 'nullable|exists:ventas,id',
            'folio_factura'     => 'required|string|max:60',
            'fecha_emision'     => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'monto_total'       => 'required|numeric',
            'saldo_pendiente'   => 'required|numeric',
            'documento'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('documento');
        if ($request->hasFile('documento')) {
            $data['documento'] = $request->file('documento')->store('documentos_cobrar', 'public');
        }

        CuentaPorCobrar::create($data);

        return redirect()->route('cuentas_por_cobrar.index')->with('success', 'Cuenta registrada');
    }

    public function show(CuentaPorCobrar $cuentas_por_cobrar)
    {
        $cuentas_por_cobrar->load(['cliente', 'venta']);
        return view('cuentas_por_cobrar.show', ['cuenta' => $cuentas_por_cobrar]);
    }

    public function edit(CuentaPorCobrar $cuentas_por_cobrar)
    {
        $clientes = Cliente::all();
        $ventas = Venta::all();
        return view('cuentas_por_cobrar.edit', compact('cuentas_por_cobrar', 'clientes', 'ventas'));
    }

    public function update(Request $request, CuentaPorCobrar $cuentas_por_cobrar)
    {
        $request->validate([
            'cliente_id'        => 'required|exists:clientes,id',
            'venta_id'          => 'nullable|exists:ventas,id',
            'folio_factura'     => 'required|string|max:60',
            'fecha_emision'     => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'monto_total'       => 'required|numeric',
            'saldo_pendiente'   => 'required|numeric',
            'documento'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('documento');
        if ($request->hasFile('documento')) {
            $data['documento'] = $request->file('documento')->store('documentos_cobrar', 'public');
        }

        $cuentas_por_cobrar->update($data);

        return redirect()->route('cuentas_por_cobrar.index')->with('success', 'Cuenta actualizada');
    }

    public function destroy(CuentaPorCobrar $cuentas_por_cobrar)
    {
        $cuentas_por_cobrar->delete();
        return redirect()->route('cuentas_por_cobrar.index')->with('success', 'Cuenta eliminada');
    }

    // --------- Exportar a Excel ----------
    public function exportExcel()
    {
        return Excel::download(new CuentasPorCobrarExport, 'cuentas_por_cobrar.xlsx');
    }

    // --------- Exportar a PDF ----------
    public function exportPDF()
    {
        $cuentas = CuentaPorCobrar::with(['cliente', 'venta'])->get();
        $pdf = PDF::loadView('cuentas_por_cobrar.export_pdf', compact('cuentas'));
        return $pdf->download('cuentas_por_cobrar.pdf');
    }
}
