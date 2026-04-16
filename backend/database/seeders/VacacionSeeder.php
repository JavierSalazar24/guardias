<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vacacion;
use App\Models\Guardia;

class VacacionSeeder extends Seeder
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
            Vacacion::factory()->create([
                'guardia_id' => $guardia->id,
            ]);
        }
    }
}
