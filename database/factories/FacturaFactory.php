<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Factura>
 */
class FacturaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_factura' => 'FCT-' . $this->faker->unique()->numerify('####'),
            'monto' => $this->faker->numberBetween(100000, 5000000),
            'estado' => $this->faker->randomElement(['pagada', 'pendiente', 'vencida']),
        ];
    }
}
