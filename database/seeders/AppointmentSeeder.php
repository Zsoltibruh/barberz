<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::role(Role::Customer)->get();
        $barbers = User::role(Role::Barber)->get();
        $services = Service::all();

        // Appointments for the test barber
        Appointment::factory(5)
            ->state([
                'barber_id' => User::find(1)->id,
                'customer_id' => $customers->random()->id,
            ])
            ->recycle($services)
            ->create();

        // Appointments for the test customer
        Appointment::factory(5)
            ->state([
                'barber_id' => $barbers->random()->id,
                'customer_id' => User::find(3)->id,
            ])
            ->recycle($services)
            ->create();

        Appointment::factory(10)
            ->state([
                'barber_id' => $barbers->random()->id,
                'customer_id' => $customers->random()->id,
            ])
            ->recycle($services)
            ->create();
    }
}
