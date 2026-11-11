<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class BarberServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Service::all();

        User::role(Role::Barber)->get()->each(function ($barber) use ($services) {
            $barber->barberServices()->syncWithoutDetaching(
                $services->random(rand(1, 3))->pluck('id')->all()
            );
        });
    }
}
