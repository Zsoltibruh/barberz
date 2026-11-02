<?php

namespace Database\Factories;

use App\Enums\AppointmentStatus;
use App\Enums\Role;
use App\Models\Appointment;
use App\Models\BarberService;
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
        $barberService = BarberService::inRandomOrder()->first();

        return [
            'barber_id' => $barberService->barber_id,
            'customer_id' => User::role(Role::Customer->value)->inRandomOrder()->first()->id,
            'service_id' => $barberService->service_id,
            'duration_minutes' => $barberService->duration_minutes,
            'price' => $barberService->price,
            'date' => fake()->dateTimeBetween('+1 days', '+14 days'),
            'status' => AppointmentStatus::Confirmed,
        ];
    }
}
