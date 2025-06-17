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

        // ----------- Gráficos (convertidos a array) -----------

        // Ventas por mes (siempre array)
        $ventasPorMes = Venta::selectRaw("to_char(fecha_venta, 'YYYY-MM') as mes, SUM(monto_total) as total")
            ->whereYear('fecha_venta', now()->year)
            ->groupByRaw("mes")
            ->orderByRaw("mes")
            ->pluck('total', 'mes')
            ->toArray();

        // Ventas por estatus (array)
        $ventasPorEstatus = Venta::selectRaw('estatus, COUNT(*) as total')
            ->groupBy('estatus')
            ->pluck('total', 'estatus')
            ->toArray();

        // Top 5 clientes por monto
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
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|integer',
            'fecha_venta' => 'required|date',
            'monto_total' => 'required|numeric',
            'estatus' => 'nullable|string|max:50',
            'tipo_venta' => 'nullable|string|max:50',
            'comentarios' => 'nullable|string',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'nullable|integer', // permite nulo si es venta rápida
            'productos.*.nombre_producto' => 'nullable|string|max:255',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
        ]);

        // Crear venta
        $venta = Venta::create([
            'cliente_id' => $validated['cliente_id'],
            'fecha_venta' => $validated['fecha_venta'],
            'monto_total' => $validated['monto_total'],
            'estatus' => $validated['estatus'] ?? 'Pendiente',
            'tipo_venta' => $validated['tipo_venta'] ?? null,
            'comentarios' => $validated['comentarios'] ?? null,
        ]);

        // Guardar detalles de venta
        foreach ($validated['productos'] as $detalle) {
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $detalle['producto_id'] ?? null,
                'nombre_producto' => $detalle['nombre_producto'] ?? null,
                'cantidad' => $detalle['cantidad'],
                'precio_unitario' => $detalle['precio'],
                'subtotal' => $detalle['cantidad'] * $detalle['precio'],
            ]);
            // Descontar del inventario si aplica
            if (!empty($detalle['producto_id'])) {
                $producto = Producto::find($detalle['producto_id']);
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
        $venta->load(['cliente', 'detalles.producto', 'pagos']);
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $venta->load('detalles.producto');
        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    public function update(Request $request, Venta $venta)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|integer',
            'fecha_venta' => 'required|date',
            'monto_total' => 'required|numeric',
            'estatus' => 'nullable|string|max:50',
            'tipo_venta' => 'nullable|string|max:50',
            'comentarios' => 'nullable|string',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'nullable|integer',
            'productos.*.nombre_producto' => 'nullable|string|max:255',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
        ]);

        $venta->update([
            'cliente_id' => $validated['cliente_id'],
            'fecha_venta' => $validated['fecha_venta'],
            'monto_total' => $validated['monto_total'],
            'estatus' => $validated['estatus'] ?? 'Pendiente',
            'tipo_venta' => $validated['tipo_venta'] ?? null,
            'comentarios' => $validated['comentarios'] ?? null,
        ]);

        // Eliminar detalles anteriores y agregar nuevos
        $venta->detalles()->delete();

        foreach ($validated['productos'] as $detalle) {
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $detalle['producto_id'] ?? null,
                'nombre_producto' => $detalle['nombre_producto'] ?? null,
                'cantidad' => $detalle['cantidad'],
                'precio_unitario' => $detalle['precio'],
                'subtotal' => $detalle['cantidad'] * $detalle['precio'],
            ]);
            // Descontar del inventario si aplica
            if (!empty($detalle['producto_id'])) {
                $producto = Producto::find($detalle['producto_id']);
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

    // EXPORTAR EXCEL
    public function exportExcel(Request $request)
    {
        return Excel::download(new VentasExport($request->all()), 'ventas.xlsx');
    }

    // EXPORTAR PDF
    public function exportPDF(Request $request)
    {
        $ventas = Venta::with('cliente')->get();
        $pdf = PDF::loadView('ventas.export_pdf', compact('ventas'));
        return $pdf->download('ventas.pdf');
    }

    // FACTURA PDF INDIVIDUAL
    public function facturaPDF(Venta $venta)
{
    $venta->load(['cliente', 'detalles']); // <--- importante
    $pdf = PDF::loadView('ventas.factura_pdf', compact('venta'));
    return $pdf->download('factura_'.$venta->id.'.pdf');
}

}
