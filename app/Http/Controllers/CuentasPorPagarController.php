<?php

namespace App\Http\Controllers;

use App\Models\CuentaPorPagar;
use App\Models\Proveedor;
use App\Models\Egreso;
use App\Models\PagoCXP;
use App\Models\SeguimientoCXP;
use Illuminate\Http\Request;
use App\Exports\CuentasPorPagarExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class CuentasPorPagarController extends Controller
{
    public function index(Request $request)
    {
        $proveedores = Proveedor::all();
        $query = CuentaPorPagar::with(['proveedor', 'egreso', 'pagos']);

        if ($request->filled('proveedor_id')) {
            $query->where('proveedor_id', $request->proveedor_id);
        }
        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }
        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('fecha_vencimiento', [$request->desde, $request->hasta]);
        }

        $registros = $query->orderBy('fecha_vencimiento')->paginate(20);
        $total_deuda = CuentaPorPagar::where('saldo', '>', 0)->sum('saldo');

        return view('cuentas_por_pagar.index', compact('registros', 'proveedores', 'total_deuda'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $egresos = Egreso::all();
        return view('cuentas_por_pagar.create', compact('proveedores', 'egresos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'proveedor_id' => 'required|integer|exists:proveedores,id',
            'egreso_id' => 'nullable|integer|exists:egresos,id',
            'factura' => 'nullable|string|max:100',
            'monto' => 'required|numeric|min:0',
            'saldo' => 'required|numeric|min:0',
            'fecha_vencimiento' => 'required|date',
            'fecha_pago' => 'nullable|date',
            'estatus' => 'required|string|max:20',
            'comprobante' => 'nullable|file|mimes:pdf,xml,jpg,png',
            'comentarios' => 'nullable|string',
        ]);

        if ($request->hasFile('comprobante')) {
            $data['comprobante'] = $request->file('comprobante')->store('comprobantes_cxp', 'public');
        }

        CuentaPorPagar::create($data);
        return redirect()->route('cuentas_por_pagar.index')->with('success', 'Registro de CxP creado');
    }

    public function show(CuentaPorPagar $cuentas_por_pagar)
    {
        $cuenta = $cuentas_por_pagar->load(['proveedor', 'egreso', 'pagos', 'seguimientos.usuario']);
        $total_pagado = $cuenta->pagos->sum('monto');
        $porcentaje_impacto = $cuenta->impacto_porcentaje;
        return view('cuentas_por_pagar.show', compact('cuenta', 'total_pagado', 'porcentaje_impacto'));
    }

    public function edit(CuentaPorPagar $cuentas_por_pagar)
    {
        $proveedores = Proveedor::all();
        $egresos = Egreso::all();
        return view('cuentas_por_pagar.edit', [
            'registro' => $cuentas_por_pagar,
            'proveedores' => $proveedores,
            'egresos' => $egresos
        ]);
    }

    public function update(Request $request, CuentaPorPagar $cuentas_por_pagar)
    {
        $data = $request->validate([
            'proveedor_id' => 'required|integer|exists:proveedores,id',
            'egreso_id' => 'nullable|integer|exists:egresos,id',
            'factura' => 'nullable|string|max:100',
            'monto' => 'required|numeric|min:0',
            'saldo' => 'required|numeric|min:0',
            'fecha_vencimiento' => 'required|date',
            'fecha_pago' => 'nullable|date',
            'estatus' => 'required|string|max:20',
            'comprobante' => 'nullable|file|mimes:pdf,xml,jpg,png',
            'comentarios' => 'nullable|string',
        ]);
        if ($request->hasFile('comprobante')) {
            $data['comprobante'] = $request->file('comprobante')->store('comprobantes_cxp', 'public');
        }
        $cuentas_por_pagar->update($data);
        return redirect()->route('cuentas_por_pagar.index')->with('success', 'Registro actualizado');
    }

    public function destroy(CuentaPorPagar $cuentas_por_pagar)
    {
        $cuentas_por_pagar->delete();
        return redirect()->route('cuentas_por_pagar.index')->with('success', 'Registro eliminado');
    }

    // ---------- REGISTRAR PAGO (total o parcial) ----------
    public function registrarPago(Request $request, $id)
    {
        $cuenta = CuentaPorPagar::findOrFail($id);

        $request->validate([
            'monto' => 'required|numeric|min:1',
            'fecha' => 'required|date',
            'tipo' => 'required|string',
            'comentarios' => 'nullable|string',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,png'
        ]);

        $monto = min($request->monto, $cuenta->saldo);

        if ($request->hasFile('comprobante')) {
            $comprobantePath = $request->file('comprobante')->store('comprobantes_pagos_cxp', 'public');
        } else {
            $comprobantePath = null;
        }

        $cuenta->pagos()->create([
            'monto' => $monto,
            'fecha' => $request->fecha,
            'tipo' => $request->tipo,
            'comentarios' => $request->comentarios,
            'comprobante' => $comprobantePath,
        ]);

        // Actualiza saldo
        $cuenta->saldo -= $monto;
        if ($cuenta->saldo <= 0) {
            $cuenta->saldo = 0;
            $cuenta->estatus = 'Pagado';
            $cuenta->fecha_pago = $request->fecha;
        }
        $cuenta->save();

        return redirect()->route('cuentas_por_pagar.show', $cuenta->id)
            ->with('success', 'Pago registrado correctamente.');
    }

    // ---------- REGISTRAR SEGUIMIENTO ----------
    public function registrarSeguimiento(Request $request, $id)
    {
        $cuenta = CuentaPorPagar::findOrFail($id);

        $request->validate([
            'tipo' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        $cuenta->seguimientos()->create([
            'usuario_id' => auth()->id(),
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'fecha' => now(),
        ]);

        return redirect()->route('cuentas_por_pagar.show', $cuenta->id)
            ->with('success', 'Seguimiento registrado correctamente.');
    }


    // Exportar Excel
public function exportExcel()
{
    return Excel::download(new CuentasPorPagarExport, 'cuentas_por_pagar.xlsx');
}

// Exportar PDF
public function exportPDF()
{
    $registros = \App\Models\CuentaPorPagar::with('proveedor')->get();
    $pdf = PDF::loadView('cuentas_por_pagar.export_pdf', compact('registros'));
    return $pdf->download('cuentas_por_pagar.pdf');
}
}
