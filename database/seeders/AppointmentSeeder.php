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

        Appointment::factory(5)
            ->state([
                'barber_id' => User::find(1)->id,
            ])
            ->recycle($customers)
            ->recycle($services)
            ->create();

        Appointment::factory(5)
            ->state([
                'customer_id' => User::find(3)->id,
            ])
            ->recycle($barbers)
            ->recycle($services)
            ->create();

        Appointment::factory(10)
            ->recycle($customers)
            ->recycle($barbers)
            ->recycle($services)
            ->create();
    }
}
