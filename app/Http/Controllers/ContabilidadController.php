<?php

namespace App\Http\Controllers;

use App\Models\CuentaContable;
use App\Models\CuentaBancaria;
use App\Models\CajaChica;
use App\Models\CuentaPorCobrar;
use App\Models\CuentaPorPagar;
use App\Models\DiarioContable;
use Illuminate\Http\Request;

class ContabilidadController extends Controller
{
    public function index()
    {
        // KPIs reales
        $saldo_bancos = CuentaBancaria::sum('saldo');
        $saldo_caja   = CajaChica::sum('monto');
        $cxc = CuentaPorCobrar::where('saldo', '>', 0)->sum('saldo');
        $cxp = CuentaPorPagar::where('saldo', '>', 0)->sum('saldo');

        // Últimos movimientos reales
        $ultimos_movimientos = DiarioContable::with(['poliza', 'cuentaContable'])
            ->orderByDesc('fecha')->take(10)->get();

        // Catálogo de cuentas contables reales
        $cuentas = CuentaContable::with('cuentaPadre')->get();

        return view('contabilidad.index', compact(
            'saldo_bancos',
            'saldo_caja',
            'cxc',
            'cxp',
            'ultimos_movimientos',
            'cuentas'
        ));

        // Catálogo de cuentas contables
        $cuentas = CuentaContable::with('cuentaPadre')->get();

        return view('contabilidad.index', compact(
            'saldo_bancos',
            'saldo_caja',
            'cxc',
            'cxp',
            'ultimos_movimientos',
            'grafica_balance',
            'cuentas'
        ));
    }
}
