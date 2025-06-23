<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\EstadoCuentaController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\QRGeneradoController;
use App\Http\Controllers\PagoEmpleadoController;
use App\Http\Controllers\CheckGuardiaController;
use App\Http\Controllers\ReporteGuardiaController;
use App\Http\Controllers\ReporteIncidenteGuardiaController;
use App\Http\Controllers\ReporteSupervisorController;
use App\Http\Controllers\ReporteBitacoraController;
use App\Http\Controllers\ReportePatrullaController;
use App\Http\Controllers\VehiculoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/api/pdf/reporte-horas-trabajadas', [CheckGuardiaController::class, 'reporteHorasPDF']);
Route::get('/api/pdf/pagos-empleados/{id}', [PagoEmpleadoController::class, 'generarPdf']);
Route::get('/api/pdf/estado-cuenta-guardias', [EstadoCuentaController::class, 'generarPdfEstadoCuentaGuardia']);
Route::get('/api/pdf/estado-cuenta-clientes', [EstadoCuentaController::class, 'generarPdfEstadoCuentaCliente']);
Route::get('/api/pdf/estado-cuenta-proveedores', [EstadoCuentaController::class, 'generarPdfEstadoCuentaProveedor']);
Route::get('/api/pdf/estado-cuenta-bancos', [EstadoCuentaController::class, 'generarPdfEstadoCuentaBanco']);
Route::get('/api/pdf/cotizacion/{id}', [CotizacionController::class, 'generarPDF']);
Route::get('/ordenes-servicio/{id}/pdf-qrs', [QRGeneradoController::class, 'generarPdf'])->name('pdf.qrs_recorrido');
Route::get('/api/pdf/reporte-check-guardia/{id}', [CheckGuardiaController::class, 'generarReporteCheckGuardia']);
Route::get('/api/pdf/reporte-incidente-guardia/{id}', [ReporteIncidenteGuardiaController::class, 'generarReporteIncidente']);
Route::get('/api/pdf/reporte-guardia/{id}', [ReporteGuardiaController::class, 'generarReporteGuardia']);
Route::get('/api/pdf/reporte-supervisor/{id}', [ReporteSupervisorController::class, 'generarReporteSupervisor']);
Route::get('/api/pdf/reporte-bitacoras/{id}', [ReporteBitacoraController::class, 'generarReporteBitacora']);
Route::get('/api/pdf/reporte-patrullas/{id}', [ReportePatrullaController::class, 'generarReportePatrulla']);

Route::get('/vehiculos/descargar-zip/{vehiculo}',[VehiculoController::class, 'descargarZip'])->name('vehiculos.descargarZip');

// Route::get('/cmd/{command}', function($command){
//     Artisan::call($command);
//     dd(Artisan::output());
// });

Route::get('/{any}', function () {
    return File::get(public_path('index.html'));
})->where('any', '.*');
