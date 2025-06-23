<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetalleVenta;
use App\Models\Pago;
use Illuminate\Http\Request;
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::all();
        $ventas = Venta::with('cliente')
            ->when($request->cliente_id, fn($q, $cliente_id) => $q->where('cliente_id', $cliente_id))
            ->when($request->fecha_venta, fn($q, $fecha) => $q->where('fecha_venta', $fecha))
            ->when($request->tipo_venta, fn($q, $tipo) => $q->where('tipo_venta', 'ILIKE', "%$tipo%"))
            ->when($request->estatus, fn($q, $estatus) => $q->where('estatus', $estatus))
            ->orderBy('id', 'desc')
            ->paginate(15);

        $ventasPorMes = Venta::selectRaw("to_char(fecha_venta, 'YYYY-MM') as mes, SUM(monto_total) as total")
            ->whereYear('fecha_venta', now()->year)
            ->groupByRaw("mes")
            ->orderByRaw("mes")
            ->pluck('total', 'mes')
            ->toArray();

        $ventasPorEstatus = Venta::selectRaw('estatus, COUNT(*) as total')
            ->groupBy('estatus')
            ->pluck('total', 'estatus')
            ->toArray();

        $topClientes = Venta::selectRaw('cliente_id, SUM(monto_total) as total')
            ->with('cliente')
            ->groupBy('cliente_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('ventas.index', compact(
            'ventas', 'clientes', 'ventasPorMes', 'ventasPorEstatus', 'topClientes'
        ));
    }

    public function create()
    {
        $clientes = Cliente::with('datoFiscal')->get();
        $productos = Producto::all();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id'               => 'required|integer',
            'fecha_venta'              => 'required|date',
            'monto_total'              => 'required|numeric',
            'estatus'                  => 'nullable|string|max:50',
            'tipo_venta'               => 'nullable|string|max:50',
            'comentarios'              => 'nullable|string',
            'productos'                => 'required|array',
            'productos.*.nombre_producto' => 'required|string|max:255',
            'productos.*.sku'          => 'nullable|string|max:255',
            'productos.*.no_serie'     => 'nullable|string|max:255',
            'productos.*.precio_costo' => 'nullable|numeric',
            'productos.*.precio_venta' => 'required|numeric|min:0',
            'productos.*.cantidad'     => 'required|integer|min:1',
        ]);

        $venta = Venta::create([
            'cliente_id'   => $validated['cliente_id'],
            'fecha_venta'  => $validated['fecha_venta'],
            'monto_total'  => $validated['monto_total'],
            'estatus'      => $validated['estatus'] ?? 'Pendiente',
            'tipo_venta'   => $validated['tipo_venta'] ?? null,
            'comentarios'  => $validated['comentarios'] ?? null,
        ]);

        foreach ($validated['productos'] as $detalle) {
            DetalleVenta::create([
                'venta_id'        => $venta->id,
                'sku'             => $detalle['sku'] ?? null,
                'no_serie'        => $detalle['no_serie'] ?? null,
                'nombre_producto' => $detalle['nombre_producto'],
                'precio_costo'    => $detalle['precio_costo'] ?? 0,
                'precio_venta'    => $detalle['precio_venta'],
                'cantidad'        => $detalle['cantidad'],
                'subtotal'        => $detalle['cantidad'] * $detalle['precio_venta'],
            ]);
            // Actualiza inventario solo si el SKU existe
            if (!empty($detalle['sku'])) {
                $producto = Producto::where('sku', $detalle['sku'])->first();
                if ($producto) {
                    $producto->cantidad -= $detalle['cantidad'];
                    $producto->save();
                }
            }
        }

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente');
    }

    public function show(Venta $venta)
    {
        $venta->load(['cliente.datoFiscal', 'detalles', 'pagos']);
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $clientes = Cliente::with('datoFiscal')->get();
        $productos = Producto::all();
        $venta->load('detalles');
        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    public function update(Request $request, Venta $venta)
    {
        $validated = $request->validate([
            'cliente_id'               => 'required|integer',
            'fecha_venta'              => 'required|date',
            'monto_total'              => 'required|numeric',
            'estatus'                  => 'nullable|string|max:50',
            'tipo_venta'               => 'nullable|string|max:50',
            'comentarios'              => 'nullable|string',
            'productos'                => 'required|array',
            'productos.*.nombre_producto' => 'required|string|max:255',
            'productos.*.sku'          => 'nullable|string|max:255',
            'productos.*.no_serie'     => 'nullable|string|max:255',
            'productos.*.precio_costo' => 'nullable|numeric',
            'productos.*.precio_venta' => 'required|numeric|min:0',
            'productos.*.cantidad'     => 'required|integer|min:1',
        ]);

        $venta->update([
            'cliente_id'   => $validated['cliente_id'],
            'fecha_venta'  => $validated['fecha_venta'],
            'monto_total'  => $validated['monto_total'],
            'estatus'      => $validated['estatus'] ?? 'Pendiente',
            'tipo_venta'   => $validated['tipo_venta'] ?? null,
            'comentarios'  => $validated['comentarios'] ?? null,
        ]);

        $venta->detalles()->delete();

        foreach ($validated['productos'] as $detalle) {
            DetalleVenta::create([
                'venta_id'        => $venta->id,
                'sku'             => $detalle['sku'] ?? null,
                'no_serie'        => $detalle['no_serie'] ?? null,
                'nombre_producto' => $detalle['nombre_producto'],
                'precio_costo'    => $detalle['precio_costo'] ?? 0,
                'precio_venta'    => $detalle['precio_venta'],
                'cantidad'        => $detalle['cantidad'],
                'subtotal'        => $detalle['cantidad'] * $detalle['precio_venta'],
            ]);
            if (!empty($detalle['sku'])) {
                $producto = Producto::where('sku', $detalle['sku'])->first();
                if ($producto) {
                    $producto->cantidad -= $detalle['cantidad'];
                    $producto->save();
                }
            }
        }

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente');
    }

    public function destroy(Venta $venta)
    {
        $venta->detalles()->delete();
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new VentasExport($request->all()), 'ventas.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $ventas = Venta::with('cliente')->get();
        $pdf = PDF::loadView('ventas.export_pdf', compact('ventas'));
        return $pdf->download('ventas.pdf');
    }

    // NOTA DE VENTA PDF
    public function notaVentaPDF(Venta $venta)
    {
        $venta->load(['cliente.datoFiscal', 'detalles']);
        $pdf = PDF::loadView('ventas.nota_venta_pdf', compact('venta'));
        return $pdf->download('nota_venta_' . $venta->id . '.pdf');
    }

    // FACTURA PDF (Botón sólo visible, integración SAT pendiente)
    public function facturaPDF(Venta $venta)
    {
        return back()->with('info', 'La generación de factura timbrada estará disponible próximamente.');
    }
}
