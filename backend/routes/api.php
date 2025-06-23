<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\GuardiaController;
use App\Http\Controllers\RecursosHumanosController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\MovimientoBancarioController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\OrdenCompraController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\VentaHistorialController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\AlmacenEntradaController;
use App\Http\Controllers\AlmacenSalidaController;
use App\Http\Controllers\EquipamientoController;
use App\Http\Controllers\OrdenServicioController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ReporteCarteraVencidaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\IncapacidadController;
use App\Http\Controllers\VacacionController;
use App\Http\Controllers\TiempoExtraController;
use App\Http\Controllers\FaltaController;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\AbonoPrestamoController;
use App\Http\Controllers\EstadoCuentaController;
use App\Http\Controllers\SucursalEmpresaController;
use App\Http\Controllers\ModuloPrestamoController;
use App\Http\Controllers\ModuloDescuentoController;
use App\Http\Controllers\ModuloConceptoController;
use App\Http\Controllers\BlackListController;
use App\Http\Controllers\BoletaGasolinaController;
use App\Http\Controllers\QRGeneradoController;
use App\Http\Controllers\QRRecorridoGuardiaController;
use App\Http\Controllers\PagoEmpleadoController;
use App\Http\Controllers\CheckGuardiaController;
use App\Http\Controllers\ReporteGuardiaController;
use App\Http\Controllers\ReporteIncidenteGuardiaController;
use App\Http\Controllers\ReporteSupervisorController;
use App\Http\Controllers\ReportePatrullaController;
use App\Http\Controllers\ReporteBitacoraController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Login y pre-registro
Route::post('/login', [AuthController::class, 'login']);
Route::post('/registro', [UsuarioController::class, 'registro']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Rutas que vienen de la app movil
Route::get('guardias-app', [GuardiaController::class, 'getGuardiaApp']);
Route::get('orden-servicio-app', [OrdenServicioController::class, 'ordenServicioGuardia']);
Route::apiResource('recorridos-guardia', QRRecorridoGuardiaController::class);
Route::get('qr-validar/{uuid}', [QRRecorridoGuardiaController::class, 'validar']);
Route::apiResource('check-guardia', CheckGuardiaController::class);
Route::get('/check-guardia/abierto/{guardiaId}', [CheckGuardiaController::class, 'ultimoCheckAbierto']);
Route::post('/check-guardia-eventual', [CheckGuardiaController::class, 'createGuardiaEventual']);
Route::get('/check-guardia-eventual/abierto/{nombreGuardia}', [CheckGuardiaController::class, 'ultimoCheckAbiertoEventual']);
Route::apiResource('reporte-guardia', ReporteGuardiaController::class);
Route::apiResource('reporte-supervisor', ReporteSupervisorController::class);
Route::apiResource('reporte-incidente-guardia', ReporteIncidenteGuardiaController::class);
Route::apiResource('reporte-patrullas', ReportePatrullaController::class);
Route::apiResource('reporte-bitacoras', ReporteBitacoraController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('perfil', PerfilController::class)->only(['index', 'update']);
});

Route::get('count-adminpage', [CountPageController::class, 'getCount']);

// Modulos de la API (rutas protegidas)
Route::middleware(['auth:sanctum', 'permiso.dinamico'])->group(function () {
    // Rutas de la app por separado
    Route::apiResource('check-guardia', CheckGuardiaController::class)->only(['index']);
    Route::apiResource('reporte-bitacoras', ReporteBitacoraController::class)->only(['index']);
    Route::apiResource('reporte-incidente-guardia', ReporteIncidenteGuardiaController::class)->only(['index']);
    Route::apiResource('reporte-guardia', ReporteGuardiaController::class)->only(['index']);
    Route::apiResource('reporte-supervisor', ReporteSupervisorController::class)->only(['index']);
    Route::apiResource('reporte-patrullas', ReportePatrullaController::class)->only(['index']);
    Route::apiResource('recorridos-guardia', QRRecorridoGuardiaController::class)->only(['index']);

    Route::apiResource('roles', RolController::class);
    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('modulos', ModuloController::class);
    Route::apiResource('guardias', GuardiaController::class);
    Route::get('supervisores', [GuardiaController::class, 'getSupervisores']);
    Route::apiResource('sucursales-empresa', SucursalEmpresaController::class);
    Route::get('guardias-asignado', [GuardiaController::class, 'guardiaAsignado']);
    Route::get('guardias-sucursal', [GuardiaController::class, 'getGuardiaBySucursal']);
    Route::get('supervisores-sucursal', [GuardiaController::class, 'getSupervisorBySucursal']);
    Route::get('jefes-sucursal', [GuardiaController::class, 'getJefeBySucursal']);
    Route::apiResource('blacklist', BlackListController::class);
    Route::post('check-blacklist', [GuardiaController::class, 'checkBlackList']);
    Route::apiResource('incapacidades', IncapacidadController::class);
    Route::apiResource('vacaciones', VacacionController::class);
    Route::apiResource('tiempo-extra', TiempoExtraController::class);
    Route::apiResource('faltas', FaltaController::class);
    Route::apiResource('descuentos', DescuentoController::class);
    Route::apiResource('prestamos', PrestamoController::class);
    Route::apiResource('pagos-empleados', PagoEmpleadoController::class);
    Route::apiResource('modulo-prestamos', ModuloPrestamoController::class);
    Route::apiResource('modulo-descuentos', ModuloDescuentoController::class);
    Route::apiResource('modulo-conceptos', ModuloConceptoController::class);
    Route::get('prestamos-pendientes', [PrestamoController::class, 'prestamosPendientes']);
    Route::get('generar-estadocuenta-guardia', [EstadoCuentaController::class, 'generarEstadoCuentaGuardia']);
    Route::apiResource('abonos-prestamo', AbonoPrestamoController::class);
    Route::apiResource('bancos', BancoController::class);
    Route::get('generar-estadocuenta-banco', [EstadoCuentaController::class, 'generarEstadoCuentaBanco']);
    Route::apiResource('movimientos-bancarios', MovimientoBancarioController::class);
    Route::apiResource('cotizaciones', CotizacionController::class);
    Route::apiResource('clientes', ClienteController::class);
    Route::get('generar-estadocuenta-cliente', [EstadoCuentaController::class, 'generarEstadoCuentaCliente']);
    Route::get('sucursales-cliente', [SucursalController::class, 'sucursalesCliente']);
    Route::apiResource('sucursales', SucursalController::class);
    Route::apiResource('proveedores', ProveedorController::class);
    Route::get('generar-estadocuenta-proveedor', [EstadoCuentaController::class, 'generarEstadoCuentaProveedor']);
    Route::apiResource('articulos', ArticuloController::class);
    Route::get('articulos-asignar', [ArticuloController::class, 'articulosAsignar']);
    Route::apiResource('vehiculos', VehiculoController::class);
    Route::get('vehiculos-disponibles', [VehiculoController::class, 'getVehiculosDisponibles']);
    Route::apiResource('boletas-gasolina', BoletaGasolinaController::class);
    Route::apiResource('ordenes-compra', OrdenCompraController::class);
    Route::apiResource('compras', CompraController::class);
    Route::apiResource('gastos', GastoController::class);
    Route::apiResource('ventas', VentaController::class);
    Route::get('ventas-orden-servicio', [VentaController::class, 'ventaOrdenServicio']);
    Route::put('cancelar-venta', [VentaController::class, 'cancelarVenta']);
    Route::apiResource('ventas-historial', VentaHistorialController::class);
    Route::apiResource('almacen', AlmacenController::class);
    Route::get('almacen-disponibles', [AlmacenController::class, 'disponibles']);
    Route::apiResource('almacen-entradas', AlmacenEntradaController::class);
    Route::apiResource('almacen-salidas', AlmacenSalidaController::class);
    Route::apiResource('equipo', EquipamientoController::class);
    Route::get('equipamiento-completo', [EquipamientoController::class, 'equipamientoCompleto']);
    Route::get('equipo-disponible/{articulo_id}', [AlmacenController::class, 'obtenerEquipoDisponible']);
    Route::apiResource('orden-servicio', OrdenServicioController::class);
    Route::post('generador-reportes', [ReporteController::class, 'getReport']);
    Route::post('reporte-rh', [ReporteController::class, 'generateReportRH']);
    Route::apiResource('cartera-vencida', ReporteCarteraVencidaController::class);
    Route::apiResource('logs', LogController::class);
    Route::apiResource('generar-qr', QRGeneradoController::class);
    Route::get('generar-horastrabajadas-guardia', [CheckGuardiaController::class, 'reporteHorasTrabajadas']);
    Route::get('ventas-ingresos-mensuales', [VentaController::class, 'ingresosMensuales']);
    Route::get('ventas-egresos-mensuales', [MovimientoBancarioController::class, 'egresosMensuales']);
});
