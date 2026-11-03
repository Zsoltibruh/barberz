<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'duration_minutes' => fake()->numberBetween(15, 120),
            'price' => fake()->numberBetween(2000, 5000),
            'currency' => 'HUF',
        ];
    }
}
