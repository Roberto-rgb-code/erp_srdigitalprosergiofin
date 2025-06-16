<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\CuentaPorCobrar;
use App\Models\CuentaPorPagar;
use App\Models\CuentaBancaria;
use App\Models\CajaChica;
use Illuminate\Http\Request;

class FinanzasController extends Controller
{
    public function index(Request $request)
    {
        // Totales principales
        $total_ingresos = Ingreso::sum('monto');
        $total_egresos = Egreso::sum('monto');
        $total_por_cobrar = CuentaPorCobrar::where('estatus', 'Pendiente')->sum('saldo');
        $total_por_pagar  = CuentaPorPagar::where('estatus', 'Pendiente')->sum('saldo');
        $saldo_bancos = CuentaBancaria::sum('saldo');
        $saldo_caja = CajaChica::sum('monto');

        // Listas para tablas rápidas
        $ingresos = Ingreso::orderByDesc('fecha')->limit(10)->get();
        $egresos  = Egreso::orderByDesc('fecha')->limit(10)->get();
        $cobros   = CuentaPorCobrar::orderByDesc('fecha_vencimiento')->limit(10)->get();
        $pagos    = CuentaPorPagar::orderByDesc('fecha_vencimiento')->limit(10)->get();

        // Para gráficos: Agrupa ingresos/egresos por mes
        $ingresos_por_mes = Ingreso::selectRaw("to_char(fecha, 'YYYY-MM') as mes, sum(monto) as total")
            ->groupBy('mes')->orderBy('mes')->pluck('total', 'mes')->toArray();

        $egresos_por_mes = Egreso::selectRaw("to_char(fecha, 'YYYY-MM') as mes, sum(monto) as total")
            ->groupBy('mes')->orderBy('mes')->pluck('total', 'mes')->toArray();


        return view('finanzas.index', compact(
            'total_ingresos', 'total_egresos', 'total_por_cobrar', 'total_por_pagar',
            'saldo_bancos', 'saldo_caja', 'ingresos', 'egresos', 'cobros', 'pagos',
            'ingresos_por_mes', 'egresos_por_mes'
        ));
    }
}
