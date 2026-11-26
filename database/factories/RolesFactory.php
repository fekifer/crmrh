<?php

namespace Database\Factories;

use App\Models\Seguridad\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Roles>
 */
class RolesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->jobTitle(),
            'guard_name' => 'web',
            'status' => 1,
            'visible' => 1,
        ];
    }
}
