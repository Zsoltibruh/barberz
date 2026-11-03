<?php

use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function appointments()
    {
        return auth()
            ->user()
            ->customerAppointments()
            ->with(['barber', 'service'])
            ->orderBy('date', 'desc')
            ->get();
    }
};
?>

<section class="w-full flex flex-col gap-2">
    <h1 class="text-3xl font-bold"> {{ __('Appointments') }} </h1>

    @foreach ($this->appointments as $appointment)
        <flux:card>
            <flux:heading size="lg"> {{ $appointment->date }} </flux:heading>

            <flux:card.body>
                <flux:card.heading> {{ $appointment->barber->name }} </flux:card.heading>
                <flux:card.subheading>
                    {{ $appointment->service->name }} - {{ $appointment->service->price }} Ft
                </flux:card.subheading>
                <flux:card.subheading>
                    {{ $appointment->status->label() }}
                </flux:card.subheading>
            </flux:card.body>

            <flux:button variant="primary" color="yellow">Modify</flux:button>
            <flux:button variant="danger">Delete</flux:button>
        </flux:card>
        <div>
        </div>
    @endforeach
</section>
