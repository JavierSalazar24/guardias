<?php

namespace Database\Seeders;

use App\Models\Documento;
use App\Models\Guardia;
use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;
use RuntimeException;

class DocumentoSeeder extends Seeder
{
    public function run(): void
    {
        $guardias = Guardia::inRandomOrder()->take(5)->get();
        $tiposDocumentoIds = TipoDocumento::pluck('id');

        if ($guardias->count() < 5) {
            throw new RuntimeException('Se necesitan al menos 5 guardias registrados para ejecutar DocumentoSeeder.');
        }

        if ($tiposDocumentoIds->count() < 4) {
            throw new RuntimeException('Se necesitan al menos 4 tipos de documentos registrados.');
        }

        foreach ($guardias as $guardia) {
            $tiposAleatorios = $tiposDocumentoIds->shuffle()->take(5);

            foreach ($tiposAleatorios as $tipoDocumentoId) {
                Documento::factory()->create([
                    'guardia_id' => $guardia->id,
                    'tipo_documento_id' => $tipoDocumentoId,
                ]);
            }
        }
    }
}
