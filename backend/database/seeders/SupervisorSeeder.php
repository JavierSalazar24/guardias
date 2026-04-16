<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modulo;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SupervisorSeeder extends Seeder
{
    public function run()
    {
        $supervisorRol = Rol::firstOrCreate([
            'nombre' => 'Supervisor',
        ], [
            'descripcion' => 'Rol para supervisores, pueden consultar ordenes de servicio en las que estén asignados.',
        ]);

        $permisosPorModulo = [
            'orden-servicio' => [
                'crear' => false,
                'consultar' => true,
                'actualizar' => false,
                'eliminar' => false,
            ],
            'check-guardia' => [
                'crear' => false,
                'consultar' => true,
                'actualizar' => false,
                'eliminar' => false,
            ],
            'reporte-bitacoras' => [
                'crear' => false,
                'consultar' => true,
                'actualizar' => false,
                'eliminar' => false,
            ],
            'reporte-incidente-guardia' => [
                'crear' => false,
                'consultar' => true,
                'actualizar' => false,
                'eliminar' => false,
            ],
            'reporte-guardia' => [
                'crear' => false,
                'consultar' => true,
                'actualizar' => false,
                'eliminar' => false,
            ],
            'reporte-supervisor' => [
                'crear' => false,
                'consultar' => true,
                'actualizar' => false,
                'eliminar' => false,
            ],
            'recorridos-guardia' => [
                'crear' => false,
                'consultar' => true,
                'actualizar' => false,
                'eliminar' => false,
            ],
            'reporte-patrullas' => [
                'crear' => false,
                'consultar' => true,
                'actualizar' => false,
                'eliminar' => false,
            ],
            'generar-qr' => [
                'crear' => false,
                'consultar' => true,
                'actualizar' => false,
                'eliminar' => false,
            ],
        ];

        foreach ($permisosPorModulo as $ruta => $permisos) {
            $modulo = Modulo::firstOrCreate(
                ['ruta' => $ruta],
                ['nombre' => Str::title(str_replace('-', ' ', $ruta))]
            );
            $supervisorRol->permisos()->firstOrCreate(
                ['modulo_id' => $modulo->id],
                $permisos
            );
        }

        $faker = Faker::create();

        for ($i = 1; $i <= 20; $i++) {
            Usuario::create([
                'nombre_completo' => $faker->name,
                'email'           => "supervisor{$i}@mail.com",
                'password'        => 'supervisor1234',
                'telefono'        => $faker->numerify('618#######'),
                'rol_id'          => $supervisorRol->id,
                'foto'            => 'default.png',
            ]);
        }
    }
}
