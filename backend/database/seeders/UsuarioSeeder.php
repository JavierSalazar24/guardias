<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            ['nombre_completo' => 'Javier Salazar', 'email' => 'javssala@gmail.com', 'password' => bcrypt('12345678'), 'rol_id' => '1'],
        ]);
    }
}
