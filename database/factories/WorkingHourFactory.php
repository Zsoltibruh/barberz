<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\User;
use App\Models\WorkingHour;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WorkingHour>
 */
class WorkingHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = Carbon::createFromTime(fake()->numberBetween(7, 12));
        $end = $start->copy()->addHours(fake()->numberBetween(2, 6));

        return [
            'barber_id' => fn () => User::factory()->create()->assignRole(Role::Barber),
            'weekday' => fake()->dayOfWeek(),
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
        ];
    }
}
