<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'János',
            'last_name' => 'Fodrász',
            'email' => 'barber@example.com',
        ])->assignRole(Role::Barber->value);

        User::factory()->create([
            'first_name' => 'Jóska',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
        ])->assignRole(Role::Admin->value);

        User::factory()->create([
            'first_name' => 'Elek',
            'last_name' => 'Teszt',
            'email' => 'test@example.com',
        ])->assignRole(Role::Customer->value);

        $services = Service::all();

        User::factory(4)
            ->create()
            ->each(function ($user) {
                $user->assignRole(Role::Barber->value);
            });

        User::factory(10)
            ->create()
            ->each(function ($user) {
                $user->assignRole(Role::Customer->value);
            });
    }
}
