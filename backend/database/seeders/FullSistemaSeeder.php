<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Modulo;
use App\Models\Rol;
use App\Models\Usuario;

class FullSistemaSeeder extends Seeder
{
    public function run(): void
    {
        $modulos = [
            'roles', 'usuarios', 'modulos', 'perfil', 'guardias', 'sucursales-empresa', 'blacklist',
            'incapacidades', 'vacaciones', 'tiempo-extra', 'faltas', 'descuentos', 'prestamos',
            'modulo-prestamos', 'modulo-descuentos', 'modulo-conceptos', 'abonos-prestamo', 'bancos', 'movimientos-bancarios',
            'cotizaciones', 'clientes', 'sucursales', 'proveedores', 'articulos', 'vehiculos',
            'boletas-gasolina', 'ordenes-compra', 'compras', 'gastos', 'ventas', 'ventas-historial',
            'almacen', 'almacen-entradas', 'almacen-salidas', 'equipo', 'orden-servicio', 'cartera-vencida',
            'logs', 'generar-qr', 'estadocuenta-guardias', 'reportes-guardias', 'estadocuenta-clientes',
            'estadocuenta-proveedores', 'recorridos-guardia', 'estadocuenta-bancos', 'generador-reportes',
            'check-guardia', 'reporte-bitacoras', 'reporte-incidente-guardia', 'reporte-guardia', 'reporte-supervisor', 'reporte-patrullas', 'pagos-empleados'
        ];

        $modulosSupervisor = [
            'check-guardia',
            'reporte-bitacoras',
            'reporte-incidente-guardia',
            'reporte-guardia',
            'reporte-supervisor',
            'recorridos-guardia',
            'reporte-patrullas'
        ];

        DB::beginTransaction();

        try {
            foreach ($modulos as $nombre) {
                Modulo::firstOrCreate(['nombre' => $nombre]);
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
                'nombre_completo' => 'Javier Salazar',
                'email' => 'javssala@gmail.com',
                'password' => bcrypt('12345678'),
                'rol_id' => $adminRol->id,
                'foto' => 'default.png',
            ]);

            $supervisorRol = Rol::create([
                'nombre' => 'Supervisor',
                'descripcion' => 'Permisos limitados para supervisión'
            ]);

            $supervisorModulos = Modulo::whereIn('nombre', $modulosSupervisor)->get();
            foreach ($supervisorModulos as $modulo) {
                $supervisorRol->permisos()->create([
                    'modulo_id' => $modulo->id,
                    'crear' => false,
                    'consultar' => true,
                    'actualizar' => false,
                    'eliminar' => false,
                ]);
            }

            Usuario::create([
                'nombre_completo' => 'Juan Supervisor',
                'email' => 'supervisor@example.com',
                'password' => bcrypt('12345678'),
                'rol_id' => $supervisorRol->id,
                'foto' => 'default.png',
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
