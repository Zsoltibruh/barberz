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
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'János',
            'surname' => 'Fodrász',
            'email' => 'barber@example.com',
            'role' => Role::Barber,
        ]);

        User::factory()->create([
            'first_name' => 'Jóska',
            'surname' => 'Admin',
            'email' => 'admin@example.com',
            'role' => Role::Admin,
        ]);

        User::factory()->create([
            'first_name' => 'Elek',
            'surname' => 'Teszt',
            'email' => 'test@example.com',
        ]);
    }
}
