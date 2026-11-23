<?php

namespace App\Livewire\Forms;

use App\Models\Service;
use Livewire\Form;

class ServiceForm extends Form
{
    public Service $service;

    public string $name = '';

    public int $durationMinutes = 0;

    public int $price = 0;

    public string $currency = 'HUF'; // Placeholder currency!

    public function setService(Service $service): void
    {
        $this->service = $service;
        $this->name = $service->name;
        $this->durationMinutes = $service->duration_minutes;
        $this->price = $service->price;
        $this->currency = $service->currency;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'durationMinutes' => ['required', 'numeric', 'between:5,300', 'multiple_of:5'],
            'price' => ['required', 'numeric', 'multiple_of:10', 'min:2000', 'min_digits:4'], // TODO: Barbershop based minimum price validation (current value is a placeholder)
            'currency' => ['required'],
        ];
    }

    public function create(): void
    {
        $this->validate();
        Service::create([
            'name' => $this->name,
            'duration_minutes' => $this->durationMinutes,
            'price' => $this->price,
            'currency' => $this->currency,
        ]);
    }

    public function modify(): void
    {
        $this->validate();
        $this->service->update([
            'name' => $this->name,
            'duration_minutes' => $this->durationMinutes,
            'price' => $this->price,
            'currency' => $this->currency,
        ]);
    }
}
