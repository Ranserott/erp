<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entrega>
 */
class EntregaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_receptor' => $this->faker->name,
            'observaciones' => $this->faker->sentence,
            'evidencia_foto' => $this->faker->optional(0.3)->imageUrl(640, 480),
        ];
    }
}
