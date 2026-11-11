<?php

use App\Enums\AppointmentStatus;
use App\Livewire\Forms\RescheduleAppointmentForm;
use App\Models\Appointment;
use Flux\Flux;
use Livewire\Component;

new class extends Component {
    public Appointment $appointment;
    public RescheduleAppointmentForm $form;

    public function mount(): void
    {
        $this->form->setAppointment($this->appointment);
    }

    public function cancel(): void
    {
        $this->authorize('cancel', $this->appointment);

        $this->appointment->update(['status' => AppointmentStatus::Cancelled]);

        Flux::modal("cancel-appointment-{$this->appointment->id}")->close();
    }

    public function reschedule(): void
    {
        $this->authorize('reschedule', $this->appointment);

        $this->form->reschedule();

        Flux::modal("reschedule-appointment-{$this->appointment->id}")->close();
    }
};
?>

<div>
    <x-appointment-summary :appointment="$appointment" :wire:key="$appointment->id">
        @can('reschedule', $appointment)
            <flux:modal.trigger name="reschedule-appointment-{{ $appointment->id }}">
                <flux:button variant="primary" color="yellow"> {{ __('Modify appointment') }} </flux:button>
            </flux:modal.trigger>
        @endcan
        @can('cancel', $appointment)
            <flux:modal.trigger name="cancel-appointment-{{ $appointment->id }}">
                <flux:button variant="danger"> {{ __('Cancel appointment') }} </flux:button>
            </flux:modal.trigger>
        @endcan
    </x-appointment-summary>

    @can('cancel', $appointment)
        <flux:modal name="cancel-appointment-{{ $appointment->id }}" class="md:w-96">
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
                            <flux:button variant="ghost"> {{ __('Cancel') }} </flux:button>
                        </flux:modal.close>
                        <flux:button variant="danger" wire:click="cancel">
                            {{ __('Cancel appointment') }}
                        </flux:button>
                    </div>
                </div>
            </div>
        </flux:modal>
    @endcan

    @can('reschedule', $appointment)
        <flux:modal name="reschedule-appointment-{{ $appointment->id }}" class="md:w-96">
            <form wire:submit="reschedule" class="space-y-6">
                <flux:heading size="lg">{{ __('Modify appointment') }}</flux:heading>

                <flux:input wire:model="form.date" type="date" :min="now()->format('Y-m-d')" :label="__('Date')" />
                <flux:input wire:model="form.time" type="time" step="900" :label="__('Time')" />

                <div class="flex justify-end gap-2">
                    <flux:modal.close>
                        <flux:button>{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </flux:modal>
    @endcan
</div>
