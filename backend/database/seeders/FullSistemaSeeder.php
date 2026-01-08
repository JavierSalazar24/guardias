<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Modulo;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Support\Str;

class FullSistemaSeeder extends Seeder
{
    public function run(): void
    {
        $rutas = [
            'roles', 'usuarios', 'modulos', 'guardias', 'sucursales-empresa', 'blacklist',
            'incapacidades', 'vacaciones', 'tiempo-extra', 'faltas', 'descuentos', 'prestamos',
            'modulo-prestamos', 'modulo-descuentos', 'modulo-conceptos', 'abonos-prestamo', 'bancos', 'movimientos-bancarios',
            'tipos-servicios', 'cotizaciones', 'clientes', 'sucursales', 'proveedores', 'articulos', 'vehiculos',
            'boletas-gasolina', 'ordenes-compra', 'compras', 'gastos', 'ventas', 'ventas-historial', 'orden-servicio-eliminadas',
            'almacen', 'almacen-entradas', 'almacen-salidas', 'equipo', 'orden-servicio', 'cartera-vencida',
            'logs', 'estadocuenta-guardias', 'reportes-guardias', 'estadocuenta-clientes','estadocuenta-proveedores',
            'estadocuenta-bancos', 'generador-reportes', 'pagos-empleados', 'limpiezas-programadas', 'limpieza-logs', 'generar-qr'
        ];

        // MOSTRAR HASTA QUE ESTÉ LISTA LA APP
        // [
        //      'generar-qr'
        //      'check-guardia',
        //      'reporte-bitacoras',
        //      'reporte-incidente-guardia',
        //      'reporte-guardia',
        //      'reporte-supervisor',
        //      'recorridos-guardia',
        //      'reporte-patrullas'
        // ]

        // $modulosSupervisor = [
        //     'check-guardia',
        //     'reporte-bitacoras',
        //     'reporte-incidente-guardia',
        //     'reporte-guardia',
        //     'reporte-supervisor',
        //     'recorridos-guardia',
        //     'reporte-patrullas'
        // ];

        DB::beginTransaction();

        try {
            foreach ($rutas as $ruta) {
                Modulo::firstOrCreate([
                    'nombre' => Str::title(str_replace('-', ' ', $ruta)),
                    'ruta'   => $ruta,
                ]);
            }

            $adminRol = Rol::create([
                'nombre' => 'Super admin',
                'descripcion' => 'Todos los permisos'
            ]);

            $todosLosModulos = Modulo::all();
            foreach ($todosLosModulos as $modulo) {
                $adminRol->permisos()->create([
                    'modulo_id' => $modulo->id,
                    'crear' => true,
                    'consultar' => true,
                    'actualizar' => true,
                    'eliminar' => true,
                ]);
            }


            Usuario::create([
                'nombre_completo' => 'Administrador Arcanix',
                'email' => 'admin@arcanix.com.mx',
                'password' => 'arcanix',
                'rol_id' => $adminRol->id,
                'foto' => 'default.png',
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
