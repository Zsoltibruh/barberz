<?php

use App\Livewire\Forms\ModifyOpeningHourForm;
use App\Models\OpeningHour;
use Flux\Flux;
use Livewire\Component;

new class extends Component {
    public OpeningHour $openingHour;
    public ModifyOpeningHourForm $form;

    public function mount(): void
    {
        $this->form->setOpeningHour($this->openingHour);
    }

    public function modify(): void
    {
        $this->form->modify();

        Flux::modal("modify-{$this->openingHour->id}")->close();
    }
};
?>

<flux:table.row>
    <flux:table.cell>
        {{ __($this->openingHour->weekday) }}
    </flux:table.cell>
    <flux:table.cell>
        {{ $this->openingHour->opens_at }}
    </flux:table.cell>
    <flux:table.cell>
        {{ $this->openingHour->closes_at }}
    </flux:table.cell>
    <flux:table.cell class="py-0">
        @if ($this->openingHour->is_closed)
            <flux:badge color="red" size="sm">
                {{ __('Closed') }}
            </flux:badge>
        @else
            <flux:badge color="green" size="sm">
                {{ __('Open') }}
            </flux:badge>
        @endif
    </flux:table.cell>
    <flux:table.cell>
        <flux:modal.trigger name="modify-{{ $this->openingHour->id }}">
            <flux:button variant="primary" color="blue">
                {{ __('Modify') }}
            </flux:button>
        </flux:modal.trigger>

        <flux:modal name="modify-{{ $this->openingHour->id }}" class="md:w-96">
            <form wire:submit="modify" class="space-y-6">
                <flux:heading size="lg">
                    {{ __($this->openingHour->weekday) }}
                </flux:heading>

                <flux:input wire:model="form.opening" type="time" :label="__('Opening')" />

                <flux:input wire:model="form.closing" type="time" :label="__('Closing')" />

                <flux:switch wire:model="form.closed" type="bool" :label="__('Closed')" />

                <div class="flex justify-end gap-2">
                    <flux:modal.close>
                        <flux:button>{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </flux:modal>
    </flux:table.cell>
</flux:table.row>
