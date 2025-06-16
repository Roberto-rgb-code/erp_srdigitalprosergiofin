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
use App\Http\Controllers\ServicioEmpresarialController;
use App\Http\Controllers\FinanzasController;
use App\Http\Controllers\CuentasPorCobrarController;
use App\Http\Controllers\CuentasPorPagarController;
use App\Http\Controllers\ContabilidadController;
use App\Http\Controllers\RecursosHumanosController;

// HOME
Route::get('/', fn() => redirect('/dashboard'));
Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');

// --- EXPORTS Y RUTAS PERSONALIZADAS ANTES DE RESOURCE ---

// Clientes
Route::get('clientes/export-excel', [ClienteController::class, 'exportExcel'])->name('clientes.exportExcel');
Route::get('clientes/export-pdf', [ClienteController::class, 'exportPDF'])->name('clientes.exportPDF');

// Ventas
Route::get('ventas/export-excel', [VentaController::class, 'exportExcel'])->name('ventas.exportExcel');
Route::get('ventas/export-pdf', [VentaController::class, 'exportPDF'])->name('ventas.exportPDF');
Route::get('ventas/{venta}/factura', [VentaController::class, 'factura'])->name('ventas.factura');

// Detalle de ventas
Route::get('ventas/{venta}/detalle_ventas/export-excel', [DetalleVentaController::class, 'exportExcel'])->name('ventas.detalle_ventas.exportExcel');
Route::get('ventas/{venta}/detalle_ventas/export-pdf', [DetalleVentaController::class, 'exportPDF'])->name('ventas.detalle_ventas.exportPDF');

// Taller y Equipos
Route::get('taller/export-excel', [TallerController::class, 'exportExcel'])->name('taller.exportExcel');
Route::get('taller/export-pdf', [TallerController::class, 'exportPDF'])->name('taller.exportPDF');

// Cableado
Route::get('cableado/export-excel', [CableadoController::class, 'exportExcel'])->name('cableado.exportExcel');
Route::get('cableado/export-pdf', [CableadoController::class, 'exportPDF'])->name('cableado.exportPDF');

// Vehículos - Export general
Route::get('vehiculos/export-excel', [VehiculoController::class, 'exportExcel'])->name('vehiculos.exportExcel');
Route::get('vehiculos/export-pdf', [VehiculoController::class, 'exportPDF'])->name('vehiculos.exportPDF');

// Vehículos - Submódulos: consumo, mantenimiento, uso, evidencia
Route::get('vehiculos/{vehiculo}/consumo/export-excel', [ConsumoCombustibleController::class, 'exportExcel'])->name('vehiculos.consumo.exportExcel');
Route::get('vehiculos/{vehiculo}/consumo/export-pdf', [ConsumoCombustibleController::class, 'exportPDF'])->name('vehiculos.consumo.exportPDF');

Route::get('vehiculos/{vehiculo}/mantenimiento/export-excel', [MantenimientoVehiculoController::class, 'exportExcel'])->name('vehiculos.mantenimiento.exportExcel');
Route::get('vehiculos/{vehiculo}/mantenimiento/export-pdf', [MantenimientoVehiculoController::class, 'exportPDF'])->name('vehiculos.mantenimiento.exportPDF');

Route::get('vehiculos/{vehiculo}/uso/export-excel', [UsoVehiculoController::class, 'exportExcel'])->name('vehiculos.uso.exportExcel');
Route::get('vehiculos/{vehiculo}/uso/export-pdf', [UsoVehiculoController::class, 'exportPDF'])->name('vehiculos.uso.exportPDF');

Route::get('vehiculos/{vehiculo}/evidencia/export-excel', [EvidenciaVehiculoController::class, 'exportExcel'])->name('vehiculos.evidencia.exportExcel');
Route::get('vehiculos/{vehiculo}/evidencia/export-pdf', [EvidenciaVehiculoController::class, 'exportPDF'])->name('vehiculos.evidencia.exportPDF');

// --- RESOURCE CONTROLLERS ---

Route::resource('clientes', ClienteController::class);
Route::resource('ventas', VentaController::class);
Route::resource('ventas.detalle_ventas', DetalleVentaController::class);
Route::resource('taller', TallerController::class);
Route::resource('equipos', EquipoController::class);
Route::resource('cableado', CableadoController::class);
Route::resource('vehiculos', VehiculoController::class);

// Vehículos - Submódulos con prefix y names
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

// Resto de módulos
Route::resource('desarrollo_software', DesarrolloSoftwareController::class);
Route::resource('servicios_empresariales', ServicioEmpresarialController::class);
Route::resource('finanzas', FinanzasController::class)->only(['index']);
Route::resource('cuentas_por_cobrar', CuentasPorCobrarController::class);
Route::resource('cuentas_por_pagar', CuentasPorPagarController::class);
Route::resource('contabilidad', ContabilidadController::class)->only(['index']);
Route::resource('recursos_humanos', RecursosHumanosController::class);
