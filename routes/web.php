<?php

use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PuestoEmpleadoController;
use App\Http\Controllers\PermisoEmpleadoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\DocumentoEmpleadoController;

// HOME/DASHBOARD
Route::get('/', fn() => redirect('/dashboard'));
Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');

// --- EXPORTACIONES (antes de los resource) ---
// Clientes
Route::get('clientes/export-excel', [ClienteController::class, 'exportExcel'])->name('clientes.export.excel');
Route::get('clientes/export-pdf', [ClienteController::class, 'exportPDF'])->name('clientes.export.pdf');

// Ventas
Route::get('ventas/export-excel', [VentaController::class, 'exportExcel'])->name('ventas.export.excel');
Route::get('ventas/export-pdf', [VentaController::class, 'exportPDF'])->name('ventas.export.pdf');
Route::get('ventas/{venta}/factura', [VentaController::class, 'factura'])->name('ventas.factura');

// Detalle ventas
Route::get('ventas/{venta}/detalle_ventas/export-excel', [DetalleVentaController::class, 'exportExcel'])->name('ventas.detalle_ventas.export.excel');
Route::get('ventas/{venta}/detalle_ventas/export-pdf', [DetalleVentaController::class, 'exportPDF'])->name('ventas.detalle_ventas.export.pdf');

// Taller
Route::get('taller/export-excel', [TallerController::class, 'exportExcel'])->name('taller.export.excel');
Route::get('taller/export-pdf', [TallerController::class, 'exportPDF'])->name('taller.export.pdf');

// Cableado
Route::get('cableado/export-excel', [CableadoController::class, 'exportExcel'])->name('cableado.export.excel');
Route::get('cableado/export-pdf', [CableadoController::class, 'exportPDF'])->name('cableado.export.pdf');

// Vehículos y submódulos
Route::get('vehiculos/export-excel', [VehiculoController::class, 'exportExcel'])->name('vehiculos.export.excel');
Route::get('vehiculos/export-pdf', [VehiculoController::class, 'exportPDF'])->name('vehiculos.export.pdf');

Route::get('vehiculos/{vehiculo}/consumo/export-excel', [ConsumoCombustibleController::class, 'exportExcel'])->name('vehiculos.consumo.export.excel');
Route::get('vehiculos/{vehiculo}/consumo/export-pdf', [ConsumoCombustibleController::class, 'exportPDF'])->name('vehiculos.consumo.export.pdf');

Route::get('vehiculos/{vehiculo}/mantenimiento/export-excel', [MantenimientoVehiculoController::class, 'exportExcel'])->name('vehiculos.mantenimiento.export.excel');
Route::get('vehiculos/{vehiculo}/mantenimiento/export-pdf', [MantenimientoVehiculoController::class, 'exportPDF'])->name('vehiculos.mantenimiento.export.pdf');

Route::get('vehiculos/{vehiculo}/uso/export-excel', [UsoVehiculoController::class, 'exportExcel'])->name('vehiculos.uso.export.excel');
Route::get('vehiculos/{vehiculo}/uso/export-pdf', [UsoVehiculoController::class, 'exportPDF'])->name('vehiculos.uso.export.pdf');

Route::get('vehiculos/{vehiculo}/evidencia/export-excel', [EvidenciaVehiculoController::class, 'exportExcel'])->name('vehiculos.evidencia.export.excel');
Route::get('vehiculos/{vehiculo}/evidencia/export-pdf', [EvidenciaVehiculoController::class, 'exportPDF'])->name('vehiculos.evidencia.export.pdf');

// Desarrollo de software
Route::get('desarrollo_software/export-excel', [DesarrolloSoftwareController::class, 'exportExcel'])->name('desarrollo_software.export.excel');
Route::get('desarrollo_software/export-pdf', [DesarrolloSoftwareController::class, 'exportPDF'])->name('desarrollo_software.export.pdf');

// Recursos Humanos
Route::get('recursos_humanos/export-excel', [EmpleadoController::class, 'exportExcel'])->name('recursos_humanos.export.excel');
Route::get('recursos_humanos/export-pdf', [EmpleadoController::class, 'exportPDF'])->name('recursos_humanos.export.pdf');

// --- CRUD PRINCIPALES ---
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
Route::resource('cuentas_por_cobrar', CuentasPorCobrarController::class);
Route::resource('cuentas_por_pagar', CuentasPorPagarController::class);
Route::resource('contabilidad', ContabilidadController::class)->only(['index']);
Route::resource('recursos_humanos', EmpleadoController::class);
Route::resource('puestos_empleado', PuestoEmpleadoController::class)->except(['show']);

// VEHÍCULOS: SUBMÓDULOS
Route::prefix('vehiculos/{vehiculo}/consumo')->name('vehiculos.consumo.')->group(function () {
    Route::get('/', [ConsumoCombustibleController::class, 'index'])->name('index');
    Route::get('create', [ConsumoCombustibleController::class, 'create'])->name('create');
    Route::post('/', [ConsumoCombustibleController::class, 'store'])->name('store');
    Route::get('{consumo}/edit', [ConsumoCombustibleController::class, 'edit'])->name('edit');
    Route::put('{consumo}', [ConsumoCombustibleController::class, 'update'])->name('update');
    Route::delete('{consumo}', [ConsumoCombustibleController::class, 'destroy'])->name('destroy');
});
Route::prefix('vehiculos/{vehiculo}/mantenimiento')->name('vehiculos.mantenimiento.')->group(function () {
    Route::get('/', [MantenimientoVehiculoController::class, 'index'])->name('index');
    Route::get('create', [MantenimientoVehiculoController::class, 'create'])->name('create');
    Route::post('/', [MantenimientoVehiculoController::class, 'store'])->name('store');
    Route::get('{mantenimiento}/edit', [MantenimientoVehiculoController::class, 'edit'])->name('edit');
    Route::put('{mantenimiento}', [MantenimientoVehiculoController::class, 'update'])->name('update');
    Route::delete('{mantenimiento}', [MantenimientoVehiculoController::class, 'destroy'])->name('destroy');
});
Route::prefix('vehiculos/{vehiculo}/uso')->name('vehiculos.uso.')->group(function () {
    Route::get('/', [UsoVehiculoController::class, 'index'])->name('index');
    Route::get('create', [UsoVehiculoController::class, 'create'])->name('create');
    Route::post('/', [UsoVehiculoController::class, 'store'])->name('store');
    Route::get('{uso}/edit', [UsoVehiculoController::class, 'edit'])->name('edit');
    Route::put('{uso}', [UsoVehiculoController::class, 'update'])->name('update');
    Route::delete('{uso}', [UsoVehiculoController::class, 'destroy'])->name('destroy');
});
Route::prefix('vehiculos/{vehiculo}/evidencia')->name('vehiculos.evidencia.')->group(function () {
    Route::get('/', [EvidenciaVehiculoController::class, 'index'])->name('index');
    Route::get('create', [EvidenciaVehiculoController::class, 'create'])->name('create');
    Route::post('/', [EvidenciaVehiculoController::class, 'store'])->name('store');
    Route::delete('{evidencia}', [EvidenciaVehiculoController::class, 'destroy'])->name('destroy');
});

// DESARROLLO DE SOFTWARE: SUBMÓDULOS
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

// RECURSOS HUMANOS: SUBMÓDULOS
Route::prefix('recursos_humanos/{empleado}')->name('recursos_humanos.')->group(function () {
    Route::resource('permisos', PermisoEmpleadoController::class);
    Route::resource('asistencias', AsistenciaController::class);
    Route::resource('nominas', NominaController::class);
    Route::resource('documentos', DocumentoEmpleadoController::class)->except(['show']);
});
