<?php

namespace Database\Seeders;

use App\Models\BarberService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class BarberServiceSeeder extends Seeder
{
    /**
     * Run the database seeds
     */
    public function run(): void
    {
        $barber = User::where('id', 1)->first();
        $services = Service::limit(5)->get();

        foreach ($services as $service) {
            BarberService::create([
                'barber_id' => $barber->id,
                'service_id' => $service->id,
                'duration_minutes' => rand(15, 120),
                'price' => rand(2000, 5000),
            ]);
        }

        BarberService::factory(5)->create();
    }
}
