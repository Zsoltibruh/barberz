<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\BarberService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BarberService>
 */
class BarberServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'barber_id' => User::factory()->state(['role' => Role::Barber]),
            'service_id' => Service::factory(),
            'duration_minutes' => $this->faker->numberBetween(15, 120),
            'price' => $this->faker->numberBetween(2000, 5000),
        ];
    }
}
