<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\StockUnit;
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

        // MÉTRICAS PARA DASHBOARD
        // Ventas por Mes (YYYY-MM => total)
        $ventasPorMes = Venta::selectRaw("to_char(fecha_venta, 'YYYY-MM') as mes, SUM(monto_total) as total")
            ->groupBy('mes')->orderBy('mes')
            ->pluck('total', 'mes')->toArray();

        // Ventas por Estatus (estatus => count)
        $ventasPorEstatus = Venta::selectRaw('estatus, COUNT(*) as total')
            ->groupBy('estatus')
            ->pluck('total', 'estatus')->toArray();

        // Top 5 Clientes (cliente_id => total vendido)
        $topClientes = Venta::selectRaw('cliente_id, SUM(monto_total) as total')
            ->with('cliente')
            ->groupBy('cliente_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('ventas.index', compact(
            'ventas', 'clientes', 'ventasPorMes', 'ventasPorEstatus', 'topClientes'
        ));
    }

    public function create()
    {
        $clientes = Cliente::with('datoFiscal')->get();
        $productos = Producto::with('stockUnits')->get();
        $productosJson = $productos->keyBy('id')->map(function($p){
            return [
                'nombre'   => $p->producto,
                'sku'      => $p->sku,
                'precio'   => (float)$p->precio_venta,
                'stock'    => (int)$p->cantidad,
                // Unidades físicas disponibles
                'unidades' => $p->stockUnits->whereNull('vendida_en')->values()->map(function($u){
                    return [
                        'id' => $u->id,
                        'numero_serie' => $u->numero_serie,
                    ];
                }),
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
            $stock_unit_ids = isset($info['stock_unit_ids']) ? $info['stock_unit_ids'] : [];
            if ($cantidad > 0) {
                $venta->productos()->attach($producto_id, [
                    'cantidad'        => $cantidad,
                    'precio_unitario' => $precio_unitario,
                    'stock_unit_ids'  => json_encode($stock_unit_ids),
                ]);

                // Marca esas unidades físicas como "vendidas" (si tienes el campo)
                if (is_array($stock_unit_ids) && count($stock_unit_ids) > 0) {
                    StockUnit::whereIn('id', $stock_unit_ids)->update(['vendida_en' => $venta->id]);
                }

                Producto::where('id', $producto_id)->decrement('cantidad', $cantidad);
            }
        }

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente');
    }

    public function show(Venta $venta)
    {
        $venta->load(['cliente.datoFiscal', 'pagos', 'productos.stockUnits']);
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $clientes = Cliente::with('datoFiscal')->get();
        $productos = Producto::with('stockUnits')->get();
        $productosJson = $productos->keyBy('id')->map(function($p){
            return [
                'nombre'   => $p->producto,
                'sku'      => $p->sku,
                'precio'   => (float)$p->precio_venta,
                'stock'    => (int)$p->cantidad,
                // Unidades físicas disponibles (no vendidas)
                'unidades' => $p->stockUnits->whereNull('vendida_en')->values()->map(function($u){
                    return [
                        'id' => $u->id,
                        'numero_serie' => $u->numero_serie,
                    ];
                }),
            ];
        });

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

        // Elimina productos actuales
        $venta->productos()->detach();

        // (igual que en store)
        $productos = $request->input('productos', []);
        foreach ($productos as $producto_id => $info) {
            $cantidad = intval($info['cantidad']);
            $precio_unitario = floatval($info['precio_unitario']);
            $stock_unit_ids = isset($info['stock_unit_ids']) ? $info['stock_unit_ids'] : [];
            if ($cantidad > 0) {
                $venta->productos()->attach($producto_id, [
                    'cantidad'        => $cantidad,
                    'precio_unitario' => $precio_unitario,
                    'stock_unit_ids'  => json_encode($stock_unit_ids),
                ]);
                if (is_array($stock_unit_ids) && count($stock_unit_ids) > 0) {
                    StockUnit::whereIn('id', $stock_unit_ids)->update(['vendida_en' => $venta->id]);
                }
            }
        }

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente');
    }

    public function destroy(Venta $venta)
    {
        $venta->productos()->detach();
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

    public function notaVentaPDF(Venta $venta)
    {
        $venta->load(['cliente.datoFiscal', 'productos']);
        $pdf = PDF::loadView('ventas.nota_venta_pdf', compact('venta'));
        return $pdf->download('nota_venta_' . $venta->id . '.pdf');
    }

    public function facturaPDF(Venta $venta)
    {
        return back()->with('info', 'La generación de factura timbrada estará disponible próximamente.');
    }
}
