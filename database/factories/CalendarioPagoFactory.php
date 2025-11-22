<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalendarioPago>
 */
class CalendarioPagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo_servicio' => $this->faker->sentence(2),
            'monto' => $this->faker->numberBetween(50000, 2000000),
            'estado' => $this->faker->randomElement(['pagado', 'pendiente']),
        ];
    }
}
