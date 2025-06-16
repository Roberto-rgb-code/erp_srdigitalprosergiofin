<?php

namespace App\Http\Controllers;

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
        // KPIs
        $saldo_bancos = CuentaBancaria::sum('saldo');
        $saldo_caja   = CajaChica::sum('monto');
        $cxc = CuentaPorCobrar::where('saldo', '>', 0)->sum('saldo');
        $cxp = CuentaPorPagar::where('saldo', '>', 0)->sum('saldo');

        // Últimos movimientos
        $ultimos_movimientos = DiarioContable::with(['poliza', 'cuentaContable'])
            ->orderByDesc('fecha')->take(10)->get();

        // Datos dummy para los gráficos (ajusta para tus queries reales)
        $grafica_balance = [
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May'],
            'datasets' => [
                [
                    'label' => 'Ingresos',
                    'data' => [12000, 15000, 10000, 18000, 14000],
                ],
                [
                    'label' => 'Egresos',
                    'data' => [8000, 9000, 7000, 11000, 10000],
                ]
            ]
        ];

        $grafica_resultados = [
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May'],
            'datasets' => [
                [
                    'label' => 'Utilidad',
                    'data' => [4000, 6000, 3000, 7000, 4000],
                ]
            ]
        ];

        return view('contabilidad.index', compact(
            'saldo_bancos',
            'saldo_caja',
            'cxc',
            'cxp',
            'ultimos_movimientos',
            'grafica_balance',
            'grafica_resultados'
        ));
    }
}
