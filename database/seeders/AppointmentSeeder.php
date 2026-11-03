<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::role(Role::Customer->value)->get();
        $barbers = User::role(Role::Barber->value)->get();

        Appointment::factory(10)
            ->recycle($customers)
            ->recycle($barbers)
            // ->state(function () use ($barbers) {
            //     $barber = $barbers->random();
            //     $service = $barber->barberServices->random();

            //     return [
            //         'barber_id' => $barber->id,
            //         'service_id' => $service->id,
            //         'duration_minutes' => $service->duration_minutes,
            //         'price' => $service->price,
            //     ];
            // })
            ->create();
    }
}
