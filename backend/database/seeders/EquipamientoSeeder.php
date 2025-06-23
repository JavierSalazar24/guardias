<?php

namespace Database\Seeders;

use App\Models\Equipamiento;
use App\Models\Vehiculo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vehiculo::factory(5)->create()->each(function ($vehiculo) {
            $vehiculo->equipamiento()->create(
                Equipamiento::factory()->make()->toArray()
            );
        });
    }
}
