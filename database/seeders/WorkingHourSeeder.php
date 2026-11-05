<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use App\Models\WorkingHour;
use Illuminate\Database\Seeder;

class WorkingHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $barbers = User::role(Role::Barber)->get()->each(function (User $barber) use ($weekdays) {
            foreach ($weekdays as $weekday) {
                WorkingHour::factory()->create([
                    'barber_id' => $barber->id,
                    'weekday' => $weekday,
                ]);
            }
        });
    }
}
