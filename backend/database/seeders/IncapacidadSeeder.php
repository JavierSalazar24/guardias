<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Incapacidad;
use App\Models\Guardia;

class IncapacidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guardias = Guardia::where('eliminado', false)->inRandomOrder()->take(5)->get();

        foreach ($guardias as $guardia) {
            Incapacidad::factory()->create([
                'guardia_id' => $guardia->id,
            ]);
        }
    }
}
