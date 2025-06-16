<?php

namespace App\Http\Controllers;

use App\Models\CuentaPorCobrar;
use App\Models\Cobro;
use App\Models\SeguimientoCobro;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;

class CuentasPorCobrarController extends Controller
{
    public function index(Request $request)
    {
        $registros = CuentaPorCobrar::with(['cliente', 'venta', 'cobros'])
            ->orderByDesc('id')
            ->paginate(20);

        $total_deuda = CuentaPorCobrar::sum('saldo');
        $clientesCredito = Cliente::where('limite_credito', '>', 0)->get();

        return view('cuentas_por_cobrar.index', compact('registros', 'total_deuda', 'clientesCredito'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $ventas = Venta::all();
        return view('cuentas_por_cobrar.create', compact('clientes', 'ventas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'venta_id' => 'required|integer|exists:ventas,id',
            'monto' => 'required|numeric|min:0',
            'saldo' => 'required|numeric|min:0',
            'fecha_vencimiento' => 'required|date',
            'fecha_pago' => 'nullable|date',
            'estatus' => 'required|string|max:20',
            'comentarios' => 'nullable|string',
        ]);
        CuentaPorCobrar::create($data);
        return redirect()->route('cuentas_por_cobrar.index')->with('success', 'Registro de CxC creado');
    }

    public function show(CuentaPorCobrar $cuentas_por_cobrar)
    {
        $cuenta = $cuentas_por_cobrar->load(['cliente', 'venta', 'cobros', 'seguimientos.usuario']);
        $total_cobrado = $cuenta->cobros->sum('monto');
        $porcentaje_impacto = $cuenta->impacto_porcentaje; // del accesor de modelo
        return view('cuentas_por_cobrar.show', compact('cuenta', 'total_cobrado', 'porcentaje_impacto'));
    }

    public function edit(CuentaPorCobrar $cuentas_por_cobrar)
    {
        $clientes = Cliente::all();
        $ventas = Venta::all();
        return view('cuentas_por_cobrar.edit', [
            'registro' => $cuentas_por_cobrar,
            'clientes' => $clientes,
            'ventas' => $ventas
        ]);
    }

    public function update(Request $request, CuentaPorCobrar $cuentas_por_cobrar)
    {
        $data = $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'venta_id' => 'required|integer|exists:ventas,id',
            'monto' => 'required|numeric|min:0',
            'saldo' => 'required|numeric|min:0',
            'fecha_vencimiento' => 'required|date',
            'fecha_pago' => 'nullable|date',
            'estatus' => 'required|string|max:20',
            'comentarios' => 'nullable|string',
        ]);
        $cuentas_por_cobrar->update($data);
        return redirect()->route('cuentas_por_cobrar.index')->with('success', 'Registro actualizado');
    }

    public function destroy(CuentaPorCobrar $cuentas_por_cobrar)
    {
        $cuentas_por_cobrar->delete();
        return redirect()->route('cuentas_por_cobrar.index')->with('success', 'Registro eliminado');
    }

    // ----------- NUEVO: REGISTRAR COBRO (PAGO) -----------
    public function registrarCobro(Request $request, $id)
    {
        $cuenta = CuentaPorCobrar::findOrFail($id);

        $request->validate([
            'monto' => 'required|numeric|min:1',
            'fecha' => 'required|date',
            'tipo' => 'required|string',
            'comentarios' => 'nullable|string',
        ]);

        $monto = min($request->monto, $cuenta->saldo); // Evita pagos de más

        $cobro = $cuenta->cobros()->create([
            'monto' => $monto,
            'fecha' => $request->fecha,
            'tipo' => $request->tipo,
            'comentarios' => $request->comentarios,
            'recibo' => $request->recibo ?? null,
        ]);

        // Actualiza saldo
        $cuenta->saldo -= $monto;
        if ($cuenta->saldo <= 0) {
            $cuenta->saldo = 0;
            $cuenta->estatus = 'Pagado';
            $cuenta->fecha_pago = $request->fecha;
        }
        $cuenta->save();

        return redirect()->route('cuentas_por_cobrar.show', $cuenta->id)
            ->with('success', 'Cobro registrado correctamente.');
    }

    // ----------- NUEVO: REGISTRAR SEGUIMIENTO -----------
    public function registrarSeguimiento(Request $request, $id)
    {
        $cuenta = CuentaPorCobrar::findOrFail($id);

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

        return redirect()->route('cuentas_por_cobrar.show', $cuenta->id)
            ->with('success', 'Seguimiento registrado correctamente.');
    }

    // ----------- (OPCIONAL) EXPORTACIÓN -----------
    public function exportExcel()
    {
        return \Excel::download(new \App\Exports\CuentasPorCobrarExport, 'cuentas_por_cobrar.xlsx');
    }

    public function exportPDF()
    {
        $cuentas = CuentaPorCobrar::with('cliente')->get();
        $pdf = \PDF::loadView('cuentas_por_cobrar.export_pdf', compact('cuentas'));
        return $pdf->download('cuentas_por_cobrar.pdf');
    }
}
