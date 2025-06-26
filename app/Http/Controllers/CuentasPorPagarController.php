<?php

namespace App\Http\Controllers;

use App\Models\CuentaPorPagar;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CuentasPorPagarController extends Controller
{
    public function index()
    {
        $cuentas = CuentaPorPagar::with('proveedor')->orderByDesc('fecha_emision')->paginate(15);
        return view('cuentas_por_pagar.index', compact('cuentas'));
    }

    public function create()
{
    $proveedores = \App\Models\Proveedor::orderBy('nombre')->get();
    return view('cuentas_por_pagar.create', compact('proveedores'));
}




    public function store(Request $request)
    {
        $data = $request->validate([
            'proveedor_id'     => 'required|exists:proveedores,id',
            'folio_factura'    => 'required|string|max:100',
            'monto'            => 'required|numeric|min:0',
            'fecha_emision'    => 'required|date',
            'fecha_vencimiento'=> 'required|date|after_or_equal:fecha_emision',
            'saldo_pendiente'  => 'required|numeric|min:0',
            'estatus'          => 'nullable|string|max:50',
            'xml_path'         => 'nullable|file|mimes:xml',
            'pdf_path'         => 'nullable|file|mimes:pdf',
            'comentarios'      => 'nullable|string|max:500',
        ]);

        // Subir archivos
        if($request->hasFile('xml_path')) {
            $data['xml_path'] = $request->file('xml_path')->store('facturas/xml', 'public');
        }
        if($request->hasFile('pdf_path')) {
            $data['pdf_path'] = $request->file('pdf_path')->store('facturas/pdf', 'public');
        }

        $cuenta = CuentaPorPagar::create($data);
        return redirect()->route('cuentas_por_pagar.show', $cuenta)->with('success', 'Factura registrada.');
    }

    public function show(CuentaPorPagar $cuentas_por_pagar)
    {
        $cuentas_por_pagar->load('proveedor', 'pagos', 'seguimientos');
        return view('cuentas_por_pagar.show', ['cuenta' => $cuentas_por_pagar]);
    }

    public function edit(CuentaPorPagar $cuentaPorPagar)
{
    $proveedores = Proveedor::orderBy('nombre')->get();
    return view('cuentas_por_pagar.edit', compact('cuentaPorPagar', 'proveedores'));
}

    public function update(Request $request, CuentaPorPagar $cuentas_por_pagar)
    {
        $data = $request->validate([
            'proveedor_id'     => 'required|exists:proveedores,id',
            'folio_factura'    => 'required|string|max:100',
            'monto'            => 'required|numeric|min:0',
            'fecha_emision'    => 'required|date',
            'fecha_vencimiento'=> 'required|date|after_or_equal:fecha_emision',
            'saldo_pendiente'  => 'required|numeric|min:0',
            'estatus'          => 'nullable|string|max:50',
            'xml_path'         => 'nullable|file|mimes:xml',
            'pdf_path'         => 'nullable|file|mimes:pdf',
            'comentarios'      => 'nullable|string|max:500',
        ]);

        if($request->hasFile('xml_path')) {
            if ($cuentas_por_pagar->xml_path) {
                Storage::disk('public')->delete($cuentas_por_pagar->xml_path);
            }
            $data['xml_path'] = $request->file('xml_path')->store('facturas/xml', 'public');
        }
        if($request->hasFile('pdf_path')) {
            if ($cuentas_por_pagar->pdf_path) {
                Storage::disk('public')->delete($cuentas_por_pagar->pdf_path);
            }
            $data['pdf_path'] = $request->file('pdf_path')->store('facturas/pdf', 'public');
        }

        $cuentas_por_pagar->update($data);
        return redirect()->route('cuentas_por_pagar.show', $cuentas_por_pagar)->with('success', 'Factura actualizada.');
    }

    public function destroy(CuentaPorPagar $cuentas_por_pagar)
    {
        if ($cuentas_por_pagar->xml_path) {
            Storage::disk('public')->delete($cuentas_por_pagar->xml_path);
        }
        if ($cuentas_por_pagar->pdf_path) {
            Storage::disk('public')->delete($cuentas_por_pagar->pdf_path);
        }
        $cuentas_por_pagar->delete();
        return redirect()->route('cuentas_por_pagar.index')->with('success', 'Factura eliminada.');
    }
}
