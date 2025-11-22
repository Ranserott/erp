<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrdenTrabajo>
 */
class OrdenTrabajoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_ot' => 'OT-' . $this->faker->unique()->numerify('####'),
            'descripcion' => $this->faker->text(200),
            'fecha_fin_estimada' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
            'estado' => $this->faker->randomElement(['en progreso', 'terminada', 'pausada']),
        ];
    }
}
