<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Appointment;
use App\Models\BarberService;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', Role::Customer)->get();
        $barberServices = BarberService::all();

        Appointment::factory(10)
            ->recycle($customers)
            ->state(function () use ($barberServices) {
                $barberService = $barberServices->random();

                return [
                    'barber_id' => $barberService->barber_id,
                    'service_id' => $barberService->service_id,
                    'duration_minutes' => $barberService->duration_minutes,
                    'price' => $barberService->price,
                ];
            })
            ->create();
    }
}
