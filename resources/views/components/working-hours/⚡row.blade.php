<?php

use App\Livewire\Forms\WorkingHourForm;
use App\Models\WorkingHour;
use Livewire\Component;

new class extends Component {
    public WorkingHour $workingHour;
    public WorkingHourForm $form;

    public function mount(): void
    {
        $this->form->setWorkingHour($this->workingHour);
    }

    public function modify(): void
    {
        $this->form->modify();
        $this->modal("modify-{$this->workingHour->id}")->close();
    }

    public function delete(): void
    {
        $this->workingHour->delete();
        $this->modal("delete-{$this->workingHour->id}")->close();
    }
};
?>

<flux:table.row>
    <flux:table.cell>
        {{ __($this->workingHour->weekday) }}
    </flux:table.cell>
    <flux:table.cell>
        {{ $this->workingHour->start_time }}
    </flux:table.cell>
    <flux:table.cell>
        {{ $this->workingHour->end_time }}
    </flux:table.cell>
    <flux:table.cell>
        <flux:modal.trigger name="modify-{{ $this->workingHour->id }}">
            <flux:button variant="primary" color="blue">
                {{ __('Modify') }}
            </flux:button>
        </flux:modal.trigger>

        <flux:modal.trigger name="delete-{{ $this->workingHour->id }}">
            <flux:button variant="primary" color="red">
                {{ __('Delete') }}
            </flux:button>
        </flux:modal.trigger>

        <x-working-hours.modify-modal :workingHour="$this->workingHour" />
        <x-working-hours.delete-modal :workingHour="$this->workingHour" />
    </flux:table.cell>
</flux:table.row>
