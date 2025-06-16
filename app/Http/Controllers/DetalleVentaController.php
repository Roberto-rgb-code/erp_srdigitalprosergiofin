<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use App\Exports\DetalleVentasExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class DetalleVentaController extends Controller
{
    public function index($venta_id)
    {
        $venta = Venta::with('detalles')->findOrFail($venta_id);
        return view('detalle_ventas.index', compact('venta'));
    }

    public function create($venta_id)
    {
        $venta = Venta::findOrFail($venta_id);
        return view('detalle_ventas.create', compact('venta'));
    }

    public function store(Request $request, $venta_id)
    {
        $venta = Venta::findOrFail($venta_id);
        $validated = $request->validate([
            'producto_servicio' => 'required|string|max:255',
            'cantidad'          => 'required|numeric|min:1',
            'precio_unitario'   => 'required|numeric|min:0',
        ]);
        $validated['venta_id'] = $venta->id;
        $validated['subtotal'] = $validated['cantidad'] * $validated['precio_unitario'];
        DetalleVenta::create($validated);
        return redirect()->route('ventas.detalle_ventas.index', $venta_id)->with('success', 'Detalle agregado');
    }

    public function edit($venta_id, $id)
    {
        $venta = Venta::findOrFail($venta_id);
        $detalle = DetalleVenta::findOrFail($id);
        return view('detalle_ventas.edit', compact('venta', 'detalle'));
    }

    public function update(Request $request, $venta_id, $id)
    {
        $detalle = DetalleVenta::findOrFail($id);
        $validated = $request->validate([
            'producto_servicio' => 'required|string|max:255',
            'cantidad'          => 'required|numeric|min:1',
            'precio_unitario'   => 'required|numeric|min:0',
        ]);
        $validated['subtotal'] = $validated['cantidad'] * $validated['precio_unitario'];
        $detalle->update($validated);
        return redirect()->route('ventas.detalle_ventas.index', $venta_id)->with('success', 'Detalle actualizado');
    }

    public function destroy($venta_id, $id)
    {
        $detalle = DetalleVenta::findOrFail($id);
        $detalle->delete();
        return redirect()->route('ventas.detalle_ventas.index', $venta_id)->with('success', 'Detalle eliminado');
    }

    public function exportExcel(Request $request, $venta_id)
{
    return Excel::download(new DetalleVentasExport($venta_id), "venta_{$venta_id}_detalles.xlsx");
}

public function exportPDF(Request $request, $venta_id)
{
    $detalles = \App\Models\DetalleVenta::where('venta_id', $venta_id)->get();
    $pdf = PDF::loadView('detalle_ventas.export_pdf', compact('detalles', 'venta_id'));
    return $pdf->download("venta_{$venta_id}_detalles.pdf");
}

}
