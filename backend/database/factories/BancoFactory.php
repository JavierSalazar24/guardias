<?php

namespace Database\Factories;

use App\Models\Banco;
use Illuminate\Database\Eloquent\Factories\Factory;

class BancoFactory extends Factory
{
    protected $model = Banco::class;

    public function definition()
    {
        $saldoInicial = 100000;

        return [
            'nombre' => $this->faker->company . ' Bank',
            'cuenta' => $this->faker->bankAccountNumber,
            'clabe' => $this->faker->numerify('###############'),
            'saldo_inicial'  => $saldoInicial,
            'saldo' => 0,
        ];
    }
}
