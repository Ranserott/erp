<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_empresa' => $this->faker->company,
            'rut_cliente' => $this->faker->unique()->numerify('########-#'),
            'direccion' => $this->faker->address,
            'contacto_nombre' => $this->faker->name,
            'contacto_telefono' => $this->faker->phoneNumber,
            'contacto_email' => $this->faker->companyEmail,
            'notas' => $this->faker->sentence,
        ];
    }
}
