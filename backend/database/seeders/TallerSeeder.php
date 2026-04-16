<?php
namespace Database\Seeders;

use App\Models\Taller;
use Illuminate\Database\Seeder;

class TallerSeeder extends Seeder
{
    public function run(): void
    {
        $talleres = [
            [
                'nombre' => 'Taller Mecánico Central',
                'direccion' => 'Av. Industria 245, Col. Centro, Monterrey, Nuevo León',
            ],
            [
                'nombre' => 'Servicio Automotriz del Norte',
                'direccion' => 'Calle Miguel Nieto 118, Col. Del Prado, Monterrey, Nuevo León',
            ],
            [
                'nombre' => 'Taller Especializado San Jorge',
                'direccion' => 'Av. Ruiz Cortines 1820, Col. Moderna, Monterrey, Nuevo León',
            ],
            [
                'nombre' => 'Centro de Diagnóstico Automotriz Express',
                'direccion' => 'Av. Lincoln 5501, Col. Paseo de Cumbres, Monterrey, Nuevo León',
            ],
            [
                'nombre' => 'Taller y Refacciones La 57',
                'direccion' => 'Av. Constitución 5700, Col. Fierro, Monterrey, Nuevo León',
            ],
        ];

        foreach ($talleres as $taller) {
            Taller::updateOrCreate(
                ['nombre' => $taller['nombre']],
                $taller
            );
        }
    }
}
