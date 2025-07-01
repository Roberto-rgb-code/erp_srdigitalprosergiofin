<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::all();
        $ventas = Venta::with(['cliente', 'productos'])
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
        // Mapea a array asociativo para JS del front
        $productosJson = $productos->keyBy('id')->map(function($p){
            return [
                'nombre' => $p->producto,
                'sku' => $p->sku,
                'precio' => (float)$p->precio_venta,
                'stock' => (int)$p->cantidad,
            ];
        });
        return view('ventas.create', compact('clientes', 'productos', 'productosJson'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id'   => 'required|integer',
            'fecha_venta'  => 'required|date',
            'monto_total'  => 'required|numeric',
            'estatus'      => 'nullable|string|max:50',
            'tipo_venta'   => 'nullable|string|max:50',
            'comentarios'  => 'nullable|string',
            // 'productos' => 'array', // opcional, validación personalizada
        ]);

        // 1. Crear la venta
        $venta = Venta::create([
            'cliente_id'   => $validated['cliente_id'],
            'fecha_venta'  => $validated['fecha_venta'],
            'monto_total'  => $validated['monto_total'],
            'estatus'      => $validated['estatus'] ?? 'Pendiente',
            'tipo_venta'   => $validated['tipo_venta'] ?? null,
            'comentarios'  => $validated['comentarios'] ?? null,
        ]);

        // 2. Asociar productos a la venta (detalle_venta)
        $productos = $request->input('productos', []);
        foreach ($productos as $producto_id => $info) {
            $cantidad = intval($info['cantidad']);
            $precio_unitario = floatval($info['precio_unitario']);
            if ($cantidad > 0) {
                $venta->productos()->attach($producto_id, [
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio_unitario,
                ]);

                // Opcional: Descontar inventario (stock)
                Producto::where('id', $producto_id)->decrement('cantidad', $cantidad);
            }
        }

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente');
    }

    public function show(Venta $venta)
    {
        $venta->load(['cliente.datoFiscal', 'pagos', 'productos']);
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $clientes = Cliente::with('datoFiscal')->get();
        $productos = Producto::all();
        $productosJson = $productos->keyBy('id')->map(function($p){
            return [
                'nombre' => $p->producto,
                'sku' => $p->sku,
                'precio' => (float)$p->precio_venta,
                'stock' => (int)$p->cantidad,
            ];
        });
        // Carga productos seleccionados si existe relación many-to-many
        $venta->load('productos');
        return view('ventas.edit', compact('venta', 'clientes', 'productos', 'productosJson'));
    }
    public function update(Request $request, Venta $venta)
    {
        $validated = $request->validate([
            'cliente_id'   => 'required|integer',
            'fecha_venta'  => 'required|date',
            'monto_total'  => 'required|numeric',
            'estatus'      => 'nullable|string|max:50',
            'tipo_venta'   => 'nullable|string|max:50',
            'comentarios'  => 'nullable|string',
        ]);

        $venta->update([
            'cliente_id'   => $validated['cliente_id'],
            'fecha_venta'  => $validated['fecha_venta'],
            'monto_total'  => $validated['monto_total'],
            'estatus'      => $validated['estatus'] ?? 'Pendiente',
            'tipo_venta'   => $validated['tipo_venta'] ?? null,
            'comentarios'  => $validated['comentarios'] ?? null,
        ]);

        // Actualiza los productos asociados:
        // (1) Elimina los existentes
        $venta->productos()->detach();
        // (2) Asocia los nuevos (igual que en store)
        $productos = $request->input('productos', []);
        foreach ($productos as $producto_id => $info) {
            $cantidad = intval($info['cantidad']);
            $precio_unitario = floatval($info['precio_unitario']);
            if ($cantidad > 0) {
                $venta->productos()->attach($producto_id, [
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio_unitario,
                ]);
            }
        }

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente');
    }

    public function destroy(Venta $venta)
    {
        $venta->productos()->detach(); // Borra detalle_venta
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new VentasExport($request->all()), 'ventas.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $ventas = Venta::with(['cliente', 'productos'])->get();
        $pdf = PDF::loadView('ventas.export_pdf', compact('ventas'));
        return $pdf->download('ventas.pdf');
    }

    // NOTA DE VENTA PDF
    public function notaVentaPDF(Venta $venta)
    {
        $venta->load(['cliente.datoFiscal', 'productos']);
        $pdf = PDF::loadView('ventas.nota_venta_pdf', compact('venta'));
        return $pdf->download('nota_venta_' . $venta->id . '.pdf');
    }

    // FACTURA PDF (Botón sólo visible, integración SAT pendiente)
    public function facturaPDF(Venta $venta)
    {
        return back()->with('info', 'La generación de factura timbrada estará disponible próximamente.');
    }
}
