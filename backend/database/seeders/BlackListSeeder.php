<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guardia;
use App\Models\BlackList;

class BlackListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener 25 guardias aleatorios de los 100 existentes
        $guardias = Guardia::inRandomOrder()->take(25)->get();

        foreach ($guardias as $guardia) {
            BlackList::factory()
                ->create([
                    'guardia_id' => $guardia->id,
                ]);

                $guardia->update(['eliminado' => true]);
        }
    }
}
