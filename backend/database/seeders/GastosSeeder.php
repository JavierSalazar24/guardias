<?php

namespace Database\Seeders;

use App\Models\Gasto;
use App\Models\Banco;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GastosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banco::all()->each(function ($banco) {
            Gasto::factory()->count(1)->create(['banco_id' => $banco->id]);
        });
    }
}
