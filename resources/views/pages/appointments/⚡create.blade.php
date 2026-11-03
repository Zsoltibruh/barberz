<?php

use App\Enums\AppointmentStatus;
use App\Enums\Role;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component {
    public User $barber;

    public string $serviceId = '';
    public string $date = '';

    protected function rules(): array
    {
        return [
            'serviceId' => ['required', 'exists:services,id', Rule::in($this->barber->barberServices()->pluck('services.id')->all())],
            'date' => ['required', 'date', 'after_or_equal:now'],
        ];
    }

    protected function messages(): array
    {
        return [
            'serviceId.required' => __('Please select a service'),
            'serviceId.exists' => __('Please select a valid service'),
            'serviceId.in' => __('Please select a valid service'),
            'date.required' => __('Please select a date and time'),
            'date.date' => __('Please select a valid date and time'),
        ];
    }

    public function mount(User $barber)
    {
        abort_unless($barber->hasRole(Role::Barber), 404);

        $this->barber = $barber;
    }

    public function save()
    {
        $this->validate();

        Appointment::create([
            'barber_id' => $this->barber->id,
            'customer_id' => auth()->id(),
            'service_id' => $this->serviceId,
            'date' => $this->date,
            'status' => AppointmentStatus::Confirmed,
        ]);

        $this->redirect(route('appointments.index'));
    }
};
?>

<section>
    <h1 class="text-3xl font-bold"> {{ __('Book appointment') }} - {{ $this->barber->name }} </h1>
    <form wire:submit="save" class="mt-6 space-y-6">
        <flux:select wire:model="serviceId" :label="__('Service')" :placeholder="__('Choose a service')">
            @foreach ($this->barber->barberServices as $service)
                <flux:select.option value="{{ $service->id }}">
                    {{ $service->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <flux:input wire:model="date" type="datetime-local" min="{{ now()->format('Y-m-d\TH:i') }}"
            :label="__('Date and time')" />

        <flux:button type="submit" variant="primary" color="blue">
            {{ __('Confirm booking') }}
        </flux:button>
    </form>
</section>
