<?php

use App\Enums\Role;
use App\Livewire\Forms\BookAppointmentForm;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public User $barber;
    public BookAppointmentForm $form;

    public function mount(User $barber)
    {
        abort_unless($barber->hasRole(Role::Barber), 404);

        $this->barber = $barber->load(['workingHours', 'barberServices']);
        $this->form->setBarber($barber);
    }

    #[Computed]
    public function workingHours(): Collection
    {
        return $this->barber->workingHours->sortBy('id')->values();
    }

    public function save(): void
    {
        $this->form->store();

        $this->redirect(route('appointments.index'));
    }
};
?>

<section>
    <h1 class="text-3xl font-bold"> {{ __('Book appointment') }} - {{ $this->barber->name }} </h1>
    <h2 class="text-2xl"> {{ __('Working hours') }} </h2>
    <div>
        <ul>
            @foreach ($this->workingHours as $workingHour)
                <li>
                    {{ __($workingHour->weekday) }}:
                    {{ $workingHour->start_time }} - {{ $workingHour->end_time }}
                </li>
            @endforeach
        </ul>
    </div>
    <form wire:submit="save" class="mt-6 space-y-6 max-w-[24rem]">
        <flux:select wire:model="form.serviceId" :label="__('Service')" :placeholder="__('Choose a service')">
            @foreach ($this->barber->barberServices as $service)
                <flux:select.option value="{{ $service->id }}">
                    {{ $service->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <flux:input wire:model="form.date" type="date" :min="now()->format('Y-m-d')" :label="__('Date')" />

        <flux:input wire:model="form.time" type="time" :label="__('Time')" step="900"
            :min="config('booking.opening_hour')" :max="config('booking.closing_hour')" />

        <flux:button type="submit" variant="primary" color="blue">
            {{ __('Confirm booking') }}
        </flux:button>
    </form>
</section>
