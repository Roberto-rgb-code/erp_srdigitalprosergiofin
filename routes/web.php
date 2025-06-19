<?php

use Illuminate\Support\Facades\Route;

// 1. CONTROLADORES PRINCIPALES
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
use App\Http\Controllers\PolizaServicioController;
use App\Http\Controllers\InventarioClienteController;
use App\Http\Controllers\UsuarioClienteController;
use App\Http\Controllers\ConfiguracionClienteController;
use App\Http\Controllers\TicketSoporteController;
use App\Http\Controllers\SeguimientoTicketController;
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

// 2. HOME Y DASHBOARD
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});
Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard')->middleware('auth');

// 3. RUTAS PROTEGIDAS (AUTENTICACIÓN)
Route::middleware(['auth'])->group(function () {

    // ------ EXPORTACIONES Y REPORTES ------
    Route::get('clientes/export-excel', [ClienteController::class, 'exportExcel'])->name('clientes.export.excel');
    Route::get('clientes/export-pdf', [ClienteController::class, 'exportPDF'])->name('clientes.export.pdf');

    Route::get('ventas/export-excel', [VentaController::class, 'exportExcel'])->name('ventas.export.excel');
    Route::get('ventas/export-pdf', [VentaController::class, 'exportPDF'])->name('ventas.export.pdf');
    Route::get('ventas/{venta}/factura', [VentaController::class, 'facturaPDF'])->name('ventas.factura');
    Route::get('ventas/{venta}/detalle_ventas/export-excel', [DetalleVentaController::class, 'exportExcel'])->name('ventas.detalle_ventas.export.excel');
    Route::get('ventas/{venta}/detalle_ventas/export-pdf', [DetalleVentaController::class, 'exportPDF'])->name('ventas.detalle_ventas.export.pdf');

    // Taller
    Route::get('taller/export-excel', [TallerController::class, 'exportExcel'])->name('taller.export.excel');
    Route::get('taller/export-pdf', [TallerController::class, 'exportPDF'])->name('taller.export.pdf');

    // Cableado
    Route::get('cableado/export-excel', [CableadoController::class, 'exportExcel'])->name('cableado.export.excel');
    Route::get('cableado/export-pdf', [CableadoController::class, 'exportPDF'])->name('cableado.export.pdf');

    // ------ VEHÍCULOS Y SUBMÓDULOS ------
    Route::get('vehiculos/export-excel', [VehiculoController::class, 'exportExcel'])->name('vehiculos.export.excel');
    Route::get('vehiculos/export-pdf', [VehiculoController::class, 'exportPDF'])->name('vehiculos.export.pdf');

    // Consumo Combustible
    Route::prefix('vehiculos/{vehiculo}/consumo')->name('vehiculos.consumo.')->group(function () {
        Route::get('/', [ConsumoCombustibleController::class, 'index'])->name('index');
        Route::get('create', [ConsumoCombustibleController::class, 'create'])->name('create');
        Route::post('/', [ConsumoCombustibleController::class, 'store'])->name('store');
        Route::get('{consumo}/edit', [ConsumoCombustibleController::class, 'edit'])->name('edit');
        Route::put('{consumo}', [ConsumoCombustibleController::class, 'update'])->name('update');
        Route::delete('{consumo}', [ConsumoCombustibleController::class, 'destroy'])->name('destroy');
        Route::get('export-excel', [ConsumoCombustibleController::class, 'exportExcel'])->name('exportExcel');
        Route::get('export-pdf', [ConsumoCombustibleController::class, 'exportPDF'])->name('exportPDF');
    });

    // Mantenimiento Vehículo
    Route::prefix('vehiculos/{vehiculo}/mantenimiento')->name('vehiculos.mantenimiento.')->group(function () {
        Route::get('/', [MantenimientoVehiculoController::class, 'index'])->name('index');
        Route::get('create', [MantenimientoVehiculoController::class, 'create'])->name('create');
        Route::post('/', [MantenimientoVehiculoController::class, 'store'])->name('store');
        Route::get('{mantenimiento}/edit', [MantenimientoVehiculoController::class, 'edit'])->name('edit');
        Route::put('{mantenimiento}', [MantenimientoVehiculoController::class, 'update'])->name('update');
        Route::delete('{mantenimiento}', [MantenimientoVehiculoController::class, 'destroy'])->name('destroy');
        Route::get('export-excel', [MantenimientoVehiculoController::class, 'exportExcel'])->name('exportExcel');
        Route::get('export-pdf', [MantenimientoVehiculoController::class, 'exportPDF'])->name('exportPDF');
    });

    // Uso Vehículo
    Route::prefix('vehiculos/{vehiculo}/uso')->name('vehiculos.uso.')->group(function () {
        Route::get('/', [UsoVehiculoController::class, 'index'])->name('index');
        Route::get('create', [UsoVehiculoController::class, 'create'])->name('create');
        Route::post('/', [UsoVehiculoController::class, 'store'])->name('store');
        Route::get('{uso}/edit', [UsoVehiculoController::class, 'edit'])->name('edit');
        Route::put('{uso}', [UsoVehiculoController::class, 'update'])->name('update');
        Route::delete('{uso}', [UsoVehiculoController::class, 'destroy'])->name('destroy');
        Route::get('export-excel', [UsoVehiculoController::class, 'exportExcel'])->name('exportExcel');
        Route::get('export-pdf', [UsoVehiculoController::class, 'exportPDF'])->name('exportPDF');
    });

    // Evidencia Vehículo
    Route::prefix('vehiculos/{vehiculo}/evidencia')->name('vehiculos.evidencia.')->group(function () {
        Route::get('/', [EvidenciaVehiculoController::class, 'index'])->name('index');
        Route::get('create', [EvidenciaVehiculoController::class, 'create'])->name('create');
        Route::post('/', [EvidenciaVehiculoController::class, 'store'])->name('store');
        Route::delete('{evidencia}', [EvidenciaVehiculoController::class, 'destroy'])->name('destroy');
        Route::get('export-excel', [EvidenciaVehiculoController::class, 'exportExcel'])->name('exportExcel');
        Route::get('export-pdf', [EvidenciaVehiculoController::class, 'exportPDF'])->name('exportPDF');
    });

    // ------ DESARROLLO SOFTWARE ------
    Route::get('desarrollo_software/export-excel', [DesarrolloSoftwareController::class, 'exportExcel'])->name('desarrollo_software.export.excel');
    Route::get('desarrollo_software/export-pdf', [DesarrolloSoftwareController::class, 'exportPDF'])->name('desarrollo_software.export.pdf');

    // ------ SERVICIOS EMPRESARIALES ------
    Route::get('servicios_empresariales/export-excel', [ServicioEmpresarialController::class, 'exportExcel'])->name('servicios_empresariales.export.excel');
    Route::get('servicios_empresariales/export-pdf', [ServicioEmpresarialController::class, 'exportPDF'])->name('servicios_empresariales.export.pdf');

    // ------ INVENTARIO GLOBAL (opcional) ------
    Route::resource('inventario_clientes', InventarioClienteController::class);

    // ------ SERVICIOS EMPRESARIALES: SUBMÓDULOS ------
    Route::resource('servicios_empresariales.inventarios', InventarioClienteController::class);
    Route::resource('servicios_empresariales.usuarios_clientes', UsuarioClienteController::class);
    Route::resource('servicios_empresariales.configuraciones_clientes', ConfiguracionClienteController::class);
    Route::resource('servicios_empresariales.tickets_soporte', TicketSoporteController::class);
    Route::resource('servicios_empresariales.seguimientos_ticket', SeguimientoTicketController::class);

    // ------ TICKETS SOPORTE ------
    Route::get('tickets_soporte/export-excel', [TicketSoporteController::class, 'exportExcel'])->name('tickets_soporte.export.excel');
    Route::get('tickets_soporte/export-pdf', [TicketSoporteController::class, 'exportPDF'])->name('tickets_soporte.export.pdf');

    // ------ RECURSOS HUMANOS ------
    Route::get('recursos_humanos/export-excel', [EmpleadoController::class, 'exportExcel'])->name('recursos_humanos.export.excel');
    Route::get('recursos_humanos/export-pdf', [EmpleadoController::class, 'exportPDF'])->name('recursos_humanos.export.pdf');

    // ------ CUENTAS POR COBRAR/PAGAR ------
    Route::get('cuentas_por_cobrar/export-excel', [CuentasPorCobrarController::class, 'exportExcel'])->name('cuentas_por_cobrar.export.excel');
    Route::get('cuentas_por_cobrar/export-pdf', [CuentasPorCobrarController::class, 'exportPDF'])->name('cuentas_por_cobrar.export.pdf');
    Route::post('cuentas_por_cobrar/{id}/cobros', [CuentasPorCobrarController::class, 'registrarCobro'])->name('cuentas_por_cobrar.cobros');
    Route::post('cuentas_por_cobrar/{id}/seguimientos', [CuentasPorCobrarController::class, 'registrarSeguimiento'])->name('cuentas_por_cobrar.seguimientos');
    Route::resource('cuentas_por_cobrar', CuentasPorCobrarController::class);

    Route::get('cuentas_por_pagar/export-excel', [CuentasPorPagarController::class, 'exportExcel'])->name('cuentas_por_pagar.export.excel');
    Route::get('cuentas_por_pagar/export-pdf', [CuentasPorPagarController::class, 'exportPDF'])->name('cuentas_por_pagar.export.pdf');
    Route::post('cuentas_por_pagar/{id}/registrar-pago', [CuentasPorPagarController::class, 'registrarPago'])->name('cuentas_por_pagar.registrarPago');
    Route::post('cuentas_por_pagar/{id}/registrar-seguimiento', [CuentasPorPagarController::class, 'registrarSeguimiento'])->name('cuentas_por_pagar.registrarSeguimiento');
    Route::resource('cuentas_por_pagar', CuentasPorPagarController::class);

    // ------ CONTABILIDAD ------
    Route::get('contabilidad', [ContabilidadController::class, 'index'])->name('contabilidad.index');
    Route::resource('diario_contable', DiarioContableController::class);
    Route::resource('polizas_contables', PolizaContableController::class);
    Route::resource('cuentas_contables', CuentaContableController::class);

    // ------ CRUD PRINCIPALES ------
    Route::resource('clientes', ClienteController::class);
    Route::resource('ventas', VentaController::class);
    Route::resource('ventas.detalle_ventas', DetalleVentaController::class);
    Route::resource('taller', TallerController::class);
    Route::resource('equipos', EquipoController::class);
    Route::resource('cableado', CableadoController::class);
    Route::resource('vehiculos', VehiculoController::class);
    Route::resource('desarrollo_software', DesarrolloSoftwareController::class);
    Route::resource('servicios_empresariales', ServicioEmpresarialController::class);
    Route::resource('finanzas', FinanzasController::class)->only(['index']);
    Route::resource('recursos_humanos', EmpleadoController::class);
    Route::resource('puestos_empleado', PuestoEmpleadoController::class)->except(['show']);

    // ------ SUBMÓDULOS DESARROLLO SOFTWARE ------
    Route::prefix('desarrollo_software/{proyecto}/modulos')->name('modulos_software.')->group(function () {
        Route::get('/', [ModuloSoftwareController::class, 'index'])->name('index');
        Route::get('create', [ModuloSoftwareController::class, 'create'])->name('create');
        Route::post('/', [ModuloSoftwareController::class, 'store'])->name('store');
        Route::get('{modulo}/edit', [ModuloSoftwareController::class, 'edit'])->name('edit');
        Route::put('{modulo}', [ModuloSoftwareController::class, 'update'])->name('update');
        Route::delete('{modulo}', [ModuloSoftwareController::class, 'destroy'])->name('destroy');
        // Entregas de módulo
        Route::get('{modulo}/entregas', [EntregaModuloController::class, 'index'])->name('entregas.index');
        Route::get('{modulo}/entregas/create', [EntregaModuloController::class, 'create'])->name('entregas.create');
        Route::post('{modulo}/entregas', [EntregaModuloController::class, 'store'])->name('entregas.store');
        Route::delete('{modulo}/entregas/{entrega}', [EntregaModuloController::class, 'destroy'])->name('entregas.destroy');
        // Feedback de cliente
        Route::get('{modulo}/feedback', [FeedbackClienteController::class, 'index'])->name('feedback.index');
        Route::post('{modulo}/feedback', [FeedbackClienteController::class, 'store'])->name('feedback.store');
        Route::delete('{modulo}/feedback/{feedback}', [FeedbackClienteController::class, 'destroy'])->name('feedback.destroy');
    });

    // ------ SUBMÓDULOS RECURSOS HUMANOS ------
    Route::prefix('recursos_humanos/{empleado}')->name('recursos_humanos.')->group(function () {
        Route::resource('permisos', PermisoEmpleadoController::class);
        Route::resource('asistencias', AsistenciaController::class);
        Route::resource('nominas', NominaController::class);
        Route::resource('documentos', DocumentoEmpleadoController::class)->except(['show']);
    });

    // ------ POLIZAS SERVICIOS EMPRESARIALES ------
    Route::resource('polizas', PolizaServicioController::class);

    // ------ FINANZAS ------
    Route::resource('ingresos', App\Http\Controllers\IngresoController::class);
    Route::resource('egresos', App\Http\Controllers\EgresoController::class);
    Route::resource('cuentas_bancarias', App\Http\Controllers\CuentaBancariaController::class);
    Route::resource('caja_chica', App\Http\Controllers\CajaChicaController::class);

    // --- ENDPOINT PARA DATOS DE GRÁFICO ---
Route::get('/api/graficos/cuentas_por_cobrar', [\App\Http\Controllers\CuentasPorCobrarController::class, 'graficoCuentasPorCobrar'])
->name('api.graficos.cuentas_por_cobrar');

// API para gráfico de Cuentas por Pagar
Route::get('api/graficos/cuentas_por_pagar', [\App\Http\Controllers\CuentasPorPagarController::class, 'grafico'])->name('api.graficos.cuentas_por_pagar');



    // ------ INVENTARIO GLOBAL (opcional, descomenta si lo necesitas como acceso general) ------
    // Route::resource('inventario_clientes', InventarioClienteController::class);

});

require __DIR__.'/auth.php'; // Si usas Breeze, Fortify, Jetstream, etc.
