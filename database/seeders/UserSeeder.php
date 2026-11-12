<?php

namespace Database\Seeders;

use App\Enums\Role;
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
        ])->assignRole(Role::Barber);

        User::factory()->create([
            'first_name' => 'Jóska',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
        ])->assignRole(Role::Admin);

        User::factory()->create([
            'first_name' => 'Elek',
            'last_name' => 'Teszt',
            'email' => 'test@example.com',
        ])->assignRole(Role::Customer);

        User::factory(4)
            ->create()
            ->each(function ($user) {
                $user->assignRole(Role::Barber);
            });

        User::factory(10)
            ->create()
            ->each(function ($user) {
                $user->assignRole(Role::Customer);
            });
    }
}
