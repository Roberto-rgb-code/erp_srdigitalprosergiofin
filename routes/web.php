<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controladores principales
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\TallerController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\CableadoController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ConsumoCombustibleController;
use App\Http\Controllers\MantenimientoVehiculoController;
use App\Http\Controllers\UsoVehiculoController;
use App\Http\Controllers\EvidenciaVehiculoController;
use App\Http\Controllers\DesarrolloSoftwareController;
use App\Http\Controllers\ModuloSoftwareController;
use App\Http\Controllers\EntregaModuloController;
use App\Http\Controllers\FeedbackClienteController;
use App\Http\Controllers\ServicioEmpresarialController;
use App\Http\Controllers\FinanzasController;
use App\Http\Controllers\CuentasPorCobrarController;
use App\Http\Controllers\CuentasPorPagarController;
use App\Http\Controllers\ContabilidadController;
use App\Http\Controllers\CuentaContableController;
use App\Http\Controllers\PolizaContableController;
use App\Http\Controllers\DiarioContableController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PuestoEmpleadoController;
use App\Http\Controllers\PermisoEmpleadoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\DocumentoEmpleadoController;
use App\Http\Controllers\CreditoController;
use App\Http\Controllers\DocumentoCreditoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\RefaccionController;
use App\Http\Controllers\EvidenciaController;
use App\Http\Controllers\PuntoVentaMovimientoController;
use App\Http\Controllers\PagoCxpController;
use App\Http\Controllers\SeguimientoCxpController;
use App\Http\Controllers\GastoFijoController;
use App\Http\Controllers\DatoFiscalClienteController;
use App\Http\Controllers\InventarioController;

// Ruta principal: redirecciona al dashboard o login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Dashboard protegido
Route::get('/dashboard', fn() => view('dashboard.index'))
    ->name('dashboard')
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {

    // SUBMÓDULOS DE TALLER
    Route::post('refacciones', [RefaccionController::class, 'store'])->name('refacciones.store');
    Route::delete('refacciones/{refaccion}', [RefaccionController::class, 'destroy'])->name('refacciones.destroy');
    Route::post('evidencias', [EvidenciaController::class, 'store'])->name('evidencias.store');
    Route::delete('evidencias/{evidencia}', [EvidenciaController::class, 'destroy'])->name('evidencias.destroy');
    Route::put('taller/{taller}/cambiar-estado', [TallerController::class, 'cambiarEstado'])->name('taller.cambiarEstado');

    // EXPORTACIONES POR MÓDULO
    Route::prefix('clientes')->group(function () {
        Route::get('export-excel', [ClienteController::class, 'exportExcel'])->name('clientes.export.excel');
        Route::get('export-pdf',   [ClienteController::class, 'exportPDF'])->name('clientes.export.pdf');
    });

    Route::prefix('ventas')->group(function () {
        Route::get('export-excel', [VentaController::class, 'exportExcel'])->name('ventas.export.excel');
        Route::get('export-pdf',   [VentaController::class, 'exportPDF'])->name('ventas.export.pdf');
        Route::get('{venta}/factura', [VentaController::class, 'facturaPDF'])->name('ventas.factura');
        Route::get('{venta}/nota',    [VentaController::class, 'notaVentaPDF'])->name('ventas.nota');

        Route::prefix('{venta}/detalle_ventas')->group(function () {
            Route::get('export-excel', [DetalleVentaController::class, 'exportExcel'])
                ->name('ventas.detalle_ventas.export.excel');
            Route::get('export-pdf',   [DetalleVentaController::class, 'exportPDF'])
                ->name('ventas.detalle_ventas.export.pdf');
        });
    });

    Route::prefix('taller')->group(function () {
        Route::get('export-excel', [TallerController::class, 'exportExcel'])->name('taller.export.excel');
        Route::get('export-pdf',   [TallerController::class, 'exportPDF'])->name('taller.export.pdf');
    });

    Route::prefix('cableado')->group(function () {
        Route::get('export-excel', [CableadoController::class, 'exportExcel'])->name('cableado.export.excel');
        Route::get('export-pdf',   [CableadoController::class, 'exportPDF'])->name('cableado.export.pdf');
    });

    Route::prefix('vehiculos')->group(function () {
        Route::get('export-excel', [VehiculoController::class, 'exportExcel'])->name('vehiculos.export.excel');
        Route::get('export-pdf',   [VehiculoController::class, 'exportPDF'])->name('vehiculos.export.pdf');

        // Submódulos Vehículos
        Route::prefix('{vehiculo}/consumo')->name('vehiculos.consumo.')->group(function () {
            Route::get('/',              [ConsumoCombustibleController::class, 'index'])->name('index');
            Route::get('create',         [ConsumoCombustibleController::class, 'create'])->name('create');
            Route::post('/',             [ConsumoCombustibleController::class, 'store'])->name('store');
            Route::get('{consumo}/edit', [ConsumoCombustibleController::class, 'edit'])->name('edit');
            Route::put('{consumo}',      [ConsumoCombustibleController::class, 'update'])->name('update');
            Route::delete('{consumo}',   [ConsumoCombustibleController::class, 'destroy'])->name('destroy');
            Route::get('export-excel',   [ConsumoCombustibleController::class, 'exportExcel'])->name('exportExcel');
            Route::get('export-pdf',     [ConsumoCombustibleController::class, 'exportPDF'])->name('exportPDF');
        });

        Route::prefix('{vehiculo}/mantenimiento')->name('vehiculos.mantenimiento.')->group(function () {
            Route::get('/',                   [MantenimientoVehiculoController::class, 'index'])->name('index');
            Route::get('create',              [MantenimientoVehiculoController::class, 'create'])->name('create');
            Route::post('/',                  [MantenimientoVehiculoController::class, 'store'])->name('store');
            Route::get('{mantenimiento}/edit',[MantenimientoVehiculoController::class, 'edit'])->name('edit');
            Route::put('{mantenimiento}',     [MantenimientoVehiculoController::class, 'update'])->name('update');
            Route::delete('{mantenimiento}',  [MantenimientoVehiculoController::class, 'destroy'])->name('destroy');
            Route::get('export-excel',        [MantenimientoVehiculoController::class, 'exportExcel'])->name('exportExcel');
            Route::get('export-pdf',          [MantenimientoVehiculoController::class, 'exportPDF'])->name('exportPDF');
        });

        Route::prefix('{vehiculo}/uso')->name('vehiculos.uso.')->group(function () {
            Route::get('/',           [UsoVehiculoController::class, 'index'])->name('index');
            Route::get('create',      [UsoVehiculoController::class, 'create'])->name('create');
            Route::post('/',          [UsoVehiculoController::class, 'store'])->name('store');
            Route::get('{uso}/edit',  [UsoVehiculoController::class, 'edit'])->name('edit');
            Route::put('{uso}',       [UsoVehiculoController::class, 'update'])->name('update');
            Route::delete('{uso}',    [UsoVehiculoController::class, 'destroy'])->name('destroy');
            Route::get('export-excel',[UsoVehiculoController::class, 'exportExcel'])->name('exportExcel');
            Route::get('export-pdf',  [UsoVehiculoController::class, 'exportPDF'])->name('exportPDF');
        });

        Route::prefix('{vehiculo}/evidencia')->name('vehiculos.evidencia.')->group(function () {
            Route::get('/',                  [EvidenciaVehiculoController::class, 'index'])->name('index');
            Route::get('create',             [EvidenciaVehiculoController::class, 'create'])->name('create');
            Route::post('/',                 [EvidenciaVehiculoController::class, 'store'])->name('store');
            Route::delete('{evidencia}',     [EvidenciaVehiculoController::class, 'destroy'])->name('destroy');
            Route::get('export-excel',       [EvidenciaVehiculoController::class, 'exportExcel'])->name('exportExcel');
            Route::get('export-pdf',         [EvidenciaVehiculoController::class, 'exportPDF'])->name('exportPDF');
        });
    });

    // DESARROLLO DE SOFTWARE Y SUBMÓDULOS
    Route::get('desarrollo_software/export-excel', [DesarrolloSoftwareController::class, 'exportExcel'])
        ->name('desarrollo_software.export.excel');
    Route::get('desarrollo_software/export-pdf',   [DesarrolloSoftwareController::class, 'exportPDF'])
        ->name('desarrollo_software.export.pdf');
    Route::resource('desarrollo_software', DesarrolloSoftwareController::class);

    Route::prefix('desarrollo_software/{proyecto}/modulos')->name('modulos_software.')->group(function () {
        Route::get('/',                    [ModuloSoftwareController::class, 'index'])->name('index');
        Route::get('create',               [ModuloSoftwareController::class, 'create'])->name('create');
        Route::post('/',                   [ModuloSoftwareController::class, 'store'])->name('store');
        Route::get('{modulo}/edit',        [ModuloSoftwareController::class, 'edit'])->name('edit');
        Route::put('{modulo}',             [ModuloSoftwareController::class, 'update'])->name('update');
        Route::delete('{modulo}',          [ModuloSoftwareController::class, 'destroy'])->name('destroy');

        Route::get('{modulo}/entregas',    [EntregaModuloController::class, 'index'])->name('entregas.index');
        Route::get('{modulo}/entregas/create',[EntregaModuloController::class, 'create'])->name('entregas.create');
        Route::post('{modulo}/entregas',   [EntregaModuloController::class, 'store'])->name('entregas.store');
        Route::delete('{modulo}/entregas/{entrega}',[EntregaModuloController::class, 'destroy'])->name('entregas.destroy');

        Route::get('{modulo}/feedback',    [FeedbackClienteController::class, 'index'])->name('feedback.index');
        Route::post('{modulo}/feedback',   [FeedbackClienteController::class, 'store'])->name('feedback.store');
        Route::delete('{modulo}/feedback/{feedback}',[FeedbackClienteController::class, 'destroy'])->name('feedback.destroy');
    });

    // SERVICIOS EMPRESARIALES
    Route::resource('servicios_empresariales', ServicioEmpresarialController::class);
    Route::get('servicios_empresariales/export-excel', [ServicioEmpresarialController::class, 'exportExcel'])
        ->name('servicios_empresariales.export.excel');
    Route::get('servicios_empresariales/export-pdf',   [ServicioEmpresarialController::class, 'exportPDF'])
        ->name('servicios_empresariales.export.pdf');

    // RECURSOS HUMANOS
    Route::resource('recursos_humanos', EmpleadoController::class);
    Route::get('recursos_humanos/export-excel', [EmpleadoController::class, 'exportExcel'])
        ->name('recursos_humanos.export.excel');
    Route::get('recursos_humanos/export-pdf',   [EmpleadoController::class, 'exportPDF'])
        ->name('recursos_humanos.export.pdf');

    Route::prefix('recursos_humanos/{empleado}')->name('recursos_humanos.')->group(function () {
        Route::resource('permisos', PermisoEmpleadoController::class);
        Route::resource('asistencias', AsistenciaController::class);
        Route::resource('nominas', NominaController::class);
        Route::resource('documentos', DocumentoEmpleadoController::class)->except(['show']);
    });

    // CUENTAS POR COBRAR
    Route::get('cuentas_por_cobrar/export-excel', [CuentasPorCobrarController::class, 'exportExcel'])
        ->name('cuentas_por_cobrar.export.excel');
    Route::get('cuentas_por_cobrar/export-pdf',   [CuentasPorCobrarController::class, 'exportPDF'])
        ->name('cuentas_por_cobrar.export.pdf');
    Route::post('cuentas_por_cobrar/{id}/cobros',       [CuentasPorCobrarController::class, 'registrarCobro'])
        ->name('cuentas_por_cobrar.cobros');
    Route::post('cuentas_por_cobrar/{id}/seguimientos',[CuentasPorCobrarController::class, 'registrarSeguimiento'])
        ->name('cuentas_por_cobrar.seguimientos');
    Route::resource('cuentas_por_cobrar', CuentasPorCobrarController::class);

    // CUENTAS POR PAGAR, PAGOS Y SEGUIMIENTOS
    Route::resource('cuentas_por_pagar', CuentasPorPagarController::class);
    Route::resource('gastos_fijos', GastoFijoController::class);
    Route::prefix('cuentas_por_pagar/{cuenta_pagar}')->group(function () {
        Route::get('pagos/create',         [PagoCxpController::class, 'create'])->name('pagos_cxp.create');
        Route::post('pagos',               [PagoCxpController::class, 'store'])->name('pagos_cxp.store');
        Route::get('seguimientos/create',  [SeguimientoCxpController::class, 'create'])->name('seguimientos_cxp.create');
        Route::post('seguimientos',        [SeguimientoCxpController::class, 'store'])->name('seguimientos_cxp.store');
    });
    Route::resource('pagos_cxp', PagoCxpController::class)->except(['create','store','index']);
    Route::resource('seguimientos_cxp', SeguimientoCxpController::class)->except(['create','store','index']);
    Route::get('agenda_pagos', [CuentasPorPagarController::class, 'agenda'])
        ->name('agenda_pagos.index');

    // CONTABILIDAD
    Route::get('contabilidad', [ContabilidadController::class, 'index'])->name('contabilidad.index');
    Route::resource('diario_contable', DiarioContableController::class);
    Route::resource('polizas_contables', PolizaContableController::class);
    Route::resource('cuentas_contables', CuentaContableController::class);

    // CRUD GENERALES BÁSICOS
    Route::resource('clientes', ClienteController::class);
    Route::resource('ventas', VentaController::class);
    Route::resource('ventas.detalle_ventas', DetalleVentaController::class);
    Route::resource('taller', TallerController::class);
    Route::resource('equipos', EquipoController::class);
    Route::resource('cableado', CableadoController::class);
    Route::resource('vehiculos', VehiculoController::class);
    Route::resource('finanzas', FinanzasController::class)->only(['index']);
    Route::resource('puestos_empleado', PuestoEmpleadoController::class)->except(['show']);

    // CRÉDITOS Y DOCUMENTOS DE CRÉDITO
    Route::resource('creditos', CreditoController::class);
    Route::resource('documentos_credito', DocumentoCreditoController::class)->only(['store','destroy']);

    // PROVEEDORES, COMPRAS Y PUNTO DE VENTA
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('compras', CompraController::class);
    Route::resource('punto_venta', PuntoVentaMovimientoController::class);

    Route::resource('personal', PersonalController::class);
    Route::resource('datos-fiscales', DatoFiscalClienteController::class);

    // ---------------------------
    //   INVENTARIO (NUEVO MODULO)
    // ---------------------------
    Route::resource('inventario', InventarioController::class);
    Route::get('inventario-export-excel', [InventarioController::class, 'exportExcel'])->name('inventario.export.excel');
    Route::get('inventario-export-pdf',   [InventarioController::class, 'exportPDF'])->name('inventario.export.pdf');
});

// Autenticación (login, registro, etc)
require __DIR__.'/auth.php';
