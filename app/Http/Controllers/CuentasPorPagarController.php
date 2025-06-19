<?php

namespace App\Http\Controllers;

use App\Models\CuentaPorPagar;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CuentasPorPagarExport;
use PDF;

class CuentasPorPagarController extends Controller
{
    // Mostrar listado con filtros y gráfico
    public function index(Request $request)
    {
        $proveedores = Proveedor::all();

        $query = CuentaPorPagar::with('proveedor');

        if ($request->filled('proveedor_id')) {
            $query->where('proveedor_id', $request->proveedor_id);
        }
        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }

        $cuentas = $query->orderByDesc('id')->paginate(15);

        $totalDeuda = CuentaPorPagar::sum('saldo_pendiente');

        return view('cuentas_por_pagar.index', compact('cuentas', 'proveedores', 'totalDeuda'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $proveedores = Proveedor::all();
        return view('cuentas_por_pagar.create', compact('proveedores'));
    }

    // Guardar nueva cuenta por pagar
    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id'      => 'required|exists:proveedores,id',
            'folio_factura'     => 'required|string|max:60',
            'fecha_emision'     => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'monto_total'       => 'required|numeric',
            'saldo_pendiente'   => 'required|numeric',
            'estatus'           => 'required|string|max:30',
            'xml'               => 'nullable|file|mimes:xml|max:2048',
            'pdf'               => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $data = $request->except(['xml', 'pdf']);

        if ($request->hasFile('xml')) {
            $data['xml'] = $request->file('xml')->store('xml_cuentas_pagar', 'public');
        }
        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('pdf_cuentas_pagar', 'public');
        }

        CuentaPorPagar::create($data);

        return redirect()->route('cuentas_por_pagar.index')->with('success', 'Cuenta por pagar registrada');
    }

    // Ver detalle de una cuenta
    public function show(CuentaPorPagar $cuentas_por_pagar)
    {
        $proveedores = Proveedor::all();
        return view('cuentas_por_pagar.show', [
            'cuenta' => $cuentas_por_pagar,
            'proveedores' => $proveedores,
        ]);
    }

    // Editar cuenta por pagar
    public function edit(CuentaPorPagar $cuentas_por_pagar)
    {
        $proveedores = Proveedor::all();
        return view('cuentas_por_pagar.edit', compact('cuentas_por_pagar', 'proveedores'));
    }

    // Actualizar cuenta por pagar
    public function update(Request $request, CuentaPorPagar $cuentas_por_pagar)
    {
        $request->validate([
            'proveedor_id'      => 'required|exists:proveedores,id',
            'folio_factura'     => 'required|string|max:60',
            'fecha_emision'     => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'monto_total'       => 'required|numeric',
            'saldo_pendiente'   => 'required|numeric',
            'estatus'           => 'required|string|max:30',
            'xml'               => 'nullable|file|mimes:xml|max:2048',
            'pdf'               => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $data = $request->except(['xml', 'pdf']);

        if ($request->hasFile('xml')) {
            $data['xml'] = $request->file('xml')->store('xml_cuentas_pagar', 'public');
        }
        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('pdf_cuentas_pagar', 'public');
        }

        $cuentas_por_pagar->update($data);

        return redirect()->route('cuentas_por_pagar.index')->with('success', 'Cuenta por pagar actualizada');
    }

    // Eliminar cuenta por pagar
    public function destroy(CuentaPorPagar $cuentas_por_pagar)
    {
        $cuentas_por_pagar->delete();
        return redirect()->route('cuentas_por_pagar.index')->with('success', 'Cuenta por pagar eliminada');
    }

    // ---------- EXPORTS Y GRÁFICO -----------

    public function exportExcel()
    {
        return Excel::download(new CuentasPorPagarExport, 'cuentas_por_pagar.xlsx');
    }

    public function exportPDF()
{
    $registros = CuentaPorPagar::with('proveedor')->get();
    $pdf = PDF::loadView('cuentas_por_pagar.export_pdf', compact('registros'));
    return $pdf->download('cuentas_por_pagar.pdf');
}


    // API para gráfico (por proveedor)
    public function apiGrafico()
    {
        $data = CuentaPorPagar::with('proveedor')
            ->selectRaw('proveedor_id, SUM(saldo_pendiente) as total')
            ->groupBy('proveedor_id')
            ->get()
            ->map(function($item){
                return [
                    'proveedor' => $item->proveedor->nombre ?? 'Sin proveedor',
                    'total'     => $item->total,
                ];
            });

        return response()->json($data);
    }
}
