<?php

namespace Database\Factories;

use App\Enums\AppointmentStatus;
use App\Enums\Role;
use App\Models\Appointment;
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
        $barberService = User::role(Role::Barber->value)
            ->with('barberServices')
            ->inRandomOrder()
            ->first();

        return [
            'barber_id' => $barberService->id,
            'customer_id' => User::role(Role::Customer->value)->inRandomOrder()->first()->id,
            'service_id' => $barberService->barberServices->first()->id,
            'date' => fake()->dateTimeBetween('+1 days', '+14 days'),
            'status' => AppointmentStatus::Confirmed,
        ];
    }
}
