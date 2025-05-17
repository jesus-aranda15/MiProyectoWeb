<?php

namespace Database\Factories;
use App\Models\Computer; //para usar el modelo
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Computer>
 */
class ComputerFactory extends Factory
{
    protected $model = Computer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(), // Nombre aleatorio.
            'description' => $this->faker->paragraph(), // Descripción aleatoria.
            'price' => $this->faker->randomFloat(2, 100, 2000), // Precio aleatorio entre 100 y 2000.
        ];
    }
}