<?php

namespace App\Livewire\Forms;

use App\Actions\Barbers\HireBarber;
use App\Models\User;
use Livewire\Form;

class BarberForm extends Form
{
    public string $firstName = '';

    public string $lastName = '';

    public string $email = '';

    public string $phone = '';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'firstName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string'],
        ];
    }

    public function create(): User
    {
        $this->validate();
        $barber = app(HireBarber::class)->handle($this->all());

        return $barber;
    }
}
