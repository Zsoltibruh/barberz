<?php

use App\Models\User;
use Livewire\Component;

new class extends Component {
    public User $barber;
};
?>

<flux:table.row>
    <flux:table.cell>
        {{ __($this->barber->name) }}
    </flux:table.cell>
    <flux:table.cell>
        {{ $this->barber->email }}
    </flux:table.cell>
    <flux:table.cell>
        {{ $this->barber->phone_number }}
    </flux:table.cell>
    <flux:table.cell>
        <flux:modal.trigger name="services-{{ $this->barber->id }}">
            <flux:button>
                {{ __('Services') }}
            </flux:button>
        </flux:modal.trigger>

        <flux:modal.trigger name="working-hours-{{ $this->barber->id }}">
            <flux:button>
                {{ __('Working hours') }}
            </flux:button>
        </flux:modal.trigger>

        <flux:modal.trigger name="modify-{{ $this->barber->id }}">
            <x-buttons.modify />
        </flux:modal.trigger>

        <x-barbers.services-modal :barber="$this->barber" />
        <x-barbers.working-hours-modal :barber="$this->barber" />
        <x-barbers.manage-modal :barber="$this->barber" />

    </flux:table.cell>
</flux:table.row>
