<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        $tiposDocumentos = [
            [
                'nombre' => 'CURP',
                'descripcion' => 'Clave Única de Registro de Población',
            ],
            [
                'nombre' => 'INE',
                'descripcion' => 'Identificación oficial',
            ],
            [
                'nombre' => 'Acta de nacimiento',
                'descripcion' => 'Documento oficial de nacimiento',
            ],
            [
                'nombre' => 'RFC',
                'descripcion' => 'Registro Federal de Contribuyentes',
            ],
            [
                'nombre' => 'Comprobante de domicilio',
                'descripcion' => 'Comprobante reciente del domicilio',
            ],
            [
                'nombre' => 'Constancia de situación fiscal',
                'descripcion' => 'Documento fiscal emitido por SAT',
            ],
            [
                'nombre' => 'Comprobante de estudios',
                'descripcion' => 'Documento que acredita nivel académico',
            ],
            [
                'nombre' => 'Carta de recomendación',
                'descripcion' => 'Carta laboral o personal de recomendación',
            ],
            [
                'nombre' => 'Antecedentes no penales',
                'descripcion' => 'Constancia de antecedentes no penales',
            ],
        ];

        foreach ($tiposDocumentos as $tipoDocumento) {
            TipoDocumento::updateOrCreate(
                ['nombre' => $tipoDocumento['nombre']],
                ['descripcion' => $tipoDocumento['descripcion']]
            );
        }
    }
}
