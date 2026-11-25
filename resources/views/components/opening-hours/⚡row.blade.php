<?php

use App\Livewire\Forms\ModifyOpeningHourForm;
use App\Models\OpeningHour;
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

        $this->modal("modify-{$this->openingHour->id}")->close();
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

        <x-opening-hours.modify-modal :openingHour="$this->openingHour" />
    </flux:table.cell>
</flux:table.row>
