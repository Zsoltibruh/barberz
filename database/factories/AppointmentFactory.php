<?php

namespace Database\Factories;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $barber = User::factory()->barber();

        return [
            'barber_id' => $barber,
            'customer_id' => User::factory()->customer(),
            'service_id' => Service::factory()->hasAttached($barber, relationship: 'barbers'),
            'date' => fake()->dateTimeBetween('+1 days', '+14 days'),
            'status' => AppointmentStatus::Confirmed,
        ];
    }
}
