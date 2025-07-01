<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductosExport;

class InventarioController extends Controller
{
    public function index()
{
    $productos = Producto::with('proveedor')->orderBy('id', 'desc')->paginate(15);
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
            'numero_serie'      => 'nullable|string|max:100',
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

        Producto::create($validated);

        return redirect()->route('inventario.index')->with('success', 'Producto agregado correctamente.');
    }

    public function show(Producto $inventario)
    {
        $inventario->load('proveedor');
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
            'numero_serie'      => 'nullable|string|max:100',
            'cantidad'          => 'required|integer|min:1',
            'costo_unitario'    => 'required|numeric|min:0',
            'precio_venta'      => 'required|numeric|min:0',
            'precio_mayoreo'    => 'required|numeric|min:0',
            'costo_total'       => 'required|numeric|min:0',
        ]);

        $inventario->update($validated);

        return redirect()->route('inventario.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $inventario)
    {
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
    $productos = \App\Models\Producto::with('proveedor')->get();
    $pdf = PDF::loadView('inventario.export_pdf', compact('productos'));
    return $pdf->download('inventario.pdf');
}

}
