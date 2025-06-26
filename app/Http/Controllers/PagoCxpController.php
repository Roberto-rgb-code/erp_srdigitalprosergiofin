<?php

namespace App\Http\Controllers;

use App\Models\PagoCxp;
use App\Models\CuentaPorPagar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PagoCxpController extends Controller
{
    public function create($cuenta_pagar_id)
    {
        $cuenta = CuentaPorPagar::findOrFail($cuenta_pagar_id);
        return view('pagos_cxp.create', compact('cuenta'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cuenta_pagar_id'   => 'required|exists:cuentas_por_pagar,id',
            'fecha_pago'        => 'required|date',
            'monto'             => 'required|numeric|min:0.01',
            'comprobante_path'  => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'comentarios'       => 'nullable|string|max:500',
        ]);

        if($request->hasFile('comprobante_path')) {
            $data['comprobante_path'] = $request->file('comprobante_path')->store('pagos_cxp', 'public');
        }

        $pago = PagoCxp::create($data);

        // Actualiza saldo de la cuenta por pagar
        $cuenta = CuentaPorPagar::find($data['cuenta_pagar_id']);
        $cuenta->saldo_pendiente -= $data['monto'];
        if ($cuenta->saldo_pendiente <= 0) {
            $cuenta->saldo_pendiente = 0;
            $cuenta->estatus = 'pagada';
        } else {
            $cuenta->estatus = 'parcial';
        }
        $cuenta->save();

        return redirect()->route('cuentas_por_pagar.show', $cuenta)->with('success', 'Pago registrado correctamente.');
    }

    public function destroy(PagoCxp $pagos_cxp)
    {
        $cuenta = $pagos_cxp->cuentaPorPagar;
        if ($pagos_cxp->comprobante_path) {
            Storage::disk('public')->delete($pagos_cxp->comprobante_path);
        }
        $cuenta->saldo_pendiente += $pagos_cxp->monto; // Reintegra saldo
        $cuenta->estatus = 'pendiente';
        $cuenta->save();
        $pagos_cxp->delete();
        return back()->with('success', 'Pago eliminado.');
    }
}
