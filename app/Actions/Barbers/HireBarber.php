<?php

namespace App\Actions\Barbers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HireBarber
{
    /**
     * @param  array<string, string>  $data
     */
    public function handle(array $data): User
    {
        $user = User::create([
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'email' => $data['email'],
            'phone_number' => $data['phone'],
            'password' => Hash::make(Str::password(12)),
        ]);

        $user->assignRole(Role::Barber);
        $user->markEmailAsVerified();

        return $user;
    }
}
