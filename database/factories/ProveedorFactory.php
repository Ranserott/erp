<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedor>
 */
class ProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company,
            'rut' => $this->faker->unique()->numerify('########-#'),
            'telefono' => $this->faker->phoneNumber,
            'email' => $this->faker->companyEmail,
            'direccion' => $this->faker->address,
            'tipo_rubro' => $this->faker->randomElement(['Servicios', 'Materiales', 'Equipamiento', 'Software', 'Consultoría', 'Mantenimiento']),
            'notas' => $this->faker->sentence,
        ];
    }
}
