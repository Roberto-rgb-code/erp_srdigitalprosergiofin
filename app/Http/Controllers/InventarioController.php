<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\StockUnit;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductosExport;

class InventarioController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['proveedor', 'stockUnits'])->orderBy('id', 'desc')->paginate(15);
        $proveedores = Proveedor::all();
        $tiposProducto = Producto::select('tipo_producto')->distinct()->pluck('tipo_producto');

        // Conteos para gráficos
        $conteoTipo = Producto::selectRaw('tipo_producto, count(*) as total')
            ->groupBy('tipo_producto')
            ->pluck('total', 'tipo_producto');

        $conteoProveedor = Producto::selectRaw('proveedor_id, count(*) as total')
            ->groupBy('proveedor_id')
            ->pluck('total', 'proveedor_id');

        return view('inventario.index', compact('productos', 'proveedores', 'tiposProducto', 'conteoTipo', 'conteoProveedor'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        return view('inventario.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'documento_compra'  => 'nullable|string|max:100',
            'proveedor_id'      => 'required|exists:proveedores,id',
            'tipo_producto'     => 'required|string|max:100',
            'producto'          => 'required|string|max:255',
            'sku'               => 'required|string|max:100|unique:productos,sku',
            'cantidad'          => 'required|integer|min:1',
            'costo_unitario'    => 'required|numeric|min:0',
            'precio_venta'      => 'required|numeric|min:0',
            'precio_mayoreo'    => 'required|numeric|min:0',
            'costo_total'       => 'required|numeric|min:0',
        ]);

        // Generar folio automático tipo PROD-000001
        $ultimo = Producto::orderByDesc('id')->first();
        $consecutivo = $ultimo ? $ultimo->id + 1 : 1;
        $folio = 'PROD-' . str_pad($consecutivo, 6, '0', STR_PAD_LEFT);
        $validated['folio'] = $folio;

        $producto = Producto::create($validated);

        // Crear unidades de stock individuales con número de serie y código de barras
        $cantidad = $request->input('cantidad', 1);
        for ($i = 1; $i <= $cantidad; $i++) {
            $numSerie = $producto->folio . '-' . str_pad($i, 3, '0', STR_PAD_LEFT); // Ejemplo: PROD-000001-001
            StockUnit::create([
                'producto_id'   => $producto->id,
                'numero_serie'  => $numSerie,
                'codigo_barras' => $numSerie
            ]);
        }

        return redirect()->route('inventario.index')->with('success', 'Producto agregado correctamente.');
    }

    public function show(Producto $inventario)
    {
        $inventario->load(['proveedor', 'stockUnits']);
        return view('inventario.show', compact('inventario'));
    }

    public function edit(Producto $inventario)
    {
        $proveedores = Proveedor::all();
        return view('inventario.edit', compact('inventario', 'proveedores'));
    }

    public function update(Request $request, Producto $inventario)
    {
        $validated = $request->validate([
            'documento_compra'  => 'nullable|string|max:100',
            'proveedor_id'      => 'required|exists:proveedores,id',
            'tipo_producto'     => 'required|string|max:100',
            'producto'          => 'required|string|max:255',
            'sku'               => 'required|string|max:100|unique:productos,sku,' . $inventario->id,
            'cantidad'          => 'required|integer|min:1',
            'costo_unitario'    => 'required|numeric|min:0',
            'precio_venta'      => 'required|numeric|min:0',
            'precio_mayoreo'    => 'required|numeric|min:0',
            'costo_total'       => 'required|numeric|min:0',
        ]);

        $inventario->update($validated);

        // (Opcional) Aquí podrías sincronizar stock_units si cambia la cantidad

        return redirect()->route('inventario.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $inventario)
    {
        // Verifica si hay ventas ligadas a este producto
        if ($inventario->ventas()->exists()) {
            return back()->with('error', 'No se puede eliminar el producto porque tiene ventas registradas.');
        }

        $inventario->delete();
        return back()->with('success', 'Producto eliminado.');
    }

    /**
     * Exporta inventario a Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new ProductosExport, 'inventario.xlsx');
    }

    /**
     * Exporta inventario a PDF.
     */
    public function exportPDF()
    {
        $productos = Producto::with('proveedor')->get();
        $pdf = PDF::loadView('inventario.export_pdf', compact('productos'));
        return $pdf->download('inventario.pdf');
    }

    /**
     * Exporta la etiqueta de una unidad individual en PDF.
     */
    public function exportEtiquetaPDF(StockUnit $stockUnit)
    {
        $producto = $stockUnit->producto;

        // Habilitar imágenes remotas para Dompdf de Barryvdh
        PDF::setOptions(['isRemoteEnabled' => true]);

        $pdf = PDF::loadView('inventario.etiqueta_pdf', compact('producto', 'stockUnit'));
        return $pdf->download("etiqueta-{$stockUnit->numero_serie}.pdf");
    }
}
