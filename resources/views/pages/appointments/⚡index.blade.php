<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Flux\Flux;
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

    public function deleteAppointment(int $appointmentId)
    {
        $appointment = auth()->user()->customerAppointments()->findOrFail($appointmentId);
        $appointment->update(['status' => AppointmentStatus::Cancelled]);

        Flux::modal('delete-appointment-' . $appointmentId)->close();
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

            @if ($appointment->status === AppointmentStatus::Confirmed)
                <flux:button variant="primary" color="yellow"> {{ __('Modify appointment') }} </flux:button>
                <flux:modal.trigger name="delete-appointment-{{ $appointment->id }}">
                    <flux:button variant="danger"> {{ __('Cancel appointment') }} </flux:button>
                </flux:modal.trigger>
            @endif
        </flux:card>
        <div>
        </div>

        <flux:modal name="delete-appointment-{{ $appointment->id }}" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg"> {{ __('Cancel appointment') }} </flux:heading>
                    <flux:text class="mt-2">
                        {{ __('Are you sure you want to cancel this appointment?') }}
                    </flux:text>
                </div>

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
                </flux:card>

                <div class="flex">
                    <flux:spacer />

                    <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                        <flux:modal.close>
                            <flux:button type="submit"> {{ __('Cancel') }} </flux:button>
                        </flux:modal.close>
                        <flux:button type="submit" variant="danger"
                            wire:click="deleteAppointment({{ $appointment->id }})"> {{ __('Cancel appointment') }}
                        </flux:button>
                    </div>
                </div>
            </div>
        </flux:modal>
    @endforeach
</section>
