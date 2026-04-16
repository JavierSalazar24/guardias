<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActaAdministrativa;
use App\Models\Guardia;

class ActaAdministrativaSeeder extends Seeder
{
    public function run(): void
    {
        if (Guardia::count() < 4) {
            $this->command->warn('No se pueden crear actas administrativas: se requieren al menos 4 guardias.');
            return;
        }

        ActaAdministrativa::factory()->count(20)->create();
    }
}
