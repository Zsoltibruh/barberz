<?php

use App\Enums\AppointmentStatus;
use App\Livewire\Forms\RescheduleAppointmentForm;
use App\Models\Appointment;
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

        $this->modal("cancel-{$this->appointment->id}")->close();
    }

    public function reschedule(): void
    {
        $this->authorize('reschedule', $this->appointment);

        $this->form->reschedule();

        $this->modal("reschedule-{$this->appointment->id}")->close();
    }
};
?>

<div>
    <x-appointments.summary :appointment="$appointment" :wire:key="$appointment->id">
        @can('reschedule', $appointment)
            <flux:modal.trigger name="reschedule-{{ $appointment->id }}">
                <flux:button variant="primary" color="yellow">
                    {{ __('Modify appointment') }}
                </flux:button>
            </flux:modal.trigger>

            <x-appointments.reschedule-modal :id="$appointment->id" />
        @endcan

        @can('cancel', $appointment)
            <flux:modal.trigger name="cancel-{{ $appointment->id }}">
                <flux:button variant="danger">
                    {{ __('Cancel appointment') }}
                </flux:button>
            </flux:modal.trigger>

            <x-modals.confirm name="cancel-{{ $appointment->id }}" class="md:w-4xl" heading="Cancel appointment"
                text="Are you sure you want to canel this appointment?" click="cancel">
                <x-appointments.summary :appointment="$appointment" :wire:key="$appointment->id" />
            </x-modals.confirm>
        @endcan
    </x-appointments.summary>

</div>
